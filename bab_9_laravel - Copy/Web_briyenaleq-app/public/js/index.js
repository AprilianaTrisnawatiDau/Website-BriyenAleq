document.addEventListener("DOMContentLoaded", function () {

    const toast = document.getElementById("toast");
    const links = document.querySelectorAll(".nav-link");
    const heading = document.querySelector(".v11_30");
    const logo = document.querySelector(".logo-img");
    const body = document.body;


    links.forEach(link => {
        link.addEventListener("click", function (e) {
            e.preventDefault();
            const menu = this.textContent.trim();
            let colorClass = "";

            if (menu === "About") colorClass = "about";
            if (menu === "Contact Us") colorClass = "contact";
            if (menu === "Login") colorClass = "login";

            showToast(`Membuka halaman ${menu}`, colorClass);

            setTimeout(() => {
                window.location.href = this.href;
            }, 1200);
        });
    });

    // ===============================
    // HOVER JUDUL
    // ===============================
    heading.addEventListener("mouseover", () => {
        heading.textContent = "Selamat Datang di Dunia BriyenaLeq!";
        showToast("Judul berubah!", "about");
    });

    heading.addEventListener("mouseout", () => {
        heading.innerHTML = "SELAMAT DATANG DI WEBSITE<br>BRIYENALEQ";
    });

    // ===============================
    // CLICK LOGO — SPIN ANIMATION
    // ===============================
    logo.addEventListener("click", () => {
        logo.classList.toggle("spin");
        showToast("Logo diklik!", "contact");
    });

    // ===============================
    // CLICK BODY — CHANGE BG COLOR
    // ===============================
    body.addEventListener("click", (e) => {
        if (!e.target.closest(".navbar, .logo-img, .v11_30")) {
            const randomColor = `hsl(${Math.floor(Math.random() * 360)}, 70%, 90%)`;
            body.style.backgroundColor = randomColor;
            showToast("Warna background berubah!", "login");
        }
    });

    // ===============================
    // TOAST FUNCTION
    // ===============================
    function showToast(message, colorClass) {
        toast.textContent = message;
        toast.className = `show ${colorClass}`;

        setTimeout(() => {
            toast.className = toast.className.replace(`show ${colorClass}`, "");
        }, 1000);
    }

});
