<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Daily Report - {{ $date }}</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; color: #333; }
        h1 { color: #ea580c; font-size: 18px; margin-bottom: 5px; }
        .subtitle { color: #666; font-size: 11px; margin-bottom: 20px; }
        .summary { display: flex; gap: 10px; margin-bottom: 20px; }
        .stat { background: #f3f4f6; padding: 10px 15px; border-radius: 8px; text-align: center; }
        .stat-value { font-size: 20px; font-weight: bold; color: #1f2937; }
        .stat-label { font-size: 10px; color: #6b7280; margin-top: 2px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #ea580c; color: white; padding: 8px 10px; text-align: left; font-size: 10px; }
        td { padding: 7px 10px; border-bottom: 1px solid #e5e7eb; font-size: 11px; }
        tr:nth-child(even) { background: #f9fafb; }
        .fast { color: #16a34a; }
        .slow { color: #dc2626; }
    </style>
</head>
<body>

    <h1>Kitchen Work Tracker</h1>
    <p class="subtitle">
        Daily Report — {{ \Carbon\Carbon::parse($date)->format('d F Y') }}
    </p>

    {{-- Summary --}}
    <table style="margin-bottom: 20px;">
        <tr>
            <td style="padding: 8px 15px; background: #f3f4f6; border-radius: 4px; text-align: center;">
                <div style="font-size: 18px; font-weight: bold;">{{ $summary['total_tasks'] }}</div>
                <div style="font-size: 10px; color: #666;">Total Tasks</div>
            </td>
            <td style="width: 10px;"></td>
            <td style="padding: 8px 15px; background: #f3f4f6; border-radius: 4px; text-align: center;">
                <div style="font-size: 18px; font-weight: bold; color: #16a34a;">{{ $summary['completed'] }}</div>
                <div style="font-size: 10px; color: #666;">Completed</div>
            </td>
            <td style="width: 10px;"></td>
            <td style="padding: 8px 15px; background: #f3f4f6; border-radius: 4px; text-align: center;">
                <div style="font-size: 18px; font-weight: bold;">{{ $summary['total_standard'] }}m</div>
                <div style="font-size: 10px; color: #666;">Standard Mins</div>
            </td>
            <td style="width: 10px;"></td>
            <td style="padding: 8px 15px; background: #f3f4f6; border-radius: 4px; text-align: center;">
                <div style="font-size: 18px; font-weight: bold;">{{ $summary['total_actual'] }}m</div>
                <div style="font-size: 10px; color: #666;">Actual Mins</div>
            </td>
            <td style="width: 10px;"></td>
            <td style="padding: 8px 15px; background: #f3f4f6; border-radius: 4px; text-align: center;">
                <div style="font-size: 18px; font-weight: bold; color: {{ $summary['avg_efficiency'] >= 100 ? '#16a34a' : '#ea580c' }};">{{ $summary['avg_efficiency'] }}%</div>
                <div style="font-size: 10px; color: #666;">Avg Efficiency</div>
            </td>
        </tr>
    </table>

    {{-- Detail Table --}}
    <table>
        <thead>
            <tr>
                <th>Employee</th>
                <th>Product</th>
                <th>Project</th>
                <th>Start</th>
                <th>End</th>
                <th>Std (m)</th>
                <th>Actual (m)</th>
                <th>Variance</th>
                <th>Eff%</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logs as $log)
                <tr>
                    <td>{{ $log->employee->name }}</td>
                    <td>{{ $log->fittingType->name }}</td>
                    <td>{{ $log->project->name ?? '—' }}</td>
                    <td>{{ $log->start_time?->format('h:i A') }}</td>
                    <td>{{ $log->end_time?->format('h:i A') ?? '—' }}</td>
                    <td>{{ $log->standard_time }}</td>
                    <td>{{ $log->actual_time ?? '—' }}</td>
                    <td class="{{ ($log->variance ?? 0) <= 0 ? 'fast' : 'slow' }}">
                        {{ $log->variance !== null ? (($log->variance > 0 ? '+' : '').$log->variance) : '—' }}
                    </td>
                    <td class="{{ ($log->efficiency ?? 0) >= 100 ? 'fast' : 'slow' }}">
                        {{ $log->efficiency ?? '—' }}{{ $log->efficiency ? '%' : '' }}
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center; color: #666; padding: 20px;">
                        No data for this date
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <p style="margin-top: 20px; color: #999; font-size: 10px; text-align: right;">
        Generated on {{ now()->format('d M Y h:i A') }}
    </p>

</body>
</html>