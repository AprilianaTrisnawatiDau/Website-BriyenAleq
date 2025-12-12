<?php
include "koneksi.php";

$id = $_GET['id'];

$res = mysqli_query($conn, "SELECT * FROM penjualan WHERE id = $id");
$data = mysqli_fetch_assoc($res);

echo json_encode($data);
?>
