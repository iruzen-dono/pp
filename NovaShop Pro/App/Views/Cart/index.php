<div class="cart">
    <h2>🛒 Votre Panier</h2>

    <?php if (empty($_SESSION['cart'])): ?>
        <p>Votre panier est vide. <a href="/products">Continuer vos achats</a></p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>Produit ID</th>
                <th>Quantité</th>
                <th>Action</th>
            </tr>
            <?php foreach ($_SESSION['cart'] as $productId => $quantity): ?>
                <tr>
                    <td><?= htmlspecialchars($productId) ?></td>
                    <td><?= htmlspecialchars($quantity) ?></td>
                    <td>
                        <a href="/cart/remove?id=<?= $productId ?>">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>

        <form method="POST" action="/orders/create">
            <button type="submit">Valider la commande</button>
        </form>
    <?php endif; ?>
</div>
