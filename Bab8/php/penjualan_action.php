<?php
include "koneksi.php";

if (isset($_POST['tanggal'])) {

    $id = $_POST['id'] ?? null;
    $tanggal = $_POST['tanggal'];
    $nama = $_POST['nama'];
    $produk = $_POST['produk'];
    $alamat = $_POST['alamat'];
    $kategori = $_POST['kategori'];
    $harga = $_POST['harga'];

    // Upload Foto
    $fotoName = null;

    if (!empty($_FILES['foto']['name'])) {
        $fotoName = time() . "_" . $_FILES['foto']['name'];
        move_uploaded_file($_FILES['foto']['tmp_name'], "../images/produk/" . $fotoName);
    }

    if ($id) {
        // Update
        if ($fotoName) {
            mysqli_query($conn, "UPDATE penjualan SET 
                tanggal='$tanggal',
                nama='$nama',
                produk='$produk',
                alamat='$alamat',
                kategori='$kategori',
                harga='$harga',
                foto='$fotoName'
            WHERE id=$id");
        } else {
            mysqli_query($conn, "UPDATE penjualan SET 
                tanggal='$tanggal',
                nama='$nama',
                produk='$produk',
                alamat='$alamat',
                kategori='$kategori',
                harga='$harga'
            WHERE id=$id");
        }
    } else {
        // Insert baru
        mysqli_query($conn, "INSERT INTO penjualan (tanggal,nama,produk,alamat,kategori,harga,foto)
        VALUES ('$tanggal','$nama','$produk','$alamat','$kategori','$harga','$fotoName')");
    }

    exit;
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM penjualan WHERE id=$id");
    exit;
}
