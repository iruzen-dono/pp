<div class="container">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <a href="/">Accueil</a>
        <span>/</span>
        <span class="current">Produits</span>
    </div>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h2>Tous nos produits</h2>
        <button id="filterBtn" class="btn btn-secondary btn-small">🔍 Filtrer</button>
    </div>

    <!-- Search Bar -->
    <div class="search-bar">
        <input type="search" placeholder="Rechercher un produit...">
        <button>Chercher</button>
    </div>

    <?php if (empty($products)): ?>
        <div class="alert alert-info">ℹ️ Aucun produit disponible pour le moment.</div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card animate-on-scroll">
                    <button class="wishlist-btn" data-product-id="<?= $product['id'] ?>">🤍</button>
                    
                    <div class="product-image">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                        <?php else: ?>
                            <div style="font-size: 4rem; width: 100%; height: 100%; display: flex; align-items: center; justify-content: center;">📦</div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                        <div class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?>€</div>
                        
                        <!-- Rating Stars -->
                        <div class="rating-container" style="margin: 0.5rem 0;">
                            <span class="star" data-rating="1">★</span>
                            <span class="star" data-rating="2">★</span>
                            <span class="star" data-rating="3">★</span>
                            <span class="star" data-rating="4">★</span>
                            <span class="star" data-rating="5">★</span>
                            <span class="rating-text">(12 avis)</span>
                            <input type="hidden" name="rating" value="4">
                        </div>

                        <p class="product-description"><?= htmlspecialchars(substr($product['description'], 0, 100)) ?>...</p>
                        <div class="product-actions">
                            <a href="/product/<?= $product['id'] ?>" class="btn btn-primary btn-small">Voir détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
