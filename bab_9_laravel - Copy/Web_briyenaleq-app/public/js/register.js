document.addEventListener("DOMContentLoaded", () => {
    const popupBox = document.getElementById("popupBox");
    const popupMessage = document.getElementById("popupMessage");
    const popupOkBtn = document.getElementById("popupOkBtn");
    const goLoginBtn = document.getElementById("goLogin");
    const registerForm = document.getElementById("registerForm");

    const showPopup = (message) => {
        popupMessage.textContent = message;
        popupBox.classList.add("show");
    };

    popupOkBtn.addEventListener("click", () => {
        popupBox.classList.remove("show");
        if (popupMessage.textContent.includes("Registrasi berhasil")) {
            window.location.href = "/Login";
        }
    });

    if (goLoginBtn) {
        goLoginBtn.addEventListener("click", () => {
            window.location.href = "/Login";
        });
    }

    registerForm.addEventListener("submit", (e) => {
        const username = document.getElementById("username").value.trim();
        const name = document.getElementById("name").value.trim();
        const password = document.getElementById("password").value.trim();
        const passwordConfirmation = document.getElementById("password_confirmation").value.trim();

        if (!username || !name || !password || !passwordConfirmation) {
            e.preventDefault();
            showPopup("Kolom harus diisi semua");
        } else if (password.length < 6) {
            e.preventDefault();
            showPopup("Password minimal 6 karakter");
        } else if (password !== passwordConfirmation) {
            e.preventDefault();
            showPopup("Konfirmasi password tidak sesuai");
        }
    });

    if (registerError) {
        showPopup(registerError);
    }

    if (registerSuccess) {
        showPopup(registerSuccess);
    }
});
