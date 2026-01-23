<div class="container">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <a href="/">Accueil</a>
        <span>/</span>
        <span class="current">Produits</span>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Produits Vedettes</h2>
        <div style="display: flex; gap: 1rem; align-items: center;">
            <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer; font-size: 0.9rem;">
                <input type="checkbox" id="autoScrollToggle" style="width: 18px; height: 18px; cursor: pointer;">
                Auto-scroll
            </label>
        </div>
    </div>
</div>

<?php if (!empty($products)): ?>
<div class="carousel-section">
    <button id="prevBtn" class="carousel-control carousel-prev">❮</button>
    <div class="carousel-track" id="productsGrid">
        <?php foreach ($products as $product): ?>
        <div class="carousel-item">
            <div class="carousel-product">
                <button class="wishlist-btn" data-product-id="<?= $product['id'] ?>">🤍</button>
                <div class="carousel-product-image">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php else: ?>
                        <div style="font-size: 2rem;">📦</div>
                    <?php endif; ?>
                </div>
                <div class="carousel-product-info">
                    <h3 class="carousel-product-name"><?= htmlspecialchars($product['name']) ?></h3>
                    <div class="carousel-product-price"><?= number_format($product['price'], 2, ',', ' ') ?>€</div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <button id="nextBtn" class="carousel-control carousel-next">❯</button>
</div>
<?php endif; ?>

<div class="container">
    <!-- Search Bar -->
    <div class="search-bar">
        <input type="search" placeholder="Rechercher un produit...">
        <button>Chercher</button>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const track = document.getElementById('productsGrid');
    const prevBtn = document.getElementById('prevBtn');
    const nextBtn = document.getElementById('nextBtn');
    const autoScrollToggle = document.getElementById('autoScrollToggle');
    
    if (!track) {
        console.error('Track not found');
        return;
    }
    
    if (!prevBtn || !nextBtn) {
        console.error('Buttons not found', {prevBtn, nextBtn});
        return;
    }
    
    let autoScrollInterval = null;
    const scrollStep = 120;
    
    function scroll(direction) {
        console.log('Scrolling:', direction);
        track.scrollLeft += direction * scrollStep;
    }
    
    prevBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('Prev clicked');
        scroll(-1);
        if (autoScrollToggle?.checked) clearInterval(autoScrollInterval);
    });
    
    nextBtn.addEventListener('click', (e) => {
        e.preventDefault();
        e.stopPropagation();
        console.log('Next clicked');
        scroll(1);
        if (autoScrollToggle?.checked) clearInterval(autoScrollInterval);
    });
    
    function startAuto() {
        autoScrollInterval = setInterval(() => scroll(1), 3500);
    }
    
    function stopAuto() {
        clearInterval(autoScrollInterval);
    }
    
    if (autoScrollToggle) {
        autoScrollToggle.addEventListener('change', function() {
            this.checked ? startAuto() : stopAuto();
        });
    }
    
    track.addEventListener('mouseenter', stopAuto);
    track.addEventListener('mouseleave', function() {
        if (autoScrollToggle?.checked) startAuto();
    });
});
</script>

<style>
/* Empty - all CSS in Style.css */
</style>
