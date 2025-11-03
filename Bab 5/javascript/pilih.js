// pilih.js YANG DIPERBAIKI

document.addEventListener("DOMContentLoaded", function() {
    
    // --- Bagian 1: Cek Status Login (Wajib untuk Keamanan Halaman) ---
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';

    if (!isLoggedIn) {
        // Jika tidak login, alihkan ke halaman login
        window.location.replace("login.html"); 
        return; 
    }
    
    // --- Bagian 2: Logika Navbar (Mengubah 'Login' menjadi 'Logout') ---
    const authLink = document.getElementById('authLink');
    if (authLink) {
        authLink.textContent = 'Logout';
        authLink.href = '#'; // Hapus link ke login.html
        
        authLink.addEventListener('click', function(e) {
            e.preventDefault();
            
            // Hapus status login dari Local Storage
            localStorage.removeItem('isLoggedIn');
            
            // Redirect kembali ke halaman login (atau home)
            window.location.replace("login.html");
        });
    }

    // Menargetkan elemen kartu berdasarkan posisi (nth-child)
    const cardPembeli = document.querySelector('.content .card:nth-child(1)');
    const cardPenjual = document.querySelector('.content .card:nth-child(2)');
    
    // Menargetkan tombol di dalam kartu
    const btnPembeli = cardPembeli ? cardPembeli.querySelector('button') : null;
    const btnPenjual = cardPenjual ? cardPenjual.querySelector('button') : null;


    // --- Event 1: Mouseover/Mouseout pada Card Pilihan (Efek Highlight) ---
    function addCardHoverEffect(card, color) {
        // ... (kode Anda yang ini sudah benar, tidak perlu diubah) ...
        card.style.transition = 'box-shadow 0.3s, border-color 0.3s';
        
        card.addEventListener('mouseover', function() {
            card.style.boxShadow = `0 4px 20px 5px ${color}`;
            card.style.borderColor = color;
        });
        card.addEventListener('mouseout', function() {
            card.style.boxShadow = '0 4px 10px rgba(86, 64, 64, 0.25)'; 
            card.style.borderColor = 'transparent'; 
        });
    }

    if (cardPembeli && cardPenjual) {
        addCardHoverEffect(cardPembeli, 'rgba(79, 123, 69, 0.5)'); // Hijau
        addCardHoverEffect(cardPenjual, 'rgba(74, 150, 200, 0.5)'); // Biru
    }

    // --- Event 2: Mousedown/Mouseup pada Tombol Peran (Efek Tekan) ---
    function addButtonPressEffect(button) {
        // ... (kode Anda yang ini sudah benar, tidak perlu diubah) ...
        button.style.transition = 'transform 0.1s, opacity 0.1s';
        button.addEventListener('mousedown', function() {
            button.style.transform = 'scale(0.95)';
            button.style.opacity = '0.8';
        });

        button.addEventListener('mouseup', function() {
            button.style.transform = 'scale(1)';
            button.style.opacity = '1';
        });
    }

    if (btnPembeli) addButtonPressEffect(btnPembeli);
    if (btnPenjual) addButtonPressEffect(btnPenjual);
    
    // --- Event 3: Click Event pada Card Pilihan (Peringatan Area Kosong) ---
    function addCardClickAlert(card, role) {
        // ... (kode Anda yang ini sudah benar, tidak perlu diubah) ...
        card.addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'IMG') {
                alert(`Anda memilih area ${role}. Silakan klik tombol pembeli di bawah untuk melanjutkan.`);
            }
        });
    }
    
    if (cardPembeli) addCardClickAlert(cardPembeli, "Pembeli");
    if (cardPenjual) addCardClickAlert(cardPenjual, "Penjual");
});