<div class="order-detail" style="max-width: 700px; margin: 0 auto;">
    <a href="/orders" class="btn btn-secondary" style="margin-bottom: 20px;">← Retour à mes commandes</a>
    <a href="/products" class="btn btn-secondary" style="margin-bottom: 20px; margin-left: 10px;">← Retour aux produits</a>

    <?php if (empty($order)): ?>
        <div class="alert alert-danger">❌ Commande non trouvée.</div>
    <?php else: ?>
        <div style="background: var(--secondary-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 30px;">
            <h1>📋 Commande #<?= htmlspecialchars($order['id']) ?></h1>
            
            <hr style="border: 1px solid var(--border-color); margin: 20px 0;">
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px; margin-bottom: 20px;">
                <div>
                    <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">MONTANT TOTAL</p>
                    <p style="font-size: 28px; color: var(--success-color); font-weight: bold;"><?= number_format($order['total'], 2, ',', ' ') ?>€</p>
                </div>
                <div>
                    <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">STATUT</p>
                    <?php 
                    $statusColor = $order['status'] === 'pending' ? '#ffc107' : ($order['status'] === 'completed' ? '#4caf50' : '#f44336');
                    $statusText = $order['status'] === 'pending' ? '⏳ En attente' : ($order['status'] === 'completed' ? '✅ Complétée' : '❌ Annulée');
                    ?>
                    <p style="font-size: 18px; color: <?= $statusColor ?>; font-weight: bold;"><?= $statusText ?></p>
                </div>
            </div>

            <hr style="border: 1px solid var(--border-color); margin: 20px 0;">

            <div style="margin-bottom: 20px;">
                <p style="color: #aaa; font-size: 14px; margin-bottom: 10px;">INFORMATIONS</p>
                <p>📅 <strong>Date:</strong> <?= date('d/m/Y à H:i', strtotime($order['created_at'] ?? 'now')) ?></p>
                <p>🆔 <strong>Numéro:</strong> Commande #<?= htmlspecialchars($order['id']) ?></p>
            </div>

            <div style="background: var(--dark-bg); padding: 15px; border-radius: 6px; border-left: 4px solid var(--primary-color); margin-bottom: 20px;">
                <p style="color: #aaa; margin-bottom: 5px;">Les articles seront envoyés sous peu.</p>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="/products" class="btn btn-primary">Continuer vos achats</a>
            </div>
        </div>
    <?php endif; ?>
</div>
