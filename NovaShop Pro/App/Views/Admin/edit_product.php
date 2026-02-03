<h1>✏️ Éditer le Produit</h1>

<a href="/admin/products" class="btn btn-secondary" style="margin-bottom: 1.5rem;">← Retour</a>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php 
        switch ($_GET['error']) {
            case 'invalid_image_type':
                echo '❌ Type d\'image non autorisé. Utilisez JPG, PNG, WebP ou GIF.';
                break;
            case 'image_too_large':
                echo '❌ L\'image est trop volumineuse (max 5MB).';
                break;
            default:
                echo '❌ Une erreur est survenue.';
        }
        ?>
    </div>
<?php endif; ?>

<!-- FORMULAIRE ÉDITION PRODUIT -->
<div class="admin-form">
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="action" value="edit">
        
        <div class="form-grid">
            <div class="form-group">
                <label>Nom du Produit</label>
                <input 
                    type="text" 
                    name="name" 
                    value="<?= htmlspecialchars($product['name']) ?>" 
                    required
                >
            </div>
            <div class="form-group">
                <label>Prix (€)</label>
                <input 
                    type="number" 
                    name="price" 
                    value="<?= htmlspecialchars($product['price']) ?>" 
                    step="0.01"
                    required
                >
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label>Catégorie</label>
                <select name="category_id" required>
                    <option value="1" <?= $product['category_id'] == 1 ? 'selected' : '' ?>>Électronique</option>
                    <option value="2" <?= $product['category_id'] == 2 ? 'selected' : '' ?>>Vêtements</option>
                    <option value="3" <?= $product['category_id'] == 3 ? 'selected' : '' ?>>Livres</option>
                    <option value="4" <?= $product['category_id'] == 4 ? 'selected' : '' ?>>Maison</option>
                </select>
            </div>
            <div class="form-group">
                <label>Stock</label>
                <input 
                    type="number" 
                    name="stock" 
                    value="<?= htmlspecialchars($product['stock'] ?? 0) ?>" 
                    min="0"
                    required
                >
            </div>
        </div>

        <div class="form-group">
            <label>Description</label>
            <textarea name="description" required><?= htmlspecialchars($product['description']) ?></textarea>
        </div>

        <?php if (!empty($product['image_url'])): ?>
        <div class="form-group">
            <label>Image actuelle:</label>
            <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="max-width: 200px; border-radius: 0.5rem; margin-top: 0.5rem;">
        </div>
        <?php endif; ?>

        <div class="form-group">
            <label>Image (JPG, PNG, WebP, GIF - Max 5MB)</label>
            <input type="file" name="image" accept="image/jpeg,image/png,image/webp,image/gif">
            <small style="color: #999; font-size: 0.85rem; margin-top: 0.5rem; display: block;">Laissez vide pour garder l'image actuelle</small>
        </div>

        <div class="form-group">
            <label>Variantes (séparées par des virgules)</label>
            <textarea name="variants" placeholder="Ex: S, M, L, XL&#10;ou: Noir, Blanc, Gris&#10;ou: 256GB, 512GB, 1TB" style="font-family: monospace; font-size: 0.9rem; min-height: 60px;"><?= htmlspecialchars($product['variants'] ?? '') ?></textarea>
            <small style="color: #999; font-size: 0.85rem; margin-top: 0.5rem; display: block;">💡 Entrez les options disponibles pour ce produit (ex: tailles, couleurs, capacités)</small>
        </div>

        <button type="submit" class="btn btn-primary" style="width: 100%;">💾 Enregistrer les Modifications</button>
    </form>
</div>

<style>
.admin-form {
    background: linear-gradient(135deg, rgba(51, 65, 85, 0.7), rgba(30, 41, 59, 0.7));
    border: 1px solid rgba(148, 163, 184, 0.2);
    border-radius: 0.75rem;
    padding: 2rem;
    margin-bottom: 2rem;
    backdrop-filter: blur(10px);
}

.form-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
    margin-bottom: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    color: #f0a76d;
    font-weight: 600;
    font-size: 0.95rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    background: rgba(15, 23, 42, 0.6);
    border: 1px solid rgba(148, 163, 184, 0.3);
    border-radius: 0.5rem;
    padding: 0.75rem;
    color: white;
    font-family: inherit;
    font-size: 0.95rem;
    transition: all 0.3s ease;
}

.form-group input::placeholder,
.form-group textarea::placeholder {
    color: rgba(148, 163, 184, 0.5);
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: #f0a76d;
    background: rgba(15, 23, 42, 0.8);
    box-shadow: 0 0 0 3px rgba(240, 167, 109, 0.1);
}

.form-group textarea {
    min-height: 150px;
    resize: vertical;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 0.5rem;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
    font-size: 1rem;
}

.btn-primary {
    background: linear-gradient(135deg, #f0a76d, #e89a5c);
    color: white;
    border: none;
}

.btn-primary:hover {
    background: linear-gradient(135deg, #f5b584, #f0a76d);
    transform: translateY(-2px);
    box-shadow: 0 8px 16px rgba(240, 167, 109, 0.3);
}

.btn-secondary {
    background: rgba(100, 116, 139, 0.5);
    color: #e2e8f0;
    border: 1px solid rgba(148, 163, 184, 0.3);
}

.btn-secondary:hover {
    background: rgba(100, 116, 139, 0.8);
    border-color: rgba(148, 163, 184, 0.5);
}

.alert {
    padding: 1rem 1.5rem;
    border-radius: 0.5rem;
    margin-bottom: 1.5rem;
    font-weight: 500;
}

.alert-danger {
    background: rgba(239, 68, 68, 0.1);
    border: 1px solid rgba(239, 68, 68, 0.3);
    color: #fca5a5;
}

.alert-success {
    background: rgba(34, 197, 94, 0.1);
    border: 1px solid rgba(34, 197, 94, 0.3);
    color: #86efac;
}

@media (max-width: 768px) {
    .form-grid {
        grid-template-columns: 1fr;
    }
    
    .admin-form {
        padding: 1.5rem;
    }
}
</style>
