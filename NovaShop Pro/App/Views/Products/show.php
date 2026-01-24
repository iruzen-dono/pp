<div class="container">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs">
        <a href="/">Accueil</a>
        <span>/</span>
        <a href="/products">Produits</a>
        <span>/</span>
        <span class="current"><?= htmlspecialchars(substr($product['name'], 0, 50)) ?></span>
    </div>

    <a href="/products" class="btn btn-secondary" style="margin-bottom: 2rem; display: inline-block;">← Retour aux produits</a>

    <?php if (empty($product)): ?>
        <div class="alert alert-danger">❌ Produit non trouvé.</div>
    <?php else: ?>
        <div class="product-detail-card">
            <div class="product-detail-grid">
                <!-- Image Section -->
                <div class="product-image-section">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-detail-image">
                    <?php else: ?>
                        <div class="product-placeholder">📦</div>
                    <?php endif; ?>
                </div>
                
                <!-- Details Section -->
                <div class="product-info-section">
                    <h1 class="product-detail-title"><?= htmlspecialchars($product['name']) ?></h1>
                    
                    <!-- Rating Stars -->
                    <div class="rating-container">
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star">★</span>
                        <span class="star active">★</span>
                        <span class="star">★</span>
                        <span class="rating-text">4.5/5 (87 avis)</span>
                    </div>
                    
                    <div class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?>€</div>
                    
                    <p class="product-description"><?= htmlspecialchars($product['description']) ?></p>
                    
                    <!-- Product Info Box -->
                    <div class="product-info-box">
                        <p class="info-item">
                            <strong>📦 Stock:</strong> 
                            <span class="stock-status" data-stock="<?= ($product['stock'] ?? 0) ?>">
                                <?= ($product['stock'] ?? 0) ?> disponibles
                            </span>
                        </p>
                        <p class="info-item"><strong>🏷️ Catégorie:</strong> <span>ID <?= ($product['category_id'] ?? 'N/A') ?></span></p>
                        <p class="info-item"><strong>✅ Référence:</strong> <span>PRD-<?= str_pad($product['id'], 5, '0', STR_PAD_LEFT) ?></span></p>
                    </div>
                    
                    <!-- Add to Cart Form -->
                    <form method="POST" action="/cart/add" class="product-form">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        
                        <div class="form-group">
                            <label for="quantity">Quantité:</label>
                            <div class="quantity-selector">
                                <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['stock'] ?? 100 ?>" required>
                                <button type="submit" class="btn btn-accent">Ajouter au panier 🛒</button>
                            </div>
                        </div>
                    </form>

                    <!-- Wishlist Button -->
                    <button class="wishlist-btn wishlist-large" data-product-id="<?= $product['id'] ?>">❤️ Ajouter à mes favoris</button>

                    <!-- Social Share -->
                    <div class="product-share">
                        <p>Partager:</p>
                        <div class="share-buttons">
                            <button class="share-btn share-facebook" title="Partager sur Facebook">f</button>
                            <button class="share-btn share-twitter" title="Partager sur Twitter">𝕏</button>
                            <button class="share-btn share-instagram" title="Partager sur Instagram">📷</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Tabs Section -->
            <div class="product-tabs">
                <div class="tabs-header">
                    <button type="button" class="tab-btn active" data-tab="description">Description</button>
                    <button type="button" class="tab-btn" data-tab="reviews">Avis (87)</button>
                    <button type="button" class="tab-btn" data-tab="shipping">Livraison</button>
                </div>

                <!-- Tab Contents -->
                <div class="tabs-content">
                    <div id="description-tab" class="tab-content active">
                        <h3>Détails du produit</h3>
                        <p><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                        <ul class="features-list">
                            <li>✓ Qualité premium garantie</li>
                            <li>✓ Matériaux durables et écologiques</li>
                            <li>✓ Garantie 2 ans</li>
                            <li>✓ Support client 24/7</li>
                        </ul>
                    </div>

                    <div id="reviews-tab" class="tab-content">
                        <h3>Avis clients</h3>
                        
                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-author">
                                    <p class="author-name">Jean Dupont</p>
                                    <p class="review-date">Il y a 2 semaines</p>
                                </div>
                                <span class="review-stars">★★★★★</span>
                            </div>
                            <p class="review-text">"Excellent produit ! La qualité est vraiment exceptionnelle et l'expédition très rapide. Je recommande vivement !"</p>
                        </div>

                        <div class="review-item">
                            <div class="review-header">
                                <div class="review-author">
                                    <p class="author-name">Marie Martin</p>
                                    <p class="review-date">Il y a 1 mois</p>
                                </div>
                                <span class="review-stars">★★★★</span>
                            </div>
                            <p class="review-text">"Très satisfait de mon achat. Le produit correspond exactement à la description. Merci !"</p>
                        </div>
                    </div>

                    <div id="shipping-tab" class="tab-content">
                        <h3>Informations de livraison</h3>
                        <div class="shipping-options">
                            <div class="shipping-option">
                                <p><strong>🚚 Livraison standard:</strong> 3-5 jours (Gratuit)</p>
                            </div>
                            <div class="shipping-option">
                                <p><strong>⚡ Livraison express:</strong> 24-48h (+9.99€)</p>
                            </div>
                            <div class="shipping-option">
                                <p><strong>🌍 Retrait en magasin:</strong> Disponible</p>
                            </div>
                            <div class="shipping-option">
                                <p><strong>📦 Retours gratuits:</strong> 30 jours</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Tab switching
    const tabBtns = document.querySelectorAll('.tab-btn');
    const tabContents = document.querySelectorAll('.tab-content');
    
    tabBtns.forEach(btn => {
        btn.addEventListener('click', function() {
            const tabName = this.dataset.tab;
            
            // Remove active class from all
            tabBtns.forEach(b => b.classList.remove('active'));
            tabContents.forEach(c => c.classList.remove('active'));
            
            // Add active class to selected
            this.classList.add('active');
            document.getElementById(tabName + '-tab').classList.add('active');
        });
    });

    // Wishlist button
    const wishlistBtn = document.querySelector('.wishlist-btn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function(e) {
            e.preventDefault();
            const isFilled = this.textContent.includes('❤️');
            this.textContent = isFilled ? '🤍 Ajouter à mes favoris' : '❤️ Retirer des favoris';
            this.classList.toggle('filled');
        });
    }

    // Stock status color
    const stockStatus = document.querySelector('.stock-status');
    if (stockStatus) {
        const stock = parseInt(stockStatus.dataset.stock);
        if (stock <= 0) {
            stockStatus.style.color = 'var(--danger)';
        } else if (stock < 10) {
            stockStatus.style.color = 'var(--warning)';
        }
    }
});
</script>
