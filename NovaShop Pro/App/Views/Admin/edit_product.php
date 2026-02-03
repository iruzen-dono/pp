<div class="admin-container">
    <div class="admin-header">
        <h1>Éditer le produit</h1>
        <a href="/admin/products" class="btn btn-secondary">← Retour</a>
    </div>

    <?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <?php 
        switch ($_GET['error']) {
            case 'invalid_image_type':
                echo 'Type d\'image non autorisé. Utilisez JPG, PNG, WebP ou GIF.';
                break;
            case 'image_too_large':
                echo 'L\'image est trop volumineuse (max 5MB).';
                break;
            default:
                echo 'Une erreur est survenue.';
        }
        ?>
    </div>
    <?php endif; ?>

    <div class="admin-form-container">
        <form method="POST" enctype="multipart/form-data" class="admin-form">
            <input type="hidden" name="action" value="edit">
            
            <div class="form-group">
                <label for="name">Nom du produit *</label>
                <input 
                    type="text" 
                    id="name" 
                    name="name" 
                    value="<?= htmlspecialchars($product['name']) ?>" 
                    required
                    class="form-control"
                >
            </div>

            <div class="form-group">
                <label for="description">Description *</label>
                <textarea 
                    id="description" 
                    name="description" 
                    required
                    rows="6"
                    class="form-control"
                ><?= htmlspecialchars($product['description']) ?></textarea>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label for="price">Prix (€) *</label>
                    <input 
                        type="number" 
                        id="price" 
                        name="price" 
                        value="<?= htmlspecialchars($product['price']) ?>" 
                        step="0.01"
                        required
                        class="form-control"
                    >
                </div>

                <div class="form-group">
                    <label for="category_id">Catégorie *</label>
                    <select id="category_id" name="category_id" required class="form-control">
                        <option value="1" <?= $product['category_id'] == 1 ? 'selected' : '' ?>>Électronique</option>
                        <option value="2" <?= $product['category_id'] == 2 ? 'selected' : '' ?>>Mode</option>
                        <option value="3" <?= $product['category_id'] == 3 ? 'selected' : '' ?>>Livres</option>
                        <option value="4" <?= $product['category_id'] == 4 ? 'selected' : '' ?>>Maison</option>
                        <option value="5" <?= $product['category_id'] == 5 ? 'selected' : '' ?>>Sports</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <label for="image">Image du produit</label>
                <div class="image-preview-section">
                    <?php if (!empty($product['image_url'])): ?>
                    <div class="current-image">
                        <p class="preview-label">Image actuelle:</p>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="preview-img">
                    </div>
                    <?php endif; ?>
                    
                    <div class="form-group">
                        <input 
                            type="file" 
                            id="image" 
                            name="image" 
                            accept="image/*"
                            class="form-control"
                        >
                        <small class="text-muted">Laissez vide pour garder l'image actuelle. Max 5MB (JPG, PNG, WebP, GIF)</small>
                    </div>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Enregistrer les modifications</button>
                <a href="/admin/products" class="btn btn-secondary">Annuler</a>
            </div>
        </form>
    </div>
</div>

<style>
.admin-form-container {
    background: white;
    border-radius: 8px;
    padding: 2rem;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    max-width: 800px;
    margin-top: 2rem;
}

.admin-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group label {
    font-weight: 600;
    color: #333;
    font-size: 0.95rem;
}

.form-control {
    padding: 0.75rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
    font-family: inherit;
}

.form-control:focus {
    outline: none;
    border-color: #d4a574;
    box-shadow: 0 0 0 3px rgba(212, 165, 116, 0.1);
}

textarea.form-control {
    resize: vertical;
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
}

.image-preview-section {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.current-image {
    padding: 1rem;
    background: #f5f5f0;
    border-radius: 6px;
}

.preview-label {
    margin: 0 0 0.5rem 0;
    color: #666;
    font-weight: 500;
    font-size: 0.9rem;
}

.preview-img {
    max-width: 200px;
    height: auto;
    border-radius: 4px;
}

.form-actions {
    display: flex;
    gap: 1rem;
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid #eee;
}

.btn {
    padding: 0.75rem 1.5rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-weight: 600;
    text-decoration: none;
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    transition: all 0.3s ease;
}

.btn-primary {
    background: #d4a574;
    color: white;
}

.btn-primary:hover {
    background: #c99463;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(212, 165, 116, 0.3);
}

.btn-secondary {
    background: #6c757d;
    color: white;
}

.btn-secondary:hover {
    background: #5a6268;
}

.alert {
    padding: 1rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.alert-danger {
    background: #f8d7da;
    color: #721c24;
    border: 1px solid #f5c6cb;
}

.text-muted {
    color: #999;
    font-size: 0.85rem;
}

@media (max-width: 768px) {
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .admin-form-container {
        padding: 1rem;
    }
}
</style>
