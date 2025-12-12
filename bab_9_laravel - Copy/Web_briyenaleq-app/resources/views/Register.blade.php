<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="{{ asset('css/login.css') }}">
</head>
<body>
    <div class="v12_342">
        <div class="navbar">
            <img src="{{ asset('images/logoweb.png') }}" alt="Logo">
            <a href="/">Home</a>
        </div>

        <div class="login-box">
            <form id="registerForm" method="POST" action="{{ route('register.post') }}">
                @csrf
                <label for="username">Username</label>
                <input type="text" id="username" name="username" placeholder="Masukkan Username" value="{{ old('username') }}" />

                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" placeholder="Masukkan Nama Lengkap" value="{{ old('name') }}" />

                <label for="email">Email (Opsional)</label>
                <input type="email" id="email" name="email" placeholder="Masukkan Email" value="{{ old('email') }}" />

                <label for="password">Password</label>
                <input type="password" id="password" name="password" placeholder="Minimal 6 karakter" />

                <label for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" placeholder="Ketik ulang password" />

                <button type="submit" class="login-btn">Daftar</button>
                <p>Sudah punya akun?</p>
                <button type="button" class="register-btn" id="goLogin">Login Disini</button>
            </form>
        </div>
    </div>

    <div id="popupBox" class="popup-box">
        <div class="popup-content success">
            <p id="popupMessage"></p>
            <button id="popupOkBtn" class="popup-ok-btn">OK</button>
        </div>
    </div>

    <script>
        const registerSuccess = @json(session('success'));
        const registerError = @json(session('register_error'));
    </script>
    <script src="{{ asset('js/register.js') }}"></script>
</body>
</html>
