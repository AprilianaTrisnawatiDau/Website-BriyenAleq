// ===============================
// SCRIPT UTAMA BRIYENALEQ
// ===============================
// Semua DOM dan toast aktif setelah halaman dimuat
document.addEventListener("DOMContentLoaded", function () {

  // ====== Elemen-elemen utama (DOM target) ======
  const toast = document.getElementById("toast");         // elemen toast berada di dalam <header class="navbar">
  const links = document.querySelectorAll(".navbar a");   // semua tautan di navbar (About, Contact Us, Login)
  const heading = document.querySelector(".v11_30");      // judul utama di tengah halaman
  const logo = document.querySelector(".logo-img");       // logo utama di tengah
  const body = document.body;                             // elemen body (untuk DOM 4)

  // ===============================
  // DOM 1 — Klik menu navbar menampilkan toast berwarna
  // ===============================
  links.forEach(link => {
    link.addEventListener("click", function (e) {
      e.preventDefault(); // mencegah pindah halaman langsung

      const menu = this.textContent.trim();
      let colorClass = "";

      // menentukan warna toast sesuai menu yang diklik
      if (menu === "About") colorClass = "about";
      else if (menu === "Contact Us") colorClass = "contact";
      else if (menu === "Login") colorClass = "login";

      // tampilkan toast
      showToast(`Membuka halaman ${menu}`, colorClass);

      // pindah ke halaman tujuan setelah 2 detik
      setTimeout(() => {
        window.location.href = this.href;
      }, 2000);
    });
  });

  // ===============================
  // DOM 2 — Hover pada judul mengubah teks sementara
  // ===============================
  heading.addEventListener("mouseover", () => {
    heading.textContent = "Selamat Datang di Dunia BriyenaLeq!";
    showToast("Judul berubah!", "about");
    console.log("Mouse masuk ke judul");
  });

  heading.addEventListener("mouseout", () => {
    heading.innerHTML = "SELAMAT DATANG DI WEBSITE<br>BRIYENALEQ";
    console.log("Mouse keluar dari judul");
  });

  // ===============================
  // DOM 3 — Klik logo membuatnya berputar
  // ===============================
  logo.addEventListener("click", () => {
    logo.classList.toggle("spin"); // tambahkan atau hapus animasi putar (CSS)
    showToast("Logo diklik!", "contact");
    console.log("Logo diklik");
  });

 // ===============================
// DOM 4 — Klik area kosong ubah warna background dengan transisi lembut
// ===============================
body.addEventListener("click", (e) => {
  // Cegah perubahan warna jika klik di navbar, logo, atau judul
  if (!e.target.closest(".navbar, .logo-img, .v11_30")) {
    const randomColor = `hsl(${Math.floor(Math.random() * 360)}, 70%, 90%)`;
    body.style.backgroundColor = randomColor;
    showToast("Warna background berubah!", "login");
    console.log("Background diubah ke:", randomColor);
  }
});
  // ===============================
  // FUNGSI TOAST
  // ===============================
  // Toast muncul di dalam navbar, menampilkan pesan berwarna
  function showToast(message, colorClass) {
    toast.textContent = message;                  // isi teks toast
    toast.className = `show ${colorClass}`;       // tampilkan toast + warna sesuai class
    console.log(message);

    // setelah 1.5 detik, toast hilang otomatis
    setTimeout(() => {
      toast.className = toast.className.replace(`show ${colorClass}`, "");
    }, 1500);
  }
});
