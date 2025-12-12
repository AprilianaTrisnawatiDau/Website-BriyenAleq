// login.js YANG DIPERBAIKI

document.addEventListener("DOMContentLoaded", function () {
    const loginButton = document.querySelector(".login-btn");
    
    // Ambil elemen pop-up
    const popupBox = document.getElementById("popupBox");
    const popupMessage = document.getElementById("popupMessage");
    const popupOkBtn = document.getElementById("popupOkBtn");

    // Fungsi untuk menampilkan pop-up
    function showPopup(message) {
        popupMessage.textContent = message;
        popupBox.style.display = 'block'; // Tampilkan pop-up
    }

    // Event listener untuk tombol OK pada pop-up
    popupOkBtn.addEventListener('click', function() {
        popupBox.style.display = 'none'; // Sembunyikan pop-up
    });

    loginButton.addEventListener("click", function (e) {
        e.preventDefault();

        const emailInput = document.getElementById("email").value.trim();
        const passwordInput = document.getElementById("password").value.trim();

        // 1. Tampilkan status loading
        loginButton.textContent = "Loading...";
        loginButton.disabled = true;

        // 2. Pengecekan kolom kosong
        if (emailInput === "" || passwordInput === "") {
            loginButton.textContent = "Login";
            loginButton.disabled = false;
            // Ganti alert() biasa dengan showPopup()
            showPopup("⚠️ Semua kolom harus diisi");
            return;
        }

        // --- SIMULASI LOGIN BERHASIL ---
        // Karena tidak ada backend, kita langsung anggap berhasil.
        
        // Simpan status login di Local Storage
        localStorage.setItem('isLoggedIn', 'true');
        
        // Redirect ke halaman pilih.html
        // Menggunakan replace() lebih baik untuk login agar halaman ini tidak tersimpan di riwayat browser.
        window.location.replace("pilih.html"); 
        
        // Catatan: Jika Anda ingin menambahkan logika otentikasi nyata (ke server),
        // kode di atas akan diletakkan di dalam blok 'if (response.success)'.
    });
});