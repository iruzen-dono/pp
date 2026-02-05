<div class="order-create" style="max-width: 600px; margin: 0 auto; text-align: center;">
    <h1>✅ Confirmer votre commande</h1>

    <div style="background: var(--secondary-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 30px; margin: 30px 0;">
        <p style="font-size: 16px; margin-bottom: 20px;">Veuillez confirmer votre commande pour finaliser votre achat.</p>
        
        <div style="background: var(--dark-bg); padding: 20px; border-radius: 6px; margin-bottom: 20px; border-left: 4px solid var(--primary-color);">
            <p style="color: #aaa; margin-bottom: 5px;">Contenu du panier:</p>
            <p style="font-size: 18px; color: var(--primary-color); font-weight: bold;">
                📦 <?= count($_SESSION['cart'] ?? []) ?> article(s)
            </p>
        </div>

        <form method="POST" style="display: inline-block;">
            <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
            <button type="submit" class="btn btn-primary" style="width: 300px; padding: 15px; font-size: 16px;">✓ Confirmer la commande</button>
        </form>
    </div>

    <p style="margin-top: 30px;">
        <a href="/cart" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">← Retour au panier</a>
    </p>
</div>
