<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard Pembeli - BriyenAleq</title>
    <link rel="stylesheet" href="{{ asset('css/pembeli.css') }}" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
  </head>
  <body>
    <div class="dashboard-container">
      <!-- SIDEBAR -->
      <aside class="sidebar">
        <div class="logo">
          <img src="./images/logoweb.png" alt="Logo BriyenAleq" />
        </div>
        <nav class="menu">
             <a href="{{ url('/Pembeli') }}" class="active"><i class="icon">🌿</i>Dashboard</a>
             <a href="{{ url('/Belanja') }}"><i class="icon">🛒</i>Belanja</a>
             <a href="{{ route('transaksi.index') }}"><i class="icon">🧾</i>Transaksi</a>
             <a href="{{ url('/') }}"><i class="icon">🚪</i>Log Out</a>
        </nav>
        <div class="ornament">
          <img src="{{asset('images/topeng.png')}}" alt="Ornamen Dayak" />
        </div>
      </aside>

      <!-- MAIN CONTENT -->
      <main class="main-content">
        <header class="topbar"></header>
        <section class="welcome">
          <h1>Halo Selamat Datang<br />Di BriyenAleq!</h1>
          <img src= "{{asset('images/logoweb.png')}}" alt="Logo BriyenAleq" class="main-logo" />
        </section>
      </main>
    </div>
  </body>
</html>
