<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Belanja Produk</title>
<link rel="stylesheet" href="{{ asset('css/belanja.css') }}">
</head>
<body>

<div class="container">

    <a href="{{ url('/Pembeli') }}" class="btn-back">⬅ Kembali</a>

    <h2 class="judul">🛒 Belanja Produk Tani & Ternak</h2>

    <a href="{{ route('keranjang.view') }}" class="btn-keranjang">🛒 Lihat Keranjang</a>

    <form method="get" class="filter">
        <label>Kategori:</label>
        <select name="kategori" onchange="this.form.submit()">
            <option value="Semua" {{ $kategoriDipilih==='Semua'?'selected':'' }}>Semua</option>
            @foreach($kategoriList as $kategori)
                <option value="{{ $kategori }}" {{ $kategoriDipilih===$kategori?'selected':'' }}>
                    {{ $kategori }}
                </option>
            @endforeach
        </select>
    </form>

    <div class="produk-grid">
        @forelse($produkFiltered as $p)
        <div class="produk-card">

           <img src="{{ asset('storage/'.$p->foto) }}" class="produk-img">

            <h3 class="nama-produk">{{ $p->produk }}</h3>

            @if($p->rating)
                <p class="rating">⭐ {{ number_format($p->rating,1) }}</p>
            @else
                <p class="rating">⭐ Belum ada rating</p>
            @endif

            <p class="harga">Rp{{ number_format($p->harga,0,',','.') }}</p>

            <p class="alamat">📍 {{ $p->alamat }}</p>

            <div class="btn-group">

                <a class="btn hijau" href="{{ route('keranjang.add', $p->id) }}">
                    Masukkan Keranjang
                </a>

                <a class="btn hijau" href="{{ route('keranjang.buynow', $p->id) }}">
                    Beli Sekarang
                </a>

                @if(in_array($p->id, $dibeli))
                    <a class="btn kuning" href="{{ route('rating.show', $p->id) }}">
                        ⭐ Kasih Rating
                    </a>
                @else
                    <span class="btn disabled">Belum Bisa Rating</span>
                @endif

            </div>

        </div>
        @empty
            <p>Tidak ada produk di kategori ini 😢</p>
        @endforelse
    </div>

</div>

</body>
</html>
