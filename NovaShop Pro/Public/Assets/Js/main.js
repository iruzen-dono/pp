// ============================================
// NOVASHOP PRO - Main JavaScript
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    initHeaderInteractions();
    initAuthInteractions();
    initDarkMode();
    initScrollAnimations();
    initCarousel();
    initWishlist();
    initNewsletterPopup();
    initFilterModal();
    initSmoothScroll();
});

// ============================================
// ADVANCED HEADER INTERACTIONS
// ============================================

function initHeaderInteractions() {
    // Hamburger Menu Toggle
    const hamburger = document.getElementById('hamburgerMenu');
    const navMenu = document.querySelector('.navbar-menu');
    
    if (hamburger) {
        hamburger.addEventListener('click', function() {
            hamburger.classList.toggle('active');
            navMenu.classList.toggle('active');
        });

        // Close menu on link click
        document.querySelectorAll('.nav-link').forEach(link => {
            link.addEventListener('click', function() {
                hamburger.classList.remove('active');
                navMenu.classList.remove('active');
            });
        });
    }

    // User Dropdown Menu
    const userMenuTrigger = document.getElementById('userMenuTrigger');
    const userDropdown = document.getElementById('userDropdown');
    
    if (userMenuTrigger && userDropdown) {
        userMenuTrigger.addEventListener('click', function(e) {
            e.preventDefault();
            userMenuTrigger.classList.toggle('active');
            userDropdown.style.display = userDropdown.style.display === 'block' ? 'none' : 'block';
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!userMenuTrigger.contains(e.target) && !userDropdown.contains(e.target)) {
                userMenuTrigger.classList.remove('active');
                userDropdown.style.display = 'none';
            }
        });

        // Close dropdown on link click
        userDropdown.querySelectorAll('a').forEach(link => {
            link.addEventListener('click', function() {
                userMenuTrigger.classList.remove('active');
                userDropdown.style.display = 'none';
            });
        });
    }

    // Scroll effect on header
    const header = document.querySelector('.navbar-header');
    if (header) {
        window.addEventListener('scroll', function() {
            if (window.scrollY > 50) {
                header.classList.add('scrolled');
            } else {
                header.classList.remove('scrolled');
            }
        });
    }

    // Scroll to top button
    initScrollToTop();

    // Update cart badge
    updateCartBadge();
}

// ============================================
// SCROLL TO TOP BUTTON
// ============================================

function initScrollToTop() {
    const scrollTopBtn = document.getElementById('scrollTopBtn');
    if (!scrollTopBtn) return;

    window.addEventListener('scroll', function() {
        if (window.scrollY > 500) {
            scrollTopBtn.classList.add('show');
        } else {
            scrollTopBtn.classList.remove('show');
        }
    });

    scrollTopBtn.addEventListener('click', function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth'
        });
    });
}

// ============================================
// CART BADGE UPDATE
// ============================================

function updateCartBadge() {
    const cartBadge = document.getElementById('cartBadge');
    if (!cartBadge) return;

    // Check if cart count exists in localStorage or session
    const cartCount = localStorage.getItem('cartCount') || sessionStorage.getItem('cartCount') || 0;
    
    if (cartCount > 0) {
        cartBadge.textContent = cartCount;
        cartBadge.style.display = 'inline-flex';
    }
}

// ============================================
// DARK MODE TOGGLE - ENHANCED
// ============================================

function initDarkMode() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (!darkModeToggle) return;

    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    
    if (isDarkMode) {
        document.documentElement.setAttribute('data-theme', 'dark');
    }

    darkModeToggle.addEventListener('click', function() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        
        if (isDark) {
            document.documentElement.removeAttribute('data-theme');
            localStorage.setItem('darkMode', 'false');
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('darkMode', 'true');
        }
    });
}

// ============================================
// AUTHENTICATION PAGE INTERACTIONS
// ============================================

function initAuthInteractions() {
    // Password Toggle
    initPasswordToggle();
    
    // Password Strength Indicator
    initPasswordStrength();
}

function initPasswordToggle() {
    const toggleButtons = document.querySelectorAll('.toggle-password');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            const input = this.closest('.input-password-wrapper').querySelector('.form-input');
            
            if (input.type === 'password') {
                input.type = 'text';
                this.textContent = '🙈';
            } else {
                input.type = 'password';
                this.textContent = '👁️';
            }
        });
    });
}

function initPasswordStrength() {
    const passwordInput = document.getElementById('password');
    const strengthBar = document.getElementById('strengthBar');
    const strengthText = document.getElementById('strengthText');
    
    if (!passwordInput || !strengthBar || !strengthText) return;
    
    passwordInput.addEventListener('input', function() {
        const password = this.value;
        let strength = 0;
        let text = 'Très faible';
        let color = '#c74136'; // danger
        
        // Length check
        if (password.length >= 8) strength += 20;
        if (password.length >= 12) strength += 20;
        
        // Complexity checks
        if (/[a-z]/.test(password)) strength += 20; // lowercase
        if (/[A-Z]/.test(password)) strength += 20; // uppercase
        if (/[0-9]/.test(password)) strength += 10; // numbers
        if (/[^a-zA-Z0-9]/.test(password)) strength += 10; // special chars
        
        // Cap at 100
        strength = Math.min(strength, 100);
        
        // Determine strength level
        if (strength < 30) {
            text = 'Très faible';
            color = '#c74136';
        } else if (strength < 50) {
            text = 'Faible';
            color = '#d4a574';
        } else if (strength < 70) {
            text = 'Moyen';
            color = '#4a7c5e';
        } else if (strength < 85) {
            text = 'Fort';
            color = '#2d5a3d';
        } else {
            text = 'Très fort';
            color = '#1a3a28';
        }
        
        // Update bar
        strengthBar.style.width = strength + '%';
        strengthBar.style.backgroundColor = color;
        strengthText.textContent = text;
        strengthText.style.color = color;
    });
}

// ============================================
// SCROLL ANIMATIONS
// ============================================

function initScrollAnimations() {
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver(function(entries) {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('animate-in');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    document.querySelectorAll('.product-card, .feature-card, .animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
}

// ============================================
// CAROUSEL
// ============================================

function initCarousel() {
    const carousels = document.querySelectorAll('.carousel-container');
    
    carousels.forEach(carousel => {
        const track = carousel.querySelector('.carousel-track');
        const slides = track.querySelectorAll('.carousel-slide');
        const prevBtn = carousel.querySelector('.carousel-prev');
        const nextBtn = carousel.querySelector('.carousel-next');
        const dots = carousel.querySelectorAll('.carousel-dot');

        if (!slides.length) return;

        let currentIndex = 0;
        const slideWidth = slides[0].clientWidth + 20; // 20px = gap

        function updateCarousel() {
            track.style.transform = `translateX(-${currentIndex * slideWidth}px)`;
            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === currentIndex);
            });
        }

        function goToSlide(index) {
            currentIndex = (index + slides.length) % slides.length;
            updateCarousel();
        }

        prevBtn?.addEventListener('click', () => goToSlide(currentIndex - 1));
        nextBtn?.addEventListener('click', () => goToSlide(currentIndex + 1));

        dots.forEach((dot, idx) => {
            dot.addEventListener('click', () => goToSlide(idx));
        });

        // Auto-play carousel
        setInterval(() => goToSlide(currentIndex + 1), 5000);
    });
}

// ============================================
// WISHLIST
// ============================================

function initWishlist() {
    const wishlistBtns = document.querySelectorAll('.wishlist-btn');
    const wishlist = JSON.parse(localStorage.getItem('wishlist') || '[]');

    wishlistBtns.forEach(btn => {
        const productId = btn.dataset.productId;
        
        if (wishlist.includes(productId)) {
            btn.classList.add('active');
            btn.textContent = '❤️';
        }

        btn.addEventListener('click', function(e) {
            e.preventDefault();
            const idx = wishlist.indexOf(productId);
            
            if (idx > -1) {
                wishlist.splice(idx, 1);
                this.classList.remove('active');
                this.textContent = '🤍';
                showNotification('Supprimé de la wishlist');
            } else {
                wishlist.push(productId);
                this.classList.add('active');
                this.textContent = '❤️';
                showNotification('Ajouté à la wishlist !');
            }
            
            localStorage.setItem('wishlist', JSON.stringify(wishlist));
        });
    });
}

// ============================================
// NEWSLETTER POPUP
// ============================================

function initNewsletterPopup() {
    const popup = document.getElementById('newsletterPopup');
    if (!popup) return;

    const hasSeenPopup = localStorage.getItem('newsletterPopupSeen');
    
    if (!hasSeenPopup) {
        setTimeout(() => {
            popup.classList.add('show');
            localStorage.setItem('newsletterPopupSeen', 'true');
        }, 3000);
    }

    const closeBtn = popup.querySelector('.popup-close');
    closeBtn?.addEventListener('click', () => {
        popup.classList.remove('show');
    });

    const form = popup.querySelector('form');
    form?.addEventListener('submit', function(e) {
        e.preventDefault();
        const email = this.querySelector('input[type="email"]').value;
        localStorage.setItem('newsletterEmail', email);
        popup.classList.remove('show');
        showNotification('✅ Merci ! Bienvenue à la newsletter !');
    });
}

// ============================================
// FILTER MODAL
// ============================================

function initFilterModal() {
    const filterBtn = document.getElementById('filterBtn');
    const filterModal = document.getElementById('filterModal');
    const closeFilter = document.querySelector('.filter-modal-close');

    filterBtn?.addEventListener('click', () => {
        filterModal?.classList.add('show');
    });

    closeFilter?.addEventListener('click', () => {
        filterModal?.classList.remove('show');
    });

    filterModal?.addEventListener('click', (e) => {
        if (e.target === filterModal) {
            filterModal.classList.remove('show');
        }
    });

    // Apply filters
    const applyFilterBtn = document.querySelector('.apply-filter');
    applyFilterBtn?.addEventListener('click', () => {
        const selectedCategory = document.querySelector('input[name="category"]:checked')?.value;
        const minPrice = document.querySelector('input[name="minPrice"]').value;
        const maxPrice = document.querySelector('input[name="maxPrice"]').value;
        
        console.log('Filters:', { selectedCategory, minPrice, maxPrice });
        filterModal?.classList.remove('show');
        showNotification('Filtres appliqués !');
    });
}

// ============================================
// SMOOTH SCROLL
// ============================================

function initSmoothScroll() {
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

// ============================================
// PARALLAX EFFECT
// ============================================

function initParallax() {
    const parallaxElements = document.querySelectorAll('[data-parallax]');
    
    window.addEventListener('scroll', () => {
        parallaxElements.forEach(el => {
            const scrollPos = window.scrollY;
            const speed = el.dataset.parallax || 0.5;
            el.style.transform = `translateY(${scrollPos * speed}px)`;
        });
    });
}

initParallax();

// ============================================
// NOTIFICATIONS
// ============================================

function showNotification(message) {
    const notification = document.createElement('div');
    notification.className = 'notification';
    notification.textContent = message;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.classList.add('show');
    }, 10);

    setTimeout(() => {
        notification.classList.remove('show');
        setTimeout(() => notification.remove(), 300);
    }, 3000);
}

// ============================================
// RATING SYSTEM
// ============================================

function initRatings() {
    const ratingContainers = document.querySelectorAll('.rating-container');
    
    ratingContainers.forEach(container => {
        const stars = container.querySelectorAll('.star');
        const input = container.querySelector('input[type="hidden"]');
        
        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = this.dataset.rating;
                input.value = rating;
                
                stars.forEach(s => {
                    s.classList.toggle('filled', s.dataset.rating <= rating);
                });
            });
            
            star.addEventListener('mouseover', function() {
                const rating = this.dataset.rating;
                stars.forEach(s => {
                    s.classList.toggle('hover', s.dataset.rating <= rating);
                });
            });
        });
        
        container.addEventListener('mouseleave', function() {
            stars.forEach(s => s.classList.remove('hover'));
        });
    });
}

initRatings();

// ============================================
// FILTER PRODUCTS (CLIENT-SIDE)
// ============================================

function filterProducts(searchTerm) {
    const products = document.querySelectorAll('.product-card');
    
    products.forEach(product => {
        const name = product.querySelector('.product-name').textContent.toLowerCase();
        const price = parseFloat(product.querySelector('.product-price').textContent);
        
        const matches = name.includes(searchTerm.toLowerCase());
        product.style.display = matches ? 'flex' : 'none';
    });
}

// Search functionality
const searchInput = document.querySelector('input[type="search"]');
if (searchInput) {
    searchInput.addEventListener('input', (e) => {
        filterProducts(e.target.value);
    });
}

// ============================================
// CART COUNTER
// ============================================

function updateCartCounter() {
    const cart = JSON.parse(localStorage.getItem('cart') || '{}');
    const count = Object.values(cart).reduce((a, b) => a + b, 0);
    const counter = document.querySelector('.cart-counter');
    
    if (counter && count > 0) {
        counter.textContent = count;
        counter.style.display = 'block';
    } else if (counter) {
        counter.style.display = 'none';
    }
}

updateCartCounter();

// ============================================
// UTILITY: Scroll to Top Button
// ============================================

const scrollTopBtn = document.getElementById('scrollTopBtn');

if (scrollTopBtn) {
    window.addEventListener('scroll', () => {
        if (window.scrollY > 300) {
            scrollTopBtn.classList.add('show');
        } else {
            scrollTopBtn.classList.remove('show');
        }
    });

    scrollTopBtn.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });
}

// ============================================
// LAZY LOADING IMAGES
// ============================================

if ('IntersectionObserver' in window) {
    const imageObserver = new IntersectionObserver((entries, observer) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const img = entry.target;
                img.src = img.dataset.src || img.src;
                img.classList.remove('lazy');
                observer.unobserve(img);
            }
        });
    });

    document.querySelectorAll('img.lazy').forEach(img => {
        imageObserver.observe(img);
    });
}

console.log('✅ NovaShop Pro - JavaScript loaded');
