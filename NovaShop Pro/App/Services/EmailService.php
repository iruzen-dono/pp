<?php
namespace App\Services;

class EmailService
{
    private static $from_email = 'noreply@novashop.local';
    private static $from_name = 'NovaShop Pro';

    /**
     * Envoyer un email de vérification
     * En mode développement, affiche le lien dans les logs
     */
    public static function sendVerificationEmail(string $email, string $token, string $userName): bool
    {
        $verificationLink = "http://localhost:8000/verify-email?token=" . urlencode($token);
        
        $subject = "Confirmez votre adresse email - NovaShop Pro";
        
        $htmlBody = self::getVerificationEmailTemplate($userName, $verificationLink);
        
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-type: text/html; charset=UTF-8\r\n";
        $headers .= "From: " . self::$from_name . " <" . self::$from_email . ">\r\n";
        
        // En développement, on va afficher le lien dans un fichier log
        $logFile = __DIR__ . '/../../logs/email_verification.log';
        @mkdir(dirname($logFile), 0755, true);
        
        $logMessage = sprintf(
            "[%s] Email à: %s | Token: %s | Lien: %s\n",
            date('Y-m-d H:i:s'),
            $email,
            $token,
            $verificationLink
        );
        @file_put_contents($logFile, $logMessage, FILE_APPEND);
        
        // Essayer d'envoyer l'email réel (va échouer localement mais c'est OK)
        // En production, il faut configurer PHP pour utiliser sendmail ou SMTP
        // @mail($email, $subject, $htmlBody, $headers);
        
        return true;
    }

    /**
     * Envoyer un email de réinitialisation de mot de passe (mode dev: log)
     */
    public static function sendPasswordResetEmail(string $email, string $token, string $userName): bool
    {
        $resetLink = "http://localhost:8000/reset-password?token=" . urlencode($token);

        $subject = "Réinitialisation de votre mot de passe - NovaShop Pro";

        $htmlBody = self::getPasswordResetTemplate($userName, $resetLink);

        // Log to file in dev
        $logFile = __DIR__ . '/../../logs/email_password_reset.log';
        @mkdir(dirname($logFile), 0755, true);

        $logMessage = sprintf(
            "[%s] Email à: %s | Token: %s | Lien: %s\n",
            date('Y-m-d H:i:s'),
            $email,
            $token,
            $resetLink
        );
        @file_put_contents($logFile, $logMessage, FILE_APPEND);

        return true;
    }

    private static function getPasswordResetTemplate(string $userName, string $resetLink): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Réinitialisation de mot de passe - NovaShop Pro</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; background: white; border-radius: 8px; }
                .header { background: linear-gradient(135deg, #d4a574, #c59461); padding: 30px; text-align: center; border-radius: 8px; }
                .header h1 { color: white; margin: 0; font-size: 24px; }
                .content { padding: 30px 0; }
                .content p { color: #333; line-height: 1.6; margin: 15px 0; }
                .button { display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #d4a574, #c59461); color: white; text-decoration: none; border-radius: 6px; margin: 20px 0; font-weight: bold; }
                .footer { background: #f9f9f9; padding: 20px; text-align: center; color: #999; font-size: 12px; border-top: 1px solid #eee; }
                .warning { background: #fff3cd; padding: 15px; border-radius: 6px; border-left: 4px solid #ffc107; margin: 20px 0; color: #856404; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>Réinitialisation de votre mot de passe</h1>
                </div>

                <div class="content">
                    <p>Bonjour <strong>$userName</strong>,</p>

                    <p>Vous avez demandé à réinitialiser votre mot de passe. Cliquez sur le bouton ci-dessous pour choisir un nouveau mot de passe:</p>

                    <center>
                        <a href="$resetLink" class="button">Réinitialiser mon mot de passe</a>
                    </center>

                    <p>Ou copiez-collez ce lien dans votre navigateur:</p>
                    <p style="background: #f5f5f5; padding: 10px; border-radius: 4px; word-break: break-all; font-size: 12px; color: #666;">
                        $resetLink
                    </p>

                    <div class="warning">
                        <strong>⏰ Attention:</strong> Ce lien expire dans <strong>2 heures</strong>. S'il n'est plus valide, recommencez la procédure.
                    </div>

                    <p>Si vous n'avez pas demandé cette réinitialisation, ignorez cet email.</p>

                    <p>Cordialement,<br>L'équipe NovaShop Pro</p>
                </div>

                <div class="footer">
                    <p>© 2026 NovaShop Pro. Tous droits réservés.</p>
                </div>
            </div>
        </body>
        </html>
        HTML;
    }

    /**
     * Template d'email de vérification
     */
    private static function getVerificationEmailTemplate(string $userName, string $verificationLink): string
    {
        return <<<HTML
        <!DOCTYPE html>
        <html lang="fr">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Confirmez votre email - NovaShop Pro</title>
            <style>
                body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background: #f5f5f5; }
                .container { max-width: 600px; margin: 0 auto; padding: 20px; background: white; border-radius: 8px; }
                .header { background: linear-gradient(135deg, #d4a574, #c59461); padding: 30px; text-align: center; border-radius: 8px; }
                .header h1 { color: white; margin: 0; font-size: 24px; }
                .content { padding: 30px 0; }
                .content p { color: #333; line-height: 1.6; margin: 15px 0; }
                .button { display: inline-block; padding: 12px 30px; background: linear-gradient(135deg, #d4a574, #c59461); color: white; text-decoration: none; border-radius: 6px; margin: 20px 0; font-weight: bold; }
                .footer { background: #f9f9f9; padding: 20px; text-align: center; color: #999; font-size: 12px; border-top: 1px solid #eee; }
                .warning { background: #fff3cd; padding: 15px; border-radius: 6px; border-left: 4px solid #ffc107; margin: 20px 0; color: #856404; }
            </style>
        </head>
        <body>
            <div class="container">
                <div class="header">
                    <h1>🎉 Bienvenue sur NovaShop Pro</h1>
                </div>
                
                <div class="content">
                    <p>Bonjour <strong>$userName</strong>,</p>
                    
                    <p>Merci de votre inscription! Avant de pouvoir accéder à votre compte, veuillez confirmer votre adresse email en cliquant sur le bouton ci-dessous:</p>
                    
                    <center>
                        <a href="$verificationLink" class="button">✓ Confirmer mon email</a>
                    </center>
                    
                    <p>Ou copiez-collez ce lien dans votre navigateur:</p>
                    <p style="background: #f5f5f5; padding: 10px; border-radius: 4px; word-break: break-all; font-size: 12px; color: #666;">
                        $verificationLink
                    </p>
                    
                    <div class="warning">
                        <strong>⏰ Attention:</strong> Ce lien d'activation expire dans <strong>24 heures</strong>. Après cela, vous devrez vous réinscrire.
                    </div>
                    
                    <p>Si vous n'avez pas créé de compte NovaShop Pro, vous pouvez ignorer cet email en toute sécurité.</p>
                    
                    <p>Cordialement,<br>L'équipe NovaShop Pro</p>
                </div>
                
                <div class="footer">
                    <p>© 2026 NovaShop Pro. Tous droits réservés.</p>
                    <p>Cet email a été envoyé à l'adresse associée à votre compte.</p>
                </div>
            </div>
        </body>
        </html>
        HTML;
    }
}
?>
