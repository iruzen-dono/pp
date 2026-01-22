<div class="products">
    <h2>📦 Catalogue Produits</h2>
    <p class="subtitle">Découvrez notre sélection de produits de qualité</p>

    <?php if (empty($products)): ?>
        <div class="alert alert-info">ℹ️ Aucun produit disponible pour le moment.</div>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card">
                    <div class="product-image" style="background-color: #1a1728; overflow: hidden; border-radius: 6px 6px 0 0;">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 200px; object-fit: cover;">
                        <?php else: ?>
                            <div style="width: 100%; height: 200px; display: flex; align-items: center; justify-content: center; font-size: 48px; background: linear-gradient(135deg, #b388ff, #5c3a9d);">📦</div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><?= htmlspecialchars($product['name']) ?></h3>
                        <p class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?>€</p>
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
