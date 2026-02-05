<div class="auth-container">
    <!-- Background Gradient -->
    <div class="auth-background"></div>

    <!-- Main Content -->
    <div class="auth-content">
        <!-- Card -->
        <div class="auth-card">
            <!-- Logo Header -->
            <div class="auth-header text-center mb-5">
                <div class="logo-wrapper mb-4">
                    <div class="logo-circle" style="color: #4CAF50;">✓</div>
                </div>
                <h1 class="auth-title">Inscription Réussie!</h1>
                <p class="auth-subtitle">Bienvenue dans NovaShop Premium</p>
            </div>

            <!-- Success Message -->
            <?php if (!empty($message)): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?= htmlspecialchars($message) ?>
                </div>
            <?php endif; ?>

            <!-- Success Content -->
            <div class="text-center mb-4">
                <p class="mb-3">
                    <strong>Compte créé:</strong> <?= htmlspecialchars($email ?? 'N/A') ?>
                </p>
                <p class="text-muted mb-4">
                    Vous pouvez maintenant accéder à votre espace personnel avec vos identifiants.
                </p>
            </div>

            <!-- Action Buttons -->
            <div class="d-grid gap-2">
                <a href="/login" class="btn btn-primary btn-lg fw-600">
                    <i class="fas fa-arrow-right-to-bracket me-2"></i>Se Connecter
                </a>
                <a href="/" class="btn btn-outline-primary btn-lg fw-600">
                    <i class="fas fa-home me-2"></i>Retour à l'accueil
                </a>
            </div>

            <!-- Divider -->
            <div class="divider my-4">
                <span>ou</span>
            </div>

            <!-- Login Link -->
            <p class="text-center text-muted">
                Vous avez déjà un compte?
                <a href="/login" class="text-primary text-decoration-none fw-600">
                    Se Connecter
                </a>
            </p>
        </div>
    </div>
</div>

<style>
.logo-circle {
    width: 80px;
    height: 80px;
    margin: 0 auto;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 48px;
    color: white;
    box-shadow: 0 10px 30px rgba(102, 126, 234, 0.3);
}
</style>
