<style>
.table-container {
    width: 100%;
    overflow-x: auto;
    border-radius: 0.5rem;
    background: rgba(30, 30, 40, 0.8);
    padding: 1rem;
}

.table-container table {
    width: 100%;
    min-width: 900px;
    border-collapse: collapse;
    background: transparent;
}

.table-container thead {
    background: rgba(60, 60, 80, 0.9);
}

.table-container th {
    padding: 0.75rem;
    text-align: left;
    font-weight: 600;
    color: #e0e7ff;
    border-bottom: 2px solid rgba(100, 100, 120, 0.5);
    user-select: none;
    white-space: nowrap;
}

.table-container td {
    padding: 0.75rem;
    border-bottom: 1px solid rgba(100, 100, 120, 0.3);
    color: #d1d5db;
}

.table-container tbody tr {
    transition: background-color 0.2s ease;
}

.table-container tbody tr:hover {
    background-color: rgba(96, 165, 250, 0.1);
}

.table-container tbody tr:last-child td {
    border-bottom: none;
}

.role-badge {
    display: inline-block;
    padding: 0.4rem 0.8rem;
    border-radius: 0.25rem;
    font-size: 0.875rem;
    font-weight: 500;
    text-transform: uppercase;
    letter-spacing: 0.05em;
}

.role-super-admin {
    background: rgba(239, 68, 68, 0.2);
    color: #fca5a5;
}

.role-admin {
    background: rgba(59, 130, 246, 0.2);
    color: #93c5fd;
}

.role-moderator {
    background: rgba(139, 92, 246, 0.2);
    color: #d8b4fe;
}

.role-user {
    background: rgba(34, 197, 94, 0.2);
    color: #86efac;
}

.role-select {
    width: 100%;
    max-width: 150px;
    padding: 0.5rem;
    border-radius: 0.25rem;
    border: 1px solid rgba(100, 100, 120, 0.5);
    background: rgba(30, 30, 40, 0.8);
    color: #d1d5db;
    font-size: 0.875rem;
}

.role-select:hover {
    border-color: rgba(100, 100, 120, 0.8);
}

.role-select:focus {
    outline: none;
    border-color: #60a5fa;
    box-shadow: 0 0 0 3px rgba(96, 165, 250, 0.1);
}

.role-actions {
    display: flex;
    gap: 0.5rem;
    align-items: center;
}

.role-actions button {
    padding: 0.4rem 0.8rem;
    border-radius: 0.25rem;
    border: none;
    cursor: pointer;
    font-size: 0.875rem;
    transition: all 0.2s ease;
}

.role-actions button.save {
    background: rgba(34, 197, 94, 0.2);
    color: #86efac;
}

.role-actions button.save:hover {
    background: rgba(34, 197, 94, 0.3);
}

@media (max-width: 768px) {
    .table-container {
        padding: 0.5rem;
        overflow-x: auto;
    }
    
    .table-container th,
    .table-container td {
        padding: 0.5rem 0.25rem;
        font-size: 0.875rem;
    }
    
    .role-select {
        max-width: 100%;
    }
    
    .role-actions {
        flex-direction: column;
        gap: 0.25rem;
    }
    
    .role-actions button {
        padding: 0.3rem 0.5rem;
        font-size: 0.75rem;
        width: 100%;
    }
}
</style>

<h1><i class="fas fa-user"></i> Gestion des Rôles Admin</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        <i class="fas fa-check-circle"></i> Rôle mis à jour avec succès
    </div>
<?php endif; ?>

<?php if (isset($_GET['error'])): ?>
    <div class="alert alert-danger">
        <i class="fas fa-exclamation-circle"></i> Erreur: <?php echo htmlspecialchars($_GET['error']); ?>
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
                                <?php echo ($user['is_active'] ?? true) ? '<i class="fas fa-check-circle"></i> Actif' : '<i class="fas fa-times-circle"></i> Désactivé'; ?>
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
                                    <button type="submit" class="btn btn-primary" style="padding: 0.4rem 0.8rem; font-size: 0.85rem; margin-left: 0.5rem;"><i class="fas fa-check"></i> Mettre à jour</button>
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
