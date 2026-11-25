<?php

namespace App\Exports;

use App\Models\WorkLog;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkLogExport implements FromCollection, WithHeadings, WithStyles
{
    protected $date;
    protected $startDate;
    protected $endDate;

    public function __construct($date = null, $startDate = null, $endDate = null)
    {
        $this->date      = $date;
        $this->startDate = $startDate;
        $this->endDate   = $endDate;
    }

    public function collection()
    {
        $query = WorkLog::with(['employee', 'fittingType', 'project'])
            ->where('status', 'completed');

        if($this->date) {
            $query->whereDate('start_time', $this->date);
        } elseif($this->startDate && $this->endDate) {
            $query->whereBetween('start_time', [
                $this->startDate.' 00:00:00',
                $this->endDate.' 23:59:59'
            ]);
        }

        return $query->get()->map(function($log) {
            return [
                'Employee'      => $log->employee->name ?? '—',
                'Product'       => $log->fittingType->name ?? '—',
                'Project'       => $log->project->name ?? '—',
                'Start Time'    => $log->start_time?->format('d M Y h:i A'),
                'End Time'      => $log->end_time?->format('d M Y h:i A'),
                'Standard(min)' => $log->standard_time,
                'Actual(min)'   => $log->actual_time,
                'Variance(min)' => $log->variance,
                'Efficiency%'   => $log->efficiency,
            ];
        });
    }

    public function headings(): array
    {
        return [
            'Employee',
            'Product',
            'Project',
            'Start Time',
            'End Time',
            'Standard (mins)',
            'Actual (mins)',
            'Variance (mins)',
            'Efficiency %',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => [
                'font' => ['bold' => true],
                'fill' => [
                    'fillType' => 'solid',
                    'color'    => ['rgb' => 'F97316'],
                ],
            ],
        ];
    }
}