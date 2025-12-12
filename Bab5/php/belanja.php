<?php
session_start();

$produkList = [
    ["nama"=>"Beras","kategori"=>"Pertanian","harga"=>15000,"rating"=>4.7,"varian"=>"1 kg","gambar"=>"../images/beras.png","alamat"=>"Jl. Contoh Raya No.123, Malang"],
    ["nama"=>"Jagung","kategori"=>"Pertanian","harga"=>12000,"rating"=>4.5,"varian"=>"1 kg","gambar"=>"../images/jagung.png","alamat"=>"Jl. Contoh Raya No.124, Malang"],
    ["nama"=>"Kangkung","kategori"=>"Pertanian","harga"=>5000,"rating"=>4.6,"varian"=>"1 ikat","gambar"=>"../images/kangkung.png","alamat"=>"Jl. Contoh Raya No.125, Malang"],
    ["nama"=>"Telur","kategori"=>"Peternakan","harga"=>27000,"rating"=>4.8,"varian"=>"1 kg / 12 butir","gambar"=>"../images/telur.png","alamat"=>"Jl. Contoh Raya No.126, Malang"],
    ["nama"=>"Tomat","kategori"=>"Pertanian","harga"=>8000,"rating"=>4.4,"varian"=>"1 kg","gambar"=>"../images/tomat.png","alamat"=>"Jl. Contoh Raya No.127, Malang"],
    ["nama"=>"Terong","kategori"=>"Pertanian","harga"=>7000,"rating"=>4.3,"varian"=>"1 kg","gambar"=>"../images/terong.png","alamat"=>"Jl. Contoh Raya No.128, Malang"],
    ["nama"=>"Daun Pare","kategori"=>"Pertanian","harga"=>6000,"rating"=>4.2,"varian"=>"1 ikat","gambar"=>"../images/daun_pare.png","alamat"=>"Jl. Contoh Raya No.129, Malang"],
    ["nama"=>"Ikan","kategori"=>"Peternakan","harga"=>50000,"rating"=>4.6,"varian"=>"1 kg","gambar"=>"../images/ikan.png","alamat"=>"Jl. Contoh Raya No.130, Malang"], 
    ["nama"=>"Ayam Potong","kategori"=>"Peternakan","harga"=>40000,"rating"=>4.7,"varian"=>"1 ekor","gambar"=>"../images/ayam_potong.png","alamat"=>"Jl. Contoh Raya No.131, Malang"],
    ["nama"=>"Daging Babi Ternak","kategori"=>"Peternakan","harga"=>135000,"rating"=>4.6,"varian"=>"1 kg","gambar"=>"../images/daging_babi_ternak.png","alamat"=>"Jl. Contoh Raya No.132, Malang"],
    ["nama"=>"Daging Sapi","kategori"=>"Peternakan","harga"=>150000,"rating"=>4.8,"varian"=>"1 kg","gambar"=>"../images/daging_sapi.png","alamat"=>"Jl. Contoh Raya No.133, Malang"]
];

$kategoriDipilih = $_GET['kategori'] ?? 'Semua';

$produkFiltered = $kategoriDipilih === 'Semua' 
    ? $produkList 
    : array_filter($produkList, fn($p)=>$p['kategori']===$kategoriDipilih);

// Membuat daftar kategori unik untuk dropdown filter
$kategoriList = array_unique(array_map(fn($p)=>$p['kategori'],$produkList));
sort($kategoriList);
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Belanja Produk</title>
<link rel="stylesheet" href="../css/belanja.css">
</head>
<body>
    
<a href="../pembeli.html" class="btn-back">⬅ Kembali</a>

<div class="container">
<h2>🛒 Belanja Produk Tani & Ternak</h2>

<a href="keranjang_view.php" class="btn-keranjang">🛒 Lihat Keranjang</a>

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
<p class="rating">⭐ <?= $p['rating'] ?></p>
<p class="harga">Rp<?= number_format($p['harga'],0,',','.') ?></p>
<p class="varian"><?= htmlspecialchars($p['varian']) ?></p>
<p class="alamat">📍 <?= htmlspecialchars($p['alamat']) ?></p>
<div class="btn-group">
    <a class="keranjang" href="keranjang_add.php?nama=<?= urlencode($p['nama']) ?>&harga=<?= $p['harga'] ?>&varian=<?= urlencode($p['varian']) ?>">Masukkan Keranjang</a>
    
    <a class="beli" href="keranjang_beli_langsung.php?nama=<?= urlencode($p['nama']) ?>&harga=<?= $p['harga'] ?>&varian=<?= urlencode($p['varian']) ?>">Beli Sekarang</a>
</div>
</div>
<?php endforeach; ?>
<?php endif; ?>
</div>
</div>
</body>
</html>