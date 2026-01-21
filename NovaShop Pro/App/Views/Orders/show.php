<div class="order-detail">
    <h2>📋 Détails de la Commande</h2>

    <?php if (empty($order)): ?>
        <p>❌ Commande non trouvée.</p>
    <?php else: ?>
        <p><strong>ID Commande:</strong> <?= htmlspecialchars($order['id']) ?></p>
        <p><strong>Total:</strong> <?= htmlspecialchars($order['total']) ?>€</p>
        <p><strong>Statut:</strong> <?= htmlspecialchars($order['status']) ?></p>
        <p><strong>Date:</strong> <?= htmlspecialchars($order['created_at'] ?? 'N/A') ?></p>

        <a href="/orders">← Retour aux commandes</a>
    <?php endif; ?>
</div>
