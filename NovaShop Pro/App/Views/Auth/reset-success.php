<div class="auth-container">
    <div class="auth-content">
        <div class="auth-card text-center">
            <div class="auth-header mb-4">
                <h2>Mot de passe réinitialisé</h2>
            </div>

            <p><?= htmlspecialchars($message ?? 'Votre mot de passe a été réinitialisé.') ?></p>

            <div class="mt-3">
                <a href="/login" class="btn btn-primary">Se connecter</a>
            </div>
        </div>
    </div>
</div>
