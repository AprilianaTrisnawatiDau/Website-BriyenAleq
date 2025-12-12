<?php
session_start();
$keranjang = $_SESSION['keranjang'] ?? [];
$total = 0;
foreach($keranjang as $item){
    $qty = isset($item['qty']) ? (int)$item['qty'] : 1;
    $total += $item['harga'] * $qty;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Keranjang Belanja</title>
<style>
body { font-family:"Poppins",sans-serif; background:#f7f9fc; margin:0; padding:20px; color:#333; }
.container { max-width:900px; margin:30px auto; background:#fff; padding:25px; border-radius:15px; box-shadow:0 6px 20px rgba(0,0,0,0.08); text-align:left; }
h2 { text-align:center; margin-bottom:20px; color:#16a34a; }
table { width:100%; border-collapse:collapse; margin-bottom:20px; }
th,td { border:1px solid #ccc; padding:8px; text-align:center; }
th { background:#16a34a; color:white; }
tr:nth-child(even) { background:#f0fdf4; }
.btn, .btn-back { display:inline-block; padding:8px 15px; background:#16a34a; color:white; border-radius:8px; text-decoration:none; font-weight:600; text-align:center; transition:all 0.3s ease; cursor:pointer; border:none; }
.btn:hover, .btn-back:hover { background:#15803d; }
form { display:inline; }
.total { text-align:right; font-size:16px; font-weight:600; margin-bottom:15px; }
.checkout-container { text-align:right; margin-top:10px; }
</style>
</head>
<body>
<a href="belanja.php" class="btn-back">⬅ Kembali Belanja</a>
<div class="container">
<h2>🛒 Keranjang Anda</h2>

<?php if(empty($keranjang)): ?>
<p>Keranjang masih kosong 😢</p>
<?php else: ?>
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
<?php foreach($keranjang as $key=>$item): ?>
<tr>
<td><?= htmlspecialchars($item['nama']) ?></td>
<td>Rp<?= number_format($item['harga'],0,',','.') ?></td>
<td><?= $item['qty'] ?? 1 ?></td>
<td>Rp<?= number_format(($item['harga']*($item['qty'] ?? 1)),0,',','.') ?></td>
<td>
<form action="keranjang_remove.php" method="get">
    <input type="hidden" name="key" value="<?= $key ?>">
    <button type="submit" class="btn">Hapus</button>
</form>
</td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
<p class="total">Total: Rp<?= number_format($total,0,',','.') ?></p>
<div class="checkout-container">
<form action="pembayaran.php" method="post">
    <button type="submit" class="btn">💳 Checkout</button>
</form>
</div>
<?php endif; ?>
</div>
</body>
</html>
