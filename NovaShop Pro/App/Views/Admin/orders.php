<h1 class="admin-title">🛒 Gestion des Commandes</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">✅ Commande supprimée avec succès</div>
<?php endif; ?>

<!-- STATISTIQUES COMMANDES -->
<?php 
$pending_count = 0;
$completed_count = 0;
$total_revenue = 0;

if (!empty($orders) && is_array($orders)) {
    foreach ($orders as $order) {
        $status = strtolower($order['status'] ?? 'pending');
        if ($status === 'pending') {
            $pending_count++;
        } elseif ($status === 'completed') {
            $completed_count++;
        }
        $total_revenue += (float)($order['total'] ?? 0);
    }
}
?>

<div class="admin-stats" style="margin-bottom: 3rem;">
    <div class="stat-card stat-card-primary">
        <p class="stat-label">⏳ En Attente</p>
        <p class="stat-value"><?php echo $pending_count; ?></p>
    </div>
    
    <div class="stat-card stat-card-success">
        <p class="stat-label">✅ Complétées</p>
        <p class="stat-value"><?php echo $completed_count; ?></p>
    </div>
    
    <div class="stat-card stat-card-accent">
        <p class="stat-label">💰 Revenu Total</p>
        <p class="stat-value" style="font-size: 1.8rem;"><?php echo number_format($total_revenue, 2, ',', ' '); ?>€</p>
    </div>
</div>

<!-- TABLEAU COMMANDES -->
<?php if (!empty($orders) && is_array($orders)): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Commande #</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                    <tr>
                        <td><strong>#<?php echo htmlspecialchars($order['id'] ?? ''); ?></strong></td>
                        <td><?php echo htmlspecialchars($order['user_id'] ?? 'N/A'); ?></td>
                        <td>
                            <span style="color: #d4a574; font-weight: 700;">
                                <?php echo number_format($order['total'] ?? 0, 2, ',', ' '); ?>€
                            </span>
                        </td>
                        <td>
                            <?php 
                            $status = strtolower($order['status'] ?? 'pending');
                            $status_label = $status === 'completed' ? '✅ Complétée' : '⏳ En Attente';
                            $statusColor = $status === 'completed' ? '#86efac' : '#fbbf24';
                            $statusBg = $status === 'completed' ? 'rgba(34, 197, 94, 0.2)' : 'rgba(251, 191, 36, 0.2)';
                            ?>
                            <span style="background: <?php echo $statusBg; ?>; color: <?php echo $statusColor; ?>; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-weight: 600; font-size: 0.85rem;">
                                <?php echo htmlspecialchars($status_label); ?>
                            </span>
                        </td>
                        <td style="color: #a0a0a0; font-size: 0.9rem;">
                            <?php 
                            if (!empty($order['created_at'])) {
                                $date = new \DateTime($order['created_at']);
                                echo $date->format('d/m/Y H:i');
                            }
                            ?>
                        </td>
                        <td style="text-align: center;">
                            <a href="/admin/order/<?php echo $order['id']; ?>" class="btn btn-info" style="padding: 0.5rem 0.8rem; font-size: 0.85rem; margin-right: 0.5rem;"><i class="fas fa-eye"></i> Voir</a>
                            <a href="/admin/deleteOrder/<?php echo $order['id']; ?>" onclick="return confirm('⚠️ Confirmer la suppression de cette commande ?')" class="btn btn-danger" style="padding: 0.5rem 0.8rem; font-size: 0.85rem;">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info" style="text-align: center;">
        Aucune commande trouvée.
    </div>
<?php endif; ?>
