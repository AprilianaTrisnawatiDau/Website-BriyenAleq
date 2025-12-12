<?php
session_start();

// Pastikan ada parameter key
if(isset($_GET['key'])){
    $key = $_GET['key'];

    // Hapus item dari keranjang
    if(isset($_SESSION['keranjang'][$key])){
        unset($_SESSION['keranjang'][$key]);
        // Reset array supaya index rapi
        $_SESSION['keranjang'] = array_values($_SESSION['keranjang']);
    }
}

// Kembali ke halaman keranjang
header("Location: keranjang_view.php");
exit;
?>
