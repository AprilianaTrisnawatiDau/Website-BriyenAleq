<?php
include "koneksi.php";

$result = mysqli_query($conn, "SELECT * FROM penjualan ORDER BY id DESC");

$output = "";

while ($row = mysqli_fetch_assoc($result)) {

    $fotoPath = "images/produk/" . $row['foto'];

    $foto = $row['foto'] ? "<img src='images/produk/{$row['foto']}' width='60'>" : "-";
    $output .= "
        <tr>
            <td>{$row['tanggal']}</td>
            <td>{$row['nama']}</td>
            <td>{$row['produk']}</td>
            <td>{$row['alamat']}</td>
            <td>{$row['kategori']}</td>
            <td>Rp " . number_format($row['harga'], 0, ',', '.') . "</td>
            <td>$foto</td>
            <td>
                <button onclick='showDetail({$row['id']})'>Detail</button>
                <button onclick='editData({$row['id']})'>Edit</button>
                <button onclick='confirmDelete({$row['id']})'>Hapus</button>
            </td>
        </tr>
    ";
}

echo $output;
