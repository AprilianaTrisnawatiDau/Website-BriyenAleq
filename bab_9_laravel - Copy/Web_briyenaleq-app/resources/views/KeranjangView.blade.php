<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keranjang Belanja</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
    <a href="{{ route('belanja') }}" class="btn btn-back">⬅ Kembali Belanja</a>
    <h2>🛒 Keranjang Anda</h2>

    @if(empty($keranjang))
    <p>Keranjang masih kosong 😢</p>
    @else
    <table>
        <thead>
            <tr>
                <th>Produk</th>
                <th>Harga</th>
                <th>Qty</th>
                <th>Subtotal</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @foreach($keranjang as $key=>$item)
            <tr>
                <td>{{ $item['nama'] }}</td>
                <td>Rp{{ number_format($item['harga'],0,',','.') }}</td>
                <td>{{ $item['qty'] }}</td>
                <td>Rp{{ number_format($item['harga']*$item['qty'],0,',','.') }}</td>
                <td>
                    <a href="{{ route('keranjang.remove', $key) }}" class="btn">Hapus</a>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
    <p class="total">Total: Rp{{ number_format($total,0,',','.') }}</p>
    <div class="checkout-container">
        <a href="{{ route('checkout') }}" class="btn">💳 Checkout</a>
    </div>
    @endif
</div>
</body>
</html>
