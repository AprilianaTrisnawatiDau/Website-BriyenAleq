document.addEventListener("DOMContentLoaded", function () {
    const loginButton = document.querySelector(".login-btn");

    loginButton.addEventListener("click", function (e) {
        e.preventDefault();

        const username = document.getElementById("username").value.trim();
        const password = document.getElementById("password").value.trim();

        if (!username || !password) return alert("⚠️ Semua kolom harus diisi");

        loginButton.textContent = "Loading...";
        loginButton.disabled = true;

        fetch("./php/login.php", {
            method: "POST",
            headers: { "Content-Type": "application/x-www-form-urlencoded" },
            body: `username=${encodeURIComponent(username)}&password=${encodeURIComponent(password)}`
        })
        .then(res => res.text())
        .then(data => {
            data = data.trim();

            if (data === "success") {
                localStorage.setItem("isLoggedIn", "true");
                localStorage.setItem("username", username);
                window.location.replace("pilih.html");
            } else if (data === "wrong_password") {
                alert("❌ Password salah!");
            } else if (data === "not_found") {
                alert("❌ Username/Email tidak ditemukan!");
            } else if (data === "db_error") {
                alert("❌ Koneksi database bermasalah!");
            } else {
                alert("❌ Server error: " + data);
            }

            loginButton.textContent = "Login";
            loginButton.disabled = false;
        })
        .catch(() => {
            alert("❌ Gagal terhubung ke server.");
            loginButton.textContent = "Login";
            loginButton.disabled = false;
        });
    });
});
