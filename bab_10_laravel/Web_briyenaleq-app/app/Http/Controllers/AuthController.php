<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth; // Penting supaya Auth::attempt() bisa dipakai

class AuthController extends Controller
{
    // Tampilkan halaman login
    public function showLogin()
    {
        return view('Login');
    }

    // Proses login
    public function login(Request $request)
    {
        if (!$request->username || !$request->password) {
            return back()->withInput()->with('login_error', 'Kolom harus diisi semua');
        }

        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string'
        ], [
            'username.required' => 'Username/email wajib diisi',
            'password.required' => 'Password wajib diisi'
        ]);

        $loginField = filter_var($request->username, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        $credentials = [
            $loginField => $request->username,
            'password' => $request->password
        ];

        if (!Auth::attempt($credentials)) {
            return back()->withInput()->with('login_error', 'Username/email atau password yang dimasukkan salah');
        }

        $request->session()->regenerate();
        return redirect()->intended('/Pilih');
    }

    // Tampilkan halaman register
    public function showRegister()
    {
        return view('Register');
    }

    // Proses register
    public function register(Request $request)
    {
        $allEmpty = !$request->username && !$request->name && !$request->password && !$request->password_confirmation;
        if ($allEmpty) {
            return back()->withInput()->with('register_error', 'Kolom harus diisi semua');
        }

        $request->validate([
            'username' => 'required|string|unique:users,username',
            'name'     => 'required|string',
            'email'    => 'nullable|email|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ], [
            'username.required' => 'Username wajib diisi',
            'username.unique' => 'Username sudah digunakan',
            'name.required' => 'Nama lengkap wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah digunakan',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 6 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sesuai'
        ]);

        User::create([
            'username' => $request->username,
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => bcrypt($request->password),
        ]);

        // Kirim flash message sukses, user harus login sendiri
        return back()->with('success', 'Registrasi berhasil! Silakan login');
    }
}
