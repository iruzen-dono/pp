<div class="admin-order-detail" style="max-width: 900px; margin: 0 auto;">
    <a href="/admin/orders" class="btn btn-secondary" style="margin-bottom: 20px;"><i class="fas fa-arrow-left"></i> Retour aux commandes</a>

    <?php if (isset($_GET['success'])): ?>
        <div class="alert alert-success">
            ✅ Statut de la commande mis à jour avec succès
        </div>
    <?php endif; ?>

    <?php if (empty($order)): ?>
        <div class="alert alert-danger"><i class="fas fa-times-circle"></i> Commande non trouvée.</div>
    <?php else: ?>
        <div style="background: rgba(99, 102, 241, 0.1); border: 1px solid rgba(99, 102, 241, 0.3); border-radius: 8px; padding: 30px;">
            <h1><i class="fas fa-clipboard-list"></i> Détails Commande #<?= htmlspecialchars($order['id']) ?></h1>
            
            <hr style="border: 1px solid rgba(99, 102, 241, 0.2); margin: 20px 0;">
            
            <!-- Info Principales -->
            <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 20px; margin-bottom: 30px;">
                <div>
                    <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">MONTANT TOTAL</p>
                    <p style="font-size: 24px; color: #d4a574; font-weight: bold;"><?= number_format($order['total'], 2, ',', ' ') ?>€</p>
                </div>
                <div>
                    <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">CLIENT ID</p>
                    <p style="font-size: 18px; font-weight: bold;">#<?= htmlspecialchars($order['user_id']) ?></p>
                </div>
                <div>
                    <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">DATE</p>
                    <p style="font-size: 18px; font-weight: bold;"><?= date('d/m/Y H:i', strtotime($order['created_at'] ?? 'now')) ?></p>
                </div>
            </div>

            <!-- Statut et Actions -->
            <div style="background: rgba(0,0,0,0.2); padding: 20px; border-radius: 6px; margin-bottom: 30px;">
                <p style="color: #aaa; font-size: 14px; margin-bottom: 15px; font-weight: 600;">GESTION DU STATUT</p>
                
                <?php 
                $status = strtolower($order['status'] ?? 'pending');
                $statusLabel = $status === 'completed' ? '<i class="fas fa-check-circle"></i> Complétée' : ($status === 'cancelled' ? '<i class="fas fa-times-circle"></i> Annulée' : '<i class="fas fa-hourglass-half"></i> En Attente');
                $statusColor = $status === 'completed' ? '#86efac' : ($status === 'cancelled' ? '#fca5a5' : '#fbbf24');
                ?>
                
                <p style="margin-bottom: 15px;">
                    <span style="background: rgba(255,255,255,0.1); color: <?= $statusColor ?>; padding: 0.6rem 1rem; border-radius: 0.4rem; font-weight: 600; display: inline-block;">
                        <?= $statusLabel ?>
                    </span>
                </p>

                <form method="POST" action="/admin/updateOrderStatus/<?= $order['id']; ?>" style="display: flex; gap: 10px; align-items: flex-end;">
                    <input type="hidden" name="_csrf" value="<?php echo \App\Middleware\CsrfMiddleware::generateToken(); ?>">
                    
                    <div>
                        <label for="status" style="display: block; font-weight: 600; margin-bottom: 0.5rem; color: #aaa; font-size: 12px;">Nouveau statut:</label>
                        <select name="status" id="status" style="padding: 0.6rem; border: 1px solid #444; border-radius: 0.3rem; background: #222; color: #fff;">
                            <option value="pending" <?= $status === 'pending' ? 'selected' : ''; ?>>⏳ En Attente</option>
                            <option value="completed" <?= $status === 'completed' ? 'selected' : ''; ?>>✅ Complétée</option>
                            <option value="cancelled" <?= $status === 'cancelled' ? 'selected' : ''; ?>>❌ Annulée</option>
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary" style="padding: 0.6rem 1.2rem;">💾 Mettre à jour</button>
                </form>
            </div>

            <!-- Articles de la Commande -->
            <h3 style="margin-bottom: 15px;"><i class="fas fa-box"></i> Articles (<?= count($items ?? []) ?>)</h3>
            
            <?php if (!empty($items) && is_array($items)): ?>
                <div style="overflow-x: auto; margin-bottom: 30px;">
                    <table style="width: 100%; border-collapse: collapse;">
                        <thead>
                            <tr style="border-bottom: 2px solid rgba(99, 102, 241, 0.3); background: rgba(99, 102, 241, 0.1);">
                                <th style="padding: 12px; text-align: left; color: #aaa;">Produit</th>
                                <th style="padding: 12px; text-align: center; color: #aaa;">Quantité</th>
                                <th style="padding: 12px; text-align: right; color: #aaa;">Prix Unitaire</th>
                                <th style="padding: 12px; text-align: right; color: #aaa;">Sous-total</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): ?>
                                <tr style="border-bottom: 1px solid rgba(99, 102, 241, 0.2);">
                                    <td style="padding: 12px; color: #fff;">
                                        <strong>Produit ID #<?= htmlspecialchars($item['product_id'] ?? 'N/A') ?></strong>
                                    </td>
                                    <td style="padding: 12px; text-align: center; color: #ccc;">
                                        <?= htmlspecialchars($item['quantity'] ?? 1) ?>
                                    </td>
                                    <td style="padding: 12px; text-align: right; color: #d4a574; font-weight: 600;">
                                        <?= number_format($item['price'] ?? 0, 2, ',', ' ') ?>€
                                    </td>
                                    <td style="padding: 12px; text-align: right; color: #86efac; font-weight: 600;">
                                        <?= number_format(($item['quantity'] ?? 1) * ($item['price'] ?? 0), 2, ',', ' ') ?>€
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <p style="color: #aaa; padding: 20px; background: rgba(0,0,0,0.2); border-radius: 6px;">Aucun article dans cette commande.</p>
            <?php endif; ?>

            <!-- Résumé -->
            <div style="background: rgba(0,0,0,0.3); padding: 20px; border-radius: 6px; text-align: right;">
                <p style="color: #aaa; margin-bottom: 10px;">MONTANT FINAL:</p>
                <p style="font-size: 28px; color: #d4a574; font-weight: bold;">
                    <?= number_format($order['total'], 2, ',', ' ') ?>€
                </p>
            </div>
        </div>
    <?php endif; ?>
</div>
