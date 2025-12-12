<?php
$conn = mysqli_connect("localhost","root","","website_briyenaleq");
if (!$conn) die("Koneksi DB gagal: " . mysqli_connect_error());

function esc($v){ global $conn; return mysqli_real_escape_string($conn, trim($v)); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add'])) {
        $tanggal = esc($_POST['tanggal']);
        $nama    = esc($_POST['nama']);
        $produk  = esc($_POST['produk']);
        $kategori= esc($_POST['kategori']);
        $harga   = (int)$_POST['harga'];
        $status  = esc($_POST['status']);

        $fileName = '';
        if (!empty($_FILES['bukti']['name']) && is_uploaded_file($_FILES['bukti']['tmp_name'])) {
            if (!is_dir(__DIR__ . '/../uploads')) mkdir(__DIR__ . '/../uploads', 0755, true);
            $ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            move_uploaded_file($_FILES['bukti']['tmp_name'], __DIR__ . '/../uploads/' . $fileName);
        }

        $sql = "INSERT INTO transaksi (tanggal,nama,produk,kategori,harga,status,bukti)
                VALUES ('$tanggal','$nama','$produk','$kategori',$harga,'$status','" . esc($fileName) . "')";
        mysqli_query($conn, $sql);
        header("Location: transaksi.php");
        exit;
    }

    if (isset($_POST['update'])) {
        $id      = (int)$_POST['id'];
        $tanggal = esc($_POST['tanggal']);
        $nama    = esc($_POST['nama']);
        $produk  = esc($_POST['produk']);
        $kategori= esc($_POST['kategori']);
        $harga   = (int)$_POST['harga'];
        $status  = esc($_POST['status']);
        $oldFile = esc($_POST['old_bukti']);

        $fileName = $oldFile;
        if (!empty($_FILES['bukti']['name']) && is_uploaded_file($_FILES['bukti']['tmp_name'])) {
            if ($oldFile && file_exists(__DIR__ . '/../uploads/' . $oldFile)) @unlink(__DIR__ . '/../uploads/' . $oldFile);
            $ext = pathinfo($_FILES['bukti']['name'], PATHINFO_EXTENSION);
            $fileName = time() . '_' . bin2hex(random_bytes(6)) . '.' . $ext;
            move_uploaded_file($_FILES['bukti']['tmp_name'], __DIR__ . '/../uploads/' . $fileName);
        }

        $sql = "UPDATE transaksi SET
                tanggal='$tanggal', nama='$nama', produk='$produk',
                kategori='$kategori', harga=$harga, status='$status', bukti='" . esc($fileName) . "'
                WHERE id=$id";
        mysqli_query($conn, $sql);
        header("Location: transaksi.php");
        exit;
    }
}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $q = mysqli_query($conn, "SELECT bukti FROM transaksi WHERE id=$id LIMIT 1");
    $d = mysqli_fetch_assoc($q);
    if ($d && !empty($d['bukti']) && file_exists(__DIR__ . '/../uploads/' . $d['bukti'])) {
        @unlink(__DIR__ . '/../uploads/' . $d['bukti']);
    }
    mysqli_query($conn, "DELETE FROM transaksi WHERE id=$id");
    header("Location: transaksi.php");
    exit;
}

if (isset($_GET['pdf'])) {
    require __DIR__ . '/fpdf.php';
    $pdf = new FPDF('L','mm','A4');
    $pdf->AddPage();
    $pdf->SetAutoPageBreak(true, 10);

    // header
    $pdf->SetFont('Arial','B',14);
    $pdf->Cell(0,10,'Laporan Transaksi BriyenAleq',0,1,'C');
    $pdf->Ln(4);

    // table header
    $pdf->SetFont('Arial','B',10);
    $pdf->SetFillColor(2,84,45); // dark green
    $pdf->SetTextColor(255,255,255);
    $pdf->Cell(30,9,'Tanggal',1,0,'C',true);
    $pdf->Cell(70,9,'Nama',1,0,'C',true);
    $pdf->Cell(90,9,'Produk',1,0,'C',true);
    $pdf->Cell(30,9,'Kategori',1,0,'C',true);
    $pdf->Cell(30,9,'Harga',1,0,'C',true);
    $pdf->Cell(30,9,'Status',1,0,'C',true);
    $pdf->Ln();

    $pdf->SetFont('Arial','',9);
    $pdf->SetTextColor(0,0,0);
    $res = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC");
    while ($r = mysqli_fetch_assoc($res)) {
        $pdf->Cell(30,8,$r['tanggal'],1);
        $pdf->Cell(70,8,substr($r['nama'],0,40),1);
        $pdf->Cell(90,8,substr($r['produk'],0,50),1);
        $pdf->Cell(30,8,$r['kategori'],1);
        $pdf->Cell(30,8,'Rp '.number_format($r['harga'],0,',','.'),1,0,'R');
        $pdf->Cell(30,8,$r['status'],1);
        $pdf->Ln();
    }

    // force download
    $filename = 'transaksi_' . date('Ymd_His') . '.pdf';
    $pdf->Output($filename, 'D');
    exit;
}

// fetch for display
$result = mysqli_query($conn, "SELECT * FROM transaksi ORDER BY id DESC");
$editRow = null;
if (isset($_GET['edit'])) {
    $eid = (int)$_GET['edit'];
    $editRow = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM transaksi WHERE id=$eid LIMIT 1"));
}
?>
<!doctype html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Transaksi - BriyenAleq</title>
<style>
*{box-sizing:border-box;margin:0;padding:0;font-family:Inter,system-ui,-apple-system,Segoe UI,Roboto}
.dashboard-container{display:flex;height:100vh;width:100%;background:rgba(219,240,206,0.68)}
.sidebar{width:260px;background:#02542d;color:#fff;display:flex;flex-direction:column;justify-content:space-between;padding:30px 20px;position:fixed;top:0;left:0;height:100vh}
.logo img{width:190px;display:block;margin-bottom:auto 40px}
.menu{display:flex;flex-direction:column;gap:20px}
.menu a{color:#fff;text-decoration:none;padding:12px 15px;border-radius:8px;display:flex;gap:12px;align-items:center;transition:.3s}
.menu a:hover,.menu a.active{background:#14ae5c}
.ornament img{width:150px;display:block;margin:auto;opacity:0.4;filter:drop-shadow(0 0 10px rgba(20,174,92,.6))}
.main-content{flex:1;margin-left:260px;padding:40px;background:#fff;overflow-y:auto}
.container{max-width:1100px;margin:0 auto}
.header{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}
.header h1{color:#02542d;font-size:22px}
.card{background:#fff;border-radius:12px;padding:16px;box-shadow:0 6px 18px rgba(7,22,12,.06);margin-bottom:18px}
.form-row{display:flex;flex-wrap:wrap;gap:12px;align-items:center}
.form-row input[type="date"],.form-row input[type="text"],.form-row input[type="number"],.form-row select,.form-row input[type="file"]{padding:10px 12px;border:1px solid #dfeee0;border-radius:8px;min-width:160px;background:#fff}
.btn{background:#14ae5c;color:#fff;padding:10px 14px;border-radius:8px;border:0;cursor:pointer;font-weight:700}
.btn.secondary{background:#1e7a4f}
.btn-pdf{background:#02542d;color:#fff;padding:10px 12px;border-radius:8px;text-decoration:none;font-weight:700}
.table-card{overflow:auto;background:#fff;border-radius:12px;padding:12px;box-shadow:0 6px 18px rgba(7,22,12,.04)}
table{width:100%;border-collapse:collapse;min-width:900px}
thead th{background:#02542d;color:#fff;text-transform:uppercase;font-size:12px;padding:12px;text-align:left}
tbody td{padding:12px;border-bottom:1px solid #eef6ee;background:#fff;vertical-align:middle}
tbody tr:nth-child(even){background:#f8fbf8}
.thumb{width:64px;height:48px;object-fit:cover;border-radius:6px;border:1px solid #e6efe6}
.actions a{margin-right:8px;text-decoration:none;padding:6px 10px;border-radius:6px;color:#fff;font-weight:700}
.actions .edit{background:#1e7a4f}
.actions .hapus{background:#c62828}
@media(max-width:1024px){.sidebar{width:220px}.main-content{margin-left:220px;padding:40px}}
@media(max-width:768px){.sidebar{display:none}.main-content{margin-left:0;padding:20px}table{min-width:700px}}
</style>
</head>
<body>
<div class="dashboard-container">
  <aside class="sidebar">
    <div>
      <div class="logo"><img src="../images/logoweb.png" alt="logo"></div>
      <nav class="menu">
        <a href="../pembeli.html">🌿 Dashboard</a>
        <a href="../php/belanja.php">🛒 Belanja</a>
        <a href="transaksi.php" class="active">🧾 Transaksi</a>
        <a href="../index.html">🚪 Log Out</a>
      </nav>
    </div>
    <div class="ornament"><img src="../images/topeng.png" alt="topeng"></div>
  </aside>

  <main class="main-content">
    <div class="container">
      <div class="header">
        <h1>Data Transaksi</h1>
        <div class="controls"><a class="btn-pdf" href="transaksi.php?pdf=1" target="_blank">🧾 Cetak PDF</a></div>
      </div>

      <div class="card">
        <?php if ($editRow): ?>
          <form method="POST" enctype="multipart/form-data" class="form-row">
            <input type="hidden" name="update" value="1">
            <input type="hidden" name="id" value="<?= (int)$editRow['id'] ?>">
            <input type="hidden" name="old_bukti" value="<?= htmlspecialchars($editRow['bukti']) ?>">
            <input type="date" name="tanggal" value="<?= htmlspecialchars($editRow['tanggal']) ?>" required>
            <input type="text" name="nama" value="<?= htmlspecialchars($editRow['nama']) ?>" required>
            <input type="text" name="produk" value="<?= htmlspecialchars($editRow['produk']) ?>" required>
            <select name="kategori" required>
              <option value="Ternak" <?= $editRow['kategori']=='Ternak'?'selected':'' ?>>Ternak</option>
              <option value="Tani" <?= $editRow['kategori']=='Tani'?'selected':'' ?>>Tani</option>
            </select>
            <input type="number" name="harga" value="<?= (int)$editRow['harga'] ?>" required>
            <select name="status" required>
              <option value="Pending" <?= $editRow['status']=='Pending'?'selected':'' ?>>Pending</option>
              <option value="Success" <?= $editRow['status']=='Success'?'selected':'' ?>>Success</option>
            </select>
            <div style="display:flex;flex-direction:column;gap:8px">
              <div style="font-size:13px;color:#444">Bukti sekarang:</div>
              <?php if (!empty($editRow['bukti']) && file_exists(__DIR__ . '/../uploads/' . $editRow['bukti'])): ?>
                <img src="../uploads/<?= htmlspecialchars($editRow['bukti']) ?>" class="thumb" alt="bukti">
              <?php else: ?>
                <div style="color:#666">tidak ada bukti</div>
              <?php endif; ?>
              <input type="file" name="bukti">
            </div>
            <div style="margin-left:auto;display:flex;gap:8px">
              <button type="submit" class="btn" name="update">Simpan</button>
              <a class="btn secondary" href="transaksi.php" style="text-decoration:none;display:inline-flex;align-items:center;justify-content:center">Batal</a>
            </div>
          </form>
        <?php else: ?>
          <form method="POST" enctype="multipart/form-data" class="form-row">
            <input type="hidden" name="add" value="1">
            <input type="date" name="tanggal" required>
            <input type="text" name="nama" placeholder="Nama" required>
            <input type="text" name="produk" placeholder="Produk" required>
            <select name="kategori" required>
              <option value="Ternak">Ternak</option>
              <option value="Tani">Tani</option>
            </select>
            <input type="number" name="harga" placeholder="Harga" required>
            <select name="status" required>
              <option value="Pending">Pending</option>
              <option value="Success">Success</option>
            </select>
            <input type="file" name="bukti" required>
            <div style="margin-left:auto"><button type="submit" class="btn" name="add">Tambah</button></div>
          </form>
        <?php endif; ?>
      </div>

      <div class="table-card">
        <table>
          <thead>
            <tr>
              <th>Tanggal</th><th>Nama</th><th>Produk</th><th>Kategori</th>
              <th>Harga</th><th>Status</th><th>Bukti</th><th>Aksi</th>
            </tr>
          </thead>
          <tbody>
            <?php while($r = mysqli_fetch_assoc($result)): ?>
              <tr>
                <td><?= htmlspecialchars($r['tanggal']) ?></td>
                <td><?= htmlspecialchars($r['nama']) ?></td>
                <td><?= htmlspecialchars($r['produk']) ?></td>
                <td><?= htmlspecialchars($r['kategori']) ?></td>
                <td>Rp <?= number_format($r['harga'],0,',','.') ?></td>
                <td><?= htmlspecialchars($r['status']) ?></td>
                <td>
                  <?php if (!empty($r['bukti']) && file_exists(__DIR__ . '/../uploads/' . $r['bukti'])): ?>
                    <img src="../uploads/<?= htmlspecialchars($r['bukti']) ?>" class="thumb" alt="bukti">
                  <?php else: ?>
                    -
                  <?php endif; ?>
                </td>
                <td class="actions">
                  <a class="edit" href="transaksi.php?edit=<?= (int)$r['id'] ?>">Edit</a>
                  <a class="hapus" href="transaksi.php?delete=<?= (int)$r['id'] ?>" onclick="return confirm('Yakin ingin menghapus data ini?')">Hapus</a>
                </td>
              </tr>
            <?php endwhile; mysqli_free_result($result); ?>
          </tbody>
        </table>
      </div>

    </div>
  </main>
</div>
</body>
</html>
