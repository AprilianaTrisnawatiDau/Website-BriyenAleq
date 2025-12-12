<?php
include "koneksi.php";

if(isset($_GET['id'])){
    $id = intval($_GET['id']);
    $res = mysqli_query($conn, "SELECT foto FROM penjualan WHERE id=$id");
    if($res && mysqli_num_rows($res)>0){
        $row = mysqli_fetch_assoc($res);
        if(!empty($row['foto']) && file_exists("../".$row['foto'])) unlink("../".$row['foto']);
    }

    $del = mysqli_query($conn, "DELETE FROM penjualan WHERE id=$id");
    if($del) header("Location: ../penjualan.html?status=deleted");
    else die("Gagal menghapus data");
}

mysqli_close($conn);
?>
