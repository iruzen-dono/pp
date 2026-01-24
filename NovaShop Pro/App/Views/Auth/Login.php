<div class="auth-container">
    <div class="auth-card auth-login">
        <!-- Decorative Background Elements -->
        <div class="auth-decoration auth-decoration-1"></div>
        <div class="auth-decoration auth-decoration-2"></div>

        <!-- Header Section -->
        <div class="auth-header">
            <div class="auth-icon">🔐</div>
            <h1 class="auth-title">Connexion</h1>
            <p class="auth-subtitle">Accédez à votre compte NovaShop Premium</p>
        </div>

        <!-- Alert Messages -->
        <?php if (!empty($error)): ?>
            <div class="auth-alert alert-danger">
                <span class="alert-icon">⚠️</span>
                <span class="alert-text"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Login Form -->
        <form method="POST" class="auth-form">
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
                        placeholder="Entrez votre mot de passe" 
                        required
                    >
                    <button type="button" class="toggle-password" id="togglePassword" aria-label="Afficher/masquer le mot de passe">
                        👁️
                    </button>
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="form-footer-options">
                <label class="remember-me">
                    <input type="checkbox" name="remember" id="remember">
                    <span>Se souvenir de moi</span>
                </label>
                <a href="#" class="forgot-password">Mot de passe oublié ?</a>
            </div>

            <!-- Submit Button -->
            <button type="submit" class="btn-submit">
                <span class="btn-text">Se Connecter</span>
                <span class="btn-arrow">→</span>
            </button>
        </form>

        <!-- Divider -->
        <div class="auth-divider">
            <span>ou</span>
        </div>

        <!-- Social Login Options -->
        <div class="social-login">
            <button type="button" class="social-btn social-google" title="Se connecter avec Google">
                <span>G</span>
            </button>
            <button type="button" class="social-btn social-github" title="Se connecter avec GitHub">
                <span>⚙️</span>
            </button>
            <button type="button" class="social-btn social-facebook" title="Se connecter avec Facebook">
                <span>f</span>
            </button>
        </div>

        <!-- Register Link -->
        <div class="auth-footer">
            <p class="auth-switch-text">
                Pas encore de compte ?
                <a href="/register" class="auth-switch-link">S'inscrire gratuitement</a>
            </p>
        </div>
    </div>
</div>
