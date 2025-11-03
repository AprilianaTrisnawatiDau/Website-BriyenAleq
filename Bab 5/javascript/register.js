document.addEventListener("DOMContentLoaded", function () {
    const registerButton = document.querySelector(".login-btn"); 
    
    // Elemen Popup
    const popupBox = document.getElementById("popupBox");
    const popupMessage = document.getElementById("popupMessage");
    const popupOkBtn = document.getElementById("popupOkBtn"); // Tombol OK baru
    const popupContent = document.querySelector(".popup-content");

    // Fungsi untuk menutup popup
    function closePopup() {
        popupBox.classList.remove('show');
    }

    // Fungsi untuk menampilkan popup ALERT STYLE dengan tombol OK
    function showPopup(message, type = 'success', callback = null) {
        popupMessage.textContent = message;
        popupContent.classList.remove('success', 'error');
        popupContent.classList.add(type);
        popupBox.classList.add('show');
        
        // Atur aksi ketika tombol OK diklik
        popupOkBtn.onclick = function() {
            closePopup();
            if (callback) {
                callback(); // Panggil fungsi callback (misal: redirect)
            }
        };
    }
    
    // Pola Regex Sederhana untuk validasi format email
    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/; 

    // --- Logika Register ---
    registerButton.addEventListener("click", function (e) {
        e.preventDefault(); 

        const usernameInput = document.getElementById("username").value.trim();
        const emailInput = document.getElementById("email").value.trim();
        const passwordInput = document.getElementById("password").value.trim();

        // 1. Validasi: Semua kolom harus diisi
        if (usernameInput === "" || emailInput === "" || passwordInput === "") {
            showPopup("⚠️ semua kolom harus diisi", 'error');
            return;
        }
        
        // 2. Validasi: Format Email tidak valid
        if (!emailPattern.test(emailInput)) {
            showPopup("❌ Email tidak valid", 'error');
            return;
        }

        // Simulasikan pendaftaran
        registerButton.textContent = "Processing...";
        registerButton.disabled = true;

        // Fungsi yang akan dijalankan setelah pendaftaran sukses dan user menekan OK
        const registrationSuccessCallback = () => {
             window.location.href = "login.html"; 
        };

        setTimeout(() => {
            // Tampilkan popup sukses. Redirect terjadi setelah tombol OK ditekan.
            showPopup(`🎉 Pendaftaran Berhasil! Silakan Login.`, 'success', registrationSuccessCallback);
            
            registerButton.textContent = "Register";
            registerButton.disabled = false;
            
        }, 1500); 
    });
});