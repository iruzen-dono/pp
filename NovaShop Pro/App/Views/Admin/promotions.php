<h1>🎁 Gestion des Promotions</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        ✓ Promotion <?php echo htmlspecialchars($_GET['success']); ?> avec succès
    </div>
<?php endif; ?>

<!-- FORMULAIRE AJOUTER PROMOTION -->
<div style="background: linear-gradient(135deg, rgba(51, 65, 85, 0.7), rgba(30, 41, 59, 0.7)); border: 1px solid rgba(148, 163, 184, 0.2); border-radius: 0.75rem; padding: 2rem; margin-bottom: 2rem; backdrop-filter: blur(10px);">
    <h2>➕ Ajouter une Promotion</h2>
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

        <button type="submit" class="btn btn-primary" style="width: 100%; padding: 0.75rem;">✅ Ajouter la Promotion</button>
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
                                echo '📦 ' . htmlspecialchars($promo['product_name'] ?? 'Produit');
                            } elseif (!empty($promo['category_id'])) {
                                echo '📂 ' . htmlspecialchars($promo['category_name'] ?? 'Catégorie');
                            } else {
                                echo '🌐 Global';
                            }
                            ?>
                        </td>
                        <td>
                            <span style="color: <?php echo ($promo['is_active'] ?? false) ? '#86efac' : '#fca5a5'; ?>; font-weight: 600;">
                                <?php echo ($promo['is_active'] ?? false) ? '✓ Actif' : '✕ Inactif'; ?>
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
                            <button class="btn btn-secondary" style="padding: 0.4rem 0.6rem; font-size: 0.85rem; margin-right: 0.3rem;" onclick="editPromo(<?php echo $promo['id']; ?>)">✏️</button>
                            <form method="POST" style="display: inline-block;">
                                <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
                                <input type="hidden" name="action" value="delete">
                                <input type="hidden" name="promotion_id" value="<?php echo $promo['id']; ?>">
                                <button type="submit" class="btn btn-danger" style="padding: 0.4rem 0.6rem; font-size: 0.85rem;" onclick="return confirm('⚠️ Supprimer cette promotion ?');">🗑️</button>
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
    alert('📝 Édition non implémentée pour le moment.\nSupprimer et recréer pour maintenant.');
}
</script>
