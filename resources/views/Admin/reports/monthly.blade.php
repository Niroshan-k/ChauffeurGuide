<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Monthly Report - {{ $month }}</title>
    <style>
        body { 
            font-family: Arial, sans-serif;
            margin: 40px;
        }
        .header { 
            text-align: center;
            margin-bottom: 30px;
        }
        table { 
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        th, td { 
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }
        th { 
            background-color: #f5f5f5;
        }
        .summary-box {
            background: #f8f9fa;
            padding: 20px;
            margin-bottom: 30px;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Monthly Report - {{ $month }}</h1>
    </div>
    
    <div class="summary-box">
        <h2>Monthly Summary</h2>
        <p>Total Guides: {{ $guides->count() }}</p>
        <p>Total Visits: {{ $visits->count() }}</p>
        <p>Total Tourists: {{ $totalTourists }}</p>
    </div>
    
    <h2>Visit Details</h2>
    <table>
        <thead>
            <tr>
                <th>Date</th>
                <th>Guide Name</th>
                <th>Tourist Count</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visits as $visit)
            <tr>
                <td>{{ $visit->created_at->format('Y-m-d') }}</td>
                <td>{{ $visit->guide->full_name }}</td>
                <td>{{ $visit->pax_count }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div style="margin-top: 50px; text-align: center; font-size: 12px; color: #666;">
        Generated on {{ now()->format('Y-m-d H:i:s') }}
        <br>
        © {{ date('Y') }} Engage Lanka, a subsidiary of Softmaster Technologies (Pvt) Ltd.
    </div>
</body>
</html>