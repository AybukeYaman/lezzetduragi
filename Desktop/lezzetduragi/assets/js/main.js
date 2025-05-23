document.addEventListener('DOMContentLoaded', function() {
    // Basit mobil menü toggle
    const menuToggle = document.getElementById('mobile-menu');
    const navLinksList = document.getElementById('nav-links-list');

    if (menuToggle && navLinksList) {
        menuToggle.addEventListener('click', () => {
            navLinksList.classList.toggle('active');
            // Opsiyonel: Hamburger ikonunu X ikonuna çevirme
            // menuToggle.classList.toggle('open'); 
        });
    }

    // Footer'da güncel yılı gösterme
    const currentYearElement = document.getElementById('current-year');
    if (currentYearElement) {
        currentYearElement.textContent = new Date().getFullYear();
    }
});