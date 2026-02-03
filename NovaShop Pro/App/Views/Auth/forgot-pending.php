<div class="auth-container">
    <div class="auth-content">
        <div class="auth-card text-center">
            <div class="auth-header mb-4">
                <h2>Vérifiez votre email</h2>
            </div>

            <p><?= htmlspecialchars($message ?? 'Si un compte existe, un email a été envoyé.') ?></p>

            <div class="mt-3">
                <a href="/login" class="btn btn-outline-primary">Retour à la connexion</a>
            </div>
        </div>
    </div>
</div>
