<?php

namespace App\Http\Controllers\TeamLeader;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use App\Models\WorkLog;
use App\Models\WorkAssignment;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    //  GET CURRENT TL 
    private function getTL()
    {
        return Employee::where('user_id', auth()->id())->first();
    }

    // GET TEAM MEMBER IDs 
    private function getTeamIds(): array
    {
        $tl = $this->getTL();
        if(!$tl) return [];
        return Employee::where('team_leader_id', $tl->id)
            ->pluck('id')
            ->toArray();
    }

    //  DAILY REPORT 
    public function daily(Request $request)
    {
        $date    = $request->date ?? today()->format('Y-m-d');
        $teamIds = $this->getTeamIds();

        $logs = WorkLog::whereIn('employee_id', $teamIds)
            ->whereDate('start_time', $date)
            ->with(['employee', 'fittingType', 'project'])
            ->where('status', 'completed')
            ->get();

        $summary = [
            'total_tasks'    => $logs->count(),
            'completed'      => $logs->count(),
            'total_actual'   => $logs->sum('actual_time'),
            'total_standard' => $logs->sum('standard_time'),
            'avg_efficiency' => round($logs->avg('efficiency') ?? 0, 1),
        ];

        if($request->export === 'pdf') {
            $saved = $summary['total_standard'] - $summary['total_actual'];
            return $this->exportPdf(
                title:        'Daily Report - Team',
                period:       \Carbon\Carbon::parse($date)->format('d M Y'),
                summaryBoxes: [
                    ['value' => $summary['total_tasks'],         'label' => 'Tasks'],
                    ['value' => $summary['total_standard'].'m',  'label' => 'Std Time'],
                    ['value' => $summary['total_actual'].'m',    'label' => 'Actual'],
                    ['value' => ($saved >= 0 ? '+' : '').$saved.'m', 'label' => 'Time Saved'],
                ],
                headers: [
                    'Employee', 'Product', 'Project',
                    'Start', 'End', 'Std', 'Actual', 'Variance', 'Result'
                ],
                rows: $logs->map(fn($l) => [
                    $l->employee->name ?? '—',
                    $l->fittingType->name ?? '—',
                    $l->project->name ?? '—',
                    $l->start_time?->format('h:i A'),
                    $l->end_time?->format('h:i A') ?? '—',
                    $l->standard_time.'m',
                    $l->actual_time.'m',
                    ($l->variance > 0 ? '+' : '').$l->variance.'m',
                    $l->variance <= 0 ? 'Fast' : 'Slow',
                ])->toArray(),
                filename: 'team-daily-'.$date.'.pdf'
            );
        }

        return view('team-leader.reports.daily',
            compact('logs', 'summary', 'date'));
    }

    // EMPLOYEE REPORT 
    public function employee(Request $request)
    {
        $startDate = $request->start_date ?? today()->format('Y-m-d');
        $endDate   = $request->end_date ?? today()->format('Y-m-d');
        $tl        = $this->getTL();

        $employees = $tl
            ? Employee::where('team_leader_id', $tl->id)->get()
            : collect();

        $employees = $employees->map(function($emp) use ($startDate, $endDate) {
            $logs = WorkLog::where('employee_id', $emp->id)
                ->whereBetween('start_time', [
                    $startDate.' 00:00:00',
                    $endDate.' 23:59:59'
                ])
                ->where('status', 'completed')
                ->get();

            $emp->tasks_done     = $logs->count();
            $emp->total_actual   = $logs->sum('actual_time');
            $emp->total_standard = $logs->sum('standard_time');
            $emp->avg_efficiency = round($logs->avg('efficiency') ?? 0, 1);
            $emp->time_saved     = $emp->total_standard - $emp->total_actual;
            return $emp;
        });

        if($request->export === 'pdf') {
            return $this->exportPdf(
                title:        'Employee Report - Team',
                period:       $this->formatPeriod($startDate, $endDate),
                summaryBoxes: [
                    ['value' => $employees->count(),          'label' => 'Employees'],
                    ['value' => $employees->sum('tasks_done'),'label' => 'Total Tasks'],
                    ['value' => $employees->sum('total_actual').'m', 'label' => 'Total Time'],
                ],
                headers: [
                    'Employee', 'Code', 'Tasks Done',
                    'Std Time', 'Actual Time', 'Time Saved', 'Result'
                ],
                rows: $employees->map(fn($e) => [
                    $e->name,
                    $e->employee_code,
                    $e->tasks_done,
                    $e->total_standard.'m',
                    $e->total_actual.'m',
                    ($e->time_saved >= 0 ? '+' : '').$e->time_saved.'m',
                    $e->time_saved >= 0 ? 'Fast' : 'Slow',
                ])->toArray(),
                filename: 'team-employee-report.pdf'
            );
        }

        return view('team-leader.reports.employee',
            compact('employees', 'startDate', 'endDate'));
    }

    // PRODUCT REPORT 
    public function product(Request $request)
    {
        $startDate = $request->start_date ?? today()->format('Y-m-d');
        $endDate   = $request->end_date ?? today()->format('Y-m-d');
        $teamIds   = $this->getTeamIds();

        $data = WorkLog::whereIn('employee_id', $teamIds)
            ->whereBetween('start_time', [
                $startDate.' 00:00:00',
                $endDate.' 23:59:59'
            ])
            ->where('status', 'completed')
            ->with('fittingType')
            ->get()
            ->groupBy('fitting_type_id')
            ->map(function($group) {
                $first = $group->first();
                return [
                    'name'           => $first->fittingType->name ?? '—',
                    'std_per_unit'   => $first->fittingType->standard_time ?? 0,
                    'count'          => $group->count(),
                    'total_actual'   => $group->sum('actual_time'),
                    'total_standard' => $group->sum('standard_time'),
                    'avg_efficiency' => round($group->avg('efficiency') ?? 0, 1),
                ];
            })
            ->sortByDesc('count')
            ->values();

        if($request->export === 'pdf') {
            return $this->exportPdf(
                title:        'Product-wise Report - Team',
                period:       $this->formatPeriod($startDate, $endDate),
                summaryBoxes: [
                    ['value' => count($data),                        'label' => 'Products'],
                    ['value' => collect($data)->sum('count'),        'label' => 'Total Tasks'],
                    ['value' => collect($data)->sum('total_standard').'m', 'label' => 'Std Time'],
                    ['value' => collect($data)->sum('total_actual').'m',   'label' => 'Actual'],
                ],
                headers: [
                    '#', 'Product', 'Tasks',
                    'Std/Unit', 'Total Std', 'Total Actual', 'Variance'
                ],
                rows: $data->map(function($item, $i) {
                    $var = $item['total_actual'] - $item['total_standard'];
                    return [
                        $i + 1,
                        $item['name'],
                        $item['count'],
                        $item['std_per_unit'].'m',
                        $item['total_standard'].'m',
                        $item['total_actual'].'m',
                        ($var > 0 ? '+' : '').$var.'m',
                    ];
                })->toArray(),
                footer: [
                    'TOTAL', '',
                    collect($data)->sum('count'),
                    '—',
                    collect($data)->sum('total_standard').'m',
                    collect($data)->sum('total_actual').'m',
                    '—',
                ],
                filename: 'team-product-report.pdf'
            );
        }

        return view('team-leader.reports.product',
            compact('data', 'startDate', 'endDate'));
    }

    // ── PRODUCTIVITY REPORT ──
    public function productivity(Request $request)
    {
        $startDate = $request->start_date
            ?? now()->startOfMonth()->format('Y-m-d');
        $endDate   = $request->end_date ?? today()->format('Y-m-d');
        $tl        = $this->getTL();

        $employees = $tl
            ? Employee::where('team_leader_id', $tl->id)->get()
            : collect();

        $employees = $employees->map(function($emp) use ($startDate, $endDate) {
            $logs = WorkLog::where('employee_id', $emp->id)
                ->whereBetween('start_time', [
                    $startDate.' 00:00:00',
                    $endDate.' 23:59:59'
                ])
                ->where('status', 'completed')
                ->get();

            $emp->tasks_done    = $logs->count();
            $emp->actual_time   = $logs->sum('actual_time');
            $emp->standard_time = $logs->sum('standard_time');
            $emp->time_saved    = $emp->standard_time - $emp->actual_time;
            $emp->efficiency    = round($logs->avg('efficiency') ?? 0, 1);
            return $emp;
        })
        ->sortByDesc('time_saved')
        ->values();

        if($request->export === 'pdf') {
            return $this->exportPdf(
                title:        'Productivity Report - Team',
                period:       $this->formatPeriod($startDate, $endDate),
                summaryBoxes: [
                    ['value' => $employees->count(),           'label' => 'Members'],
                    ['value' => $employees->sum('tasks_done'), 'label' => 'Total Tasks'],
                    ['value' => $employees->sum('time_saved').'m', 'label' => 'Time Saved'],
                ],
                headers: [
                    'Rank', 'Employee', 'Tasks Done',
                    'Std Time', 'Actual Time', 'Time Saved', 'Result'
                ],
                rows: $employees->map(fn($e, $i) => [
                    '#'.($i + 1),
                    $e->name,
                    $e->tasks_done,
                    $e->standard_time.'m',
                    $e->actual_time.'m',
                    ($e->time_saved >= 0 ? '+' : '').$e->time_saved.'m',
                    $e->time_saved >= 0 ? 'Fast' : 'Slow',
                ])->toArray(),
                filename: 'team-productivity.pdf'
            );
        }

        return view('team-leader.reports.productivity',
            compact('employees', 'startDate', 'endDate'));
    }
    public function standardActual(Request $request)
    {
        $startDate = $request->start_date ?? today()->format('Y-m-d');
        $endDate   = $request->end_date ?? today()->format('Y-m-d');
        $teamIds   = $this->getTeamIds();

        $logs = WorkLog::whereIn('employee_id', $teamIds)
            ->whereBetween('start_time', [
                $startDate.' 00:00:00',
                $endDate.' 23:59:59'
            ])
            ->where('status', 'completed')
            ->with(['employee', 'fittingType', 'project'])
            ->get();

        $summary = [
            'total_standard' => $logs->sum('standard_time'),
            'total_actual'   => $logs->sum('actual_time'),
            'total_variance' => $logs->sum('variance'),
            'avg_efficiency' => round($logs->avg('efficiency') ?? 0, 1),
            'on_time'        => $logs->where('variance', '<=', 0)->count(),
            'delayed'        => $logs->where('variance', '>', 0)->count(),
        ];

        if($request->export === 'pdf') {
            return $this->exportPdf(
                title:        'Standard vs Actual - Team',
                period:       $this->formatPeriod($startDate, $endDate),
                summaryBoxes: [
                    ['value' => $summary['total_standard'].'m', 'label' => 'Std Time'],
                    ['value' => $summary['total_actual'].'m',   'label' => 'Actual Time'],
                    ['value' => ($summary['total_variance'] > 0 ? '+' : '').$summary['total_variance'].'m', 'label' => 'Variance'],
                    ['value' => $summary['on_time'],            'label' => 'Fast'],
                    ['value' => $summary['delayed'],            'label' => 'Slow'],
                ],
                headers: [
                    'Employee', 'Product', 'Date',
                    'Standard', 'Actual', 'Variance', 'Result'
                ],
                rows: $logs->map(fn($l) => [
                    $l->employee->name ?? '—',
                    $l->fittingType->name ?? '—',
                    $l->start_time?->format('d M Y'),
                    $l->standard_time.'m',
                    $l->actual_time.'m',
                    ($l->variance > 0 ? '+' : '').$l->variance.'m',
                    $l->variance <= 0 ? 'Fast' : 'Slow',
                ])->toArray(),
                filename: 'team-std-vs-actual.pdf'
            );
        }

        return view('team-leader.reports.standard-actual',
            compact('logs', 'summary', 'startDate', 'endDate'));
    }

    // PENDING REPORT
    public function pending(Request $request)
    {
        $teamIds = $this->getTeamIds();

        $pending = WorkAssignment::whereIn('employee_id', $teamIds)
            ->whereIn('status', ['pending', 'in_progress'])
            ->with(['employee', 'fittingType', 'project'])
            ->orderBy('assigned_date')
            ->get();

        if($request->export === 'pdf') {
            return $this->exportPdf(
                title:        'Pending Work - Team',
                period:       today()->format('d M Y'),
                summaryBoxes: [
                    ['value' => $pending->count(), 'label' => 'Total Pending'],
                    ['value' => $pending->where('status','pending')->count(),    'label' => 'Not Started'],
                    ['value' => $pending->where('status','in_progress')->count(),'label' => 'In Progress'],
                ],
                headers: [
                    'Employee', 'Product', 'Project',
                    'Qty', 'Std Time', 'Date', 'Status'
                ],
                rows: $pending->map(fn($a) => [
                    $a->employee->name ?? '—',
                    $a->fittingType->name ?? '—',
                    $a->project->name ?? '—',
                    $a->quantity,
                    $a->standard_time.'m',
                    $a->assigned_date->format('d M Y'),
                    ucfirst($a->status),
                ])->toArray(),
                filename: 'team-pending.pdf'
            );
        }

        return view('team-leader.reports.pending',
            compact('pending'));
    }

    // COMPLETED REPORT
    public function completed(Request $request)
    {
        $startDate = $request->start_date ?? today()->format('Y-m-d');
        $endDate   = $request->end_date ?? today()->format('Y-m-d');
        $teamIds   = $this->getTeamIds();

        $logs = WorkLog::whereIn('employee_id', $teamIds)
            ->where('status', 'completed')
            ->whereBetween('updated_at', [
                $startDate.' 00:00:00',
                $endDate.' 23:59:59'
            ])
            ->with(['employee', 'fittingType', 'project'])
            ->latest()
            ->get();

        if($request->export === 'pdf') {
            $totalSaved = $logs->sum('standard_time') - $logs->sum('actual_time');
            return $this->exportPdf(
                title:        'Completed Work - Team',
                period:       $this->formatPeriod($startDate, $endDate),
                summaryBoxes: [
                    ['value' => $logs->count(), 'label' => 'Tasks Done'],
                    ['value' => $logs->sum('actual_time').'m', 'label' => 'Total Time'],
                    ['value' => ($totalSaved >= 0 ? '+' : '').$totalSaved.'m', 'label' => 'Time Saved'],
                ],
                headers: [
                    'Employee', 'Product', 'Project',
                    'Date', 'Std', 'Actual', 'Variance', 'Result'
                ],
                rows: $logs->map(fn($l) => [
                    $l->employee->name ?? '—',
                    $l->fittingType->name ?? '—',
                    $l->project->name ?? '—',
                    $l->start_time?->format('d M Y'),
                    $l->standard_time.'m',
                    $l->actual_time.'m',
                    ($l->variance > 0 ? '+' : '').$l->variance.'m',
                    $l->variance <= 0 ? 'Fast' : 'Slow',
                ])->toArray(),
                filename: 'team-completed.pdf'
            );
        }

        return view('team-leader.reports.completed',
            compact('logs', 'startDate', 'endDate'));
    }

    // ── SHARED PDF EXPORT METHOD ──
    private function exportPdf(
        string $title,
        string $period,
        array  $summaryBoxes = [],
        array  $headers      = [],
        array  $rows         = [],
        array  $footer       = [],
        string $filename     = 'report.pdf'
    ) {
        $pdf = Pdf::loadView('admin.reports.pdf.report', [
            'reportTitle'  => $title,
            'reportPeriod' => $period,
            'summaryBoxes' => $summaryBoxes,
            'tableHeaders' => $headers,
            'tableRows'    => $rows,
            'tableFooter'  => count($footer) > 0 ? $footer : null,
        ]);

        $pdf->setPaper('a4', 'landscape');

        return $pdf->download($filename);
    }
    private function formatPeriod(string $start, string $end): string
    {
        $s = \Carbon\Carbon::parse($start)->format('d M Y');
        $e = \Carbon\Carbon::parse($end)->format('d M Y');
        return $s === $e ? $s : "$s to $e";
    }
}