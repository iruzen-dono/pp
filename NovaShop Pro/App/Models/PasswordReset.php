<?php
namespace App\Models;

use App\Core\Model;

class PasswordReset extends Model
{
    /**
     * Crée un token de reset pour un utilisateur
     */
    public function create(int $userId): string
    {
        $token = bin2hex(random_bytes(32));
        $expiresAt = date('Y-m-d H:i:s', strtotime('+2 hours'));

        try {
            $result = $this->run(
                "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)",
                [$userId, $token, $expiresAt]
            );

            if ($result <= 0) {
                throw new \Exception("Impossible d'insérer le token de reset");
            }
        } catch (\Exception $e) {
            // Détecter erreur de table absente ou autre problème DB
            $msg = $e->getMessage();
            $shouldCreate = false;

            if (isset($e->errorInfo[1]) && (int)$e->errorInfo[1] === 1146) {
                $shouldCreate = true;
            } elseif (
                stripos($msg, "doesn't exist") !== false ||
                stripos($msg, 'does not exist') !== false ||
                stripos($msg, 'Base table or view not found') !== false ||
                stripos($msg, 'SQLSTATE[42S02]') !== false ||
                (stripos($msg, 'Table') !== false && stripos($msg, 'not found') !== false)
            ) {
                $shouldCreate = true;
            }

            if ($shouldCreate) {
                $migrationPath = __DIR__ . '/../../migrate_password_resets.sql';
                if (file_exists($migrationPath)) {
                    $sql = file_get_contents($migrationPath);
                    try {
                        $this->db->exec($sql);
                    } catch (\Exception $innerEx) {
                        // DB creation failed (permissions?) — utiliser le fallback fichier
                        return $this->fallbackCreate($userId, $token, $expiresAt);
                    }

                    // Retry the insert after creating the table
                    $stmt = $this->db->prepare(
                        "INSERT INTO password_resets (user_id, token, expires_at) VALUES (?, ?, ?)"
                    );
                    $stmt->execute([$userId, $token, $expiresAt]);
                } else {
                    // Migration file missing — fallback to file storage
                    return $this->fallbackCreate($userId, $token, $expiresAt);
                }
            } else {
                // Other DB error — fallback
                return $this->fallbackCreate($userId, $token, $expiresAt);
            }
        }

        return $token;
    }

    /**
     * Récupérer un token valide
     */
    public function getByToken(string $token): ?array
    {
        try {
            $row = $this->run(
                "SELECT * FROM password_resets WHERE token = ? AND expires_at > NOW() LIMIT 1",
                [$token],
                true
            );
        } catch (\Exception $e) {
            // If DB unavailable, try fallback file storage
            $fb = $this->fallbackGetByToken($token);
            if ($fb) return $fb;

            // If exact token not found and token may be truncated, try prefix match in fallback
            if (strlen($token) < 64) {
                $fbPrefix = $this->fallbackFindByPrefix($token);
                if ($fbPrefix) return $fbPrefix;
            }

            return null;
        }

        // If DB query returned a row, return it
        if (!empty($row)) {
            return $row;
        }

        // If table exists but token not found in DB, try fallback file storage
        $fb = $this->fallbackGetByToken($token);
        if ($fb) return $fb;

        if (strlen($token) < 64) {
            $fbPrefix = $this->fallbackFindByPrefix($token);
            if ($fbPrefix) return $fbPrefix;
        }

        return null;
    }

    public function deleteByUserId(int $userId): int
    {
        try {
            return $this->run(
                "DELETE FROM password_resets WHERE user_id = ?",
                [$userId]
            );
        } catch (\Exception $e) {
            // Try to delete from fallback storage
            return $this->fallbackDeleteByUserId($userId);
        }
    }

    public function deleteByToken(string $token): int
    {
        try {
            return $this->run(
                "DELETE FROM password_resets WHERE token = ?",
                [$token]
            );
        } catch (\Exception $e) {
            return $this->fallbackDeleteByToken($token);
        }
    }

    public function deleteExpired(): int
    {
        try {
            return $this->run(
                "DELETE FROM password_resets WHERE expires_at < NOW()"
            );
        } catch (\Exception $e) {
            return $this->fallbackDeleteExpired();
        }
    }

    /**
     * File-based fallback storage for environments where DB migrations cannot be applied.
     */
    private function getFallbackPath(): string
    {
        $dir = __DIR__ . '/../../storage';
        if (!is_dir($dir)) {
            @mkdir($dir, 0755, true);
        }
        return $dir . '/password_resets.json';
    }

    private function fallbackCreate(int $userId, string $token, string $expiresAt): string
    {
        $path = $this->getFallbackPath();
        $data = [];
        if (file_exists($path)) {
            $raw = file_get_contents($path);
            $data = json_decode($raw, true) ?: [];
        }

        $entry = [
            'user_id' => $userId,
            'token' => $token,
            'expires_at' => $expiresAt,
            'created_at' => date('Y-m-d H:i:s')
        ];

        $data[] = $entry;
        @file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));

        return $token;
    }

    private function fallbackGetByToken(string $token): ?array
    {
        $path = $this->getFallbackPath();
        if (!file_exists($path)) return null;
        $raw = file_get_contents($path);
        $data = json_decode($raw, true) ?: [];

        foreach ($data as $entry) {
            if ($entry['token'] === $token) {
                // Check expiry
                if (strtotime($entry['expires_at']) > time()) {
                    return $entry;
                }
                return null;
            }
        }

        return null;
    }

    private function fallbackFindByPrefix(string $prefix): ?array
    {
        $path = $this->getFallbackPath();
        if (!file_exists($path)) return null;
        $raw = file_get_contents($path);
        $data = json_decode($raw, true) ?: [];

        $matches = [];
        foreach ($data as $entry) {
            if (stripos($entry['token'], $prefix) === 0) {
                if (strtotime($entry['expires_at']) > time()) {
                    $matches[] = $entry;
                }
            }
        }

        // If exactly one match, return it. Otherwise return null to avoid ambiguity.
        if (count($matches) === 1) return $matches[0];
        return null;
    }

    private function fallbackDeleteByUserId(int $userId): int
    {
        $path = $this->getFallbackPath();
        if (!file_exists($path)) return 0;
        $raw = file_get_contents($path);
        $data = json_decode($raw, true) ?: [];
        $before = count($data);
        $data = array_values(array_filter($data, function ($e) use ($userId) {
            return (int)$e['user_id'] !== $userId;
        }));
        @file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
        return $before - count($data);
    }

    private function fallbackDeleteByToken(string $token): int
    {
        $path = $this->getFallbackPath();
        if (!file_exists($path)) return 0;
        $raw = file_get_contents($path);
        $data = json_decode($raw, true) ?: [];
        $before = count($data);
        $data = array_values(array_filter($data, function ($e) use ($token) {
            return $e['token'] !== $token;
        }));
        @file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
        return $before - count($data);
    }

    private function fallbackDeleteExpired(): int
    {
        $path = $this->getFallbackPath();
        if (!file_exists($path)) return 0;
        $raw = file_get_contents($path);
        $data = json_decode($raw, true) ?: [];
        $before = count($data);
        $now = time();
        $data = array_values(array_filter($data, function ($e) use ($now) {
            return strtotime($e['expires_at']) > $now;
        }));
        @file_put_contents($path, json_encode($data, JSON_PRETTY_PRINT));
        return $before - count($data);
    }
}
?>
