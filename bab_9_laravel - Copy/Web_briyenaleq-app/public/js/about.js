

document.addEventListener("DOMContentLoaded", function() {
    // Menargetkan elemen yang sudah ada di HTML asli
    const logoSection = document.querySelector('.v12_309'); // Logo/Gambar di konten
    const aboutText = document.querySelector('.v12_295'); // Teks utama
    const homeButton = document.querySelector('.btn-home'); // Tombol Home

    // --- Event 1: Mouseover/Mouseout pada Teks Utama ---
    if (aboutText) {
        aboutText.addEventListener('mouseover', function() {
            // Memberi feedback visual dengan mengubah font weight
            aboutText.style.fontWeight = '700';
            aboutText.style.cursor = 'pointer';
        });

        aboutText.addEventListener('mouseout', function() {
            // Kembalikan ke default CSS
            aboutText.style.fontWeight = '500';
            aboutText.style.cursor = 'default';
        });
    }

    // --- Event 2: Mousedown/Mouseup pada Logo/Gambar di Konten ---
    if (logoSection) {
        logoSection.style.cursor = 'pointer'; // Tambahkan kursor tangan

        logoSection.addEventListener('mousedown', function() {
            // Efek 'tekan'
            logoSection.style.transform = 'scale(0.95)';
            logoSection.style.filter = 'brightness(0.8)';
        });

        logoSection.addEventListener('mouseup', function() {
            // Kembalikan normal
            logoSection.style.transform = 'scale(1)';
            logoSection.style.filter = 'none';
        });
    }

    // --- Event 3: Click Event (Konfirmasi) pada Tombol Home ---
    if (homeButton) {
        homeButton.addEventListener('click', function(e) {
            e.preventDefault(); // Hentikan aksi default (redirect)

            // Konfirmasi sebelum redirect
            if (confirm("Apakah Anda yakin ingin kembali ke Halaman Utama?")) {
                window.location.href = "index.html";
            }
        });
    }
});
