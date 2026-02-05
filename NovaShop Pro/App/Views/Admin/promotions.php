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
    min-width: 1000px;
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

.badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
}

.badge-active {
    background: rgba(34, 197, 94, 0.2);
    color: #86efac;
}

.badge-inactive {
    background: rgba(107, 114, 128, 0.2);
    color: #d1d5db;
}

.badge-percentage {
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
}

.badge-fixed {
    background: rgba(139, 92, 246, 0.2);
    color: #d8b4fe;
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

.admin-actions a.edit {
    background: rgba(59, 130, 246, 0.2);
    color: #60a5fa;
}

.admin-actions a.edit:hover {
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

<h1><i class="fas fa-tag"></i> Gestion des Promotions</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> Promotion <?php echo htmlspecialchars($_GET['success']); ?> avec succès
    </div>
<?php endif; ?>

<!-- FORMULAIRE AJOUTER PROMOTION -->
<div style="background: linear-gradient(135deg, rgba(51, 65, 85, 0.7), rgba(30, 41, 59, 0.7)); border: 1px solid rgba(148, 163, 184, 0.2); border-radius: 0.75rem; padding: 2rem; margin-bottom: 2rem; backdrop-filter: blur(10px);">
    <h2><i class="fas fa-plus-circle"></i> Ajouter une Promotion</h2>
    <form method="POST">
        <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
        <input type="hidden" name="action" value="create">

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label>Nom de la Promotion *</label>
                <input type="text" name="name" required style="width: 100%; padding: 0.75rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff;">
            </div>
            <div>
                <label>Type de réduction *</label>
                <select name="discount_type" required style="width: 100%; padding: 0.75rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff;">
                    <option value="percentage">Pourcentage (%)</option>
                    <option value="fixed">Montant fixe (€)</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label>Valeur de réduction *</label>
                <input type="number" name="discount_value" step="0.01" min="0" required style="width: 100%; padding: 0.75rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff;">
            </div>
            <div>
                <label>Produit (optionnel)</label>
                <select name="product_id" style="width: 100%; padding: 0.75rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff;">
                    <option value="">-- Sélectionner un produit --</option>
                    <?php foreach ($products ?? [] as $product): ?>
                        <option value="<?php echo $product['id']; ?>"><?php echo htmlspecialchars($product['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 1.5rem;">
            <div>
                <label>Catégorie (optionnel)</label>
                <select name="category_id" style="width: 100%; padding: 0.75rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff;">
                    <option value="">-- Sélectionner une catégorie --</option>
                    <?php foreach ($categories ?? [] as $category): ?>
                        <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div style="display: flex; align-items: flex-end;">
                <label style="flex: 1; margin-bottom: 0;">
                    <input type="checkbox" name="is_active" value="1" checked>
                    Activer cette promotion
                </label>
            </div>
        </div>

        <div>
            <label>Description</label>
            <textarea name="description" style="width: 100%; padding: 0.75rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff; min-height: 80px; font-family: inherit;"></textarea>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin: 1.5rem 0;">
            <div>
                <label>Date de début *</label>
                <input type="datetime-local" name="start_date" value="<?php echo date('Y-m-d\TH:i'); ?>" required style="width: 100%; padding: 0.75rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff;">
            </div>
            <div>
                <label>Date de fin *</label>
                <input type="datetime-local" name="end_date" value="<?php echo date('Y-m-d\TH:i', strtotime('+30 days')); ?>" required style="width: 100%; padding: 0.75rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff;">
            </div>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;"><i class="fas fa-plus"></i> Ajouter la Promotion</button>
    </form>
</div>

<!-- TABLEAU PROMOTIONS -->
<h2>Promotions (<?php echo count($promotions ?? []); ?>)</h2>

<?php if (!empty($promotions) && is_array($promotions)): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Type</th>
                    <th>Valeur</th>
                    <th>Appliqué à</th>
                    <th>Statut</th>
                    <th>Dates</th>
                    <th>Créé par</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($promotions as $promo): ?>
                    <tr>
                        <td>
                            <strong><?php echo htmlspecialchars($promo['name'] ?? ''); ?></strong>
                            <?php if (!empty($promo['description'])): ?>
                                <br><small style="color: #999;"><?php echo htmlspecialchars(substr($promo['description'], 0, 50)); ?></small>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="background: rgba(99, 102, 241, 0.2); padding: 0.3rem 0.6rem; border-radius: 0.2rem; font-size: 0.85rem;">
                                <?php echo strtoupper($promo['discount_type'] ?? ''); ?>
                            </span>
                        </td>
                        <td style="color: #86efac; font-weight: bold;">
                            <?php echo $promo['discount_value']; ?><?php echo ($promo['discount_type'] === 'percentage') ? '%' : '€'; ?>
                        </td>
                        <td style="font-size: 0.9rem;">
                            <?php 
                            if (!empty($promo['product_id'])) {
                                echo '<i class="fas fa-box"></i> ' . htmlspecialchars($promo['product_name'] ?? 'Produit');
                            } elseif (!empty($promo['category_id'])) {
                                echo '<i class="fas fa-folder"></i> ' . htmlspecialchars($promo['category_name'] ?? 'Catégorie');
                            } else {
                                echo '<i class="fas fa-globe"></i> Global';
                            }
                            ?>
                        </td>
                        <td>
                            <span style="color: <?php echo ($promo['is_active'] ?? false) ? '#86efac' : '#fca5a5'; ?>; font-weight: 600;">
                                <?php echo ($promo['is_active'] ?? false) ? '<i class="fas fa-check-circle"></i> Actif' : '<i class="fas fa-times-circle"></i> Inactif'; ?>
                            </span>
                        </td>
                        <td style="font-size: 0.85rem; color: #999;">
                            <?php 
                            $start = new \DateTime($promo['start_date']);
                            $end = new \DateTime($promo['end_date']);
                            echo $start->format('d/m H:i') . '<br>' . $end->format('d/m H:i');
                            ?>
                        </td>
                        <td style="font-size: 0.9rem;">
                            <?php echo htmlspecialchars($promo['created_by_name'] ?? 'Admin'); ?>
                        </td>
                        <td style="text-align: center;">
                            <button class="btn btn-secondary" style="padding: 0.4rem 0.6rem; font-size: 0.85rem; margin-right: 0.3rem;" onclick="editPromo(<?php echo $promo['id']; ?>)"><i class="fas fa-edit"></i></button>
                            <form method="POST" style="display: inline-block;">
                                <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="promotion_id" value="<?php echo $promo['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.6rem; font-size: 0.85rem;" onclick="return confirm('Supprimer cette promotion ?');"><i class="fas fa-trash"></i></button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info" style="text-align: center;">
        Aucune promotion trouvée.
    </div>
<?php endif; ?>

<script>
function editPromo(id) {
    alert('Édition non implémentée pour le moment.\nSupprimer et recréer pour maintenant.');
}
</script>
