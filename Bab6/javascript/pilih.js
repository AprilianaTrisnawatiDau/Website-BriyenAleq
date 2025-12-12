document.addEventListener("DOMContentLoaded", function() {
    
    const isLoggedIn = localStorage.getItem('isLoggedIn') === 'true';

    if (!isLoggedIn) {
        window.location.replace("login.html"); 
        return; 
    }
    
    const authLink = document.getElementById('authLink');
    if (authLink) {
        authLink.textContent = 'Logout';
        authLink.href = '#';
        
        authLink.addEventListener('click', function(e) {
            e.preventDefault();
            localStorage.removeItem('isLoggedIn');
            window.location.replace("login.html");
        });
    }

    const cardPembeli = document.querySelector('.content .card:nth-child(1)');
    const cardPenjual = document.querySelector('.content .card:nth-child(2)');

    const btnPembeli = cardPembeli ? cardPembeli.querySelector('button') : null;
    const btnPenjual = cardPenjual ? cardPenjual.querySelector('button') : null;

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

    // 🔥 Bagian ini aku benerin
    function addCardClickAlert(card, role) {
        card.addEventListener('click', function(e) {

            if (e.target.tagName !== 'BUTTON' && e.target.tagName !== 'IMG') {
                showAlert(role);
            }
        });
    }

    // Pop-up alert custom (bukan alert jelek default)
    function showAlert(role) {
        alert(`Anda memilih area ${role}. Silakan klik tombol ${role.toLowerCase()} untuk melanjutkan.`);
    }

    if (cardPembeli) addCardClickAlert(cardPembeli, "Pembeli");
    if (cardPenjual) addCardClickAlert(cardPenjual, "Penjual");

});
