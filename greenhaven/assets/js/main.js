/**
 * JavaScript Utama - GreenHaven Plant Shop
 * Mengatur interaktivitas halaman publik (Navbar, Slider, Form, Quantity)
 */

document.addEventListener('DOMContentLoaded', function() {
    
    // ==========================================
    // 1. MENU NAVIGASI RESPONSIVE (MOBILE MENU)
    // ==========================================
    const navbarToggle = document.getElementById('navbarToggle');
    const navbarLinks = document.getElementById('navbarLinks');
    
    if (navbarToggle && navbarLinks) {
        navbarToggle.addEventListener('click', function() {
            // Toggle class 'active' untuk menampilkan/menyembunyikan menu
            navbarLinks.classList.toggle('active');
            
            // Animasi tombol hamburger menjadi ikon 'X'
            navbarToggle.classList.toggle('open');
            const bars = navbarToggle.querySelectorAll('.bar');
            if (navbarToggle.classList.contains('open')) {
                bars[0].style.transform = 'rotate(-45deg) translate(-5px, 6px)';
                bars[1].style.opacity = '0';
                bars[2].style.transform = 'rotate(45deg) translate(-5px, -6px)';
            } else {
                bars[0].style.transform = 'none';
                bars[1].style.opacity = '1';
                bars[2].style.transform = 'none';
            }
        });
        
        // Menutup menu mobile saat salah satu tautan diklik
        const navItems = navbarLinks.querySelectorAll('.nav-item');
        navItems.forEach(item => {
            item.addEventListener('click', function() {
                navbarLinks.classList.remove('active');
                navbarToggle.classList.remove('open');
                bars.forEach(bar => bar.style.transform = 'none');
                bars[1].style.opacity = '1';
            });
        });
    }

    // ==========================================
    // 2. EFEK SCROLL PADA NAVBAR
    // ==========================================
    const navbar = document.getElementById('mainNavbar');
    
    if (navbar) {
        window.addEventListener('scroll', function() {
            // Jika halaman di-scroll lebih dari 50px, tambahkan class 'scrolled'
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });
    }

    // ==========================================
    // 3. SMOOTH SCROLLING UNTUK LINKS INTERNAL
    // ==========================================
    const scrollLinks = document.querySelectorAll('a[href^="#"]');
    scrollLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            const targetId = this.getAttribute('href');
            if (targetId === '#') return;
            
            const targetElement = document.querySelector(targetId);
            if (targetElement) {
                e.preventDefault();
                // Mengambil tinggi navbar untuk offset scroll
                const navbarHeight = navbar ? navbar.offsetHeight : 80;
                const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
                
                window.scrollTo({
                    top: targetPosition,
                    behavior: 'smooth'
                });
            }
        });
    });

    // ==========================================
    // 4. KONTROL JUMLAH (QUANTITY) DI HALAMAN DETAIL PRODUK
    // ==========================================
    const btnMinus = document.getElementById('btnMinus');
    const btnPlus = document.getElementById('btnPlus');
    const quantityInput = document.getElementById('quantityInput');
    
    if (btnMinus && btnPlus && quantityInput) {
        // Event saat tombol minus (-) diklik
        btnMinus.addEventListener('click', function() {
            let currentVal = parseInt(quantityInput.value) || 1;
            if (currentVal > 1) {
                quantityInput.value = currentVal - 1;
            }
        });
        
        // Event saat tombol plus (+) diklik
        btnPlus.addEventListener('click', function() {
            let currentVal = parseInt(quantityInput.value) || 1;
            const maxVal = parseInt(quantityInput.getAttribute('max')) || 99;
            if (currentVal < maxVal) {
                quantityInput.value = currentVal + 1;
            }
        });
        
        // Validasi input manual agar tidak bernilai negatif atau melebihi stok
        quantityInput.addEventListener('change', function() {
            let currentVal = parseInt(this.value) || 1;
            const maxVal = parseInt(this.getAttribute('max')) || 99;
            if (currentVal < 1) {
                this.value = 1;
            } else if (currentVal > maxVal) {
                this.value = maxVal;
            }
        });
    }
});
