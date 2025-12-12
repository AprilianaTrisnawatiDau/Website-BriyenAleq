<?php
// 1. Panggil koneksi.php
include "koneksi.php"; 

if (!$conn) {
    http_response_code(500);
    die("error: Koneksi database GAGAL!");
}

// 2. Cek metode request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(400);
    die("error: Metode request tidak valid.");
}

// 3. Ambil dan sanitasi input
$nama = sanitize($conn, $_POST['nama'] ?? '');
$username = sanitize($conn, $_POST['username'] ?? '');
$email = sanitize($conn, $_POST['email'] ?? '');
$password = sanitize($conn, $_POST['password'] ?? '');

if (empty($nama) || empty($username) || empty($email) || empty($password)) {
    http_response_code(400);
    die("error: Semua field wajib diisi.");
}

// 4. Cek apakah username atau email sudah terdaftar
$check_sql = "SELECT id FROM regist WHERE username = ? OR email = ? LIMIT 1";
$check_stmt = mysqli_prepare($conn, $check_sql);

if (!$check_stmt) {
    http_response_code(500);
    die("error: Database error.");
}

mysqli_stmt_bind_param($check_stmt, "ss", $username, $email);
mysqli_stmt_execute($check_stmt);
$check_result = mysqli_stmt_get_result($check_stmt);

if (mysqli_num_rows($check_result) > 0) {
    echo "error: Username atau Email sudah digunakan.";
    mysqli_stmt_close($check_stmt);
    exit;
}
mysqli_stmt_close($check_stmt);

// 5. Query INSERT data dengan prepared statement
$sql = "INSERT INTO regist (nama, username, email, password) VALUES (?, ?, ?, ?)";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    http_response_code(500);
    die("error: Database error.");
}

mysqli_stmt_bind_param($stmt, "ssss", $nama, $username, $email, $password);

if (mysqli_stmt_execute($stmt)) {
    echo "success";
} else {
    http_response_code(500);
    echo "error: Gagal menyimpan data. " . mysqli_error($conn);
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>