<?php
session_start();
$keranjang = $_SESSION['keranjang'] ?? [];

if(empty($keranjang)){
    header("Location: keranjang_view.php");
    exit;
}

// Simpan ID produk yang dibeli agar bisa kasih rating
$_SESSION['pembelian_sukses'] = array_map(fn($item) => $item['id'], $keranjang);

// Kosongkan keranjang
unset($_SESSION['keranjang']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pembayaran Berhasil</title>
<style>
body { font-family:"Poppins",sans-serif; background:#f7f9fc; margin:0; padding:20px; color:#333; }
.container { max-width:600px; margin:50px auto; padding:25px; background:#fff; border-radius:12px; text-align:center; box-shadow:0 6px 20px rgba(0,0,0,0.08);}
h2 { color:#16a34a; margin-bottom:20px; }
.btn { display:inline-block; padding:10px 20px; background:#16a34a; color:#fff; border-radius:8px; text-decoration:none; font-weight:600; transition:0.3s; margin:5px; }
.btn:hover { background:#15803d; }
</style>
</head>
<body>
<div class="container">
<h2>✅ Pembayaran Berhasil!</h2>
<p>Terima kasih telah melakukan pembelian.</p>
<a href="belanja.php" class="btn">⬅ Kembali Belanja</a>

<?php foreach($_SESSION['pembelian_sukses'] as $id_produk): ?>
    <a href="rating.php?id=<?= $id_produk ?>" class="btn">⭐ Kasih Rating Produk #<?= $id_produk ?></a>
<?php endforeach; ?>
</div>
</body>
</html>
