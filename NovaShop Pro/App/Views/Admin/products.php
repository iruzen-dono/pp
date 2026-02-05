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
        <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
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

        <div class="form-group">
            <label>Variantes (séparées par des virgules)</label>
            <textarea name="variants" placeholder="Ex: S, M, L, XL&#10;ou: Noir, Blanc, Gris&#10;ou: 256GB, 512GB, 1TB" style="font-family: monospace; font-size: 0.9rem; min-height: 60px;"></textarea>
            <small style="color: #999; font-size: 0.85rem; margin-top: 0.5rem; display: block;">💡 Entrez les options disponibles pour ce produit (ex: tailles, couleurs, capacités)</small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">✅ Ajouter le Produit</button>
    </form>
</div>

<!-- TABLEAU PRODUITS -->
<h2>Produits (<?php echo count($products ?? []); ?>)</h2>

<!-- Barre de recherche et filtres -->
<div style="margin-bottom: 1.5rem; padding: 1rem; background: rgba(99, 102, 241, 0.1); border-radius: 0.5rem;">
    <form method="GET" action="/admin/products" style="display: grid; grid-template-columns: 1fr 1fr 1fr auto; gap: 1rem; align-items: end;">
        <div>
            <label for="search" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">🔍 Rechercher</label>
            <input type="text" id="search" name="search" placeholder="Nom ou description..." value="<?php echo htmlspecialchars($search ?? ''); ?>" style="width: 100%; padding: 0.6rem; border: 1px solid #444; border-radius: 0.3rem; background: #222; color: #fff;">
        </div>
        <div>
            <label for="category" style="display: block; font-weight: 600; margin-bottom: 0.5rem;">📁 Catégorie</label>
            <select id="category" name="category" style="width: 100%; padding: 0.6rem; border: 1px solid #444; border-radius: 0.3rem; background: #222; color: #fff;">
                <option value="0">-- Tous --</option>
                <option value="1" <?php echo ($category ?? 0) == 1 ? 'selected' : ''; ?>>Électronique</option>
                <option value="2" <?php echo ($category ?? 0) == 2 ? 'selected' : ''; ?>>Vêtements</option>
                <option value="3" <?php echo ($category ?? 0) == 3 ? 'selected' : ''; ?>>Livres</option>
                <option value="4" <?php echo ($category ?? 0) == 4 ? 'selected' : ''; ?>>Maison</option>
            </select>
        </div>
        <div style="display: flex; gap: 0.5rem;">
            <button type="submit" class="btn btn-primary" style="flex: 1;">🔍 Chercher</button>
            <a href="/admin/products" class="btn btn-secondary" style="padding: 0.6rem 1rem; text-decoration: none; text-align: center;">✕ Réinitialiser</a>
        </div>
    </form>
</div>

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
                    <th>Variantes</th>
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
                        <td>
                            <small style="color: #a0aec0; font-family: monospace;">
                                <?php 
                                    $variants = $product['variants'] ?? '';
                                    if (!empty($variants)) {
                                        $variantList = array_map('trim', explode(',', $variants));
                                        echo htmlspecialchars(count($variantList)) . ' option' . (count($variantList) > 1 ? 's' : '');
                                        echo '<br/>';
                                        echo htmlspecialchars(implode(', ', array_slice($variantList, 0, 2)));
                                        if (count($variantList) > 2) echo '...';
                                    } else {
                                        echo '<em style="color: #64748b;">Aucune</em>';
                                    }
                                ?>
                            </small>
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
