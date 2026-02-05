<style>
.table-container {
    width: 100%;
    overflow-x: auto;
    border-radius: 0.5rem;
    background: rgba(30, 30, 40, 0.8);
    padding: 1rem;
    margin-top: 2rem;
}

.table-container table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
    background: transparent;
}

.table-container thead {
    background: rgba(60, 60, 80, 0.9);
}

.table-container th {
    padding: 0.75rem;
    text-align: left;
    font-weight: 600;
    color: #e0e7ff;
    border-bottom: 2px solid rgba(100, 100, 120, 0.5);
    user-select: none;
    white-space: nowrap;
}

.table-container td {
    padding: 0.75rem;
    border-bottom: 1px solid rgba(100, 100, 120, 0.3);
    color: #d1d5db;
}

.table-container tbody tr {
    transition: background-color 0.2s ease;
}

.table-container tbody tr:hover {
    background-color: rgba(96, 165, 250, 0.1);
}

.table-container tbody tr:last-child td {
    border-bottom: none;
}

.table-container a {
    color: #60a5fa;
    text-decoration: none;
    transition: color 0.2s ease;
}

.table-container a:hover {
    color: #93c5fd;
    text-decoration: underline;
}

.status-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: capitalize;
}

.status-pending {
    background: rgba(245, 158, 11, 0.2);
    color: #fbbf24;
}

.status-completed {
    background: rgba(34, 197, 94, 0.2);
    color: #86efac;
}

.status-cancelled {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
}

.admin-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.admin-actions a, .admin-actions button {
    padding: 0.4rem 0.8rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    border: none;
    cursor: pointer;
    transition: all 0.2s ease;
    text-decoration: none;
}

.admin-actions a.view {
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
}

.admin-actions a.view:hover {
    background: rgba(59, 130, 246, 0.3);
}

.admin-actions a.delete {
    background: rgba(239, 68, 68, 0.2);
    color: #ef4444;
}

.admin-actions a.delete:hover {
    background: rgba(239, 68, 68, 0.3);
}

@media (max-width: 768px) {
    .table-container {
        padding: 0.5rem;
        overflow-x: auto;
    }
    
    .table-container th,
    .table-container td {
        padding: 0.5rem 0.25rem;
        font-size: 0.875rem;
    }
    
    .admin-actions {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .admin-actions a, .admin-actions button {
        padding: 0.3rem 0.5rem;
        font-size: 0.75rem;
        width: 100%;
    }
}
</style>

<h1 class="admin-title"><i class="fas fa-shopping-cart"></i> Gestion des Commandes</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">✅ Commande supprimée avec succès</div>
<?php endif; ?>

<!-- STATISTIQUES COMMANDES -->
<?php 
$pending_count = 0;
$delivered_count = 0;
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
        <p class="stat-label"><i class="fas fa-hourglass-half"></i> En Attente</p>
        <p class="stat-value"><?php echo $pending_count; ?></p>
    </div>
    
    <div class="stat-card stat-card-success">
        <p class="stat-label"><i class="fas fa-check-circle"></i> Livrées</p>
        <p class="stat-value"><?php echo $delivered_count; ?></p>
    </div>
    
    <div class="stat-card stat-card-accent">
        <p class="stat-label"><i class="fas fa-wallet"></i> Revenu Total</p>
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
                            if ($status === 'cancelled') {
                                $status_label = 'Annulée';
                                $statusColor = '#fca5a5';
                                $statusBg = 'rgba(252, 165, 165, 0.08)';
                                $statusIcon = '<i class="fas fa-times-circle"></i>';
                            } elseif ($status === 'shipped') {
                                $status_label = 'Expédiée';
                                $statusColor = '#60a5fa';
                                $statusBg = 'rgba(96, 165, 250, 0.08)';
                                $statusIcon = '<i class="fas fa-truck"></i>';
                            } elseif ($status === 'confirmed') {
                                $status_label = 'Confirmée';
                                $statusColor = '#86efac';
                                $statusBg = 'rgba(134, 239, 172, 0.08)';
                                $statusIcon = '<i class="fas fa-check"></i>';
                            } elseif ($status === 'delivered') {
                                $status_label = 'Livrée';
                                $statusColor = '#16a34a';
                                $statusBg = 'rgba(22, 163, 74, 0.08)';
                                $statusIcon = '<i class="fas fa-check-circle"></i>';
                            } else {
                                $status_label = 'En Attente';
                                $statusColor = '#fbbf24';
                                $statusBg = 'rgba(251, 191, 36, 0.08)';
                                $statusIcon = '<i class="fas fa-hourglass-half"></i>';
                            }
                            ?>
                            <span style="background: <?php echo $statusBg; ?>; color: <?php echo $statusColor; ?>; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-weight: 600; font-size: 0.85rem;">
                                <?php echo $statusIcon . ' ' . htmlspecialchars($status_label); ?>
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
                            <a href="/admin/deleteOrder/<?php echo $order['id']; ?>" onclick="return confirm('Confirmer la suppression de cette commande ?')" class="btn btn-danger" style="padding: 0.5rem 0.8rem; font-size: 0.85rem;"><i class="fas fa-trash"></i></a>
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
