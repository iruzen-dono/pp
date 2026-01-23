<?php
// App/Views/Home/index.php
?>

<!-- HERO SECTION -->
<section class="hero" data-parallax="true">
    <div class="hero-content">
        <h1>Bienvenue chez <span>NovaShop</span></h1>
        <p>Découvrez une sélection curatée de produits premium pour vos aventures du quotidien</p>
        <div class="hero-buttons">
            <a href="/products" class="btn btn-primary">Découvrir les produits</a>
            <a href="#features" class="btn btn-secondary">En savoir plus</a>
        </div>
    </div>
</section>

<!-- FEATURED CAROUSEL -->
<?php if (isset($products) && count($products) > 0): ?>
<section class="container" style="margin: 5rem 0;">
    <h2 class="section-title">Produits Vedettes</h2>
    <p class="section-subtitle">Nos meilleures ventes cette semaine</p>
    
    <div class="carousel">
        <div class="carousel-track">
            <?php foreach (array_slice($products, 0, min(5, count($products))) as $index => $product): ?>
            <div class="carousel-slide">
                <div class="product-card">
                    <button class="wishlist-btn" data-product-id="<?= $product['id'] ?>">🤍</button>
                    <div class="product-image">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>">
                        <?php else: ?>
                            <div style="font-size: 4rem; display: flex; align-items: center; justify-content: center; height: 100%;">📦</div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="product-price"><?php echo number_format($product['price'], 2, ',', ' '); ?>€</div>
                        <div class="product-actions">
                            <a href="/product/<?= $product['id'] ?>" class="btn btn-primary btn-small">Voir détails</a>
                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <button class="carousel-prev">❮</button>
        <button class="carousel-next">❯</button>
        <div class="carousel-dots">
            <?php for ($i = 0; $i < min(5, count($products)); $i++): ?>
                <span class="dot <?= $i === 0 ? 'active' : '' ?>" data-slide="<?= $i ?>"></span>
            <?php endfor; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<!-- FEATURES SECTION -->
<section class="features" id="features">
    <h2 class="section-title">Pourquoi NovaShop ?</h2>
    <p class="section-subtitle">Une expérience shopping pensée pour votre satisfaction</p>
    
    <div class="features-grid">
        <div class="feature-card animate-on-scroll">
            <div class="feature-icon">🌍</div>
            <h3>Sélection Mondiale</h3>
            <p>Produits sélectionnés avec soin du monde entier, garantissant qualité et authenticité</p>
        </div>
        
        <div class="feature-card animate-on-scroll">
            <div class="feature-icon">⚡</div>
            <h3>Livraison Express</h3>
            <p>Commandes traitées en 24h et livrées rapidement. Suivi en temps réel inclus</p>
        </div>
        
        <div class="feature-card animate-on-scroll">
            <div class="feature-icon">🔒</div>
            <h3>100% Sécurisé</h3>
            <p>Paiements cryptés et données protégées. Retours gratuits sous 30 jours</p>
        </div>
        
        <div class="feature-card animate-on-scroll">
            <div class="feature-icon">💰</div>
            <h3>Meilleurs Prix</h3>
            <p>Prix compétitifs et réductions régulières. Programme de fidélité exclusif</p>
        </div>
        
        <div class="feature-card animate-on-scroll">
            <div class="feature-icon">📞</div>
            <h3>Support 24/7</h3>
            <p>Équipe réactive et disponible. Réponses rapides à vos questions</p>
        </div>
        
        <div class="feature-card animate-on-scroll">
            <div class="feature-icon">⭐</div>
            <h3>Qualité Garantie</h3>
            <p>Tous produits testés et approuvés. Satisfaction garantie ou remboursement</p>
        </div>
    </div>
</section>

<!-- PRODUCTS SECTION -->
<section class="container" style="margin: 5rem 0;">
    <h2 class="section-title">Tous nos produits</h2>
    <p class="section-subtitle">Une large sélection pour tous vos besoins</p>
    
    <div class="search-bar" style="margin-bottom: 2rem;">
        <input type="search" placeholder="Rechercher un produit..." id="searchInput">
        <button onclick="filterProductsByName()">Chercher</button>
    </div>
    
    <div class="products-grid">
        <?php if (isset($products) && count($products) > 0): ?>
            <?php foreach ($products as $product): ?>
                <div class="product-card animate-on-scroll" data-product-name="<?= strtolower($product['name']) ?>">
                    <button class="wishlist-btn" data-product-id="<?= $product['id'] ?>">🤍</button>
                    <div class="product-image">
                        <?php if (!empty($product['image_url'])): ?>
                            <img src="<?php echo htmlspecialchars($product['image_url']); ?>" alt="<?php echo htmlspecialchars($product['name']); ?>" loading="lazy">
                        <?php else: ?>
                            <div style="font-size: 4rem; display: flex; align-items: center; justify-content: center; height: 100%;">📦</div>
                        <?php endif; ?>
                    </div>
                    <div class="product-info">
                        <h3 class="product-name"><?php echo htmlspecialchars($product['name']); ?></h3>
                        <div class="product-price"><?php echo number_format($product['price'], 2, ',', ' '); ?>€</div>
                        
                        <!-- Rating Stars -->
                        <div class="rating-container" data-rating="4">
                            <span class="star" data-rating="1">★</span>
                            <span class="star" data-rating="2">★</span>
                            <span class="star" data-rating="3">★</span>
                            <span class="star active" data-rating="4">★</span>
                            <span class="star" data-rating="5">★</span>
                            <span class="rating-text" style="font-size: 0.85rem; color: #666;">4/5 (12 avis)</span>
                        </div>

                        <p class="product-description"><?php echo htmlspecialchars(substr($product['description'], 0, 100) . '...'); ?></p>
                        <div class="product-actions">
                            <a href="/product/<?= $product['id'] ?>" class="btn btn-primary btn-small">Voir détails</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="text-center" style="grid-column: 1/-1; padding: 2rem;">Aucun produit disponible pour le moment</p>
        <?php endif; ?>
    </div>
</section>

<!-- CTA SECTION -->
<section class="hero" style="margin-top: 5rem;">
    <div class="hero-content">
        <h2 style="font-size: 2.8rem; margin-bottom: 1rem;">Prêt pour l'aventure ?</h2>
        <p>Rejoignez des milliers de clients satisfaits</p>
        <div class="hero-buttons">
            <a href="/products" class="btn btn-primary">Continuer le Shopping</a>
        </div>
    </div>
</section>

<script>
function filterProductsByName() {
    const searchInput = document.getElementById('searchInput').value.toLowerCase();
    const productCards = document.querySelectorAll('.product-card[data-product-name]');
    
    productCards.forEach(card => {
        const productName = card.getAttribute('data-product-name');
        if (productName.includes(searchInput)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Allow search on Enter key
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('searchInput');
    if (searchInput) {
        searchInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterProductsByName();
            }
        });
    }
});
</script>
