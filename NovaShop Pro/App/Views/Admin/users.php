<h1>👥 Gestion des Utilisateurs</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <?php
            $success = $_GET['success'];
            if ($success === 'deactivated') echo '✓ Utilisateur désactivé avec succès';
            elseif ($success === 'reactivated') echo '✓ Utilisateur réactivé avec succès';
            elseif ($success === 'role_changed') echo '✓ Rôle modifié avec succès';
            else echo '✓ Opération réussie';
        ?>
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        ❌ Erreur: <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<?php 
$currentUserRole = $_SESSION['user']['role'] ?? 'user';
$isSuperAdmin = $currentUserRole === 'super_admin';
?>

<?php if (!empty($users) && is_array($users)): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th><a href="/admin/users?sort=id&order=<?php echo ($sortBy === 'id' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>" style="color: inherit; text-decoration: none;">ID <?php echo $sortBy === 'id' ? ($sortOrder === 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                    <th><a href="/admin/users?sort=name&order=<?php echo ($sortBy === 'name' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>" style="color: inherit; text-decoration: none;">Nom <?php echo $sortBy === 'name' ? ($sortOrder === 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                    <th><a href="/admin/users?sort=email&order=<?php echo ($sortBy === 'email' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>" style="color: inherit; text-decoration: none;">Email <?php echo $sortBy === 'email' ? ($sortOrder === 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                    <th><a href="/admin/users?sort=role&order=<?php echo ($sortBy === 'role' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>" style="color: inherit; text-decoration: none;">Rôle <?php echo $sortBy === 'role' ? ($sortOrder === 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                    <th><a href="/admin/users?sort=is_active&order=<?php echo ($sortBy === 'is_active' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>" style="color: inherit; text-decoration: none;">Statut <?php echo $sortBy === 'is_active' ? ($sortOrder === 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                    <th><a href="/admin/users?sort=created_at&order=<?php echo ($sortBy === 'created_at' && $sortOrder === 'ASC') ? 'DESC' : 'ASC'; ?>" style="color: inherit; text-decoration: none;">Inscription <?php echo $sortBy === 'created_at' ? ($sortOrder === 'ASC' ? '↑' : '↓') : ''; ?></a></th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr style="opacity: <?php echo ($user['is_active'] ?? true) ? '1' : '0.6'; ?>">
                        <td>#<?php echo htmlspecialchars($user['id'] ?? ''); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($user['name'] ?? ''); ?></strong>
                        </td>
                        <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                        <td>
                            <?php if ($isSuperAdmin && $user['id'] !== ($_SESSION['user']['id'] ?? 0)): ?>
                                <form method="POST" action="/admin/changeRole/<?php echo $user['id']; ?>" style="display: inline; margin: 0;">
                                    <input type="hidden" name="_csrf" value="<?php echo \App\Middleware\CsrfMiddleware::generateToken(); ?>">
                                    <select name="role" onchange="this.form.submit()" style="padding: 0.3rem 0.5rem; border-radius: 0.3rem; font-weight: 600; font-size: 0.85rem; cursor: pointer;">
                                        <option value="user" <?php echo ($user['role'] ?? 'user') === 'user' ? 'selected' : ''; ?>>USER</option>
                                        <option value="admin" <?php echo ($user['role'] ?? 'user') === 'admin' ? 'selected' : ''; ?>>ADMIN</option>
                                        <option value="super_admin" <?php echo ($user['role'] ?? 'user') === 'super_admin' ? 'selected' : ''; ?>>SUPER_ADMIN</option>
                                    </select>
                                </form>
                            <?php else: ?>
                                <span style="background: <?php 
                                    $roleColor = match($user['role'] ?? 'user') {
                                        'super_admin' => 'rgba(239, 68, 68, 0.3)',
                                        'admin' => 'rgba(99, 102, 241, 0.3)',
                                        default => 'rgba(99, 102, 241, 0.1)'
                                    };
                                    echo $roleColor;
                                ?>; color: <?php 
                                    $roleTextColor = match($user['role'] ?? 'user') {
                                        'super_admin' => '#fca5a5',
                                        'admin' => '#93c5fd',
                                        default => '#a0a0a0'
                                    };
                                    echo $roleTextColor;
                                ?>; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-weight: 600; font-size: 0.85rem; display: inline-block;">
                                    <?php echo strtoupper($user['role'] ?? 'user'); ?>
                                </span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <span style="color: <?php echo ($user['is_active'] ?? true) ? '#86efac' : '#fca5a5'; ?>; font-weight: 600;">
                                <?php echo ($user['is_active'] ?? true) ? '✓ Actif' : '✕ Désactivé'; ?>
                            </span>
                        </td>
                        <td style="color: #a0a0a0; font-size: 0.9rem;">
                            <?php 
                            if (!empty($user['created_at'])) {
                                $date = new \DateTime($user['created_at']);
                                echo $date->format('d/m/Y H:i');
                            }
                            ?>
                        </td>
                        <td style="text-align: center; display: flex; gap: 0.5rem; justify-content: center;">
                            <?php if ($isSuperAdmin && $user['id'] !== ($_SESSION['user']['id'] ?? 0)): ?>
                                <?php if ($user['is_active'] ?? true): ?>
                                    <!-- User is active: show deactivate button -->
                                    <a href="/admin/deleteUser/<?php echo $user['id']; ?>" onclick="return confirm('⚠️ Confirmer la désactivation de cet utilisateur ?')" class="btn btn-danger" style="padding: 0.4rem 0.7rem; font-size: 0.8rem; margin: 0;">🗑️ Désa.</a>
                                <?php else: ?>
                                    <!-- User is inactive: show reactivate button -->
                                    <a href="/admin/reactivateUser/<?php echo $user['id']; ?>" onclick="return confirm('✓ Réactiver cet utilisateur ?')" class="btn btn-success" style="padding: 0.4rem 0.7rem; font-size: 0.8rem; margin: 0; background: #10b981; color: white;">↻ Réac.</a>
                                <?php endif; ?>
                            <?php else: ?>
                                <span style="color: #666; font-size: 0.85rem;">-</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php else: ?>
    <div class="alert alert-info" style="text-align: center;">
        Aucun utilisateur trouvé.
    </div>
<?php endif; ?>
