<?php
// App/Views/Home/index.php - NEW DESIGN
?>

<!-- HERO SECTION -->
<section class="hero">
    <div class="hero-content">
        <h1>Bienvenue chez NovaShop Pro</h1>
        <p>Découvrez une sélection exclusive de produits de qualité supérieure, livrés rapidement et à des prix compétitifs</p>
        <div class="hero-buttons">
            <a href="/products" class="btn btn-primary">⊙ Découvrir les Produits</a>
            <a href="#features" class="btn btn-secondary">ℹ En Savoir Plus</a>
        </div>
    </div>
</section>

<!-- FEATURES SECTION -->
<section class="features" id="features">
    <h2 class="section-title">Pourquoi Choisir NovaShop ?</h2>
    
    <div class="features-grid">
        <div class="feature-card">
            <div class="feature-icon">🌍</div>
            <h3>Sélection Mondiale</h3>
            <p>Accédez à une vaste gamme de produits provenant du monde entier, sélectionnés avec soin pour leur qualité</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">⚡</div>
            <h3>Livraison Rapide</h3>
            <p>Commandes traitées et expédiées en 24h. Suivi en temps réel et garantie de satisfaction</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">🔒</div>
            <h3>Sécurité Garantie</h3>
            <p>Paiements sécurisés et données protégées. Retours gratuits sous 30 jours</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">💰</div>
            <h3>Meilleurs Prix</h3>
            <p>Prix compétitifs et réductions régulières. Offres spéciales pour nos membres fidèles</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">📞</div>
            <h3>Support 24/7</h3>
            <p>Équipe d'assistance réactive. Réponses rapides à vos questions et problèmes</p>
        </div>
        
        <div class="feature-card">
            <div class="feature-icon">⭐</div>
            <h3>Qualité Premium</h3>
            <p>Tous nos produits sont testés et approuvés. Garantie de satisfaction ou remboursement</p>
        </div>
    </div>
</section>

<!-- FEATURED PRODUCTS -->
<section class="container">
    <h2 class="section-title">Produits Populaires</h2>
    
    <div class="products-grid">
        <?php if (isset($products) && count($products) > 0): ?>
            <?php foreach (array_slice($products, 0, 6) as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            🎁
                        <?php endif; ?>
                    </div>
                    <div class="product-content">
                        <div class="product-category"><?php echo htmlspecialchars($product['category_id'] ?? 'Général'); ?></div>
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <p class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 80) . '...'); ?></p>
                        <div class="product-footer">
                            <div class="product-price"><?php echo number_format($product['price'], 2); ?>€</div>
                            <div class="product-stock <?php echo $product['stock'] > 0 ? ($product['stock'] < 5 ? 'low' : '') : 'out'; ?>">
                                <?php echo $product['stock'] > 0 ? '✓ En stock' : '✗ Rupture'; ?>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center" style="grid-column: 1/-1;">Aucun produit disponible pour le moment</p>
        <?php endif; ?>
    </div>
</section>

<!-- CTA SECTION -->
<section class="hero" style="margin-top: 3rem; padding: 60px 2rem;">
    <div class="hero-content">
        <h2 style="font-size: 2.5rem; margin-bottom: 1rem;">Prêt à Commencer ?</h2>
        <p style="font-size: 1.1rem; margin-bottom: 2rem;">Rejoignez des milliers de clients satisfaits et profitez d'offres exclusives</p>
        <div class="hero-buttons">
            <a href="/register" class="btn btn-primary">S'Inscrire Maintenant</a>
            <a href="/products" class="btn btn-secondary">Continuer le Shopping</a>
        </div>
    </div>
</section>

<?php
// footer is injected by Controller::view()
?>
