<?php
// Header inclusion is handled by Controller::view()
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-info text-white">
                    <h2 class="mb-0">⚙️ Paramètres</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            ❌ <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($message)): ?>
                        <div class="alert alert-success" role="alert">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($user)): ?>
                        <form method="POST" class="form-group">
                            <?php 
                            // Token CSRF
                            if (!isset($_SESSION['csrf_token'])) {
                                $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
                            }
                            ?>
                            <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">

                            <!-- Section: Informations personnelles -->
                            <div class="mb-4">
                                <h4 class="border-bottom pb-2">👤 Informations personnelles</h4>

                                <div class="mb-3">
                                    <label for="name" class="form-label">Nom</label>
                                    <input 
                                        type="text" 
                                        class="form-control" 
                                        id="name" 
                                        name="name"
                                        value="<?php echo htmlspecialchars($user['name']); ?>"
                                        required>
                                </div>

                                <div class="mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input 
                                        type="email" 
                                        class="form-control" 
                                        id="email" 
                                        name="email"
                                        value="<?php echo htmlspecialchars($user['email']); ?>"
                                        required>
                                </div>
                            </div>

                            <hr>

                            <!-- Section: Changer le mot de passe -->
                            <div class="mb-4">
                                <h4 class="border-bottom pb-2">🔐 Changer le mot de passe</h4>
                                <p class="text-muted small">Laissez vide si vous ne souhaitez pas le changer</p>

                                <div class="mb-3">
                                    <label for="current_password" class="form-label">Mot de passe actuel</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="current_password" 
                                        name="current_password"
                                        placeholder="Votre mot de passe actuel">
                                </div>

                                <div class="mb-3">
                                    <label for="new_password" class="form-label">Nouveau mot de passe</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="new_password" 
                                        name="new_password"
                                        placeholder="Au moins 6 caractères">
                                    <small class="text-muted d-block mt-1">Minimum 6 caractères</small>
                                </div>

                                <div class="mb-3">
                                    <label for="confirm_password" class="form-label">Confirmer le nouveau mot de passe</label>
                                    <input 
                                        type="password" 
                                        class="form-control" 
                                        id="confirm_password" 
                                        name="confirm_password"
                                        placeholder="Confirmez votre nouveau mot de passe">
                                </div>
                            </div>

                            <hr>

                            <!-- Boutons -->
                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-success">
                                    💾 Enregistrer les modifications
                                </button>
                                <a href="/profile" class="btn btn-secondary">
                                    ← Retour au profil
                                </a>
                                <a href="/home" class="btn btn-outline-secondary">
                                    🏠 Retour à l'accueil
                                </a>
                            </div>
                        </form>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            ⚠️ Impossible de charger vos paramètres. Veuillez vous reconnecter.
                        </div>
                        <a href="/login" class="btn btn-primary">Se connecter</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .form-control:focus {
        border-color: #d4a574;
        box-shadow: 0 0 0 0.2rem rgba(212, 165, 116, 0.25);
    }

    .btn-warning:hover {
        background-color: #c59461;
    }
</style>

<?php
// Footer inclusion is handled by Controller::view()
?>
