<h1>👥 Gestion des Utilisateurs</h1>

<?php if (isset($_GET['success'])): ?>
    <div class="alert alert-success">
        ✓ Utilisateur supprimé avec succès
    </div>
<?php endif; ?>

<?php if (!empty($users) && is_array($users)): ?>
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Inscription</th>
                    <th style="text-align: center;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                    <tr>
                        <td>#<?php echo htmlspecialchars($user['id'] ?? ''); ?></td>
                        <td>
                            <strong><?php echo htmlspecialchars($user['name'] ?? ''); ?></strong>
                        </td>
                        <td><?php echo htmlspecialchars($user['email'] ?? ''); ?></td>
                        <td>
                            <span style="background: <?php echo ($user['role'] ?? 'user') === 'admin' ? 'rgba(99, 102, 241, 0.3)' : 'rgba(99, 102, 241, 0.1)'; ?>; color: <?php echo ($user['role'] ?? 'user') === 'admin' ? '#93c5fd' : '#a0a0a0'; ?>; padding: 0.4rem 0.8rem; border-radius: 0.3rem; font-weight: 600; font-size: 0.85rem; display: inline-block;">
                                <?php echo strtoupper($user['role'] ?? 'user'); ?>
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
                        <td style="text-align: center;">
                            <a href="/admin/deleteUser/<?php echo $user['id']; ?>" onclick="return confirm('⚠️ Confirmer la suppression de cet utilisateur ?')" class="btn btn-danger" style="padding: 0.5rem 0.8rem; font-size: 0.85rem;">🗑️</a>
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
