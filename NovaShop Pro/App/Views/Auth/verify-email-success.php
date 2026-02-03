<div style="max-width: 500px; margin: 4rem auto; padding: 2rem; background: white; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1); text-align: center;">
    <div style="font-size: 64px; margin-bottom: 1rem; animation: bounce 1s infinite;">✅</div>
    <h1 style="margin: 1rem 0; color: #22c55e;">Email Vérifié avec Succès!</h1>
    
    <div style="background: #dcfce7; padding: 1.5rem; border-radius: 8px; border-left: 4px solid #22c55e; margin: 2rem 0;">
        <p style="margin: 0; color: #166534; line-height: 1.6;">
            <?php if (isset($message)): ?>
                <?= htmlspecialchars($message) ?>
            <?php else: ?>
                Votre adresse email a été confirmée. Vous pouvez maintenant accéder à votre compte.
            <?php endif; ?>
        </p>
    </div>

    <div style="margin: 2rem 0;">
        <a href="/login" style="display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #d4a574, #c59461); color: white; text-decoration: none; border-radius: 6px; font-weight: bold; transition: transform 0.2s;">
            🚀 Se connecter à mon compte
        </a>
    </div>

    <p style="margin-top: 2rem; color: #666; font-size: 14px;">
        Vous serez redirigé automatiquement dans quelques secondes...
    </p>
</div>

<script>
    // Redirection automatique après 3 secondes
    setTimeout(function() {
        window.location.href = '/login';
    }, 3000);
</script>

<style>
    body {
        background: linear-gradient(135deg, #1e1e2e 0%, #2d2d44 100%);
        color: #333;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        padding: 2rem;
    }

    @keyframes bounce {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }
</style>
