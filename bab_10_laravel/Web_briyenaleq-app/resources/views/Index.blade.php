<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BriyenaLeq</title>

    <link href="https://fonts.googleapis.com/css?family=Baloo+Bhai&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/index.css') }}">
</head>
<body>

<header class="navbar">
    <nav>
        <ul>
            <li><a href="{{ url('/About') }}" class="nav-link">About</a></li>
            <li><a href="{{ url('/Contact') }}" class="nav-link">Contact Us</a></li>
            <li><a href="{{ url('/Login') }}" class="nav-link">Login</a></li>
        </ul>
    </nav>

    <div id="toast"></div>
</header>

<main class="v8_19">
    <div class="v12_12"></div>

    <div class="logo-container">
        <img src="{{ asset('images/logoweb.png') }}" class="logo-img">
    </div>

    <h1 class="v11_30">SELAMAT DATANG DI WEBSITE<br>BRIYENALEQ</h1>
</main>

<script src="{{ asset('js/index.js') }}"></script>
</body>
</html>
