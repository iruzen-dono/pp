<div class="orders" style="max-width: 900px; margin: 0 auto;">
    <h1>📋 Mes Commandes</h1>

    <?php if (empty($orders)): ?>
        <div class="alert alert-info">ℹ️ Vous n'avez aucune commande pour le moment.</div>
        <p style="text-align: center; margin-top: 30px;">
            <a href="/products" class="btn btn-primary">Commencer à acheter →</a>
        </p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Commande</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong>#<?= htmlspecialchars($order['id']) ?></strong></td>
                        <td><span style="color: var(--success-color); font-weight: bold;"><?= number_format($order['total'], 2, ',', ' ') ?>€</span></td>
                        <td>
                            <?php 
                            $statusColor = $order['status'] === 'pending' ? '#ffc107' : ($order['status'] === 'completed' ? '#4caf50' : '#f44336');
                            $statusText = $order['status'] === 'pending' ? '⏳ En attente' : ($order['status'] === 'completed' ? '✅ Complétée' : '❌ Annulée');
                            ?>
                            <span style="color: <?= $statusColor ?>; font-weight: bold;"><?= $statusText ?></span>
                        </td>
                        <td style="font-size: 14px; color: #aaa;"><?= date('d/m/Y', strtotime($order['created_at'] ?? 'now')) ?></td>
                        <td>
                            <a href="/order/<?= $order['id'] ?>" class="btn btn-secondary" style="padding: 8px 12px; font-size: 12px;">Détails</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>
