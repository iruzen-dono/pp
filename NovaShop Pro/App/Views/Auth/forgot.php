<div class="auth-container">
    <div class="auth-content">
        <div class="auth-card">
            <div class="auth-header text-center mb-4">
                <h2>Réinitialiser le mot de passe</h2>
                <p>Entrez l'adresse email associée à votre compte.</p>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
                <div class="form-group mb-3">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required placeholder="vous@exemple.com">
                </div>

                <button class="btn btn-primary w-100" type="submit">Envoyer le lien de réinitialisation</button>
            </form>

            <div class="mt-3 text-center">
                <a href="/login">Retour à la connexion</a>
            </div>
        </div>
    </div>
</div>
