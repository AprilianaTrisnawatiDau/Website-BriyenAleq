<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Penjualan</title>
    <link rel="stylesheet" href="{{ asset('css/penjualan.css') }}">
</head>
<body>
<div class="dashboard-container">
    <aside class="sidebar">
        <div class="logo">
            <img src="{{ asset('images/logoweb.png') }}" alt="Logo BriyenAleq">
        </div>
        <nav class="menu">
            <a href="{{ route('penjual.index') }}">🌿 Dashboard</a>
            <a href="{{ route('penjualan.index') }}" class="active">🛒 Jual</a>
            <a href="{{ url('/') }}">🚪 Log Out</a>
        </nav>
        <div class="ornament">
            <img src="{{ asset('images/topeng.png') }}" alt="Ornamen Dayak">
        </div>
    </aside>

    <main class="main-content">
        <section class="penjualan-section">
            <h2>Data Penjualan</h2>

            <div class="table-actions">
                <a href="{{ route('penjualan.report') }}" target="_blank" class="report-btn">📄 Generate Report</a>
            </div>

            <form id="penjualanForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" id="id" name="id">
                <input type="date" name="tanggal" required>
                <input type="text" name="nama" placeholder="Nama Penjual" required>
                <input type="text" name="produk" placeholder="Nama Produk" required>
                <input type="text" name="alamat" placeholder="Alamat" required>
                <select name="kategori" required>
                    <option value="">Pilih Kategori</option>
                    <option value="Ternak">Ternak</option>
                    <option value="Tani">Tani</option>
                </select>
                <input type="number" name="harga" placeholder="Harga" required>
                <input type="file" name="foto" id="foto">
                <img id="previewFoto" src="" width="60" style="display:none;margin-top:5px;">
                <button type="submit">Simpan</button>
            </form>

            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Produk</th>
                        <th>Alamat</th>
                        <th>Kategori</th>
                        <th>Harga</th>
                        <th>Foto</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody id="data-penjualan">
                    @foreach($penjualData as $p)
                    <tr id="row-{{ $p->id }}">
                        <td>{{ $p->tanggal }}</td>
                        <td>{{ $p->nama }}</td>
                        <td>{{ $p->produk }}</td>
                        <td>{{ $p->alamat }}</td>
                        <td>{{ $p->kategori }}</td>
                        <td>Rp {{ number_format($p->harga,0,',','.') }}</td>
                        <td>
                            @if($p->foto)
                                <img src="{{ asset('storage/'.$p->foto) }}" width="50">
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            <button class="edit-btn" onclick="editData({{ $p->id }})">Edit</button>
                            <button class="delete-btn" onclick="deleteData({{ $p->id }})">Hapus</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </section>
    </main>
</div>

<script src="{{ asset('js/penjualan.js') }}"></script>
</body>
</html>
