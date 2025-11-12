<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: index');
    exit;
}

$auth = new Auth();
$page_title = 'Area Cliente - Accesso';
$page_description = 'Accedi alla tua area personale per gestire ordini e preferenze.';

// Handle form submission
$error_message = '';
$success_message = '';

if ($_POST) {
    $csrf_valid = verifyCSRFToken($_POST['csrf_token'] ?? '');
    
    if (!$csrf_valid) {
        $error_message = 'Token di sicurezza non valido. Ricarica la pagina.';
    } else {
        $email = sanitizeInput($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $remember = isset($_POST['remember']);
        
        if (empty($email) || empty($password)) {
            $error_message = 'Email e password sono obbligatori.';
        } else {
            $result = $auth->login($email, $password, $remember);
            
            if ($result['success']) {
                // Redirect to intended page or dashboard
                $redirect = $_GET['redirect'] ?? 'index';
                header("Location: $redirect");
                exit;
            } else {
                $error_message = $result['message'];
            }
        }
    }
}

include '../includes/header.php';
?>

<main class="auth-page">
    <div class="auth-container">
        <div class="auth-wrapper">
            <!-- Left side - Brand info -->
            <div class="auth-brand">
                <div class="brand-content">
                    <div class="brand-logo">
                        <h2>AG SERVIZI</h2>
                        <p>VIA PLINIO 72</p>
                    </div>
                    
                    <div class="brand-info">
                        <h3>Benvenuto nell'Area Cliente</h3>
                        <p>Accedi al tuo account per gestire ordini, preferiti e impostazioni personali.</p>
                        
                        <div class="features-list">
                            <div class="feature">
                                <i class="icon-check"></i>
                                <span>Gestione ordini e fatture</span>
                            </div>
                            <div class="feature">
                                <i class="icon-check"></i>
                                <span>Lista preferiti personalizzata</span>
                            </div>
                            <div class="feature">
                                <i class="icon-check"></i>
                                <span>Supporto clienti dedicato</span>
                            </div>
                            <div class="feature">
                                <i class="icon-check"></i>
                                <span>Notifiche e aggiornamenti</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="brand-footer">
                    <p>Non hai ancora un account?</p>
                    <a href="register" class="btn btn-outline-light">
                        <i class="icon-user-plus"></i> Registrati
                    </a>
                </div>
            </div>
            
            <!-- Right side - Login form -->
            <div class="auth-form">
                <div class="form-container">
                    <div class="form-header">
                        <h1>Accedi al tuo Account</h1>
                        <p>Inserisci le tue credenziali per continuare</p>
                    </div>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-error">
                            <i class="icon-alert-circle"></i>
                            <?= htmlspecialchars($error_message) ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($success_message): ?>
                        <div class="alert alert-success">
                            <i class="icon-check-circle"></i>
                            <?= htmlspecialchars($success_message) ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="login-form" id="loginForm">
                        <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                        
                        <div class="form-group">
                            <label for="email">
                                <i class="icon-mail"></i>
                                Email
                            </label>
                            <input type="email" 
                                   id="email" 
                                   name="email" 
                                   value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
                                   required
                                   autocomplete="email"
                                   placeholder="La tua email">
                        </div>
                        
                        <div class="form-group">
                            <label for="password">
                                <i class="icon-lock"></i>
                                Password
                            </label>
                            <div class="password-input">
                                <input type="password" 
                                       id="password" 
                                       name="password" 
                                       required
                                       autocomplete="current-password"
                                       placeholder="La tua password">
                                <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                    <i class="icon-eye"></i>
                                </button>
                            </div>
                        </div>
                        
                        <div class="form-options">
                            <label class="checkbox-label">
                                <input type="checkbox" name="remember" <?= isset($_POST['remember']) ? 'checked' : '' ?>>
                                <span class="checkmark"></span>
                                Ricordami per 30 giorni
                            </label>
                            
                            <a href="password-dimenticata" class="forgot-link">
                                Password dimenticata?
                            </a>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="icon-log-in"></i>
                            <span>Accedi</span>
                            <div class="btn-loader" style="display: none;">
                                <div class="spinner"></div>
                            </div>
                        </button>
                    </form>
                    
                    <div class="form-divider">
                        <span>oppure</span>
                    </div>
                    
                    <div class="social-login">
                        <button class="btn btn-social btn-google" onclick="socialLogin('google')">
                            <i class="icon-google"></i>
                            Continua con Google
                        </button>
                        
                        <button class="btn btn-social btn-facebook" onclick="socialLogin('facebook')">
                            <i class="icon-facebook"></i>
                            Continua con Facebook
                        </button>
                    </div>
                    
                    <div class="form-footer">
                        <p>
                            Non hai un account? 
                            <a href="register">Registrati gratuitamente</a>
                        </p>
                        
                        <div class="help-links">
                            <a href="../contatti">Supporto</a>
                            <span>•</span>
                            <a href="../privacy-policy">Privacy</a>
                            <span>•</span>
                            <a href="../termini-servizio">Termini</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>

<style>
.auth-page {
    min-height: 100vh;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem 1rem;
}

.auth-container {
    width: 100%;
    max-width: 1200px;
}

.auth-wrapper {
    display: grid;
    grid-template-columns: 1fr 1fr;
    background: white;
    border-radius: 20px;
    box-shadow: 0 20px 60px rgba(0,0,0,0.2);
    overflow: hidden;
    min-height: 600px;
}

.auth-brand {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 3rem;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    position: relative;
}

.auth-brand::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="white" opacity="0.1"/><circle cx="75" cy="75" r="1" fill="white" opacity="0.1"/><circle cx="50" cy="10" r="0.5" fill="white" opacity="0.05"/><circle cx="10" cy="60" r="0.5" fill="white" opacity="0.05"/><circle cx="90" cy="40" r="0.5" fill="white" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
}

.brand-content {
    position: relative;
    z-index: 2;
}

.brand-logo h2 {
    font-size: 2.5rem;
    font-weight: 800;
    margin: 0 0 0.5rem 0;
    background: linear-gradient(45deg, #fff, #ffbf00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.brand-logo p {
    font-size: 1.2rem;
    font-weight: 300;
    opacity: 0.9;
    margin: 0 0 3rem 0;
    letter-spacing: 2px;
}

.brand-info h3 {
    font-size: 1.8rem;
    font-weight: 600;
    margin: 0 0 1rem 0;
}

.brand-info > p {
    font-size: 1.1rem;
    line-height: 1.6;
    opacity: 0.9;
    margin: 0 0 2rem 0;
}

.features-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.feature {
    display: flex;
    align-items: center;
    gap: 1rem;
    font-size: 1rem;
}

.feature i {
    width: 1.5rem;
    height: 1.5rem;
    background: rgba(255, 255, 255, 0.2);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
}

.brand-footer {
    position: relative;
    z-index: 2;
    text-align: center;
}

.brand-footer p {
    margin: 0 0 1rem 0;
    opacity: 0.9;
}

.auth-form {
    padding: 3rem;
    display: flex;
    align-items: center;
}

.form-container {
    width: 100%;
    max-width: 400px;
    margin: 0 auto;
}

.form-header {
    text-align: center;
    margin-bottom: 2rem;
}

.form-header h1 {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-color);
    margin: 0 0 0.5rem 0;
}

.form-header p {
    color: var(--text-muted);
    font-size: 1rem;
    margin: 0;
}

.login-form {
    margin-bottom: 2rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-group input {
    width: 100%;
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    font-size: 1rem;
    transition: all 0.3s ease;
    background: white;
}

.form-group input:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(var(--primary-color-rgb), 0.1);
}

.password-input {
    position: relative;
}

.toggle-password {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
    background: none;
    border: none;
    color: var(--text-muted);
    cursor: pointer;
    font-size: 1.2rem;
    transition: color 0.3s ease;
}

.toggle-password:hover {
    color: var(--primary-color);
}

.form-options {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.checkbox-label {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--text-color);
    position: relative;
}

.checkbox-label input {
    opacity: 0;
    position: absolute;
    width: 0;
    height: 0;
}

.checkmark {
    width: 18px;
    height: 18px;
    border: 2px solid var(--border-color);
    border-radius: 4px;
    position: relative;
    transition: all 0.3s ease;
}

.checkbox-label input:checked + .checkmark {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.checkbox-label input:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    color: white;
    font-size: 12px;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.forgot-link {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.9rem;
    font-weight: 500;
    transition: color 0.3s ease;
}

.forgot-link:hover {
    color: var(--primary-dark);
}

.btn-large {
    width: 100%;
    padding: 1.25rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    position: relative;
    overflow: hidden;
}

.btn-loader {
    position: absolute;
    right: 1rem;
    top: 50%;
    transform: translateY(-50%);
}

.spinner {
    width: 20px;
    height: 20px;
    border: 2px solid rgba(255,255,255,0.3);
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

.form-divider {
    text-align: center;
    margin: 2rem 0;
    position: relative;
}

.form-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 0;
    right: 0;
    height: 1px;
    background: var(--border-color);
}

.form-divider span {
    background: white;
    color: var(--text-muted);
    padding: 0 1rem;
    font-size: 0.9rem;
    position: relative;
}

.social-login {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.btn-social {
    width: 100%;
    padding: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.75rem;
    border-radius: 12px;
    font-weight: 600;
    transition: all 0.3s ease;
}

.btn-google {
    background: white;
    color: #333;
    border: 2px solid #ddd;
}

.btn-google:hover {
    background: #f8f9fa;
    border-color: #ccc;
    transform: translateY(-2px);
}

.btn-facebook {
    background: #1877f2;
    color: white;
    border: 2px solid #1877f2;
}

.btn-facebook:hover {
    background: #166fe5;
    transform: translateY(-2px);
}

.form-footer {
    text-align: center;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

.form-footer p {
    margin: 0 0 1rem 0;
    color: var(--text-muted);
}

.form-footer a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    transition: color 0.3s ease;
}

.form-footer a:hover {
    color: var(--primary-dark);
}

.help-links {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.help-links a {
    color: var(--text-muted);
    text-decoration: none;
    transition: color 0.3s ease;
}

.help-links a:hover {
    color: var(--primary-color);
}

.help-links span {
    margin: 0 0.5rem;
    opacity: 0.5;
}

@media (max-width: 768px) {
    .auth-wrapper {
        grid-template-columns: 1fr;
    }
    
    .auth-brand {
        padding: 2rem;
        order: 2;
    }
    
    .auth-form {
        padding: 2rem;
        order: 1;
    }
    
    .brand-logo h2 {
        font-size: 2rem;
    }
    
    .form-options {
        flex-direction: column;
        gap: 1rem;
        align-items: flex-start;
    }
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}

@keyframes slideIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.form-container {
    animation: slideIn 0.6s ease;
}
</style>

<script>
// Login form functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeLoginForm();
});

function initializeLoginForm() {
    const form = document.getElementById('loginForm');
    const submitBtn = form.querySelector('button[type="submit"]');
    
    form.addEventListener('submit', function(e) {
        // Show loading state
        const btnText = submitBtn.querySelector('span');
        const btnLoader = submitBtn.querySelector('.btn-loader');
        
        btnText.style.display = 'none';
        btnLoader.style.display = 'block';
        submitBtn.disabled = true;
        
        // Form will submit normally, but we show loading state
        setTimeout(() => {
            if (document.querySelector('.alert-error')) {
                btnText.style.display = 'block';
                btnLoader.style.display = 'none';
                submitBtn.disabled = false;
            }
        }, 100);
    });
    
    // Auto-focus first input
    const emailInput = document.getElementById('email');
    if (emailInput && !emailInput.value) {
        emailInput.focus();
    }
    
    // Enhanced form validation
    addFormValidation(form);
}

function togglePassword(inputId) {
    const input = document.getElementById(inputId);
    const toggleBtn = input.nextElementSibling;
    const icon = toggleBtn.querySelector('i');
    
    if (input.type === 'password') {
        input.type = 'text';
        icon.className = 'icon-eye-off';
    } else {
        input.type = 'password';
        icon.className = 'icon-eye';
    }
}

function addFormValidation(form) {
    const inputs = form.querySelectorAll('input[required]');
    
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
        
        input.addEventListener('input', function() {
            if (this.classList.contains('error')) {
                validateField(this);
            }
        });
    });
}

function validateField(input) {
    const value = input.value.trim();
    const type = input.type;
    
    // Remove existing error state
    input.classList.remove('error');
    const existingError = input.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    let error = '';
    
    if (!value) {
        error = 'Questo campo è obbligatorio';
    } else if (type === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            error = 'Inserisci un indirizzo email valido';
        }
    } else if (input.name === 'password' && value.length < 6) {
        error = 'La password deve contenere almeno 6 caratteri';
    }
    
    if (error) {
        input.classList.add('error');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = error;
        input.parentNode.appendChild(errorDiv);
        return false;
    }
    
    return true;
}

function socialLogin(provider) {
    // Placeholder for social login implementation
    AgenziaPlinio.showToast(`Login con ${provider} non ancora implementato`, 'info');
}

// Add error styling
document.head.insertAdjacentHTML('beforeend', `
<style>
.form-group input.error {
    border-color: var(--error-color);
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}

.field-error {
    color: var(--error-color);
    font-size: 0.85rem;
    margin-top: 0.5rem;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.field-error::before {
    content: '⚠';
    font-size: 0.9rem;
}
</style>
`);
</script>

<?php include '../includes/footer.php'; ?>