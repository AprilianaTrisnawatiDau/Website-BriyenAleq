<?php
include "koneksi.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $tanggal = $_POST['tanggal'] ?? '';
    $nama = sanitize($conn, $_POST['nama'] ?? '');
    $produk = sanitize($conn, $_POST['produk'] ?? '');
    $alamat = sanitize($conn, $_POST['alamat'] ?? '');
    $kategori = $_POST['kategori'] ?? '';
    $harga = $_POST['harga'] ?? '';

    $res = mysqli_query($conn, "SELECT foto FROM penjualan WHERE id = $id");
    $row = mysqli_fetch_assoc($res);
    $foto = $row['foto'];

    if(isset($_FILES['foto']) && $_FILES['foto']['error'] === 0){
        $target_dir = "../images/produk/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);

        $ext = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
        $file_name = time() . "_" . uniqid() . "." . $ext;
        $target_file = $target_dir . $file_name;

        if(getimagesize($_FILES['foto']['tmp_name']) !== false){
            move_uploaded_file($_FILES['foto']['tmp_name'], $target_file);
            if(!empty($foto) && file_exists("../".$foto)) unlink("../".$foto);
            $foto = "images/produk/".$file_name;
        }
    }

    $sql = "UPDATE penjualan SET tanggal='$tanggal', nama='$nama', produk='$produk', alamat='$alamat',
            kategori='$kategori', harga='$harga', foto='$foto' WHERE id=$id";

    if(mysqli_query($conn, $sql)){
        echo "success";
    } else {
        echo "Error: ".mysqli_error($conn);
    }
}

mysqli_close($conn);
?>
