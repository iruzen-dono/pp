<div class="auth-container">
    <!-- Background Gradient -->
    <div class="auth-background"></div>

    <!-- Main Content -->
    <div class="auth-content">
        <!-- Card -->
        <div class="auth-card">
            <!-- Logo Header -->
            <div class="auth-header text-center mb-5">
                <div class="logo-wrapper mb-4">
                    <div class="logo-circle">◆</div>
                </div>
                <h1 class="auth-title">NovaShop Premium</h1>
                <p class="auth-subtitle">Se Connecter à votre compte</p>
            </div>

            <!-- Error Alert -->
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-circle-xmark me-2"></i>
                    <strong>Erreur !</strong> <?= htmlspecialchars($error) ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <!-- Login Form -->
            <form method="POST" id="loginForm">
                <?php echo '<input type="hidden" name="_csrf" value="' . htmlspecialchars(\App\Middleware\CsrfMiddleware::generateToken()) . '">'; ?>
                <!-- Email -->
                <div class="form-group mb-4">
                    <label for="email" class="form-label">
                        <i class="fas fa-envelope me-2"></i>Email
                    </label>
                    <input 
                        type="email" 
                        name="email" 
                        id="email" 
                        class="form-control form-control-lg" 
                        placeholder="vous@exemple.com"
                        autocomplete="email"
                        required
                    >
                </div>

                <!-- Password -->
                <div class="form-group mb-3">
                    <label for="password" class="form-label">
                        <i class="fas fa-lock me-2"></i>Mot de Passe
                    </label>
                    <div class="password-wrapper">
                        <input 
                            type="password" 
                            name="password" 
                            id="password" 
                            class="form-control form-control-lg" 
                            placeholder="Entrez votre mot de passe"
                            autocomplete="current-password"
                            required
                        >
                        <button 
                            type="button" 
                            class="btn-toggle-password" 
                            id="togglePassword"
                            tabindex="-1"
                        >
                            <i class="fas fa-eye"></i>
                        </button>
                    </div>
                </div>

                <!-- Remember & Forgot -->
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <div class="form-check">
                        <input 
                            type="checkbox" 
                            class="form-check-input" 
                            name="remember" 
                            id="remember"
                        >
                        <label class="form-check-label" for="remember">
                            Se souvenir de moi
                        </label>
                    </div>
                    <a href="/forgot" class="text-primary text-decoration-none fw-500">
                        <i class="fas fa-key me-1"></i>Mot de passe oublié ?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary btn-lg w-100 mb-4 fw-600">
                    <i class="fas fa-arrow-right-to-bracket me-2"></i>Se Connecter
                </button>
            </form>

            <!-- Divider -->
            <div class="divider mb-4">
                <span>ou continuer avec</span>
            </div>

            <!-- Social Buttons -->
            <div class="social-buttons">
                <button type="button" class="btn-social" title="Google">
                    <i class="fab fa-google"></i>
                </button>
                <button type="button" class="btn-social" title="GitHub">
                    <i class="fab fa-github"></i>
                </button>
                <button type="button" class="btn-social" title="Facebook">
                    <i class="fab fa-facebook-f"></i>
                </button>
            </div>

            <!-- Footer Link -->
            <div class="text-center mt-5 pt-4 border-top">
                <p class="text-muted mb-0">
                    Pas encore de compte ? 
                    <a href="/register" class="fw-600 text-primary text-decoration-none">
                        S'inscrire
                    </a>
                </p>
            </div>
        </div>

        <!-- Security Badge -->
        <div class="security-badge mt-4">
            <i class="fas fa-shield-alt"></i>
            <span>Connexion sécurisée</span>
        </div>
    </div>
</div>

<style>
.auth-container {
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    position: relative;
    overflow: hidden;
}

.auth-background {
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    z-index: -1;
}

.auth-content {
    width: 100%;
    /* Allow a wider layout on large screens while remaining responsive */
    max-width: 720px;
    padding: 20px;
}

.auth-card {
    background: white;
    border-radius: 20px;
    padding: 40px 36px;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
    backdrop-filter: blur(6px);
    /* keep the card reasonably narrow and centered inside the wider auth-content */
    max-width: 520px;
    margin: 0 auto;
}

.logo-circle {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 40px;
    color: white;
    margin: 0 auto;
    box-shadow: 0 10px 25px rgba(102, 126, 234, 0.3);
}

.auth-title {
    font-size: 28px;
    font-weight: 700;
    color: #1a1a1a;
    margin: 0;
}

.auth-subtitle {
    color: #6c757d;
    font-size: 16px;
    margin: 0;
}

.form-label {
    font-weight: 600;
    color: #333;
    margin-bottom: 8px;
    display: flex;
    align-items: center;
}

.form-control {
    border: 2px solid #e9ecef;
    border-radius: 12px;
    padding: 12px 16px;
    font-size: 16px;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: #667eea;
    box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
}

.password-wrapper {
    position: relative;
    display: flex;
}

.password-wrapper .form-control {
    flex: 1;
}

.btn-toggle-password {
    position: absolute;
    right: 15px;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: #667eea;
    cursor: pointer;
    font-size: 18px;
    padding: 0;
    width: 24px;
    height: 24px;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-toggle-password:hover {
    color: #764ba2;
}

.form-check-input {
    width: 20px;
    height: 20px;
    border-radius: 6px;
    border: 2px solid #e9ecef;
    cursor: pointer;
    margin-top: 3px;
}

.form-check-input:checked {
    background-color: #667eea;
    border-color: #667eea;
}

.btn-primary {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    border: none;
    border-radius: 12px;
    font-size: 16px;
    font-weight: 600;
    padding: 14px 28px;
    transition: all 0.3s ease;
}

.btn-primary:hover {
    transform: translateY(-2px);
    box-shadow: 0 12px 30px rgba(102, 126, 234, 0.35);
}

.btn-primary:active {
    transform: translateY(0);
}

.divider {
    display: flex;
    align-items: center;
    color: #999;
    font-size: 14px;
    gap: 15px;
}

.divider::before,
.divider::after {
    content: '';
    flex: 1;
    height: 1px;
    background: #e9ecef;
}

.social-buttons {
    display: flex;
    gap: 12px;
    justify-content: center;
}

.btn-social {
    width: 50px;
    height: 50px;
    border-radius: 12px;
    border: 2px solid #e9ecef;
    background: white;
    color: #667eea;
    font-size: 20px;
    cursor: pointer;
    display: flex;
    align-items: center;
    justify-content: center;
    transition: all 0.3s ease;
}

.btn-social:hover {
    border-color: #667eea;
    background: rgba(102, 126, 234, 0.05);
    transform: translateY(-3px);
}

.security-badge {
    text-align: center;
    color: rgba(255, 255, 255, 0.8);
    font-size: 14px;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 8px;
}

.alert {
    border: none;
    border-radius: 12px;
    border-left: 4px solid #dc3545;
    background: rgba(220, 53, 69, 0.1);
    color: #721c24;
}

@media (max-width: 768px) {
    .auth-card {
        padding: 40px 30px;
    }

    .auth-title {
        font-size: 24px;
    }

    .logo-circle {
        width: 70px;
        height: 70px;
        font-size: 35px;
    }
}
</style>

<script>
document.getElementById('togglePassword')?.addEventListener('click', function() {
    const input = document.getElementById('password');
    const icon = this.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
});

document.getElementById('loginForm')?.addEventListener('submit', function(e) {
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value;
    
    if (!email || !password) {
        e.preventDefault();
        alert('Veuillez remplir tous les champs');
    }
});
</script>
