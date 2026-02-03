<?php
// App/Views/Home/index.php
?>

<!-- ===== HERO SECTION ===== -->
<section class="hero-large">
    <div class="container">
        <div class="hero-grid">
            <div class="hero-content-wrapper">
                <h1 class="hero-title">
                    Shopping de <span class="gradient-text">qualité premium</span><br>
                    sans compromis
                </h1>
                <p class="hero-subtitle">
                    Découvrez une sélection mondiale de produits soigneusement choisis.<br>
                    Qualité garantie. Livraison rapide. Satisfaction 100%.
                </p>
                <div class="hero-buttons">
                    <a href="/products" class="btn btn-primary btn-large">
                        Découvrir nos produits
                        <span class="btn-arrow">→</span>
                    </a>
                    <a href="#how-it-works" class="btn btn-secondary btn-large">
                        Comment ça marche
                    </a>
                </div>
                
                <!-- Trust Signals -->
                <div class="trust-signals">
                    <div class="trust-item">
                        <span class="trust-number">10k+</span>
                        <span class="trust-label">Clients satisfaits</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-number">5k+</span>
                        <span class="trust-label">Produits premium</span>
                    </div>
                    <div class="trust-item">
                        <span class="trust-number">4.8★</span>
                        <span class="trust-label">Note moyenne</span>
                    </div>
                </div>
            </div>
            
            <div class="hero-image-wrapper">
                <div class="hero-image-placeholder">
                    <div class="floating-card"><i class="fas fa-box"></i> Produits premium</div>
                    <div class="floating-card" style="animation-delay: 0.5s;"><i class="fas fa-truck"></i> Livraison rapide</div>
                    <div class="floating-card" style="animation-delay: 1s;"><i class="fas fa-sparkles"></i> Qualité garantie</div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- ===== FEATURED PRODUCTS SECTION (Alternating Layout) ===== -->
<?php if (isset($products) && count($products) > 0): ?>
<section class="featured-products-section" id="featured">
    <div class="container">
        <h2 class="section-title-large">Nos sélections vedettes</h2>
        <p class="section-subtitle-large">Les produits les plus appréciés par nos clients</p>
        
        <?php 
        $featured = array_slice($products, 0, 3);
        foreach ($featured as $index => $product):
            $isEven = $index % 2 === 0;
        ?>
        
        <div class="featured-product-section <?= $isEven ? 'layout-left' : 'layout-right' ?> animate-on-scroll">
            <div class="featured-product-image">
                <?php if (!empty($product['image_url'])): ?>
                    <img src="<?= htmlspecialchars($product['image_url']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">
                <?php else: ?>
                    <div class="placeholder-large"><i class="fas fa-box fa-3x"></i></div>
                <?php endif; ?>
            </div>
            
            <div class="featured-product-info">
                <span class="product-badge">Vedette</span>
                <h3 class="featured-product-title"><?= htmlspecialchars($product['name']) ?></h3>
                <p class="featured-product-description">
                    <?= htmlspecialchars($product['description']) ?>
                </p>
                
                <div class="featured-product-features">
                    <div class="feature-item">
                        <span class="feature-icon"><i class="fas fa-check"></i></span>
                        <span>Qualité certifiée</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon"><i class="fas fa-check"></i></span>
                        <span>Livraison gratuite</span>
                    </div>
                    <div class="feature-item">
                        <span class="feature-icon"><i class="fas fa-check"></i></span>
                        <span>Retour sans frais</span>
                    </div>
                </div>
                
                <div class="featured-product-price">
                    <span class="price-label">À partir de</span>
                    <span class="price-value"><?= number_format($product['price'], 2, ',', ' ') ?>€</span>
                </div>
                
                <div class="featured-product-actions">
                    <a href="/products/<?= $product['id'] ?>" class="btn btn-primary btn-large">
                        Voir le produit
                        <span class="btn-arrow">→</span>
                    </a>
                </div>
            </div>
        </div>
        
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<!-- ===== WHY NOVASHOP SECTION ===== -->
<section class="why-section" id="why">
    <div class="container">
        <h2 class="section-title-large">Pourquoi choisir NovaShop ?</h2>
        <p class="section-subtitle-large">Une plateforme pensée pour votre satisfaction</p>
        
        <div class="benefits-grid">
            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon"><i class="fas fa-globe fa-2x"></i></div>
                <h3 class="benefit-title">Sélection Mondiale</h3>
                <p class="benefit-description">
                    Produits sélectionnés avec soin du monde entier, garantissant qualité et authenticité
                </p>
            </div>
            
            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon"><i class="fas fa-bolt fa-2x"></i></div>
                <h3 class="benefit-title">Livraison Express</h3>
                <p class="benefit-description">
                    Commandes traitées en 24h et livrées rapidement. Suivi en temps réel inclus
                </p>
            </div>
            
            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon"><i class="fas fa-lock fa-2x"></i></div>
                <h3 class="benefit-title">100% Sécurisé</h3>
                <p class="benefit-description">
                    Paiements cryptés et données protégées. Retours gratuits sous 30 jours
                </p>
            </div>
            
            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon"><i class="fas fa-dollar-sign fa-2x"></i></div>
                <h3 class="benefit-title">Meilleurs Prix</h3>
                <p class="benefit-description">
                    Prix compétitifs et réductions régulières. Programme de fidélité exclusif
                </p>
            </div>
            
            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon"><i class="fas fa-headset fa-2x"></i></div>
                <h3 class="benefit-title">Support 24/7</h3>
                <p class="benefit-description">
                    Équipe réactive et disponible. Réponses rapides à vos questions
                </p>
            </div>
            
            <div class="benefit-card animate-on-scroll">
                <div class="benefit-icon"><i class="fas fa-star fa-2x"></i></div>
                <h3 class="benefit-title">Qualité Garantie</h3>
                <p class="benefit-description">
                    Tous produits testés et approuvés. Satisfaction garantie ou remboursement
                </p>
            </div>
        </div>
    </div>
</section>

<!-- ===== HOW IT WORKS SECTION ===== -->
<section class="how-works-section" id="how-it-works">
    <div class="container">
        <h2 class="section-title-large">Comment ça marche</h2>
        <p class="section-subtitle-large">Un processus simple et transparent en 4 étapes</p>
        
        <div class="steps-grid">
            <div class="step-card animate-on-scroll">
                <div class="step-number">1</div>
                <h3 class="step-title">Parcourir</h3>
                <p class="step-description">
                    Explorez notre vaste sélection de produits premium soigneusement curés
                </p>
                <div class="step-icon"><i class="fas fa-search fa-2x"></i></div>
            </div>
            
            <div class="step-arrow">→</div>
            
            <div class="step-card animate-on-scroll">
                <div class="step-number">2</div>
                <h3 class="step-title">Ajouter</h3>
                <p class="step-description">
                    Sélectionnez vos produits préférés et ajoutez-les au panier
                </p>
                <div class="step-icon"><i class="fas fa-cart-plus fa-2x"></i></div>
            </div>
            
            <div class="step-arrow">→</div>
            
            <div class="step-card animate-on-scroll">
                <div class="step-number">3</div>
                <h3 class="step-title">Payer</h3>
                <p class="step-description">
                    Paiement sécurisé avec plusieurs options disponibles
                </p>
                <div class="step-icon"><i class="fas fa-credit-card fa-2x"></i></div>
            </div>
            
            <div class="step-arrow">→</div>
            
            <div class="step-card animate-on-scroll">
                <div class="step-number">4</div>
                <h3 class="step-title">Recevoir</h3>
                <p class="step-description">
                    Livraison rapide avec suivi en temps réel
                </p>
                <div class="step-icon"><i class="fas fa-box fa-2x"></i></div>
            </div>
        </div>
    </div>
</section>

<!-- ===== SOCIAL PROOF & TRUST SECTION ===== -->
<section class="trust-proof-section">
    <div class="container">
        <h2 class="section-title-large">La confiance au cœur de nos valeurs</h2>
        <p class="section-subtitle-large">Transparence, sécurité et fiabilité garanties</p>
        
        <div class="trust-grid">
            <!-- Chiffres clés -->
            <div class="trust-stat-card animate-on-scroll">
                <div class="stat-icon"><i class="fas fa-users fa-2x"></i></div>
                <div class="stat-number">847K+</div>
                <div class="stat-label">Clients actifs</div>
                <p class="stat-description">Une communauté en croissance constante depuis 2020</p>
            </div>
            
            <div class="trust-stat-card animate-on-scroll">
                <div class="stat-icon"><i class="fas fa-box fa-2x"></i></div>
                <div class="stat-number">2.3M+</div>
                <div class="stat-label">Commandes livrées</div>
                <p class="stat-description">99.2% de satisfaction client documentée</p>
            </div>
            
            <div class="trust-stat-card animate-on-scroll">
                <div class="stat-icon"><i class="fas fa-star fa-2x"></i></div>
                <div class="stat-number">4.8/5</div>
                <div class="stat-label">Note moyenne</div>
                <p class="stat-description">Basée sur 156K+ avis vérifiés</p>
            </div>
            
            <div class="trust-stat-card animate-on-scroll">
                <div class="stat-icon"><i class="fas fa-shield fa-2x"></i></div>
                <div class="stat-number">100%</div>
                <div class="stat-label">Sécurisé</div>
                <p class="stat-description">SSL certifié + Paiements cryptés</p>
            </div>
        </div>
        
        <!-- Certifications & Garanties -->
        <div class="certifications-section">
            <h3 class="certifications-title">Certifications & Garanties</h3>
            <div class="certifications-grid">
                <div class="cert-badge animate-on-scroll">
                    <div class="cert-icon"><i class="fas fa-check"></i></div>
                    <div class="cert-name">Paiements 100% sécurisés</div>
                    <p class="cert-description">Chiffrement SSL et protection PCI-DSS</p>
                </div>
                
                <div class="cert-badge animate-on-scroll">
                    <div class="cert-icon"><i class="fas fa-check"></i></div>
                    <div class="cert-name">Retours gratuits 30j</div>
                    <p class="cert-description">Satisfait ou remboursé, sans questions</p>
                </div>
                
                <div class="cert-badge animate-on-scroll">
                    <div class="cert-icon"><i class="fas fa-check"></i></div>
                    <div class="cert-name">Livraison Express</div>
                    <p class="cert-description">Suivi en temps réel garanti</p>
                </div>
                
                <div class="cert-badge animate-on-scroll">
                    <div class="cert-icon"><i class="fas fa-check"></i></div>
                    <div class="cert-name">Support 24/7</div>
                    <p class="cert-description">Réponse en moins de 2h</p>
                </div>
            </div>
        </div>
    </div>
</section>
            </div>
        </div>
    </div>
</section>

<!-- ===== FINAL CTA SECTION ===== -->
<section class="final-cta-section">
    <div class="container">
        <div class="cta-content">
            <h2 class="cta-title">
                Prêt à commencer votre<br>
                shopping <span class="gradient-text">premium</span> ?
            </h2>
            <p class="cta-subtitle">
                Rejoignez des milliers de clients satisfaits et découvrez une sélection exceptionnelle
            </p>
            <div class="cta-buttons">
                <a href="/products" class="btn btn-primary btn-large">
                    Découvrir nos produits
                    <span class="btn-arrow">→</span>
                </a>
                <a href="#why" class="btn btn-secondary btn-large">
                    En savoir plus
                </a>
            </div>
        </div>
    </div>
</section>

<script>
// Wishlist functionality
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.wishlist-btn').forEach(btn => {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            const productId = this.dataset.productId;
            const isFilled = this.textContent === '❤️';
            
            this.textContent = isFilled ? '🤍' : '❤️';
            this.style.transform = 'scale(1.2)';
            setTimeout(() => { this.style.transform = 'scale(1)'; }, 200);
        });
    });
});
</script>
