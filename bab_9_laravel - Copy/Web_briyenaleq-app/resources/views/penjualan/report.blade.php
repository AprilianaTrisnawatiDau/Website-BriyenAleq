<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Penjualan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; }
        table, th, td { border: 1px solid black; }
        th, td { padding: 5px; text-align: center; }
        img { width: 50px; }
    </style>
</head>
<body>
    <h2 style="text-align:center;">Laporan Penjualan</h2>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Nama</th>
                <th>Produk</th>
                <th>Alamat</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Foto</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $d)
            <tr>
                <td>{{ $d->tanggal }}</td>
                <td>{{ $d->nama }}</td>
                <td>{{ $d->produk }}</td>
                <td>{{ $d->alamat }}</td>
                <td>{{ $d->kategori }}</td>
                <td>Rp {{ number_format($d->harga,0,',','.') }}</td>
                <td>
                    @if($d->foto)
                        <img src="{{ public_path('storage/'.$d->foto) }}">
                    @else
                        -
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
