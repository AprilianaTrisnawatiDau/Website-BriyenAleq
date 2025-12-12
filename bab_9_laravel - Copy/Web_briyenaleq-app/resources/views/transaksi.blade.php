<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Transaksi</title>

    <link rel="stylesheet" href="{{ asset('css/transaksi.css') }}">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/js/all.min.js" integrity="sha512-GWzVrcGlo0TxTRvz9ttioyYJ+Wwk9Ck0G81D+eO63BaqHaJ3YZX9wuqjwgfcV/MrB2PhaVX9DkYVhbFpStnqpQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<body>
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logoweb.png') }}" alt="Logo BriyenAleq" />
        </div>

        <nav class="menu">
            <a href="{{ url('/Pembeli') }}"><i class="icon">🌿</i>Dashboard</a>
            <a href="{{ url('/Belanja') }}"><i class="icon">🛒</i>Belanja</a>
            <a href="{{ route('transaksi.index') }}" class="active"><i class="icon">🧾</i>Transaksi</a>
            <a href="{{ url('/') }}"><i class="icon">🚪</i>Log Out</a>
        </nav>

        <div class="ornament">
            <img src="{{ asset('images/topeng.png') }}" alt="Topeng Dayak" />
        </div>
    </aside>

    <div class="main-content">
        <div class="header-with-button">
            <h2 class="header-title">Data Transaksi</h2>
            <a href="{{ route('transaksi.pdf.download') }}" class="btn-pdf-head">
                <i class="fa-solid fa-print"></i> Cetak PDF
            </a>
        </div>

        <div class="form-card">
            <form id="formTransaksi" enctype="multipart/form-data">
                <div class="grid-form">

                    <div class="form-group">
                        <label>Tanggal</label>
                        <input type="date" name="tanggal" required>
                    </div>

                    <div class="form-group">
                        <label>Nama</label>
                        <input type="text" name="nama" required>
                    </div>

                    <div class="form-group">
                        <label>Produk</label>
                        <input type="text" name="produk" required>
                    </div>

                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori" required>
                            <option value="">Kategori</option>
                            <option value="Tani">Tani</option>
                            <option value="Ternak">Ternak</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Harga</label>
                        <input type="number" name="harga" required>
                    </div>

                    <div class="form-group">
                        <label>Bukti</label>
                        <input type="file" name="bukti">
                    </div>

                    <div class="form-group">
                        <label>Status</label>
                        <select name="status">
                            <option value="Pending">Pending</option>
                            <option value="Success">Success</option>
                        </select>
                    </div>

                </div>

                <div class="row-action">
                    <button type="submit" class="btn-tambah">
                        <i class="fa fa-plus"></i> Tambah
                    </button>
                </div>
            </form>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Bukti</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <script src="{{ asset('js/Transaksi.js') }}"></script>
</body>
</html>
