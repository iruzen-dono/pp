<div class="product-detail">
    <h2>📦 Détails du Produit</h2>

    <?php if (empty($product)): ?>
        <p>❌ Produit non trouvé.</p>
    <?php else: ?>
        <h3><?= htmlspecialchars($product['name']) ?></h3>
        <p><?= htmlspecialchars($product['description']) ?></p>
        <p><strong>Prix: <?= htmlspecialchars($product['price']) ?>€</strong></p>
        <p><strong>Catégorie ID: <?= htmlspecialchars($product['category_id']) ?></strong></p>

        <form method="POST" action="/cart/add">
            <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
            <label for="quantity">Quantité:</label>
            <input type="number" name="quantity" id="quantity" value="1" min="1" required>
            <button type="submit">Ajouter au panier</button>
        </form>

        <a href="/products">← Retour aux produits</a>
    <?php endif; ?>
</div>
