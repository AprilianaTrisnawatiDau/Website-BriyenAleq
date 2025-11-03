
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
           
            showPopup("⚠️ Semua kolom harus diisi");
            return;
        }


        localStorage.setItem('isLoggedIn', 'true');
        
        
        window.location.replace("pilih.html"); 
        
    });
});