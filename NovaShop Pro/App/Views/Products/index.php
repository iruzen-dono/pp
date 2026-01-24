<div class="container">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <a href="/">Accueil</a>
        <span>/</span>
        <span class="current">Produits</span>
    </div>

    <div class="products-page-header">
        <h2>Nos Produits Vedettes</h2>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="search" placeholder="🔍 Rechercher un produit..." aria-label="Rechercher">
        <button type="button">Chercher</button>
    </div>
</div>

<?php if (!empty($products)): ?>
<div class="container">
    <div class="products-grid" id="productsGrid">
        <?php foreach ($products as $product): ?>
        <a href="/products/<?= $product['id'] ?>" class="product-card">
            <div class="product-card-inner">
                <button class="wishlist-btn" data-product-id="<?= $product['id'] ?>" aria-label="Ajouter aux favoris" type="button" tabindex="-1">🤍</button>
                <div class="product-card-image">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php else: ?>
                        <div class="placeholder-icon">📦</div>
                    <?php endif; ?>
                </div>
                <div class="product-card-content">
                    <h3 class="product-card-name"><?= htmlspecialchars($product['name']) ?></h3>
                    <div class="product-card-price"><?= number_format($product['price'], 2, ',', ' ') ?>€</div>
                    <div class="product-card-rating">
                        <span class="stars">★★★★★</span>
                        <span class="rating-value">4.5</span>
                    </div>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
</div>
<?php else: ?>
<div class="container">
    <div class="no-products">
        <p>📦 Aucun produit trouvé</p>
    </div>
</div>
<?php endif; ?>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Wishlist button handling
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            const isFilled = this.textContent === '❤️';
            
            this.textContent = isFilled ? '🤍' : '❤️';
            this.style.transform = 'scale(1.2)';
            setTimeout(() => { this.style.transform = 'scale(1)'; }, 200);
            
            // TODO: Send AJAX request to add/remove from wishlist
        });
    });
});
</script>
