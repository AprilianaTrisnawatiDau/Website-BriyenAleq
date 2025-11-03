<?php
session_start();
$metode = $_POST['metode'] ?? '';
if(isset($_SESSION['keranjang']) && !empty($_SESSION['keranjang'])){
    $total = 0;
    foreach($_SESSION['keranjang'] as $item){
        $total += $item['harga']*$item['qty'];
    }
    session_unset();
    session_destroy();
} else {
    header('Location: belanja.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran Berhasil</title>
<link rel="stylesheet" href="../css/pembayaran.css">
</head>
<body>
<div class="container">
    <h1>✅ Pembayaran Berhasil!</h1>
    <p>Total: Rp<?= number_format($total,0,',','.') ?></p>
    <p>Metode Pembayaran: <?= htmlspecialchars($metode) ?></p>
    <a href="belanja.php" class="lanjut">← Kembali Belanja</a>
</div>
</body>
</html>
