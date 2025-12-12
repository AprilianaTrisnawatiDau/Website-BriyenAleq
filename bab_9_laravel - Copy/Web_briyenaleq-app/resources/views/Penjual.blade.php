<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Penjual - BriyenAleq</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('css/penjual.css') }}" />
</head>
<body>
<div class="dashboard-container">
  <!-- SIDEBAR -->
  <aside class="sidebar">
    <div class="logo">
      <img src="{{ asset('images/logoweb.png') }}" alt="Logo BriyenAleq" />
    </div>
    <nav class="menu">
      <a href="{{ url('/Penjual') }}" class="active">🌿 Dashboard</a>
      <a href="{{ url('/Penjualan') }}">🛒 Jual</a>
      <a href="{{ url('/') }}">🚪 Log Out</a>
    </nav>
    <div class="ornament">
      <img src="{{ asset('images/topeng.png') }}" alt="Ornamen Dayak" />
    </div>
  </aside>

  <!-- MAIN CONTENT -->
  <main class="main-content">
    <section class="welcome">
      <h1>Halo Selamat Datang<br />Di BriyenAleq!</h1>
      <img src="{{ asset('images/logoweb.png') }}" alt="Logo BriyenAleq" class="main-logo" />
    </section>

    <section class="widgets">
      <div class="widget-grid">
        @foreach($penjualData as $p)
          <div class="widget">
            <h2>{{ $p->jumlah }}</h2>
            <p>Produk Terjual dari Penjual: {{ $p->nama }}</p>
          </div>
        @endforeach
        <div class="widget">
          <h2>{{ $totalData }}</h2>
          <p>Total Semua Produk Yang Dijual</p>
        </div>
      </div>
    </section>
  </main>
</div>
</body>
</html>
