<?php
session_start();
$conn = mysqli_connect("localhost","root","","website_briyenaleq");

$produkList = [];
if($conn){
    $res = mysqli_query($conn,"SELECT * FROM penjualan ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($res)){
        $id_produk = $row['id'];

        $ratingQuery = mysqli_query($conn,"SELECT AVG(rating) as avg_rating FROM rating_produk WHERE id_produk=$id_produk");
        $ratingData = mysqli_fetch_assoc($ratingQuery);
        $avgRating = $ratingData['avg_rating'];
        $ratingFinal = $avgRating ? round($avgRating,1) : 0;

        $produkList[] = [
            "id"        => $id_produk,
            "nama"      => $row['produk'],
            "kategori"  => $row['kategori'],
            "harga"     => (int)$row['harga'],
            "varian"    => $row['varian'] ?? '', // aman dari undefined
            "rating"    => $ratingFinal,
            "gambar"    => "../images/produk/".$row['foto'],
            "alamat"    => $row['alamat']
        ];
    }
}

// Filter kategori
$kategoriDipilih = $_GET['kategori'] ?? 'Semua';
$produkFiltered = ($kategoriDipilih==='Semua') ? $produkList : array_filter($produkList, fn($p)=>$p['kategori']===$kategoriDipilih);
$kategoriList = array_unique(array_map(fn($p)=>$p['kategori'],$produkList));
sort($kategoriList);

// Produk yang sudah dibeli untuk bisa kasih rating
$dibeli = $_SESSION['pembelian_sukses'] ?? [];
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Belanja Produk</title>
<link rel="stylesheet" href="../css/belanja.css">
<style>
.produk-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill,minmax(240px,1fr));
    gap: 25px;
}
.produk-card {
    background:#fff;
    border-radius:15px;
    box-shadow:0 4px 10px rgba(0,0,0,0.08);
    padding:15px;
    text-align:center;
}
.produk-card img {
    width:100%;
    height:160px;
    object-fit:cover;
    border-radius:12px;
    margin-bottom:10px;
}
.produk-card h3 { font-size:18px; margin-bottom:5px; color:#16a34a; }
.rating { font-size:14px; color:#16a34a; margin-bottom:5px; }
.harga { font-size:16px; font-weight:600; color:#16a34a; margin-bottom:5px; }
.varian { font-size:12px; color:#555; margin-bottom:5px; }
.alamat { font-size:12px; color:#333; margin-bottom:12px; }
.btn-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}
.btn-group .btn {
    display: block;
    width: 100%;
    text-align: center;
    padding: 8px 0;
    border-radius: 8px;
    white-space: nowrap;
    font-weight: 600;
    text-decoration: none;
    color: white;
    background:#16a34a;
    transition: 0.3s;
}
.btn-group .btn:hover {
    background:#15803d;
}
.btn-disabled {
    background:#ccc !important;
    cursor:not-allowed;
}
</style>
</head>
<body>
<a href="../pembeli.html" class="btn btn-back">⬅ Kembali</a>
<div class="container">
<h2>🛒 Belanja Produk Tani & Ternak</h2>
<a href="keranjang_view.php" class="btn btn-back" style="margin-bottom:15px; display:inline-block;">🛒 Lihat Keranjang</a>

<form method="get" class="filter">
<label for="kategori">Kategori:</label>
<select name="kategori" id="kategori" onchange="this.form.submit()">
<option value="Semua" <?= $kategoriDipilih==='Semua'?'selected':'' ?>>Semua</option>
<?php foreach($kategoriList as $kategori): ?>
<option value="<?= $kategori ?>" <?= $kategoriDipilih===$kategori?'selected':'' ?>><?= $kategori ?></option>
<?php endforeach; ?>
</select>
</form>

<div class="produk-grid">
<?php if(empty($produkFiltered)): ?>
<p>Tidak ada produk di kategori ini 😢</p>
<?php else: ?>
<?php foreach($produkFiltered as $p): ?>
<div class="produk-card">
    <img src="<?= htmlspecialchars($p['gambar']) ?>" alt="<?= htmlspecialchars($p['nama']) ?>">
    <h3><?= htmlspecialchars($p['nama']) ?></h3>
    <?php if($p['rating']==0): ?>
        <p class="rating">⭐ Belum ada rating</p>
    <?php else: ?>
        <p class="rating">⭐ <?= $p['rating'] ?></p>
    <?php endif; ?>
    <p class="harga">Rp<?= number_format($p['harga'],0,',','.') ?></p>
    <?php if($p['varian']): ?><p class="varian"><?= htmlspecialchars($p['varian']) ?></p><?php endif; ?>
    <p class="alamat">📍 <?= htmlspecialchars($p['alamat']) ?></p>

    <div class="btn-group">
        <a href="keranjang_add.php?id=<?= $p['id'] ?>&nama=<?= urlencode($p['nama']) ?>&harga=<?= $p['harga'] ?>" class="btn">Masukkan Keranjang</a>
        <a href="keranjang_beli_langsung.php?id=<?= $p['id'] ?>&nama=<?= urlencode($p['nama']) ?>&harga=<?= $p['harga'] ?>" class="btn">Beli Sekarang</a>

        <?php if(in_array($p['id'],$dibeli)): ?>
        <a href="rating.php?id=<?= $p['id'] ?>" class="btn">⭐ Kasih Rating</a>
        <?php else: ?>
        <span class="btn btn-disabled">Belum Bisa Rating</span>
        <?php endif; ?>
    </div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</body>
</html>
