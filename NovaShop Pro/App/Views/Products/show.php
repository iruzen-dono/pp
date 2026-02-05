<div class="container product-page">
    <!-- Breadcrumbs Navigation -->
    <div class="breadcrumbs">
        <a href="/">Accueil</a>
        <span class="divider">›</span>
        <a href="/products">Produits</a>
        <span class="divider">›</span>
        <span class="current"><?= htmlspecialchars(substr($product['name'] ?? '', 0, 50)) ?></span>
    </div>

    <?php if (empty($product)): ?>
        <div class="alert alert-error">
            <h2><i class="fas fa-times-circle"></i> Produit non trouvé</h2>
            <p>Le produit que vous recherchez n'existe pas ou a été supprimé.</p>
            <a href="/products" class="btn-link"><i class="fas fa-arrow-left"></i> Retour aux produits</a>
        </div>
    <?php else: ?>
        <!-- Product Main Section -->
        <div class="product-main-section">
            <!-- Left: Image Gallery -->
            <div class="product-image-gallery">
                <div class="main-image-container">
                    <?php if (!empty($product['image_url'])): ?>
                        <img id="mainImage" src="<?= htmlspecialchars($product['image_url']) ?>" 
                             alt="<?= htmlspecialchars($product['name']) ?>" 
                             class="main-product-image">
                    <?php else: ?>
                        <div class="product-image-placeholder">
                            <i class="fas fa-box placeholder-fa"></i>
                            <p>Pas d'image disponible</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Right: Product Details & Purchase -->
            <div class="product-info-panel">
                <!-- Header Info -->
                <div class="product-header-info">
                    <div class="product-category-tag">
                        <?php 
                            $categories = [
                                1 => 'Électronique',
                                2 => 'Vêtements',
                                3 => 'Livres',
                                4 => 'Maison'
                            ];
                            $cat_name = $categories[$product['category_id'] ?? 1] ?? 'Catégorie';
                        ?>
                        <span class="category-badge"><?= htmlspecialchars($cat_name) ?></span>
                    </div>

                    <h1 class="product-title"><?= htmlspecialchars($product['name']) ?></h1>

                    <!-- Rating & Reviews -->
                    <div class="rating-section">
                        <div class="stars">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star-half-alt"></i>
                        </div>
                        <span class="rating-text">4.8 sur 5</span>
                        <span class="reviews-count">(247 avis)</span>
                    </div>
                </div>

                <!-- Price Section -->
                <div class="price-section">
                    <div class="price-container">
                        <span class="current-price"><?= number_format($product['price'], 2, ',', ' ') ?></span>
                        <span class="currency">€</span>
                    </div>
                    <div class="price-info">
                        <span class="stock-status" data-stock="<?= $product['stock'] ?? 0 ?>">
                            <?= ($product['stock'] ?? 0) > 0 
                                ? '<i class="fas fa-check-circle"></i> En stock (' . ($product['stock'] ?? 0) . ' disponibles)' 
                                : '<i class="fas fa-times-circle"></i> Rupture de stock' ?>
                        </span>
                    </div>
                </div>

                <!-- Description -->
                <div class="product-description-box">
                    <p class="description-text">
                        <?= htmlspecialchars($product['description'] ?? 'Aucune description disponible.') ?>
                    </p>
                </div>

                <!-- Quick Info Badges -->
                    <div class="info-badges">
                    <div class="badge-item">
                        <i class="fas fa-truck badge-fa"></i>
                        <span class="badge-label">Livraison rapide</span>
                    </div>
                    <div class="badge-item">
                        <i class="fas fa-undo-alt badge-fa"></i>
                        <span class="badge-label">Retour 30 jours</span>
                    </div>
                    <div class="badge-item">
                        <i class="fas fa-shield-alt badge-fa"></i>
                        <span class="badge-label">Garantie 1 an</span>
                    </div>
                </div>

                <!-- Purchase Card -->
                <form method="POST" action="/cart/add" class="purchase-form">
                    <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
                    <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">

                    <!-- Variant Selection -->
                    <div class="form-group">
                        <label for="variant" class="form-label">Sélectionner une variante</label>
                        <select name="variant" id="variant" class="form-select">
                            <?php 
                                if (!empty($product['variants'])) {
                                    $variants = array_map('trim', explode(',', $product['variants']));
                                    foreach ($variants as $variant) {
                                        echo '<option value="' . htmlspecialchars($variant) . '">' . htmlspecialchars($variant) . '</option>';
                                    }
                                } else {
                                    echo '<option value="">Aucune variante disponible</option>';
                                }
                            ?>
                        </select>
                    </div>

                    <!-- Quantity Selection -->
                    <div class="form-group">
                        <label for="quantity" class="form-label">Quantité</label>
                        <div class="quantity-input">
                            <button type="button" class="qty-btn qty-minus" onclick="decreaseQty()">−</button>
                            <input type="number" name="quantity" id="quantity" 
                                   class="form-number" value="1" min="1" 
                                   max="<?= $product['stock'] ?? 100 ?>">
                            <button type="button" class="qty-btn qty-plus" onclick="increaseQty()">+</button>
                        </div>
                    </div>

                    <!-- Action Buttons -->
                    <div class="action-buttons">
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="fas fa-shopping-cart btn-fa"></i>
                            <span class="btn-text">Ajouter au panier</span>
                        </button>
                        <a href="/products" class="btn btn-secondary btn-large" style="text-decoration: none; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-arrow-left btn-fa"></i>
                            <span class="btn-text">Retour aux produits</span>
                        </a>
                    </div>

                    <!-- Secure Info -->
                    <div class="secure-info">
                        <i class="fas fa-lock secure-fa"></i>
                        <span class="secure-text">Paiement sécurisé • Données cryptées</span>
                    </div>
                </form>
            </div>
        </div>

        <!-- Product Details Section -->
        <div class="product-details-tabs">
            <div class="tabs-header">
                <button class="tab-btn active" data-tab="specs">Spécifications</button>
                <button class="tab-btn" data-tab="shipping">Livraison</button>
                <button class="tab-btn" data-tab="reviews">Avis clients</button>
                <button class="tab-btn" data-tab="warranty">Garantie</button>
            </div>

            <!-- Specs Tab -->
            <div id="specs-tab" class="tab-content active">
                <div class="specs-grid">
                    <div class="spec-item">
                        <span class="spec-label">Référence produit</span>
                        <span class="spec-value">PRD-<?= str_pad($product['id'] ?? 0, 5, '0', STR_PAD_LEFT) ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Catégorie</span>
                        <span class="spec-value"><?= htmlspecialchars($cat_name) ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Stock disponible</span>
                        <span class="spec-value"><?= ($product['stock'] ?? 0) . ' unités' ?></span>
                    </div>
                    <div class="spec-item">
                        <span class="spec-label">Date d'ajout</span>
                        <span class="spec-value">Il y a 3 mois</span>
                    </div>
                </div>
            </div>

            <!-- Shipping Tab -->
            <div id="shipping-tab" class="tab-content">
                <div class="info-block">
                    <h3>Options de livraison</h3>
                    <ul class="shipping-options">
                        <li><strong>Livraison Standard (5-7 jours):</strong> Gratuite pour les commandes > 50€</li>
                        <li><strong>Livraison Express (2-3 jours):</strong> 9,99€</li>
                        <li><strong>Livraison Rapide (24h):</strong> 19,99€</li>
                    </ul>
                </div>
            </div>

            <!-- Reviews Tab -->
            <div id="reviews-tab" class="tab-content">
                <div class="reviews-section">
                    <div class="review-summary">
                        <div class="rating-large">4.8/5</div>
                        <p>Basé sur 247 avis vérifiés</p>
                    </div>
                    <div class="sample-reviews">
                        <div class="review-item">
                            <div class="review-header">
                                <span class="review-author">Marie D.</span>
                                <span class="review-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </span>
                            </div>
                            <p class="review-text">"Excellent produit, conforme à la description. Livraison rapide !"</p>
                        </div>
                        <div class="review-item">
                            <div class="review-header">
                                <span class="review-author">Jean P.</span>
                                <span class="review-rating">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star-half-alt"></i>
                                </span>
                            </div>
                            <p class="review-text">"Très bon rapport qualité/prix. Je recommande !"</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Warranty Tab -->
            <div id="warranty-tab" class="tab-content">
                <div class="warranty-info">
                    <h3>Garantie 1 an</h3>
                    <ul class="warranty-details">
                        <li>Garantie constructeur 12 mois</li>
                        <li>Service client 24/7 disponible</li>
                        <li>Retour gratuit sous 30 jours</li>
                        <li>Remplacement sans frais en cas de défaut</li>
                    </ul>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<style>
/* ============================================
   PROFESSIONAL PRODUCT PAGE DESIGN
   ============================================ */

.product-page {
    padding: 40px 0;
    background: #f9fafb;
}

/* Breadcrumbs */
.breadcrumbs {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 24px 0;
    font-size: 13px;
    color: #666;
}

.breadcrumbs a {
    color: #0066cc;
    text-decoration: none;
    transition: color 0.2s;
}

.breadcrumbs a:hover {
    color: #0047d4;
    text-decoration: underline;
}

.breadcrumbs .divider {
    color: #ddd;
    margin: 0 4px;
}

.breadcrumbs .current {
    color: #333;
    font-weight: 600;
}

/* Alert Error */
.alert {
    background: #fee;
    border: 1px solid #fcc;
    border-radius: 12px;
    padding: 32px;
    text-align: center;
    color: #c33;
}

.alert h2 { margin: 0 0 12px 0; font-size: 24px; }
.alert p { margin: 0 0 16px 0; }
.alert .btn-link { color: #0066cc; text-decoration: none; font-weight: 600; }

/* ============================================
   MAIN PRODUCT SECTION
   ============================================ */

.product-main-section {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 64px;
    background: white;
    border-radius: 16px;
    padding: 48px;
    margin-bottom: 48px;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
}

/* Image Gallery */
.product-image-gallery {
    position: sticky;
    top: 80px;
    height: fit-content;
}

.main-image-container {
    background: linear-gradient(135deg, #f8f9fa 0%, #f0f2f5 100%);
    border-radius: 14px;
    padding: 32px;
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
    border: 1px solid #e5e7eb;
    transition: all 0.3s ease;
}

.main-image-container:hover {
    box-shadow: 0 12px 32px rgba(0,0,0,0.08);
    border-color: #0066cc;
}

.main-product-image {
    width: 100%;
    height: 100%;
    object-fit: contain;
    display: block;
}

.product-image-placeholder {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 12px;
    color: #999;
}

.product-image-placeholder span {
    font-size: 64px;
}

/* Info Panel */
.product-info-panel {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

/* Header Info */
.product-header-info {
    padding-bottom: 24px;
    border-bottom: 1px solid #e5e7eb;
}

.product-category-tag {
    display: inline-block;
    margin-bottom: 12px;
}

.category-badge {
    background: #ede9fe;
    color: #6d28d9;
    padding: 6px 14px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-title {
    font-size: 36px;
    font-weight: 700;
    color: #1a202c;
    margin: 12px 0;
    line-height: 1.2;
}

/* Rating Section */
.rating-section {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 16px;
}

.stars {
    font-size: 16px;
    color: #f59e0b;
    letter-spacing: 2px;
}

.rating-text {
    font-weight: 700;
    color: #1a202c;
    font-size: 14px;
}

.reviews-count {
    color: #999;
    font-size: 14px;
}

/* Price Section */
.price-section {
    background: linear-gradient(135deg, #fef08a 0%, #fef3c7 100%);
    border-radius: 12px;
    padding: 24px;
    border-left: 4px solid #f59e0b;
}

.price-container {
    display: flex;
    align-items: baseline;
    gap: 4px;
}

.current-price {
    font-size: 44px;
    font-weight: 800;
    color: #1a202c;
    letter-spacing: -1px;
}

.currency {
    font-size: 24px;
    font-weight: 700;
    color: #666;
}

.price-info {
    margin-top: 12px;
}

.stock-status {
    font-weight: 600;
    font-size: 14px;
    color: #10b981;
}

.stock-status[data-stock="0"] {
    color: #ef4444;
}

/* Description */
.product-description-box {
    padding: 20px 0;
}

.description-text {
    font-size: 15px;
    line-height: 1.8;
    color: #4b5563;
    margin: 0;
}

/* Info Badges */
.info-badges {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
}

.badge-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 8px;
    padding: 16px;
    background: #f9fafb;
    border-radius: 10px;
    border: 1px solid #e5e7eb;
    transition: all 0.3s;
}

.badge-item:hover {
    background: #ede9fe;
    border-color: #6d28d9;
}

.badge-icon {
    font-size: 28px;
}

.badge-label {
    font-size: 13px;
    font-weight: 600;
    color: #1a202c;
    text-align: center;
}

/* Purchase Form */
.purchase-form {
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 14px;
    padding: 28px;
    display: flex;
    flex-direction: column;
    gap: 24px;
    transition: all 0.3s ease;
}

.purchase-form:hover {
    border-color: #0066cc;
    box-shadow: 0 12px 32px rgba(0,102,204,0.12);
}

/* Form Groups */
.form-group {
    display: flex;
    flex-direction: column;
    gap: 8px;
}

.form-label {
    font-size: 13px;
    font-weight: 700;
    color: #1a202c;
    text-transform: uppercase;
    letter-spacing: 0.8px;
}

.form-select {
    padding: 12px 14px;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    font-size: 14px;
    color: #1a202c;
    background: white;
    cursor: pointer;
    transition: all 0.2s;
    font-weight: 500;
}

.form-select:hover {
    border-color: #0066cc;
    background: #f0f5ff;
}

.form-select:focus {
    outline: none;
    border-color: #0066cc;
    box-shadow: 0 0 0 3px rgba(0,102,204,0.1);
}

/* Quantity Input */
.quantity-input {
    display: flex;
    align-items: center;
    border: 1.5px solid #d1d5db;
    border-radius: 8px;
    overflow: hidden;
    transition: all 0.2s;
}

.quantity-input:hover {
    border-color: #0066cc;
}

.qty-btn {
    width: 44px;
    height: 44px;
    border: none;
    background: #f9fafb;
    color: #1a202c;
    font-size: 18px;
    font-weight: 700;
    cursor: pointer;
    transition: all 0.2s;
}

.qty-btn:hover {
    background: #0066cc;
    color: white;
}

.form-number {
    flex: 1;
    border: none;
    text-align: center;
    font-size: 16px;
    font-weight: 600;
    color: #1a202c;
    padding: 0 12px;
}

.form-number:focus {
    outline: none;
}

/* Action Buttons */
.action-buttons {
    display: flex;
    gap: 14px;
    margin-top: 8px;
}

.btn {
    padding: 14px 28px;
    border: none;
    border-radius: 10px;
    font-size: 15px;
    font-weight: 700;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    flex: 1;
}

.btn-icon {
    font-size: 18px;
}

.btn-text {
    display: inline;
}

.btn-large {
    padding: 16px 32px;
    min-height: 50px;
    font-size: 16px;
}

.btn-primary {
    background: linear-gradient(135deg, #0066ff 0%, #0047d4 100%);
    color: white;
    box-shadow: 0 8px 24px rgba(0,102,255,0.3);
}

.btn-primary:hover {
    background: linear-gradient(135deg, #0047d4 0%, #0033a0 100%);
    transform: translateY(-3px);
    box-shadow: 0 14px 32px rgba(0,102,255,0.4);
}

.btn-primary:active {
    transform: translateY(-1px);
}

.btn-secondary {
    background: white;
    color: #0066cc;
    border: 2px solid #0066cc;
    box-shadow: none;
}

.btn-secondary:hover {
    background: linear-gradient(135deg, #0066ff 0%, #0047d4 100%);
    color: white;
    border-color: #0047d4;
    transform: translateY(-3px);
    box-shadow: 0 12px 28px rgba(0,102,255,0.3);
}

/* Secure Info */
.secure-info {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
    padding: 12px;
    background: #f0fdf4;
    border-radius: 8px;
    color: #16a34a;
    font-size: 13px;
    font-weight: 600;
}

.secure-icon {
    font-size: 16px;
}

/* ============================================
   PRODUCT DETAILS TABS
   ============================================ */

.product-details-tabs {
    background: white;
    border-radius: 16px;
    padding: 0;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    overflow: hidden;
}

.tabs-header {
    display: flex;
    border-bottom: 2px solid #e5e7eb;
    background: #f9fafb;
}

.tab-btn {
    padding: 18px 28px;
    border: none;
    background: transparent;
    color: #666;
    font-size: 14px;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s;
    border-bottom: 3px solid transparent;
    position: relative;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.tab-btn:hover {
    color: #0066cc;
}

.tab-btn.active {
    color: #0066cc;
    border-bottom-color: #0066cc;
    background: white;
}

.tab-content {
    padding: 40px;
    display: none;
    animation: fadeIn 0.3s ease;
}

.tab-content.active {
    display: block;
}

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

/* Specs Grid */
.specs-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 32px;
}

.spec-item {
    display: flex;
    flex-direction: column;
    gap: 8px;
    padding: 16px 0;
    border-bottom: 1px solid #e5e7eb;
}

.spec-label {
    font-size: 12px;
    font-weight: 700;
    color: #999;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.spec-value {
    font-size: 16px;
    font-weight: 600;
    color: #1a202c;
}

/* Info Block */
.info-block h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 16px 0;
}

.shipping-options {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.shipping-options li {
    padding: 12px 0;
    border-bottom: 1px solid #e5e7eb;
    font-size: 14px;
    line-height: 1.6;
    color: #555;
}

.shipping-options li:last-child {
    border-bottom: none;
}

/* Reviews Section */
.reviews-section {
    display: flex;
    flex-direction: column;
    gap: 32px;
}

.review-summary {
    text-align: center;
    padding: 24px;
    background: #f9fafb;
    border-radius: 12px;
}

.rating-large {
    font-size: 44px;
    font-weight: 800;
    color: #f59e0b;
    margin-bottom: 8px;
}

.sample-reviews {
    display: flex;
    flex-direction: column;
    gap: 20px;
}

.review-item {
    padding: 20px;
    background: #f9fafb;
    border-radius: 10px;
    border-left: 4px solid #0066cc;
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 10px;
}

.review-author {
    font-weight: 700;
    color: #1a202c;
    font-size: 14px;
}

.review-rating {
    color: #f59e0b;
    font-size: 14px;
}

.review-text {
    font-size: 14px;
    color: #555;
    margin: 0;
    line-height: 1.6;
}

/* Warranty Info */
.warranty-info h3 {
    font-size: 18px;
    font-weight: 700;
    color: #1a202c;
    margin: 0 0 16px 0;
}

.warranty-details {
    list-style: none;
    padding: 0;
    margin: 0;
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.warranty-details li {
    padding: 12px 16px;
    padding-left: 36px;
    background: #f0fdf4;
    border-radius: 8px;
    color: #16a34a;
    font-weight: 500;
    position: relative;
    font-size: 14px;
}

.warranty-details li::before {
    content: '✓';
    position: absolute;
    left: 12px;
    font-weight: 800;
    font-size: 16px;
}

/* ============================================
   RESPONSIVE DESIGN
   ============================================ */

@media (max-width: 1024px) {
    .product-main-section {
        grid-template-columns: 1fr;
        gap: 40px;
        padding: 32px;
    }

    .product-image-gallery {
        position: relative;
        top: 0;
    }

    .info-badges {
        grid-template-columns: repeat(2, 1fr);
    }
}

@media (max-width: 768px) {
    .product-page {
        padding: 20px 0;
    }

    .product-main-section {
        border-radius: 0;
        padding: 20px;
        gap: 24px;
    }

    .product-title {
        font-size: 28px;
    }

    .current-price {
        font-size: 36px;
    }

    .action-buttons {
        flex-direction: column;
    }

    .btn {
        width: 100%;
    }

    .info-badges {
        grid-template-columns: 1fr;
    }

    .tabs-header {
        overflow-x: auto;
    }

    .tab-btn {
        padding: 14px 20px;
        font-size: 12px;
        white-space: nowrap;
    }

    .tab-content {
        padding: 24px;
    }

    .specs-grid {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .product-title {
        font-size: 24px;
    }

    .current-price {
        font-size: 28px;
    }

    .category-badge {
        font-size: 11px;
    }

    .purchase-form {
        padding: 20px;
        gap: 16px;
    }

    .btn {
        padding: 12px 20px;
        font-size: 14px;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // ============================================
    // TAB MANAGEMENT
    // ============================================
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Remove active class from all
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to clicked button and corresponding content
            this.classList.add('active');
            const tabElement = document.getElementById(tabName + '-tab');
            if (tabElement) {
                tabElement.classList.add('active');
            }
        });
    });

    // ============================================
    // QUANTITY CONTROL
    // ============================================
    window.increaseQty = function() {
        const input = document.getElementById('quantity');
        const max = parseInt(input.max);
        const current = parseInt(input.value);
        if (current < max) {
            input.value = current + 1;
        }
    };

    window.decreaseQty = function() {
        const input = document.getElementById('quantity');
        const current = parseInt(input.value);
        if (current > 1) {
            input.value = current - 1;
        }
    };

    // ============================================
    // DYNAMIC STOCK STATUS COLOR
    // ============================================
    const stockStatus = document.querySelector('.stock-status');
    if (stockStatus) {
        const stock = parseInt(stockStatus.dataset.stock);
        if (stock <= 0) {
            stockStatus.style.color = '#ef4444'; // Red
        } else if (stock < 10) {
            stockStatus.style.color = '#f59e0b'; // Orange
        } else {
            stockStatus.style.color = '#10b981'; // Green
        }
    }

    // ============================================
    // FORM VALIDATION
    // ============================================
    const purchaseForm = document.querySelector('.purchase-form');
    if (purchaseForm) {
        purchaseForm.addEventListener('submit', function(e) {
            const quantity = parseInt(document.getElementById('quantity').value);
            const maxStock = parseInt(document.getElementById('quantity').max);
            
            if (quantity > maxStock) {
                e.preventDefault();
                alert('Quantité indisponible');
                return false;
            }
        });
    }

    // ============================================
    // SMOOTH SCROLL TO TOP ON LOAD
    // ============================================
    window.scrollTo({ top: 0, behavior: 'smooth' });
});
</script>

