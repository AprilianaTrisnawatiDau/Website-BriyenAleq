document.addEventListener("DOMContentLoaded", function() {

    const cardPembeli = document.querySelector('.content .card:nth-child(1)');
    const cardPenjual = document.querySelector('.content .card:nth-child(2)');

    const btnPembeli = document.getElementById('btnPembeli');
    const btnPenjual = document.getElementById('btnPenjual');

    // Efek hover card
    function addCardHoverEffect(card, color) {
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
        addCardHoverEffect(cardPembeli, 'rgba(79, 123, 69, 0.5)');
        addCardHoverEffect(cardPenjual, 'rgba(74, 150, 200, 0.5)');
    }

    // Efek tekan tombol
    function addButtonPressEffect(button) {
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


    function addCardClickAlert(card, role) {
        card.addEventListener('click', function(e) {
            if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'IMG') {
                alert(`Silahkan klik tombol ${role} yang ada di card`);
            }
        });
    }

    if (cardPembeli) addCardClickAlert(cardPembeli, 'Pembeli');
    if (cardPenjual) addCardClickAlert(cardPenjual, 'Penjual');

    // Navigasi tombol menggunakan data-url
    if (btnPembeli) {
        btnPembeli.addEventListener('click', function() {
            window.location.href = btnPembeli.dataset.url;
        });
    }

    if (btnPenjual) {
        btnPenjual.addEventListener('click', function() {
            window.location.href = btnPenjual.dataset.url;
        });
    }

});
