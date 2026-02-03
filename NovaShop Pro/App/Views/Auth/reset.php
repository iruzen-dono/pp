<div class="auth-container">
    <div class="auth-content">
        <div class="auth-card">
            <div class="auth-header text-center mb-4">
                <h2>Choisissez un nouveau mot de passe</h2>
            </div>

            <?php if (!empty($error)): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
            <?php endif; ?>

            <form method="POST">
                <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
                <input type="hidden" name="token" value="<?= htmlspecialchars($token ?? '') ?>">

                <div class="form-group mb-3">
                    <label for="password">Nouveau mot de passe</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="password_confirm">Confirmez le mot de passe</label>
                    <input type="password" name="password_confirm" id="password_confirm" class="form-control" required>
                </div>

                <button class="btn btn-primary w-100" type="submit">Réinitialiser mon mot de passe</button>
            </form>

            <div class="mt-3 text-center">
                <a href="/login">Retour à la connexion</a>
            </div>
        </div>
    </div>
</div>
