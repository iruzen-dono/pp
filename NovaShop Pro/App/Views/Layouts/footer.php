    </main>

    <!-- Newsletter Popup -->
    <div id="newsletterPopup" class="popup">
        <div class="modal-content">
            <button class="popup-close">✕</button>
            <h3>🎁 Offre Exclusive</h3>
            <p>Inscrivez-vous à notre newsletter et recevez <strong>10% de réduction</strong> sur votre première commande !</p>
            <form>
                <input type="email" placeholder="Votre email" required>
                <button type="submit" class="btn btn-accent">S'abonner</button>
            </form>
        </div>
    </div>

    <!-- Filter Modal -->
    <div id="filterModal" class="filter-modal">
        <div class="filter-modal-content">
            <button class="filter-modal-close">✕</button>
            <h2>Filtrer les produits</h2>
            
            <div class="filter-group">
                <h3>Catégories</h3>
                <label>
                    <input type="radio" name="category" value="all" checked> Tous
                </label>
                <label>
                    <input type="radio" name="category" value="1"> Électronique
                </label>
                <label>
                    <input type="radio" name="category" value="2"> Vêtements
                </label>
                <label>
                    <input type="radio" name="category" value="3"> Livres
                </label>
                <label>
                    <input type="radio" name="category" value="4"> Maison
                </label>
            </div>

            <div class="filter-group">
                <h3>Prix</h3>
                <label>Min: <input type="number" name="minPrice" value="0" style="width: 80px;"></label>
                <label>Max: <input type="number" name="maxPrice" value="10000" style="width: 80px;"></label>
            </div>

            <button class="btn btn-primary apply-filter">Appliquer les filtres</button>
        </div>
    </div>

    <footer class="footer">
        <p>&copy; <?= date('Y') ?> NovaShop — Tous droits réservés. Fait avec ❤️ pour les aventuriers.</p>
    </footer>

    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Custom JS -->
    <script src="/Assets/Js/main.js"></script>
</body>
</html>
