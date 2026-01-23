<div class="container">
    <!-- Breadcrumbs -->
    <div class="breadcrumbs" style="margin-bottom: 2rem;">
        <a href="/">Accueil</a>
        <span>/</span>
        <a href="/products">Produits</a>
        <span>/</span>
        <span class="current"><?= htmlspecialchars(substr($product['name'], 0, 30)) ?></span>
    </div>

    <a href="/products" class="btn btn-secondary" style="margin-bottom: 2rem; display: inline-block;">← Retour aux produits</a>

    <?php if (empty($product)): ?>
        <div class="alert alert-danger">❌ Produit non trouvé.</div>
    <?php else: ?>
        <div style="background: var(--white); border: 1px solid var(--secondary-dark); border-radius: 8px; padding: 2.5rem; margin-bottom: 2rem; box-shadow: var(--shadow-sm);">
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 2rem;">
                <!-- Image avec Parallax -->
                <div style="background: linear-gradient(135deg, var(--secondary) 0%, var(--secondary-light) 100%); padding: 1.5rem; text-align: center; border-radius: 8px; overflow: hidden; height: 500px; position: relative;" data-parallax="true">
                    <?php if (!empty($product['image_url'])): ?>
                        <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>" style="width: 100%; height: 100%; object-fit: cover; border-radius: 4px; transition: transform 0.3s ease;">
                    <?php else: ?>
                        <div style="width: 100%; height: 100%; display: flex; align-items: center; justify-content: center; font-size: 5rem;">📦</div>
                    <?php endif; ?>
                </div>
                
                <!-- Détails -->
                <div>
                    <h1 style="color: var(--primary); font-size: 2.5rem; margin-bottom: 1rem; font-weight: 800; animation: slideInLeft 0.6s ease-out;"><?= htmlspecialchars($product['name']) ?></h1>
                    
                    <!-- Rating Stars -->
                    <div class="rating-container" data-rating="4" style="margin-bottom: 1.5rem;">
                        <span class="star" data-rating="1">★</span>
                        <span class="star" data-rating="2">★</span>
                        <span class="star" data-rating="3">★</span>
                        <span class="star active" data-rating="4">★</span>
                        <span class="star" data-rating="5">★</span>
                        <span class="rating-text" style="font-size: 1rem; color: #666; margin-left: 1rem;">4.5/5 (87 avis)</span>
                    </div>
                    
                    <div class="product-price" style="font-size: 2.5rem; margin: 1.5rem 0; color: var(--accent); font-weight: 800;"><?= number_format($product['price'], 2, ',', ' ') ?>€</div>
                    
                    <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 2rem; font-size: 1.05rem;"><?= htmlspecialchars($product['description']) ?></p>
                    
                    <!-- Informations -->
                    <div style="background: var(--secondary); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem; border-left: 4px solid var(--accent);">
                        <p style="margin: 0.8rem 0; color: var(--text-dark);"><strong>📦 Stock:</strong> <span style="color: <?= ($product['stock'] ?? 0) > 0 ? 'var(--success)' : 'var(--danger)' ?>; font-weight: 700;"><?= ($product['stock'] ?? 0) ?> disponibles</span></p>
                        <p style="margin: 0.8rem 0; color: var(--text-dark);"><strong>🏷️ Catégorie:</strong> <span style="color: var(--primary); font-weight: 600;">ID <?= ($product['category_id'] ?? 'N/A') ?></span></p>
                        <p style="margin: 0.8rem 0; color: var(--text-dark);"><strong>✅ Référence:</strong> <span style="color: var(--text-dark); font-weight: 600;">PRD-<?= str_pad($product['id'], 5, '0', STR_PAD_LEFT) ?></span></p>
                    </div>
                    
                    <!-- Actions -->
                    <form method="POST" action="/cart/add" style="max-width: 100%; background: transparent; border: none; padding: 0; margin-bottom: 2rem;">
                        <input type="hidden" name="product_id" value="<?= htmlspecialchars($product['id']) ?>">
                        
                        <label for="quantity" style="display: block; margin-bottom: 0.8rem; color: var(--text-dark); font-weight: 600;">Quantité:</label>
                        <div style="display: flex; gap: 1rem; margin-bottom: 2rem;">
                            <input type="number" name="quantity" id="quantity" value="1" min="1" max="<?= $product['stock'] ?? 100 ?>" required style="flex: 1; max-width: 120px; padding: 0.9rem; background: var(--white); border: 2px solid var(--secondary-dark); border-radius: 4px; color: var(--text-dark); font-size: 1rem;">
                            <button type="submit" class="btn btn-accent" style="flex: 1; font-weight: 600;">Ajouter au panier 🛒</button>
                        </div>
                    </form>

                    <!-- Wishlist Button -->
                    <button class="wishlist-btn" data-product-id="<?= $product['id'] ?>" style="width: 100%; padding: 0.9rem; font-size: 1.05rem; margin-bottom: 2rem;">❤️ Ajouter à mes favoris</button>

                    <!-- Social Share -->
                    <div style="border-top: 1px solid var(--secondary-dark); padding-top: 1.5rem;">
                        <p style="margin-bottom: 0.5rem; font-weight: 600; color: var(--text-dark);">Partager:</p>
                        <div style="display: flex; gap: 0.5rem;">
                            <button style="background: #4267B2; color: white; border: none; padding: 0.6rem 1rem; border-radius: 4px; cursor: pointer;">📘 Facebook</button>
                            <button style="background: #1DA1F2; color: white; border: none; padding: 0.6rem 1rem; border-radius: 4px; cursor: pointer;">🐦 Twitter</button>
                            <button style="background: #E1306C; color: white; border: none; padding: 0.6rem 1rem; border-radius: 4px; cursor: pointer;">📸 Instagram</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Onglets -->
            <div style="margin-top: 3rem; border-top: 2px solid var(--secondary-dark); padding-top: 2rem;">
                <div style="display: flex; gap: 2rem; margin-bottom: 2rem; border-bottom: 2px solid var(--secondary-dark);">
                    <button onclick="showTab('description')" class="tab-btn active" style="background: none; border: none; padding: 1rem; color: var(--primary); font-weight: 600; cursor: pointer; border-bottom: 3px solid var(--primary); margin-bottom: -2rem;">Description</button>
                    <button onclick="showTab('reviews')" class="tab-btn" style="background: none; border: none; padding: 1rem; color: var(--text-muted); font-weight: 600; cursor: pointer; margin-bottom: -2rem;">Avis (87)</button>
                    <button onclick="showTab('shipping')" class="tab-btn" style="background: none; border: none; padding: 1rem; color: var(--text-muted); font-weight: 600; cursor: pointer; margin-bottom: -2rem;">Livraison</button>
                </div>

                <!-- Tab Content -->
                <div id="description-tab" style="display: block;">
                    <h3 style="color: var(--primary); margin-bottom: 1rem;">Détails du produit</h3>
                    <p style="color: var(--text-muted); line-height: 1.8; margin-bottom: 1rem;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                    <ul style="color: var(--text-muted); line-height: 2; margin-left: 1.5rem;">
                        <li>✓ Qualité premium garantie</li>
                        <li>✓ Matériaux durables et écologiques</li>
                        <li>✓ Garantie 2 ans</li>
                        <li>✓ Support client 24/7</li>
                    </ul>
                </div>

                <div id="reviews-tab" style="display: none;">
                    <h3 style="color: var(--primary); margin-bottom: 1rem;">Avis clients</h3>
                    
                    <div style="background: var(--secondary); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <div>
                                <p style="margin: 0; font-weight: 600; color: var(--text-dark);">Jean Dupont</p>
                                <p style="margin: 0.5rem 0 0; color: var(--text-muted); font-size: 0.9rem;">Il y a 2 semaines</p>
                            </div>
                            <span style="color: var(--accent); font-size: 1.3rem;">★★★★★</span>
                        </div>
                        <p style="color: var(--text-dark); line-height: 1.6;">"Excellent produit ! La qualité est vraiment exceptionnelle et l'expédition très rapide. Je recommande vivement !"</p>
                    </div>

                    <div style="background: var(--secondary); padding: 1.5rem; border-radius: 8px; margin-bottom: 2rem;">
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                            <div>
                                <p style="margin: 0; font-weight: 600; color: var(--text-dark);">Marie Martin</p>
                                <p style="margin: 0.5rem 0 0; color: var(--text-muted); font-size: 0.9rem;">Il y a 1 mois</p>
                            </div>
                            <span style="color: var(--accent); font-size: 1.3rem;">★★★★</span>
                        </div>
                        <p style="color: var(--text-dark); line-height: 1.6;">"Très satisfait de mon achat. Le produit correspond exactement à la description. Merci !"</p>
                    </div>
                </div>

                <div id="shipping-tab" style="display: none;">
                    <h3 style="color: var(--primary); margin-bottom: 1rem;">Informations de livraison</h3>
                    <div style="background: var(--secondary); padding: 1.5rem; border-radius: 8px; margin-bottom: 1rem;">
                        <p style="margin: 0.8rem 0; color: var(--text-dark);"><strong>🚚 Livraison standard:</strong> 3-5 jours (Gratuit)</p>
                        <p style="margin: 0.8rem 0; color: var(--text-dark);"><strong>⚡ Livraison express:</strong> 24-48h (+9.99€)</p>
                        <p style="margin: 0.8rem 0; color: var(--text-dark);"><strong>🌍 Retrait en magasin:</strong> Disponible</p>
                        <p style="margin: 0.8rem 0; color: var(--text-dark);"><strong>📦 Retours gratuits:</strong> 30 jours</p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>

<script>
function showTab(tabName) {
    // Hide all tabs
    document.getElementById('description-tab').style.display = 'none';
    document.getElementById('reviews-tab').style.display = 'none';
    document.getElementById('shipping-tab').style.display = 'none';
    
    // Show selected tab
    document.getElementById(tabName + '-tab').style.display = 'block';
    
    // Update button styles
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.style.color = 'var(--text-muted)';
        btn.style.borderBottom = 'none';
        btn.style.marginBottom = '-2rem';
    });
    event.target.style.color = 'var(--primary)';
    event.target.style.borderBottom = '3px solid var(--primary)';
    event.target.style.marginBottom = '-2rem';
}
</script>
