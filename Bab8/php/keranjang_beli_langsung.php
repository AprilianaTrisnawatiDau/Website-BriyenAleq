<?php
session_start();
$id = $_GET['id'];
$nama = $_GET['nama'];
$harga = $_GET['harga'];

$_SESSION['keranjang'] = [
    ["id"=>$id,"nama"=>$nama,"harga"=>$harga,"qty"=>1]
];

header("Location: pembayaran.php");
exit;
