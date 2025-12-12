// ===================================
// SCRIPT CONTACT.JS (EVENT INTERAKSI MURNI)
// ===================================

document.addEventListener("DOMContentLoaded", function() {
    // Menargetkan elemen yang sudah ada di HTML asli
    const contactTitle = document.querySelector('.v12_293'); // Judul kontak ("Jika Anda memiliki...")
    const contactDetail = document.querySelector('.v12_295'); // Detail Email/Telepon
    const homeButton = document.querySelector('.btn-home'); // Tombol Home

    // Tambahkan ID ke elemen logo di contact.html (jika belum ada)
    const logoSection = document.querySelector('.v12_309');

    // --- Event 1: Mouseover/Mouseout pada Detail Kontak ---
    if (contactDetail) {
        contactDetail.style.transition = 'background-color 0.3s';
        contactDetail.style.cursor = 'pointer';

        contactDetail.addEventListener('mouseover', function() {
            // Efek highlight saat kursor mendekat
            contactDetail.style.backgroundColor = 'rgba(71, 91, 63, 0.1)';
        });

        contactDetail.addEventListener('mouseout', function() {
            // Hilangkan highlight
            contactDetail.style.backgroundColor = 'transparent';
        });
    }

    // --- Event 2: Mousedown/Mouseup pada Judul Kontak ---
    if (contactTitle) {
        contactTitle.style.cursor = 'pointer';
        contactTitle.style.transition = 'color 0.1s';

        contactTitle.addEventListener('mousedown', function() {
            // Efek 'tekan' pada teks
            contactTitle.style.color = '#5c2e1e'; // Ubah ke warna gelap
        });

        contactTitle.addEventListener('mouseup', function() {
            // Kembalikan warna normal
            contactTitle.style.color = '#475b3f';
        });
    }

    // --- Event 3: Click Event (Simulasi Loading) pada Tombol Home ---
    if (homeButton) {
        homeButton.addEventListener('click', function(e) {
            e.preventDefault();

            // Tampilkan loading sebentar
            const originalText = homeButton.textContent;
            homeButton.textContent = "Loading...";
            homeButton.style.backgroundColor = "#a4b693";

            setTimeout(() => {
                window.location.href = "/";
                homeButton.textContent = originalText; // Reset (walaupun akan redirect)
            }, 700);
        });
    }
});
