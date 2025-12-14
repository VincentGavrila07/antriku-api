<!DOCTYPE html>
<html>
<head>
    <title>Service Report {{ $report_date }}</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            margin: 0;
            padding: 0;
        }

        /* Header Styling */
        .header-container {
            width: 100%;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb; /* Warna Biru Antriku */
            padding-bottom: 15px;
        }
        
        .header-table {
            width: 100%;
            border: none;
        }

        .company-info h2 {
            margin: 0;
            color: #1e3a8a; /* Biru Tua */
            font-size: 24px;
            text-transform: uppercase;
        }

        .company-info p {
            margin: 2px 0;
            color: #666;
            font-size: 11px;
        }

        /* Data Table Styling */
        .data-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .data-table th {
            background-color: #2563eb; /* Header Biru */
            color: #ffffff;
            font-weight: bold;
            text-transform: uppercase;
            padding: 10px 8px;
            border: 1px solid #1d4ed8;
            font-size: 11px;
        }

        .data-table td {
            padding: 8px;
            border: 1px solid #ddd;
            color: #444;
        }

        /* Zebra Striping (Baris selang-seling) */
        .data-table tr:nth-child(even) {
            background-color: #f3f4f6;
        }

        /* Status Badge Styling */
        .status-text {
            font-weight: bold;
        }

        /* Footer */
        .footer {
            margin-top: 30px;
            text-align: right;
            font-size: 10px;
            color: #888;
            font-style: italic;
        }
    </style>
</head>
<body>

    <div class="header-container">
        <table class="header-table">
            <tr>
                <td style="width: 30%; vertical-align: middle;">
                    <?php
                        // Definisikan path gambar
                        $path = public_path('assets/LogoAntriku3NoBG.png');
                        $base64 = null;

                        // Cek apakah file ada sebelum di-encode
                        if (file_exists($path)) {
                            $type = pathinfo($path, PATHINFO_EXTENSION);
                            $data = file_get_contents($path);
                            $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                        }
                    ?>

                    @if($base64)
                        <img src="{{ $base64 }}" style="height: 50px;" alt="Antriku Logo">
                    @else
                        <h2 style="color: #2563eb; margin: 0;">ANTRIKU</h2>
                    @endif
                </td>
                
                <td style="width: 70%; text-align: right; vertical-align: middle;">
                    <div class="company-info">
                        <h2>Service Report</h2>
                        <p>Generated Date: {{ $report_date }}</p>
                        <p>System: Antriku Management System</p>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th style="width: 5%; text-align: center;">No</th>
                <th style="width: 15%;">Queue Code</th>
                <th style="width: 20%;">Customer</th>
                <th style="width: 20%;">Service</th>
                <th style="width: 10%; text-align: center;">Status</th>
                <th style="width: 15%;">Queue Date</th>
                <th style="width: 15%;">Created At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transactions as $index => $t)
            <tr>
                <td style="text-align: center;">{{ $index + 1 }}</td>
                
                <td style="font-weight: bold; color: #2563eb;">
                    {{ strtoupper($t->service->code ?? '') . $t->queue_number }}
                </td>
                
                <td>{{ $t->user->name ?? '-' }}</td>
                
                <td>{{ $t->service->name ?? '-' }}</td>
                
                <td style="text-align: center;">
                    <span class="status-text">{{ ucfirst($t->status) }}</span>
                </td>
                
                <td style="font-size: 11px;">{{ $t->queue_date }}</td>
                
                <td style="font-size: 11px;">{{ $t->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="footer">
        <p>This document is computer generated. No signature is required.</p>
    </div>

</body>
</html>