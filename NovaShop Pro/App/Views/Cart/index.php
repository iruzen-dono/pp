<div class="cart" style="max-width: 900px; margin: 0 auto;">
    <h1>⊙ Votre Panier</h1>

    <?php if (empty($_SESSION['cart'])): ?>
        <div class="alert alert-info">ℹ️ Votre panier est vide.</div>
        <p style="text-align: center; margin-top: 30px;">
            <a href="/products" class="btn btn-primary">Continuer vos achats →</a>
        </p>
    <?php else: ?>
        <div class="cart-container">
            <div style="margin-bottom: 20px;">
                <p style="color: #aaa; font-size: 14px;">📦 <?= count($_SESSION['cart']) ?> article(s) dans le panier</p>
            </div>

            <?php 
            $total = 0;
            $cartItems = [];
            
            // Récupérer les détails des produits
            require_once __DIR__ . '/../../Models/Product.php';
            $productModel = new \App\Models\Product();
            
            foreach ($_SESSION['cart'] as $productId => $quantity):
                $product = $productModel->getById($productId);
                if ($product):
                    $itemTotal = $product['price'] * $quantity;
                    $total += $itemTotal;
            ?>
                <div class="cart-item">
                    <div class="cart-item-info">
                        <h4><?= htmlspecialchars($product['name']) ?></h4>
                        <p style="color: #aaa; margin-bottom: 0;">Quantité: <strong><?= $quantity ?></strong></p>
                    </div>
                    <div style="text-align: right;">
                        <p class="cart-item-price"><?= number_format($itemTotal, 2, ',', ' ') ?>€</p>
                        <a href="/cart/remove?id=<?= $productId ?>" class="btn btn-danger" style="font-size: 12px; padding: 8px 12px;">✕ Supprimer</a>
                    </div>
                </div>
            <?php 
                endif;
            endforeach; 
            ?>

            <div class="cart-total">
                💰 Total: <span style="font-size: 24px; color: var(--success-color);"><?= number_format($total, 2, ',', ' ') ?>€</span>
            </div>

            <form method="POST" action="/orders/create" style="margin-top: 20px;">
                <button type="submit" class="btn btn-primary" style="width: 100%; padding: 15px; font-size: 16px;">✓ Valider la commande</button>
            </form>
        </div>
        
        <p style="text-align: center; margin-top: 20px;">
            <a href="/products" style="color: var(--primary-color); text-decoration: none;">← Continuer vos achats</a>
        </p>
    <?php endif; ?>
</div>
