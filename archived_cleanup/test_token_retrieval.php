<?php
// Via la requête web directement
$token = 'c3ac186f187830046c8a3331830a85457d496f3589c66b6944b996408f96777e';

// Charger le fichier pour inclure la config
include 'Public/index.php';

// Cette inclusion a chargé l'app, maintenant vérifions la BD
$model = new \App\Models\EmailVerificationToken();
$result = $model->getByToken($token);

echo "Résultat pour token: c3ac186f187830046c8a3331830a85457d496f3589c66b6944b996408f96777e\n";
echo "getByToken() retourne: " . var_export($result, true) . "\n";

if (!$result) {
    echo "\n❌ Le token n'a pas été trouvé!\n";
    echo "\nCela signifie que soit:\n";
    echo "1. Le token n'a jamais été inséré en base\n";
    echo "2. Le token a expiré (+ de 24h)\n";
    echo "3. Le token a été supprimé\n";
} else {
    echo "\n✅ Token trouvé!\n";
    echo "user_id: " . $result['user_id'] . "\n";
    echo "expires_at: " . $result['expires_at'] . "\n";
}
