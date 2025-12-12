<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pilih Peran - BriyenAleq</title>
    <link rel="stylesheet" href="{{ asset('css/pilih.css') }}" />
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="{{ asset('images/logoweb.png') }}" alt="Logo BriyenAleq" />
            <h1>BriyenAleq</h1>
        </div>
        <ul>
            <li><a href="{{ url('/') }}">Home</a></li>
            <li><a href="{{ url('/About') }}">About</a></li>
            <li><a href="{{ url('/Contact') }}">Contact Us</a></li>
            <li><a href="{{ route('login.show') }}">Login</a></li>
        </ul>
    </nav>

    <div class="container">
        <div class="background"></div>

        <div class="content">
            <div class="card">
                <img src="{{ asset('images/pembeli.png') }}" alt="Pembeli" />
                <button id="btnPembeli" data-url="{{ url('/Pembeli') }}">Pembeli</button>
            </div>
            <div class="card">
                <img src="{{ asset('images/penjual.png') }}" alt="Penjual" />
                <button id="btnPenjual" data-url="{{ url('/Penjual') }}">Penjual</button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/pilih.js') }}"></script>
</body>
</html>
