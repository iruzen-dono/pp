<?php
// Header inclusion is handled by Controller::view()
?>

<div class="container my-5">
    <div class="row">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h2 class="mb-0"><i class="fas fa-user-circle"></i> Mon Profil</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($error)): ?>
                        <div class="alert alert-danger" role="alert">
                            <?php echo htmlspecialchars($error); ?>
                        </div>
                    <?php endif; ?>

                    <?php if (!empty($user)): ?>
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-muted">Nom</h5>
                                <p class="h6"><?php echo htmlspecialchars($user['name']); ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted">Email</h5>
                                <p class="h6"><?php echo htmlspecialchars($user['email']); ?></p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h5 class="text-muted">Compte créé le</h5>
                                <p class="h6"><?php echo date('d/m/Y à H:i', strtotime($user['created_at'])); ?></p>
                            </div>
                            <div class="col-md-6">
                                <h5 class="text-muted">Statut du compte</h5>
                                <p class="h6">
                                    <?php if ($user['is_active']): ?>
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Actif</span>
                                    <?php else: ?>
                                        <span class="badge bg-warning">⏳ En attente de vérification</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-md-12">
                                <h5 class="text-muted">Vérification email</h5>
                                <p class="h6">
                                    <?php if ($user['email_verified_at']): ?>
                                        <span class="badge bg-success"><i class="fas fa-check-circle"></i> Email vérifié le <?php echo date('d/m/Y à H:i', strtotime($user['email_verified_at'])); ?></span>
                                    <?php else: ?>
                                        <span class="badge bg-danger"><i class="fas fa-times-circle"></i> Email non vérifié</span>
                                    <?php endif; ?>
                                </p>
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex gap-2">
                            <a href="/settings" class="btn btn-warning">
                                <i class="fas fa-cog"></i> Modifier les paramètres
                            </a>
                            <a href="/orders" class="btn btn-info">
                                <i class="fas fa-box"></i> Mes commandes
                            </a>
                            <a href="/home" class="btn btn-secondary">
                                <i class="fas fa-arrow-left"></i> Retour à l'accueil
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Footer inclusion is handled by Controller::view()
?>
