<div class="cart" style="max-width: 900px; margin: 0 auto;">
    <h1>⊙ Votre Panier</h1>

    <?php if (empty($products)): ?>
        <div class="alert alert-info">ℹ️ Votre panier est vide.</div>
        <p style="text-align: center; margin-top: 30px;">
            <a href="/products" class="btn btn-primary">Continuer vos achats →</a>
        </p>
    <?php else: ?>
        <div class="cart-container">
            <div style="margin-bottom: 20px;">
                <p style="color: #aaa; font-size: 14px;">📦 <?= count($products) ?> article(s) dans le panier</p>
            </div>

            <?php 
            $total = $total ?? 0;
            foreach ($products as $item):
                $itemTotal = $item['subtotal'] ?? ($item['price'] * ($item['quantity'] ?? 1));
            ?>
                <div class="cart-item">
                    <div class="cart-item-info">
                        <h4><?= htmlspecialchars($item['name']) ?><?= isset($item['variant']) ? ' — ' . htmlspecialchars($item['variant']) : '' ?></h4>
                        <p style="color: #aaa; margin-bottom: 0;">Quantité: <strong><?= $item['quantity'] ?? 1 ?></strong></p>
                    </div>
                    <div style="text-align: right;">
                        <p class="cart-item-price"><?= number_format($itemTotal, 2, ',', ' ') ?>€</p>
                        <a href="/cart/remove?id=<?= $item['id'] ?><?= isset($item['variant']) ? '&variant=' . urlencode($item['variant']) : '' ?>" class="btn btn-danger" style="font-size: 12px; padding: 8px 12px;">✕ Supprimer</a>
                    </div>
                </div>
            <?php endforeach; ?>

            <div class="cart-total">
                💰 Total: <span style="font-size: 24px; color: var(--success-color);"><?= number_format($total, 2, ',', ' ') ?>€</span>
            </div>

            <form method="POST" action="/orders/create" style="margin-top: 20px;">
                <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 16px;">✓ Valider la commande</button>
            </form>
        </div>
        
        <p style="text-align: center; margin-top: 20px;">
            <a href="/products" style="color: var(--primary-color); text-decoration: none;">← Continuer vos achats</a>
        </p>
    <?php endif; ?>
</div>
