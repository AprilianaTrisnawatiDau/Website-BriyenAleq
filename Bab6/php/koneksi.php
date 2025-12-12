<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "website_briyenaleq";

$conn = mysqli_connect($host, $user, $pass, $db);

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

mysqli_set_charset($conn, "utf8");

function sanitize($conn, $data) {
    return mysqli_real_escape_string($conn, trim($data));
}
?>
