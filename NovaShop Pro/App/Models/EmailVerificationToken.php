<?php
namespace App\Models;

use App\Core\Model;

class EmailVerificationToken extends Model
{
    /**
     * Créer un token de vérification pour un utilisateur
     */
    public function create(int $userId): string
    {
        // Générer un token sécurisé unique
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+24 hours'));
        
        try {
            $result = $this->run(
                "INSERT INTO email_verification_tokens (user_id, token, expires_at) VALUES (?, ?, ?)",
                [$userId, $token, $expiresAt]
            );
            
            if ($result <= 0) {
                throw new \Exception("Impossible d'insérer le token de vérification");
            }
        } catch (\Exception $e) {
            // Essayer via PDO direct pour diagnostic
            $stmt = $this->db->prepare(
                "INSERT INTO email_verification_tokens (user_id, token, expires_at) VALUES (?, ?, ?)"
            );
            $stmt->execute([$userId, $token, $expiresAt]);
        }
        
        return $token;
    }

    /**
     * Récupérer un token valide par sa valeur
     */
    public function getByToken(string $token): ?array
    {
        return $this->run(
            "SELECT * FROM email_verification_tokens 
             WHERE token = ? AND expires_at > NOW() LIMIT 1",
            [$token],
            true
        );
    }

    /**
     * Supprimer les tokens d'un utilisateur après vérification
     */
    public function deleteByUserId(int $userId): int
    {
        return $this->run(
            "DELETE FROM email_verification_tokens WHERE user_id = ?",
            [$userId]
        );
    }

    /**
     * Nettoyer les tokens expirés
     */
    public function deleteExpired(): int
    {
        return $this->run(
            "DELETE FROM email_verification_tokens WHERE expires_at < NOW()"
        );
    }
}
?>
