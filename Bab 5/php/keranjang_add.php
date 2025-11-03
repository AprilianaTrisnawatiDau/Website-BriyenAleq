<?php
session_start();

$nama = $_GET['nama'] ?? '';
$harga = $_GET['harga'] ?? 0;
$varian = $_GET['varian'] ?? '';

if(!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Jika produk sudah ada, tambahkan jumlah
$found = false;
foreach($_SESSION['keranjang'] as &$item){
    if($item['nama'] === $nama){
        $item['qty'] += 1;
        $found = true;
        break;
    }
}
if(!$found){
    $_SESSION['keranjang'][] = ['nama'=>$nama, 'harga'=>$harga, 'varian'=>$varian, 'qty'=>1];
}

header("Location: keranjang_view.php");
exit;
