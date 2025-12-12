<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran Berhasil</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h2>✅ Pembayaran Berhasil!</h2>
    <p>Terima kasih telah melakukan pembelian.</p>
    <a href="{{ route('belanja') }}" class="btn">⬅ Kembali Belanja</a>

    @foreach($pembelian_sukses as $id_produk)
    <a href="{{ route('rating.show', $id_produk) }}" class="btn">⭐ Kasih Rating Produk #{{ $id_produk }}</a>
    @endforeach
</div>
</body>
</html>
