<h1>👤 Gestion des Rôles Admin</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        ✓ Rôle mis à jour avec succès
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        ❌ Erreur: <?php echo htmlspecialchars($_GET['error']); ?>
    </div>
<?php endif; ?>

<p style="color: #999; margin-bottom: 2rem;">Seul un super administrateur peut modifier les rôles.</p>

<?php if (!empty($users) && is_array($users)): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle actuel</th>
                    <th>Statut</th>
                    <th style="text-align: center;">Changer le rôle</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <?php 
                    $isCurrentUser = ($user['id'] === ($_SESSION['user']['id'] ?? 0));
                    $isAdmin = in_array($user['role'] ?? 'user', ['admin', 'moderator', 'super_admin']);
                    ?>
                    <tr style="opacity: <?php echo ($user['is_active'] ?? true) ? '1' : '0.6'; ?>">
                        <td>#<?php echo htmlspecialchars($user['id'] ?? ''); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($user['name'] ?? ''); ?></strong>
                            <?php if ($isCurrentUser): ?>
                                <span style="color: #666; font-size: 0.85rem;"> (Vous)</span>
                            <?php endif; ?>
                        </td>
                        <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                        <td>
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
                        </td>
                        <td>
                            <span style="color: <?php echo ($user['is_active'] ?? true) ? '#86efac' : '#fca5a5'; ?>; font-weight: 600;">
                                <?php echo ($user['is_active'] ?? true) ? '✓ Actif' : '✕ Désactivé'; ?>
                            </span>
                        </td>
                        <td style="text-align: center;">
                            <?php if (!$isCurrentUser && ($user['is_active'] ?? true)): ?>
                                <form method="POST" style="display: inline-block;">
                                    <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
                                    <input type="hidden" name="user_id" value="<?php echo $user['id']; ?>">
                                    <select name="role" style="padding: 0.4rem; border-radius: 0.3rem; border: 1px solid #444; background: #2a2a2a; color: #fff;">
                                        <option value="user" <?php echo ($user['role'] ?? 'user') === 'user' ? 'selected' : ''; ?>>User</option>
                                        <option value="admin" <?php echo ($user['role'] ?? 'user') === 'admin' ? 'selected' : ''; ?>>Admin</option>
                                        <option value="super_admin" <?php echo ($user['role'] ?? 'user') === 'super_admin' ? 'selected' : ''; ?>>Super Admin</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; margin-left: 0.5rem;">✓ Mettre à jour</button>
                                </form>
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

<style>
select {
    font-family: inherit;
}
</style>
