<div class="product-detail" style="max-width: 700px; margin: 0 auto;">
    <a href="/products" class="btn btn-secondary" style="margin-bottom: 20px;">← Retour aux produits</a>

    <?php if (empty($product)): ?>
        <div class="alert alert-danger">❌ Produit non trouvé.</div>
    <?php else: ?>
        <div style="background: var(--secondary-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 30px; margin-bottom: 30px;">
            <div style="background: var(--dark-bg); padding: 0; text-align: center; border-radius: 8px; margin-bottom: 20px; overflow: hidden; height: 300px;">
                <?php if (!empty($product['image_url'])): ?>
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 100%; object-fit: cover;">
                <?php else: ?>
                    <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 64px; background: linear-gradient(135deg, #b388ff, #5c3a9d);">📦</div>
                <?php endif; ?>
            </div>
            
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p class="product-price" style="font-size: 32px; margin: 20px 0; color: #4caf50;"><?= number_format($product['price'], 2, ',', ' ') ?>€</p>
            <p style="color: #aaa; line-height: 1.8; margin-bottom: 20px;"><?= htmlspecialchars($product['description']) ?></p>
            
            <div style="background: var(--dark-bg); padding: 15px; border-radius: 6px; margin-bottom: 20px;">
                <p style="margin: 5px 0;"><strong>📦 Stock:</strong> <span style="color: <?= ($product['stock'] ?? 0) > 0 ? '#4caf50' : '#f44336' ?>"><?= ($product['stock'] ?? 0) ?> unités</span></p>
                <p style="margin: 5px 0;"><strong>🏷️ Catégorie:</strong> <span style="color: var(--primary-color);">ID <?= ($product['category_id'] ?? '') ?></span></p>
            </div>
            
            <hr style="border: 1px solid var(--border-color); margin: 20px 0;">
            
            <form method="POST" action="/cart/add" style="max-width: 100%; background: transparent; border: none; padding: 0;">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                
                <label for="quantity" style="display: block; margin-bottom: 10px; color: #aaa;">Quantité:</label>
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['stock'] ?? 100 ?>" required style="flex: 1; max-width: 100px; padding: 10px; background: var(--dark-bg); border: 1px solid var(--border-color); border-radius: 4px; color: white;">
                    <button type="submit" class="btn btn-primary" style="flex: 1; max-width: 300px;">🛒 Ajouter au panier</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
