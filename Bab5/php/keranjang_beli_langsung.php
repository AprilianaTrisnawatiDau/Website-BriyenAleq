<?php
session_start();

$nama = $_GET['nama'] ?? '';
$harga = $_GET['harga'] ?? 0;
$varian = $_GET['varian'] ?? '';

// Pastikan array keranjang diinisialisasi
if(!isset($_SESSION['keranjang'])) {
    $_SESSION['keranjang'] = [];
}

// Logika penambahan produk (sama seperti keranjang_add.php)
$found = false;
foreach($_SESSION['keranjang'] as &$item){
    if($item['nama'] === $nama){
        // Jika produk sudah ada, tambahkan kuantitasnya
        $item['qty'] += 1;
        $found = true;
        break;
    }
}

// Jika produk belum ada, tambahkan item baru
if(!$found){
    $_SESSION['keranjang'][] = ['nama'=>$nama, 'harga'=>$harga, 'varian'=>$varian, 'qty'=>1];
}

// PENGALIHAN UTAMA: Langsung ke halaman pembayaran
header("Location: pembayaran.php");
exit;