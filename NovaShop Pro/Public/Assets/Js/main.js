// ============================================
// NOVASHOP PRO - Main JavaScript
// ============================================

document.addEventListener('DOMContentLoaded', function() {
    initDarkMode();
    initScrollAnimations();
    initCarousel();
    initWishlist();
    initNewsletterPopup();
    initFilterModal();
    initSmoothScroll();
});

// ============================================
// DARK MODE TOGGLE
// ============================================

function initDarkMode() {
    const darkModeToggle = document.getElementById('darkModeToggle');
    if (!darkModeToggle) return;

    const isDarkMode = localStorage.getItem('darkMode') === 'true';
    
    if (isDarkMode) {
        document.documentElement.setAttribute('data-theme', 'dark');
        darkModeToggle.textContent = '☀️';
    }

    darkModeToggle.addEventListener('click', function() {
        const isDark = document.documentElement.getAttribute('data-theme') === 'dark';
        
        if (isDark) {
            document.documentElement.removeAttribute('data-theme');
            localStorage.setItem('darkMode', 'false');
            this.textContent = '🌙';
        } else {
            document.documentElement.setAttribute('data-theme', 'dark');
            localStorage.setItem('darkMode', 'true');
            this.textContent = '☀️';
        }
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
