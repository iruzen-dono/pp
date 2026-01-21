<div class="products">
    <h2>📦 Produits</h2>

    <?php if (empty($products)): ?>
        <p>Aucun produit disponible.</p>
    <?php else: ?>
        <div class="products-grid">
            <?php foreach ($products as $product): ?>
                <div class="product-card" style="border: 1px solid #b388ff; padding: 15px; margin: 10px; border-radius: 8px;">
                    <h3><?= htmlspecialchars($product['name']) ?></h3>
                    <p><?= htmlspecialchars($product['description']) ?></p>
                    <p><strong>Prix: <?= htmlspecialchars($product['price']) ?>€</strong></p>
                    <a href="/products/show?id=<?= $product['id'] ?>">Voir détails</a>
                </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>
