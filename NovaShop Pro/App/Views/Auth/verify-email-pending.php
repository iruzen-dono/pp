<div style="max-width: 500px; margin: 4rem auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
    <div style="text-align: center; margin-bottom: 2rem;">
        <div style="font-size: 48px; margin-bottom: 1rem;">📧</div>
        <h1 style="margin: 0; color: #333;">Vérification d'Email</h1>
    </div>

    <div style="background: #e8f4f8; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #0ea5e9; margin-bottom: 2rem;">
        <p style="margin: 0; color: #0369a1; line-height: 1.6;">
            <strong>✓ Compte créé avec succès!</strong><br>
            Un email de confirmation a été envoyé à <strong><?= htmlspecialchars($email) ?></strong>
        </p>
    </div>

    <div style="background: #f9f9f9; padding: 1.5rem; border-radius: 6px; margin-bottom: 2rem;">
        <h3 style="margin-top: 0; color: #333;">Prochaines étapes:</h3>
        <ol style="color: #666; line-height: 1.8;">
            <li>Vérifiez votre boîte de réception</li>
            <li>Cliquez sur le lien de confirmation dans l'email</li>
            <li>Vous serez automatiquement redirigé pour vous connecter</li>
            <li>Si vous ne voyez pas l'email, vérifiez vos spams</li>
        </ol>
    </div>

    <div style="background: #fff3cd; padding: 1rem; border-radius: 6px; border-left: 4px solid #ffc107; margin-bottom: 2rem;">
        <p style="margin: 0; color: #856404; font-size: 14px;">
            <strong>⏰ Le lien d'activation expire dans 24 heures.</strong> Après cela, vous devrez vous réinscrire.
        </p>
    </div>

    <div style="text-align: center;">
        <p style="margin: 1rem 0; color: #666;">
            Vous avez un problème? 
            <a href="/login" style="color: #0ea5e9; text-decoration: none; font-weight: 600;">Retour à la connexion</a>
        </p>
    </div>
</div>

<style>
    body {
        background: linear-gradient(135deg, #1e1e2e 0%, #2d2d44 100%);
        color: #333;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 2rem;
    }
</style>
