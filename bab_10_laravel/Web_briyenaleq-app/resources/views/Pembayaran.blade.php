<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran</title>
<link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="container">
<h2>💳 Pembayaran</h2>

@if(empty($keranjang))
<p>Keranjang kosong 😢</p>
<a href="{{ url('/Belanja') }}" class="btn">← Kembali Belanja</a>
@else
<table>
<thead>
<tr>
<th>Produk</th>
<th>Harga</th>
<th>Qty</th>
<th>Subtotal</th>
</tr>
</thead>
<tbody>
@foreach($keranjang as $item)
<tr>
<td>{{ $item['nama'] }}</td>
<td>Rp{{ number_format($item['harga'],0,',','.') }}</td>
<td>{{ $item['qty'] ?? 1 }}</td>
<td>Rp{{ number_format($item['harga']*($item['qty'] ?? 1),0,',','.') }}</td>
</tr>
@endforeach
</tbody>
</table>

<h3>Total: Rp{{ number_format($total ?? 0,0,',','.') }}</h3>

<form method="post" action="{{ url('/Pembayaran/Proses') }}">
@csrf
<label>Pilih Metode Pembayaran:</label>
<select name="metode" required>
<option value="">--Pilih Metode--</option>
<option value="Transfer Bank">Transfer Bank</option>
<option value="COD">COD</option>
<option value="E-Wallet">E-Wallet</option>
</select>
<br>
<button type="submit" class="bayar">💳 Bayar Sekarang</button>
</form>
@endif
</div>
</body>
</html>
