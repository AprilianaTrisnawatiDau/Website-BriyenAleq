<?php
session_start();
$index = $_GET['index'] ?? -1;
if(isset($_SESSION['keranjang'][$index])){
    unset($_SESSION['keranjang'][$index]);
    $_SESSION['keranjang'] = array_values($_SESSION['keranjang']); // reset index
}
header("Location: keranjang_view.php");
exit;
