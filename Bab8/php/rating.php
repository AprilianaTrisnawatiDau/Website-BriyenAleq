<?php
session_start();
$conn = mysqli_connect("localhost","root","","website_briyenaleq");
if(!$conn){
    die("Koneksi gagal: ".mysqli_connect_error());
}

$id_produk = $_GET['id'] ?? null;
if(!$id_produk || !is_numeric($id_produk)){
    echo "❌ Produk tidak valid.";
    exit;
}

// Cek apakah produk ini sudah dibeli
$dibeli = $_SESSION['pembelian_sukses'] ?? [];
if(!in_array($id_produk, $dibeli)){
    echo "❌ Anda belum membeli produk ini, jadi belum bisa kasih rating.";
    exit;
}

// Ambil data produk
$res = mysqli_query($conn,"SELECT produk, harga FROM penjualan WHERE id=$id_produk");
$produk = mysqli_fetch_assoc($res);
if(!$produk){
    echo "❌ Produk tidak ditemukan.";
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rating Produk</title>
<style>
body { font-family:"Poppins",sans-serif; background:#f7f9fc; margin:0; padding:20px; color:#333; display:flex; justify-content:center; align-items:center; min-height:100vh; }
.container { max-width:400px; width:100%; padding:25px; background:#fff; border-radius:12px; box-shadow:0 6px 20px rgba(0,0,0,0.08); text-align:center; }
h2 { color:#16a34a; margin-bottom:20px; }
select, button { padding:10px; border-radius:6px; margin-top:10px; width:100%; }
button { background:#16a34a; color:white; border:none; font-weight:600; cursor:pointer; }
button:hover { background:#15803d; }
</style>
</head>
<body>
<div class="container">
<h2>⭐ Kasih Rating Produk</h2>
<p><?= htmlspecialchars($produk['produk']) ?> - Rp<?= number_format($produk['harga'],0,',','.') ?></p>
<form action="proses_rating.php" method="post">
    <input type="hidden" name="id_produk" value="<?= $id_produk ?>">
    <label>Pilih Rating:</label>
    <select name="rating" required>
        <option value="">--Pilih--</option>
        <option value="1">1 ⭐</option>
        <option value="2">2 ⭐</option>
        <option value="3">3 ⭐</option>
        <option value="4">4 ⭐</option>
        <option value="5">5 ⭐</option>
    </select>
    <button type="submit">Kirim Rating</button>
</form>
<a href="belanja.php" style="display:inline-block; margin-top:15px; text-decoration:none; color:#16a34a;">⬅ Kembali Belanja</a>
</div>
</body>
</html>
