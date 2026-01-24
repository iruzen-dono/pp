<div class="auth-container">
    <div class="auth-card auth-register">
        <!-- Decorative Background Elements -->
        <div class="auth-decoration auth-decoration-1"></div>
        <div class="auth-decoration auth-decoration-2"></div>

        <!-- Header Section -->
        <div class="auth-header">
            <div class="auth-icon">✨</div>
            <h1 class="auth-title">Créer un Compte</h1>
            <p class="auth-subtitle">Rejoignez NovaShop Premium en quelques secondes</p>
        </div>

        <!-- Alert Messages -->
        <?php if (!empty($error)): ?>
            <div class="auth-alert alert-danger">
                <span class="alert-icon">⚠️</span>
                <span class="alert-text"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Register Form -->
        <form method="POST" class="auth-form">
            <!-- Full Name Input -->
            <div class="form-group">
                <label for="name" class="form-label">
                    <span class="label-icon">👤</span>
                    <span>Nom Complet</span>
                </label>
                <div class="input-wrapper">
                    <input 
                        type="text" 
                        name="name" 
                        id="name" 
                        class="form-input" 
                        placeholder="Jean Dupont" 
                        required
                    >
                    <span class="input-icon">✓</span>
                </div>
            </div>

            <!-- Email Input -->
            <div class="form-group">
                <label for="email" class="form-label">
                    <span class="label-icon">📧</span>
                    <span>Adresse Email</span>
                </label>
                <div class="input-wrapper">
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-input" 
                        placeholder="vous@exemple.com" 
                        required
                    >
                    <span class="input-icon">✓</span>
                </div>
            </div>

            <!-- Password Input -->
            <div class="form-group">
                <label for="password" class="form-label">
                    <span class="label-icon">🔑</span>
                    <span>Mot de passe</span>
                </label>
                <div class="input-wrapper input-password-wrapper">
                    <input 
                        type="password" 
                        name="password" 
                        id="password" 
                        class="form-input" 
                        placeholder="Au moins 8 caractères" 
                        required
                    >
                    <button type="button" class="toggle-password" id="togglePassword" aria-label="Afficher/masquer le mot de passe">
                        👁️
                    </button>
                </div>
                <div class="password-strength">
                    <div class="strength-bar" id="strengthBar"></div>
                    <span class="strength-text" id="strengthText">Force: Faible</span>
                </div>
            </div>

            <!-- Terms & Conditions -->
            <div class="form-group">
                <label class="terms-checkbox">
                    <input type="checkbox" name="terms" id="terms" required>
                    <span>J'accepte les <a href="#" class="terms-link">conditions d'utilisation</a></span>
                </label>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                <span class="btn-text">Créer mon Compte</span>
                <span class="btn-arrow">→</span>
            </button>
        </form>

        <!-- Divider -->
        <div class="auth-divider">
            <span>ou s'inscrire avec</span>
        </div>

        <!-- Social Signup Options -->
        <div class="social-login">
            <button type="button" class="social-btn social-google" title="S'inscrire avec Google">
                <span>G</span>
            </button>
            <button type="button" class="social-btn social-github" title="S'inscrire avec GitHub">
                <span>⚙️</span>
            </button>
            <button type="button" class="social-btn social-facebook" title="S'inscrire avec Facebook">
                <span>f</span>
            </button>
        </div>

        <!-- Login Link -->
        <div class="auth-footer">
            <p class="auth-switch-text">
                Déjà inscrit ?
                <a href="/login" class="auth-switch-link">Se connecter ici</a>
            </p>
        </div>
    </div>
</div>
