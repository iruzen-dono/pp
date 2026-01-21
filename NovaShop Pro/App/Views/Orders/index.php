<div class="orders">
    <h2>📋 Mes Commandes</h2>

    <?php if (empty($orders)): ?>
        <p>Vous n'avez aucune commande. <a href="/products">Commencer à acheter</a></p>
    <?php else: ?>
        <table border="1" cellpadding="10">
            <tr>
                <th>ID</th>
                <th>Total</th>
                <th>Statut</th>
                <th>Date</th>
                <th>Action</th>
            </tr>
            <?php foreach ($orders as $order): ?>
                <tr>
                    <td><?= htmlspecialchars($order['id']) ?></td>
                    <td><?= htmlspecialchars($order['total']) ?>€</td>
                    <td><?= htmlspecialchars($order['status']) ?></td>
                    <td><?= htmlspecialchars($order['created_at'] ?? 'N/A') ?></td>
                    <td><a href="/orders/show?id=<?= $order['id'] ?>">Détails</a></td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php endif; ?>
</div>
