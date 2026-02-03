<h1>📦 Gestion des Produits</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">✅ Produit créé/supprimé avec succès</div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">❌ Erreur: <?php 
    $errors = [
        'invalid_image_type' => 'Format d\'image non autorisé',
        'image_too_large' => 'L\'image dépasse 5MB'
    ];
    echo htmlspecialchars($errors[$_GET['error']] ?? 'Une erreur est survenue');
    ?></div>
<?php endif; ?>

<!-- FORMULAIRE AJOUTER PRODUIT -->
<div class="admin-form">
    <h2>➕ Ajouter un Produit</h2>
    <form method="POST" action="/admin/products" enctype="multipart/form-data">
        <input type="hidden" name="action" value="create">
        
        <div class="form-grid">
            <div class="form-group">
                <label>Nom du Produit</label>
                <input type="text" name="name" required>
            </div>
            <div class="form-group">
                <label>Prix (€)</label>
                <input type="number" name="price" step="0.01" min="0" required>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Catégorie</label>
                <select name="category_id" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="1">Électronique</option>
                    <option value="2">Vêtements</option>
                    <option value="3">Livres</option>
                    <option value="4">Maison</option>
                </select>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input type="number" name="stock" min="0" required>
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required></textarea>
        </div>

        <div class="form-group">
            <label>Image (JPG, PNG, WebP, GIF - Max 5MB)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">✅ Ajouter le Produit</button>
    </form>
</div>

<!-- TABLEAU PRODUITS -->
<h2>Produits (<?php echo count($products ?? []); ?>)</h2>

<?php if (!empty($products) && is_array($products)): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Catégorie</th>
                    <th>Stock</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($product['id'] ?? ''); ?></td>
                        <td>
                            <div style="display: flex; align-items: center; gap: 0.75rem;">
                                <?php if (!empty($product['image_url'])): ?>
                                    <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" style="width: 40px; height: 40px; object-fit: cover; border-radius: 0.5rem;">
                                <?php else: ?>
                                    <div style="width: 40px; height: 40px; background: linear-gradient(135deg, #d4a574, #c59461); border-radius: 0.5rem; display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">📦</div>
                                <?php endif; ?>
                                <strong><?php echo htmlspecialchars($product['name'] ?? ''); ?></strong>
                            </div>
                        </td>
                        <td>
                            <span style="color: #86efac; font-weight: 700;">
                                <?php echo number_format($product['price'] ?? 0, 2, ',', ' '); ?>€
                            </span>
                        </td>
                        <td>
                            <?php 
                            $categories = [1 => 'Électronique', 2 => 'Vêtements', 3 => 'Livres', 4 => 'Maison'];
                            echo htmlspecialchars($categories[$product['category_id']] ?? 'N/A');
                            ?>
                        </td>
                        <td>
                            <span style="background: <?php echo ($product['stock'] ?? 0) > 0 ? 'rgba(34, 197, 94, 0.2)' : 'rgba(239, 68, 68, 0.2)'; ?>; color: <?php echo ($product['stock'] ?? 0) > 0 ? '#86efac' : '#fca5a5'; ?>; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-weight: 600; font-size: 0.85rem;">
                                <?php echo $product['stock'] ?? 0; ?> unités
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <a href="/admin/products/edit/<?php echo $product['id']; ?>" class="btn btn-warning" style="padding: 0.5rem 0.8rem; font-size: 0.85rem; margin-right: 0.5rem;">✏️</a>
                            <a href="/admin/deleteProduct/<?php echo $product['id']; ?>" onclick="return confirm('⚠️ Confirmer la suppression ?')" class="btn btn-danger" style="padding: 0.5rem 0.8rem; font-size: 0.85rem;">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info" style="text-align: center;">
        Aucun produit trouvé. Créez-en un avec le formulaire ci-dessus.
    </div>
<?php endif; ?>
