<div class="product-detail" style="max-width: 700px; margin: 0 auto;">
    <a href="/products" class="btn btn-secondary" style="margin-bottom: 20px;">← Retour aux produits</a>

    <?php if (empty($product)): ?>
        <div class="alert alert-danger">❌ Produit non trouvé.</div>
    <?php else: ?>
        <div style="background: var(--secondary-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 30px; margin-bottom: 30px;">
            <div style="background: linear-gradient(135deg, #2a2447 0%, #1a1433 100%); padding: 60px; text-align: center; border-radius: 8px; margin-bottom: 20px; font-size: 64px;">📦</div>
            
            <h1><?= htmlspecialchars($product['name']) ?></h1>
            <p class="product-price" style="font-size: 32px; margin: 20px 0;"><?= htmlspecialchars($product['price']) ?>€</p>
            <p style="color: #aaa; line-height: 1.8; margin-bottom: 20px;"><?= htmlspecialchars($product['description']) ?></p>
            
            <hr style="border: 1px solid var(--border-color); margin: 20px 0;">
            
            <form method="POST" action="/cart/add" style="max-width: 100%; background: transparent; border: none; padding: 0;">
                <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                
                <label for="quantity">Quantité:</label>
                <div style="display: flex; gap: 10px; margin-bottom: 20px;">
                    <input type="number" name="quantity" id="quantity" value="1" min="1" max="100" required style="flex: 1; max-width: 100px;">
                    <button type="submit" class="btn btn-primary" style="flex: 1;">🛒 Ajouter au panier</button>
                </div>
            </form>
        </div>
    <?php endif; ?>
</div>
