<?php
session_start();

$keranjang = $_SESSION['keranjang'] ?? [];

$total = 0;
foreach($keranjang as $item){
    $total += $item['harga'] * $item['qty'];
}

?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran</title>
<link rel="stylesheet" href="../css/pembayaran.css">
</head>
<body>
<div class="container">
    <h1>💳 Pembayaran</h1>
    <?php if(empty($keranjang)): ?>
        <p>Keranjang kosong 😢</p>
        <a href="belanja.php" class="lanjut">← Kembali Belanja</a>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Varian</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                
                <?php foreach($keranjang as $index=>$item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama']) ?></td>
                    <td><?= htmlspecialchars($item['varian']) ?></td>
                    <td>Rp<?= number_format($item['harga'],0,',','.') ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td>Rp<?= number_format($item['harga']*$item['qty'],0,',','.') ?></td>
                </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>

        <h3>Total Pembayaran: Rp<?= number_format($total,0,',','.') ?></h3>

        <form method="post" action="proses_bayar.php">
            <label>Metode Pembayaran:</label><br>
            <select name="metode" required>
                <option value="">--Pilih Metode--</option>
                <option value="Transfer Bank">Transfer Bank</option>
                <option value="COD">COD</option>
                <option value="E-Wallet">E-Wallet</option>
            </select><br><br>
            <button type="submit" class="bayar">Bayar Sekarang</button>
        </form>
    <?php endif; ?>
</div>
</body>
</html>