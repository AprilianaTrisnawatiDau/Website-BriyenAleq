<?php
session_start();
$conn = mysqli_connect("localhost","root","", "website_briyenaleq");

if(!$conn){
    die("Koneksi gagal: " . mysqli_connect_error());
}

$id_produk = intval($_POST['id_produk'] ?? 0);
$rating    = intval($_POST['rating'] ?? 0);

// Validasi
if($id_produk <= 0 || $rating < 1 || $rating > 5){
    die("❌ Input tidak valid.");
}

// Cek kalau produk pernah dibeli
$dibeli = $_SESSION['pembelian_sukses'] ?? [];
if(!in_array($id_produk, $dibeli)){
    die("❌ Produk belum dibeli.");
}

// Masukkan rating
$sql = "INSERT INTO rating_produk (id_produk, rating) VALUES ($id_produk, $rating)";
$success = mysqli_query($conn, $sql);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Rating Produk</title>
<style>
body {
    font-family:"Poppins",sans-serif;
    background:#f7f9fc;
    margin:0;
    padding:0;
    display:flex;
    justify-content:center;
    align-items:center;
    min-height:100vh;
    color:#333;
}
.container {
    background:#fff;
    padding:25px;
    border-radius:12px;
    box-shadow:0 6px 20px rgba(0,0,0,0.08);
    text-align:center;
    max-width:400px;
    width:90%;
}
h2 {
    color:#16a34a;
    margin-bottom:20px;
}
.message {
    font-size:1em;
    margin-bottom:20px;
}
a.btn {
    display:inline-block;
    padding:10px 20px;
    background:#16a34a;
    color:white;
    border-radius:8px;
    text-decoration:none;
    font-weight:600;
    transition:0.3s;
}
a.btn:hover {
    background:#15803d;
}
</style>
</head>
<body>
<div class="container">
<h2>⭐ Rating Produk</h2>
<p class="message">
<?php
if($success){
    echo "✅ Terima kasih, rating berhasil dikirim!";
} else {
    echo "❌ Terjadi kesalahan: " . mysqli_error($conn);
}
?>
</p>
<a href="belanja.php" class="btn">⬅ Kembali Belanja</a>
</div>
</body>
</html>
