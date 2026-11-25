<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
            color: #1e293b;
            padding: 20px;
        }
        .header {
            border-bottom: 3px solid #f97316;
            padding-bottom: 12px;
            margin-bottom: 16px;
        }
        .header h1 {
            font-size: 18px;
            color: #f97316;
            margin-bottom: 2px;
        }
        .header p {
            font-size: 10px;
            color: #64748b;
        }
        .summary {
            display: table;
            width: 100%;
            margin-bottom: 16px;
        }
        .summary-box {
            display: table-cell;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            padding: 8px 12px;
            text-align: center;
            width: 20%;
        }
        .summary-box .val {
            font-size: 16px;
            font-weight: bold;
            color: #0f172a;
        }
        .summary-box .lbl {
            font-size: 9px;
            color: #64748b;
            margin-top: 2px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        thead th {
            background: #f97316;
            color: white;
            padding: 8px 10px;
            text-align: left;
            font-size: 10px;
        }
        tbody td {
            padding: 7px 10px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 10px;
        }
        tbody tr:nth-child(even) td {
            background: #f8fafc;
        }
        tfoot td {
            padding: 8px 10px;
            background: #f1f5f9;
            font-weight: bold;
            border-top: 2px solid #e2e8f0;
            font-size: 10px;
        }
        .fast { color: #16a34a; font-weight: bold; }
        .slow { color: #dc2626; font-weight: bold; }
        .badge {
            background: #fff7ed;
            color: #ea580c;
            padding: 2px 6px;
            border-radius: 4px;
            font-size: 9px;
        }
        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #e2e8f0;
            font-size: 9px;
            color: #94a3b8;
            text-align: right;
        }
    </style>
</head>
<body>

    {{-- Header --}}
    <div class="header">
        <h1>Kitchen Work Tracker</h1>
        <p>{{ $reportTitle }} | {{ $reportPeriod }}</p>
    </div>

    {{-- Summary Boxes --}}
    @if(isset($summaryBoxes) && count($summaryBoxes) > 0)
    <div class="summary">
        @foreach($summaryBoxes as $box)
            <div class="summary-box">
                <div class="val">{{ $box['value'] }}</div>
                <div class="lbl">{{ $box['label'] }}</div>
            </div>
        @endforeach
    </div>
    @endif

    {{-- Table --}}
    <table>
        <thead>
            <tr>
                @foreach($tableHeaders as $header)
                    <th>{{ $header }}</th>
                @endforeach
            </tr>
        </thead>
        <tbody>
            @forelse($tableRows as $row)
                <tr>
                    @foreach($row as $cell)
                        <td>{{ $cell }}</td>
                    @endforeach
                </tr>
            @empty
                <tr>
                    <td colspan="{{ count($tableHeaders) }}"
                        style="text-align:center; padding: 20px; color: #94a3b8;">
                        No data for selected period!
                    </td>
                </tr>
            @endforelse
        </tbody>
        @if(isset($tableFooter))
        <tfoot>
            <tr>
                @foreach($tableFooter as $cell)
                    <td>{{ $cell }}</td>
                @endforeach
            </tr>
        </tfoot>
        @endif
    </table>

    <div class="footer">
        Generated on {{ now()->format('d M Y, h:i A') }} |
        Kitchen Work Tracker
    </div>

</body>
</html>