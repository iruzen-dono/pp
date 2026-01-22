<div style="max-width: 500px; margin: 0 auto;">
    <h1>� Connexion</h1>
    <p class="subtitle">Accédez à votre compte NovaShop</p>

    <?php if (!empty($error)): ?>
        <div class="alert alert-danger">❌ <?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" placeholder="votre@email.com" required>

        <label for="password">Mot de passe:</label>
        <input type="password" name="password" id="password" placeholder="••••••••" required>

        <button type="submit" style="width: 100%;">Se connecter</button>
    </form>

    <hr style="border: 1px solid var(--border-color); margin: 20px 0;">
    
    <p style="text-align: center;">
        Pas encore de compte ? <a href="/register" style="color: var(--primary-color); text-decoration: none; font-weight: bold;">S'inscrire ici</a>
    </p>
</div>
