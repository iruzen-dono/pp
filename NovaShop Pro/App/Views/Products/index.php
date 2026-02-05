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
        <form class="inline-search-form" method="GET" action="/products">
            <div class="input-with-icon">
                <span class="search-icon">🔎</span>
                <input type="search" name="q" placeholder="Rechercher un produit, catégorie..." value="<?php echo htmlspecialchars($searchQuery ?? ''); ?>">
            </div>
            <button type="submit" class="btn">Rechercher</button>
        </form>
    </div>
</div>

<?php 
// Debug temporaire
if (empty($products)) {
    error_log("PRODUCTS DEBUG: products is empty or not set. Type: " . gettype($products) . ", Value: " . json_encode($products));
}
?>
<?php if (!empty($products)): ?>
<div class="container">
    <div class="products-grid" id="productsGrid">
        <?php foreach ($products as $product): ?>
        <a href="/products/<?= $product['id'] ?>" class="product-card">
            <div class="product-card-inner">
                <div class="product-card-image">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                    <?php else: ?>
                        <div class="placeholder-icon"><i class="fas fa-box"></i></div>
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
        <p><i class="fas fa-box"></i> Aucun produit trouvé</p>
    </div>
</div>
<?php endif; ?>

<!-- wishlist removed -->
