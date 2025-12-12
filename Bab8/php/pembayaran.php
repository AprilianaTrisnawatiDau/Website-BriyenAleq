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
<title>Pembayaran</title>
<style>
body { font-family:"Poppins",sans-serif; background:#f7f9fc; margin:0; padding:20px; color:#333; display:flex; justify-content:center; align-items:flex-start; min-height:100vh; }
.container { width:90%; max-width:700px; margin:40px auto; padding:30px; background:#fff; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
h1 { color:#16a34a; text-align:center; margin-bottom:25px; }
table { width:100%; border-collapse:collapse; margin-bottom:15px; }
th, td { padding:12px; text-align:left; border-bottom:1px solid #dee2e6; }
th { background:#16a34a; color:white; }
td:nth-child(2), td:nth-child(3), td:nth-child(4) { text-align:right; width:15%; }
select, button { padding:10px; border-radius:6px; margin-top:10px; }
.bayar { background:#28a745; color:#fff; font-weight:700; border:none; width:100%; cursor:pointer; font-size:1.1em; }
.bayar:hover { background:#1e7e34; }
</style>
</head>
<body>
<div class="container">
<h1>💳 Pembayaran</h1>

<?php if(empty($keranjang)): ?>
<p>Keranjang kosong 😢</p>
<a href="belanja.php" class="btn">← Kembali Belanja</a>
<?php else: ?>

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
<?php foreach($keranjang as $item): 
$qty = isset($item['qty']) ? (int)$item['qty'] : 1;
?>
<tr>
<td><?= htmlspecialchars($item['nama']) ?></td>
<td>Rp<?= number_format($item['harga'],0,',','.') ?></td>
<td><?= $qty ?></td>
<td>Rp<?= number_format($item['harga']*$qty,0,',','.') ?></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>

<h3>Total: Rp<?= number_format($total,0,',','.') ?></h3>

<form method="post" action="proses_bayar.php">
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

<?php endif; ?>
</div>
</body>
</html>
