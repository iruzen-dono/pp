<div class="products">
    <h2>📦 Catalogue Produits</h2>
    <p class="subtitle">Découvrez notre sélection de produits de qualité</p>

    <?php if (empty($products)): ?>
        <div class="alert alert-info">ℹ️ Aucun produit disponible pour le moment.</div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image">📦</div>
                    <div class="product-info">
                        <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="product-price"><?= htmlspecialchars($product['price']) ?>€</p>
                        <p class="product-description"><?= htmlspecialchars(substr($product['description'], 0, 80)) ?>...</p>
                        <div class="product-actions">
                            <a href="/products/show?id=<?= $product['id'] ?>" class="btn btn-primary">Voir détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
