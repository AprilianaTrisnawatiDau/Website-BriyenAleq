document.addEventListener("DOMContentLoaded", () => {
    const popupBox = document.getElementById("popupBox");
    const popupMessage = document.getElementById("popupMessage");
    const popupOkBtn = document.getElementById("popupOkBtn");
    const goRegisterBtn = document.getElementById("goRegister");
    const loginForm = document.getElementById("loginForm");

    const showPopup = (message) => {
        popupMessage.textContent = message;
        popupBox.classList.add("show");
    };

    popupOkBtn.addEventListener("click", () => {
        popupBox.classList.remove("show");
    });

    if (goRegisterBtn) {
        goRegisterBtn.addEventListener("click", () => {
            window.location.href = "/Register";
        });
    }

    loginForm.addEventListener("submit", (e) => {
        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();

        if (!username || !password) {
            e.preventDefault();
            showPopup("Kolom harus diisi semua");
        }
    });

    if (loginError) {
        showPopup(loginError);
    }
});
