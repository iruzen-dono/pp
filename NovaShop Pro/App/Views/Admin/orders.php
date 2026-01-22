<div class="admin-orders" style="max-width: 1000px; margin: 0 auto;">
    <a href="/admin/dashboard" class="btn btn-secondary" style="margin-bottom: 20px;">← Retour au dashboard</a>

    <h1>📋 Gestion des commandes</h1>

    <div style="background: var(--secondary-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-top: 20px;">
        <table>
            <thead>
                <tr>
                    <th>Commande</th>
                    <th>Client</th>
                    <th>Total</th>
                    <th>Statut</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><strong>#1</strong></td>
                    <td>Jean Dupont</td>
                    <td><span style="color: var(--success-color); font-weight: bold;">179.97€</span></td>
                    <td><span style="background: #ffc107; color: #000; padding: 4px 8px; border-radius: 3px; font-weight: bold;">⏳ En attente</span></td>
                    <td>22/01/2026</td>
                    <td>
                        <a href="#" class="btn btn-secondary" style="padding: 6px 12px; font-size: 12px; margin-right: 5px;">Détails</a>
                        <a href="#" class="btn btn-primary" style="padding: 6px 12px; font-size: 12px;">Mettre à jour</a>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>

    <div style="background: var(--secondary-color); border: 1px solid var(--border-color); border-radius: 8px; padding: 20px; margin-top: 30px;">
        <h3>📊 Résumé des commandes</h3>
        <div style="display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 15px; margin-top: 15px;">
            <div style="text-align: center;">
                <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">EN ATTENTE</p>
                <p style="font-size: 24px; color: #ffc107; font-weight: bold;">1</p>
            </div>
            <div style="text-align: center;">
                <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">COMPLÉTÉES</p>
                <p style="font-size: 24px; color: #4caf50; font-weight: bold;">0</p>
            </div>
            <div style="text-align: center;">
                <p style="color: #aaa; font-size: 14px; margin-bottom: 5px;">TOTAL REVENUS</p>
                <p style="font-size: 24px; color: var(--success-color); font-weight: bold;">179.97€</p>
            </div>
        </div>
    </div>
</div>
