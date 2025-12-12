<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="v12_342">
        <div class="navbar">
            <img src="{{ asset('images/logoweb.png') }}" alt="Logo">
            <a href="/">Home</a>
        </div>

        <div class="login-box">
            <form id="loginForm" method="POST" action="{{ route('login.post') }}">
                @csrf
                <label for="username">Username / Email</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Email / Username" value="{{ old('username') }}" />

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password" />

                <button type="submit" class="login-btn">Login</button>
                <p>Belum punya akun?</p>
                <button type="button" class="register-btn" id="goRegister">Daftar Disini</button>
            </form>
        </div>
    </div>

    <div id="popupBox" class="popup-box">
        <div class="popup-content error">
            <p id="popupMessage"></p>
            <button id="popupOkBtn" class="popup-ok-btn">OK</button>
        </div>
    </div>

    <script>
        const loginError = @json(session('login_error'));
    </script>
    <script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
