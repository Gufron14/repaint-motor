<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Pendapatan</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h1 {
            margin: 0;
            padding: 0;
            font-size: 18px;
        }
        .header p {
            margin: 5px 0;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        table th {
            background-color: #f2f2f2;
        }
        .footer {
            margin-top: 20px;
            text-align: right;
        }
        .text-right {
            text-align: right;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>LAPORAN PENDAPATAN HYPE CUSTOM PROJECT</h1>
        <p>Periode: {{ \Carbon\Carbon::parse($startDate)->format('d-m-Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->format('d-m-Y') }}</p>
    </div>
    
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama Customer</th>
                <th>Tipe Motor</th>
                <th>Repaint</th>
                <th>Harga</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @forelse($laporan as $item)
                @foreach($item['jenis_repaints'] as $index => $repaint)
                    <tr>
                        @if($index === 0)
                            <td rowspan="{{ $item['rowspan'] }}">{{ $item['tanggal'] }}</td>
                            <td rowspan="{{ $item['rowspan'] }}">{{ $item['nama_customer'] }}</td>
                            <td rowspan="{{ $item['rowspan'] }}">{{ $item['tipe_motor'] }}</td>
                        @endif
                        <td>{{ $repaint['nama_repaint'] }}</td>
                        <td class="text-right">Rp {{ number_format($repaint['harga'] ?? 0, 0, ',', '.') }}</td>
                        @if($index === 0)
                            <td rowspan="{{ $item['rowspan'] }}" class="text-right">Rp {{ number_format($item['total_harga'], 0, ',', '.') }}</td>
                        @endif
                    </tr>
                @endforeach
            @empty
                <tr>
                    <td colspan="6" style="text-align: center">Tidak ada data laporan</td>
                </tr>
            @endforelse
        </tbody>
        <tfoot>
            <tr>
                <th colspan="5" class="text-right">Total Pendapatan:</th>
                <th class="text-right">Rp {{ number_format($totalPendapatan, 0, ',', '.') }}</th>
            </tr>
        </tfoot>
    </table>
    
    <div class="footer">
        <p>Dicetak pada: {{ now()->format('d-m-Y H:i:s') }}</p>
    </div>
</body>
</html>
