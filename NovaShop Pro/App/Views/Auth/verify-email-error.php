<div style="max-width: 500px; margin: 4rem auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
    <div style="font-size: 64px; margin-bottom: 1rem;">❌</div>
    <h1 style="margin: 1rem 0; color: #ef4444;">Erreur de Vérification</h1>
    
    <div style="background: #fee2e2; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #ef4444; margin: 2rem 0;">
        <p style="margin: 0; color: #991b1b; line-height: 1.6;">
            <?php if (isset($error)): ?>
                <?= htmlspecialchars($error) ?>
            <?php else: ?>
                Une erreur est survenue lors de la vérification de votre email.
            <?php endif; ?>
        </p>
    </div>

    <div style="margin: 2rem 0;">
        <a href="/register" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #d4a574, #c59461); color: white; text-decoration: none; border-radius: 6px; font-weight: bold; margin-right: 1rem;">
            📝 Créer un nouveau compte
        </a>
        <a href="/" style="display: inline-block; padding: 12px 30px; background: #6b7280; color: white; text-decoration: none; border-radius: 6px; font-weight: bold;">
            🏠 Retour à l'accueil
        </a>
    </div>

    <p style="margin-top: 2rem; color: #666; font-size: 14px;">
        Si vous avez des questions, veuillez nous <a href="/contact" style="color: #0ea5e9; text-decoration: none;">contacter</a>.
    </p>
</div>

<style>
    body {
        background: linear-gradient(135deg, #1e1e2e 0%, #2d2d44 100%);
        color: #333;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 2rem;
    }
</style>
