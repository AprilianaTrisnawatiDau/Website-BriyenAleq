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
<title>Keranjang Belanja</title>
<link rel="stylesheet" href="../css/keranjang.css">
</head>
<body>
<div class="container">
    <h1>🛒 Keranjang Belanja</h1>
    <?php if(empty($keranjang)): ?>
        <p>Keranjang kosong 😢</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Produk</th>
                    <th>Varian</th>
                    <th>Harga</th>
                    <th>Qty</th>
                    <th>Subtotal</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($keranjang as $index=>$item): ?>
                <tr>
                    <td><?= htmlspecialchars($item['nama']) ?></td> <td><?= htmlspecialchars($item['varian']) ?></td>
                    <td>Rp<?= number_format($item['harga'],0,',','.') ?></td>
                    <td><?= $item['qty'] ?></td>
                    <td>Rp<?= number_format($item['harga']*$item['qty'],0,',','.') ?></td>
                    
                    <td><a href="keranjang_remove.php?index=<?= $index ?>" class="hapus">Hapus</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <h3>Total: Rp<?= number_format($total,0,',','.') ?></h3>
        <a href="pembayaran.php" class="bayar">Bayar Sekarang</a>
    <?php endif; ?>
    <div style="margin-top:20px;"><a href="belanja.php" class="lanjut">← Lanjut Belanja</a></div>
</div>
</body>
</html>