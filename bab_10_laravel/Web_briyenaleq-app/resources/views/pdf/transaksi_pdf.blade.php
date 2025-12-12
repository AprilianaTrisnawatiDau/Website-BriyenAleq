<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Data Transaksi</title>
    <style>
        body { font-family: Arial, sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { border: 1px solid #333; padding: 6px; text-align: left; }
        th { background-color: #064b1e; color: white; }
    </style>
</head>
<body>
    <h2>Data Transaksi</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Produk</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($transaksi as $t)
                <tr>
                    <td>{{ $t->tanggal }}</td>
                    <td>{{ $t->nama }}</td>
                    <td>{{ $t->produk }}</td>
                    <td>{{ $t->kategori }}</td>
                    <td>Rp {{ number_format($t->harga,0,',','.') }}</td>
                    <td>{{ $t->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
