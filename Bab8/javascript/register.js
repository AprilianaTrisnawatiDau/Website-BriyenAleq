document.addEventListener("DOMContentLoaded", function () {
    const registerButton = document.querySelector(".login-btn"); 
    
    const popupBox = document.getElementById("popupBox");
    const popupMessage = document.getElementById("popupMessage");
    const popupOkBtn = document.getElementById("popupOkBtn");
    const popupContent = document.querySelector(".popup-content");

    function closePopup() {
        popupBox.classList.remove('show');
    }

    function showPopup(message, type = 'success', callback = null) {
        popupMessage.textContent = message;
        popupContent.classList.remove('success', 'error');
        popupContent.classList.add(type);
        popupBox.classList.add('show');

        popupOkBtn.onclick = function () {
            closePopup();
            if (callback) callback();
        };
    }

    const emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;

    registerButton.addEventListener("click", function (e) {
        e.preventDefault();

        const namaInput = document.getElementById("nama").value.trim();
        const usernameInput = document.getElementById("username").value.trim();
        const emailInput = document.getElementById("email").value.trim();
        const passwordInput = document.getElementById("password").value.trim();

        if (namaInput === "" || usernameInput === "" || emailInput === "" || passwordInput === "") {
            showPopup("⚠️ Semua kolom harus diisi!", "error");
            return;
        }

        if (!emailPattern.test(emailInput)) {
            showPopup("❌ Format email tidak valid!", "error");
            return;
        }

        registerButton.textContent = "Processing...";
        registerButton.disabled = true;

        fetch("./php/register.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `nama=${namaInput}&username=${usernameInput}&email=${emailInput}&password=${passwordInput}`
        })
        .then(res => res.text())
        .then(data => {

            if (data === "success") {
                const redirectCallback = () => {
                    window.location.href = "login.html";
                };

                showPopup("🎉 Pendaftaran Berhasil! Silakan login.", "success", redirectCallback);
            } 
            else {
                showPopup("❌ Username atau Email sudah digunakan!", "error");
            }

            registerButton.textContent = "Register";
            registerButton.disabled = false;

        })
        .catch(() => {
            showPopup("❌ Terjadi kesalahan. Coba lagi nanti!", "error");
            registerButton.textContent = "Register";
            registerButton.disabled = false;
        });
    });
});
