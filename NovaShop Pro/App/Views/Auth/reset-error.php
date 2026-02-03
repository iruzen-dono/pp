<div class="auth-container">
    <div class="auth-content">
        <div class="auth-card text-center">
            <div class="auth-header mb-4">
                <h2>Erreur</h2>
            </div>

            <div class="alert alert-danger"><?= htmlspecialchars($error ?? 'Erreur lors de la réinitialisation.') ?></div>

            <div class="mt-3">
                <a href="/forgot" class="btn btn-outline-primary">Demander un nouveau lien</a>
                <a href="/login" class="btn btn-link">Retour à la connexion</a>
            </div>
        </div>
    </div>
</div>
