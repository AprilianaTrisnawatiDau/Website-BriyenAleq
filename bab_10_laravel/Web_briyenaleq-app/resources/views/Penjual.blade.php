<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Dashboard Penjual - BriyenAleq</title>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&display=swap" rel="stylesheet" />
<style>
* { box-sizing: border-box; margin: 0; padding: 0; font-family: "Inter", sans-serif; }

.dashboard-container {
  display: flex;
  height: 100vh;
  width: 100%;
  background-color: rgba(219, 240, 206, 0.68);
  overflow: hidden;
}

.sidebar {
  width: 260px;
  background-color: #02542d;
  color: white;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  padding: 30px 20px;
  position: fixed;
  top: 0;
  left: 0;
  height: 100vh;
}

.sidebar .logo img { width: 190px; display: block; margin-top: 25px;margin-right:30px; }
.sidebar .menu { display: flex; flex-direction: column; gap: 20px; }
.sidebar .menu a { text-decoration: none; color: white; font-size: 16px; display: flex; align-items: center; gap: 12px; padding: 12px 15px; border-radius: 8px; transition: background 0.3s ease; }
.sidebar .menu a.active, .sidebar .menu a:hover { background-color: #14ae5c; }
.sidebar .ornament img { width: 180px; max-width: 100%; height: auto; display: block; margin: 20px auto 0; opacity: 0.3; filter: drop-shadow(0 0 10px rgba(20, 174, 92, 0.4)); }

.main-content {
  flex: 1;
  margin-left: 260px;
  padding: 40px 20px;
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  overflow-y: auto;
  text-align: center;
  background-color: rgba(255, 255, 255, 0.9);
}

.welcome { display: flex; flex-direction: column; align-items: center; justify-content: center; text-align: center; margin-bottom: 30px; }
.welcome h1 { color: #02542d; font-size: 28px; font-weight: 700; line-height: 1.4; margin-bottom: 20px; }
.welcome .main-logo { width: 180px; max-width: 100%; margin-bottom: 20px; }

.widget-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 25px; width: 100%; max-width: 900px; }
.widget { background: #b09865ff; padding: 20px; border-radius: 12px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); text-align: center; }
.widget h2 { margin: 0; color: #1f5031ff; font-size: 24px; }
.widget p { margin: 5px 0 0; font-size: 16px; color: #284127ff; }

.sidebar { width: 220px; }
.main-content { margin-left: 220px; padding: 30px 15px; }
.welcome h1 { font-size: 24px; }
.welcome .main-logo { width: 250px; }
.sidebar .ornament img { width: 130px; }

@media (max-width: 768px) {
  .sidebar { display: none; }
  .main-content { margin: 0; padding: 20px; }
}
</style>
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
