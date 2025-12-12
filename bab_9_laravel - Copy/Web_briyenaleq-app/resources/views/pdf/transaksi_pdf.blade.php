<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        th, td {
            border: 1px solid #333;
            padding: 6px;
            text-align: left;
            vertical-align: middle;
        }
        th {
            background-color: #064b1e;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        .img-container {
            text-align: center;
        }
        .bukti-img {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .no-image {
            color: #999;
            font-style: italic;
            font-size: 10px;
        }
        .header {
            text-align: center;
            margin-bottom: 15px;
        }
        .header h2 {
            margin-bottom: 5px;
            color: #064b1e;
        }
        .header p {
            color: #666;
            font-size: 10px;
        }
        .footer {
            margin-top: 20px;
            text-align: center;
            font-size: 9px;
            color: #666;
            padding-top: 10px;
        }
        .status-success {
            color: #0f6f33;
            font-weight: bold;
        }
        .status-pending {
            color: #8a6300;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Laporan Data Transaksi</h2>
        <p>Dicetak pada: {{ date('d/m/Y H:i:s') }}</p>
        <p>Total Data: {{ count($transaksi) }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Bukti Transaksi</th> <!-- Kolom baru untuk gambar -->
            </tr>
        </thead>
        <tbody>
            @forelse($transaksi as $index => $t)
                <tr>
                    <td style="text-align: center;">{{ $loop->iteration }}</td>
                    <td>{{ date('d/m/Y', strtotime($t->tanggal)) }}</td>
                    <td>{{ $t->nama }}</td>
                    <td>{{ $t->produk }}</td>
                    <td>{{ $t->kategori }}</td>
                    <td>Rp {{ number_format($t->harga, 0, ',', '.') }}</td>
                    <td class="{{ $t->status == 'Success' ? 'status-success' : 'status-pending' }}">
                        {{ $t->status }}
                    </td>
                    <td class="img-container">
                        @if($t->bukti && Storage::disk('public')->exists($t->bukti))
                            @php
                                $imagePath = storage_path('app/public/' . $t->bukti);
                            @endphp
                            <img src="{{ $imagePath }}" class="bukti-img" alt="Bukti Transaksi">
                        @else
                            <span class="no-image">Tidak ada bukti</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" style="text-align: center; color: #999; font-style: italic;">
                        Tidak ada data transaksi
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Total Harga: Rp {{ number_format($transaksi->sum('harga'), 0, ',', '.') }}</p>
        <p>© {{ date('Y') }} BriyenAleq - Sistem Manajemen Transaksi</p>
    </div>
</body>
</html>
