<div class="admin-products" style="max-width: 1000px; margin: 0 auto;">
    <a href="/admin/dashboard" class="btn btn-secondary" style="margin-bottom: 20px;">← Retour au dashboard</a>

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 30px;">
        <h1>📦 Gestion des produits</h1>
        <button class="btn btn-primary" onclick="alert('Ajouter un produit - À venir')">➕ Ajouter un produit</button>
    </div>

    <div style="background: var(--secondary-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-top: 20px;">
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Stock</th>
                    <th>Catégorie</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>1</td>
                    <td>Laptop Pro 15"</td>
                    <td><span style="color: var(--success-color); font-weight: bold;">1299.99€</span></td>
                    <td><span style="background: #4caf50; color: white; padding: 4px 8px; border-radius: 3px;">15</span></td>
                    <td>Électronique</td>
                    <td>
                        <a href="#" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px; margin-right: 5px;">Éditer</a>
                        <a href="#" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">Supprimer</a>
                    </td>
                </tr>
                <tr>
                    <td>2</td>
                    <td>Souris Wireless</td>
                    <td><span style="color: var(--success-color); font-weight: bold;">29.99€</span></td>
                    <td><span style="background: #4caf50; color: white; padding: 4px 8px; border-radius: 3px;">50</span></td>
                    <td>Électronique</td>
                    <td>
                        <a href="#" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px; margin-right: 5px;">Éditer</a>
                        <a href="#" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">Supprimer</a>
                    </td>
                </tr>
                <tr>
                    <td>3</td>
                    <td>T-Shirt NovaShop</td>
                    <td><span style="color: var(--success-color); font-weight: bold;">19.99€</span></td>
                    <td><span style="background: #4caf50; color: white; padding: 4px 8px; border-radius: 3px;">100</span></td>
                    <td>Vêtements</td>
                    <td>
                        <a href="#" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px; margin-right: 5px;">Éditer</a>
                        <a href="#" class="btn btn-danger" style="padding: 6px 12px; font-size: 12px;">Supprimer</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <p style="color: #aaa; font-size: 14px; margin-top: 20px;">📌 Fonctionnalités avancées (CRUD complet) à venir</p>
</div>
