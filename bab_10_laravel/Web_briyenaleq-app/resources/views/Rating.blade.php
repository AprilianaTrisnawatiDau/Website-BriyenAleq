<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rating Produk</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <h2>⭐ Kasih Rating Produk</h2>

    <p>{{ $produk->produk }} - Rp{{ number_format($produk->harga,0,',','.') }}</p>

    <form action="{{ route('rating.process') }}" method="post">
        @csrf

      
        <input type="hidden" name="id_penjualan" value="{{ $produk->id }}">


        <label>Pilih Rating:</label>
        <select name="rating" required>
            <option value="">--Pilih--</option>
            <option value="1">1 ⭐</option>
            <option value="2">2 ⭐</option>
            <option value="3">3 ⭐</option>
            <option value="4">4 ⭐</option>
            <option value="5">5 ⭐</option>
        </select>

        <button type="submit" class="btn">Kirim Rating</button>
    </form>

    <a href="{{ route('belanja') }}" class="btn">⬅ Kembali Belanja</a>
</div>
</body>
</html>
