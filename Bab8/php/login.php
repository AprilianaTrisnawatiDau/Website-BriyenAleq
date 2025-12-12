<?php
header('Content-Type: text/plain; charset=utf-8');

// 1. Panggil koneksi.php
include "koneksi.php";

if (!$conn) {
    echo "db_error";
    exit;
}

// 2. CEK JIKA FORM DISUBMIT
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "invalid_request";
    exit;
}

// 3. AMBIL DATA DARI POST - INI YANG HILANG!
$username = mysqli_real_escape_string($conn, $_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

// Debug: lihat data yang diterima
error_log("Login attempt - Username: $username, Password: $password");

if ($username === '' || $password === '') {
    echo "empty_fields";
    exit;
}

// 4. Cek user di tabel regist
$sql = "SELECT `password` FROM `regist` WHERE `username` = ? OR `email` = ? LIMIT 1";
$stmt = mysqli_prepare($conn, $sql);

if (!$stmt) {
    error_log("Prepare statement failed: " . mysqli_error($conn));
    echo "db_error";
    exit;
}

mysqli_stmt_bind_param($stmt, "ss", $username, $username);
mysqli_stmt_execute($stmt);
$result = mysqli_stmt_get_result($stmt);

if ($result && mysqli_num_rows($result) === 1) {
    $row = mysqli_fetch_assoc($result);

    // Bandingkan password plain text
    if (isset($row['password']) && $row['password'] === $password) {
        echo "success";
    } else {
        echo "wrong_password";
    }
} else {
    echo "not_found";
}

mysqli_stmt_close($stmt);
mysqli_close($conn);
?>