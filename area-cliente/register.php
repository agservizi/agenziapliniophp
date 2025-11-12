<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header('Location: index');
    exit;
}

$auth = new Auth();
$page_title = 'Registrazione - Crea il tuo Account';
$page_description = 'Registrati gratuitamente per accedere a tutti i servizi e vantaggi esclusivi.';

// Handle form submission
$error_message = '';
$success_message = '';
$form_data = [];

if ($_POST) {
    $csrf_valid = verifyCSRFToken($_POST['csrf_token'] ?? '');
    
    if (!$csrf_valid) {
        $error_message = 'Token di sicurezza non valido. Ricarica la pagina.';
    } else {
        // Sanitize and store form data
        $form_data = [
            'nome' => sanitizeInput($_POST['nome'] ?? ''),
            'cognome' => sanitizeInput($_POST['cognome'] ?? ''),
            'email' => sanitizeInput($_POST['email'] ?? ''),
            'telefono' => sanitizeInput($_POST['telefono'] ?? ''),
            'password' => $_POST['password'] ?? '',
            'password_confirm' => $_POST['password_confirm'] ?? '',
            'privacy_accepted' => isset($_POST['privacy_accepted']),
            'marketing_accepted' => isset($_POST['marketing_accepted'])
        ];
        
        // Basic validation
        $errors = [];
        
        if (empty($form_data['nome'])) {
            $errors['nome'] = 'Il nome è obbligatorio';
        } elseif (strlen($form_data['nome']) < 2) {
            $errors['nome'] = 'Il nome deve contenere almeno 2 caratteri';
        }
        
        if (empty($form_data['cognome'])) {
            $errors['cognome'] = 'Il cognome è obbligatorio';
        } elseif (strlen($form_data['cognome']) < 2) {
            $errors['cognome'] = 'Il cognome deve contenere almeno 2 caratteri';
        }
        
        if (empty($form_data['email'])) {
            $errors['email'] = 'L\'email è obbligatoria';
        } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Formato email non valido';
        }
        
        if (empty($form_data['password'])) {
            $errors['password'] = 'La password è obbligatoria';
        } elseif (strlen($form_data['password']) < 8) {
            $errors['password'] = 'La password deve contenere almeno 8 caratteri';
        } elseif (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $form_data['password'])) {
            $errors['password'] = 'La password deve contenere almeno una maiuscola, una minuscola e un numero';
        }
        
        if ($form_data['password'] !== $form_data['password_confirm']) {
            $errors['password_confirm'] = 'Le password non corrispondono';
        }
        
        if (!empty($form_data['telefono']) && !preg_match('/^[0-9+\-\s]{8,20}$/', $form_data['telefono'])) {
            $errors['telefono'] = 'Numero di telefono non valido';
        }
        
        if (!$form_data['privacy_accepted']) {
            $errors['privacy_accepted'] = 'Devi accettare la privacy policy per continuare';
        }
        
        if (empty($errors)) {
            // Attempt registration
            $result = $auth->register($form_data);
            
            if ($result['success']) {
                $success_message = $result['message'];
                $form_data = []; // Clear form on success
            } else {
                $error_message = $result['message'];
                if (isset($result['errors'])) {
                    $errors = array_merge($errors, $result['errors']);
                }
            }
        } else {
            $error_message = 'Controlla i campi evidenziati e riprova.';
        }
    }
}

include '../includes/header.php';
?>

<main class="auth-page register-page">
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
                        <h3>Unisciti alla nostra Community</h3>
                        <p>Crea un account gratuito e scopri tutti i vantaggi esclusivi riservati ai nostri clienti.</p>
                        
                        <div class="features-list">
                            <div class="feature">
                                <i class="icon-gift"></i>
                                <span>Offerte e sconti esclusivi</span>
                            </div>
                            <div class="feature">
                                <i class="icon-truck"></i>
                                <span>Spedizioni gratuite priority</span>
                            </div>
                            <div class="feature">
                                <i class="icon-award"></i>
                                <span>Programma fedeltà premium</span>
                            </div>
                            <div class="feature">
                                <i class="icon-headphones"></i>
                                <span>Supporto clienti 24/7</span>
                            </div>
                            <div class="feature">
                                <i class="icon-bell"></i>
                                <span>Notifiche personalizzate</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="brand-footer">
                    <p>Hai già un account?</p>
                    <a href="login" class="btn btn-outline-light">
                        <i class="icon-log-in"></i> Accedi
                    </a>
                </div>
            </div>
            
            <!-- Right side - Registration form -->
            <div class="auth-form">
                <div class="form-container">
                    <div class="form-header">
                        <h1>Crea il tuo Account</h1>
                        <p>Bastano pochi minuti per iniziare</p>
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
                            <p style="margin-top: 1rem;">
                                <a href="login" class="btn btn-primary">Accedi al tuo account</a>
                            </p>
                        </div>
                    <?php else: ?>
                    
                    <form method="POST" class="register-form" id="registerForm">
                        <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                        
                        <!-- Personal Information -->
                        <div class="form-section">
                            <h3><i class="icon-user"></i> Informazioni Personali</h3>
                            
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="nome">Nome *</label>
                                    <input type="text" 
                                           id="nome" 
                                           name="nome" 
                                           value="<?= htmlspecialchars($form_data['nome'] ?? '') ?>"
                                           required
                                           autocomplete="given-name"
                                           placeholder="Il tuo nome"
                                           class="<?= isset($errors['nome']) ? 'error' : '' ?>">
                                    <?php if (isset($errors['nome'])): ?>
                                        <span class="field-error"><?= htmlspecialchars($errors['nome']) ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <div class="form-group">
                                    <label for="cognome">Cognome *</label>
                                    <input type="text" 
                                           id="cognome" 
                                           name="cognome" 
                                           value="<?= htmlspecialchars($form_data['cognome'] ?? '') ?>"
                                           required
                                           autocomplete="family-name"
                                           placeholder="Il tuo cognome"
                                           class="<?= isset($errors['cognome']) ? 'error' : '' ?>">
                                    <?php if (isset($errors['cognome'])): ?>
                                        <span class="field-error"><?= htmlspecialchars($errors['cognome']) ?></span>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Contact Information -->
                        <div class="form-section">
                            <h3><i class="icon-mail"></i> Contatti</h3>
                            
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                                       required
                                       autocomplete="email"
                                       placeholder="la.tua@email.com"
                                       class="<?= isset($errors['email']) ? 'error' : '' ?>">
                                <?php if (isset($errors['email'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['email']) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="tel" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="<?= htmlspecialchars($form_data['telefono'] ?? '') ?>"
                                       autocomplete="tel"
                                       placeholder="+39 123 456 7890"
                                       class="<?= isset($errors['telefono']) ? 'error' : '' ?>">
                                <?php if (isset($errors['telefono'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['telefono']) ?></span>
                                <?php endif; ?>
                                <small class="field-help">Opzionale - per aggiornamenti sui tuoi ordini</small>
                            </div>
                        </div>
                        
                        <!-- Security -->
                        <div class="form-section">
                            <h3><i class="icon-lock"></i> Sicurezza</h3>
                            
                            <div class="form-group">
                                <label for="password">Password *</label>
                                <div class="password-input">
                                    <input type="password" 
                                           id="password" 
                                           name="password" 
                                           required
                                           autocomplete="new-password"
                                           placeholder="Crea una password sicura"
                                           class="<?= isset($errors['password']) ? 'error' : '' ?>">
                                    <button type="button" class="toggle-password" onclick="togglePassword('password')">
                                        <i class="icon-eye"></i>
                                    </button>
                                </div>
                                <?php if (isset($errors['password'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['password']) ?></span>
                                <?php endif; ?>
                                <div class="password-strength" id="passwordStrength">
                                    <div class="strength-meter">
                                        <div class="strength-fill"></div>
                                    </div>
                                    <small class="strength-text">Inserisci almeno 8 caratteri</small>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label for="password_confirm">Conferma Password *</label>
                                <div class="password-input">
                                    <input type="password" 
                                           id="password_confirm" 
                                           name="password_confirm" 
                                           required
                                           autocomplete="new-password"
                                           placeholder="Ripeti la password"
                                           class="<?= isset($errors['password_confirm']) ? 'error' : '' ?>">
                                    <button type="button" class="toggle-password" onclick="togglePassword('password_confirm')">
                                        <i class="icon-eye"></i>
                                    </button>
                                </div>
                                <?php if (isset($errors['password_confirm'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['password_confirm']) ?></span>
                                <?php endif; ?>
                            </div>
                        </div>
                        
                        <!-- Terms and Conditions -->
                        <div class="form-section">
                            <h3><i class="icon-shield-check"></i> Consensi</h3>
                            
                            <div class="checkbox-group">
                                <label class="checkbox-label <?= isset($errors['privacy_accepted']) ? 'error' : '' ?>">
                                    <input type="checkbox" 
                                           name="privacy_accepted" 
                                           <?= ($form_data['privacy_accepted'] ?? false) ? 'checked' : '' ?>
                                           required>
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">
                                        Ho letto e accetto la 
                                        <a href="../privacy-policy" target="_blank">Privacy Policy</a> e i 
                                        <a href="../termini-servizio" target="_blank">Termini di Servizio</a> *
                                    </span>
                                </label>
                                <?php if (isset($errors['privacy_accepted'])): ?>
                                    <span class="field-error"><?= htmlspecialchars($errors['privacy_accepted']) ?></span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="checkbox-group">
                                <label class="checkbox-label">
                                    <input type="checkbox" 
                                           name="marketing_accepted"
                                           <?= ($form_data['marketing_accepted'] ?? false) ? 'checked' : '' ?>>
                                    <span class="checkmark"></span>
                                    <span class="checkbox-text">
                                        Desidero ricevere offerte speciali e aggiornamenti via email
                                    </span>
                                </label>
                            </div>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="icon-user-plus"></i>
                            <span>Crea Account</span>
                            <div class="btn-loader" style="display: none;">
                                <div class="spinner"></div>
                            </div>
                        </button>
                    </form>
                    
                    <?php endif; ?>
                    
                    <div class="form-divider">
                        <span>oppure</span>
                    </div>
                    
                    <div class="social-register">
                        <button class="btn btn-social btn-google" onclick="socialRegister('google')">
                            <i class="icon-google"></i>
                            Registrati con Google
                        </button>
                        
                        <button class="btn btn-social btn-facebook" onclick="socialRegister('facebook')">
                            <i class="icon-facebook"></i>
                            Registrati con Facebook
                        </button>
                    </div>
                    
                    <div class="form-footer">
                        <p>
                            Hai già un account? 
                            <a href="login">Accedi subito</a>
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
.register-page .auth-wrapper {
    grid-template-columns: 1fr 1.2fr;
}

.register-page .auth-form {
    padding: 2rem 3rem;
}

.form-section {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.form-section:last-child {
    border-bottom: none;
    margin-bottom: 0;
    padding-bottom: 0;
}

.form-section h3 {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 1.1rem;
    font-weight: 600;
    color: var(--text-color);
    margin: 0 0 1.5rem 0;
}

.form-section h3 i {
    color: var(--primary-color);
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
}

.form-group {
    margin-bottom: 1.5rem;
}

.form-group label {
    display: block;
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

.field-help {
    color: var(--text-muted);
    font-size: 0.8rem;
    margin-top: 0.5rem;
    display: block;
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

.password-strength {
    margin-top: 0.75rem;
}

.strength-meter {
    width: 100%;
    height: 4px;
    background: var(--light-gray);
    border-radius: 2px;
    overflow: hidden;
    margin-bottom: 0.5rem;
}

.strength-fill {
    height: 100%;
    background: var(--error-color);
    width: 0%;
    transition: all 0.3s ease;
    border-radius: 2px;
}

.strength-text {
    font-size: 0.8rem;
    color: var(--text-muted);
}

.checkbox-group {
    margin-bottom: 1rem;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--text-color);
    line-height: 1.4;
    position: relative;
}

.checkbox-label.error {
    color: var(--error-color);
}

.checkbox-label input {
    opacity: 0;
    position: absolute;
    width: 0;
    height: 0;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border-color);
    border-radius: 4px;
    position: relative;
    transition: all 0.3s ease;
    flex-shrink: 0;
    margin-top: 1px;
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
    font-weight: bold;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.checkbox-label.error .checkmark {
    border-color: var(--error-color);
}

.checkbox-text {
    flex: 1;
}

.checkbox-text a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.checkbox-text a:hover {
    text-decoration: underline;
}

.social-register {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-bottom: 2rem;
}

.register-form {
    max-height: 70vh;
    overflow-y: auto;
    padding-right: 0.5rem;
    margin-bottom: 2rem;
}

/* Custom scrollbar */
.register-form::-webkit-scrollbar {
    width: 6px;
}

.register-form::-webkit-scrollbar-track {
    background: var(--light-background);
    border-radius: 3px;
}

.register-form::-webkit-scrollbar-thumb {
    background: var(--border-color);
    border-radius: 3px;
}

.register-form::-webkit-scrollbar-thumb:hover {
    background: var(--text-muted);
}

@media (max-width: 768px) {
    .register-page .auth-wrapper {
        grid-template-columns: 1fr;
    }
    
    .register-page .auth-form {
        padding: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
    
    .register-form {
        max-height: none;
        overflow-y: visible;
    }
    
    .auth-brand {
        order: 2;
    }
    
    .auth-form {
        order: 1;
    }
}

@media (max-width: 480px) {
    .register-page .auth-form {
        padding: 1.5rem;
    }
    
    .form-section h3 {
        font-size: 1rem;
    }
    
    .checkbox-label {
        font-size: 0.85rem;
    }
}
</style>

<script>
// Registration form functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeRegisterForm();
});

function initializeRegisterForm() {
    const form = document.getElementById('registerForm');
    if (!form) return;
    
    const submitBtn = form.querySelector('button[type="submit"]');
    const passwordInput = document.getElementById('password');
    const confirmInput = document.getElementById('password_confirm');
    
    // Form submission handling
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
    
    // Password strength indicator
    if (passwordInput) {
        passwordInput.addEventListener('input', function() {
            updatePasswordStrength(this.value);
        });
    }
    
    // Password confirmation validation
    if (confirmInput) {
        confirmInput.addEventListener('input', function() {
            validatePasswordConfirmation();
        });
        
        passwordInput.addEventListener('input', function() {
            if (confirmInput.value) {
                validatePasswordConfirmation();
            }
        });
    }
    
    // Real-time field validation
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
    
    // Auto-focus first input
    const firstInput = document.getElementById('nome');
    if (firstInput && !firstInput.value) {
        firstInput.focus();
    }
}

function updatePasswordStrength(password) {
    const strengthMeter = document.querySelector('.strength-fill');
    const strengthText = document.querySelector('.strength-text');
    
    if (!strengthMeter || !strengthText) return;
    
    let strength = 0;
    let text = 'Molto debole';
    let color = '#dc3545';
    
    if (password.length >= 8) strength += 20;
    if (password.match(/[a-z]/)) strength += 20;
    if (password.match(/[A-Z]/)) strength += 20;
    if (password.match(/[0-9]/)) strength += 20;
    if (password.match(/[^a-zA-Z0-9]/)) strength += 20;
    
    if (strength >= 80) {
        text = 'Molto forte';
        color = '#28a745';
    } else if (strength >= 60) {
        text = 'Forte';
        color = '#20c997';
    } else if (strength >= 40) {
        text = 'Media';
        color = '#ffc107';
    } else if (strength >= 20) {
        text = 'Debole';
        color = '#fd7e14';
    }
    
    strengthMeter.style.width = strength + '%';
    strengthMeter.style.background = color;
    strengthText.textContent = text;
    strengthText.style.color = color;
}

function validatePasswordConfirmation() {
    const password = document.getElementById('password').value;
    const confirm = document.getElementById('password_confirm').value;
    const confirmInput = document.getElementById('password_confirm');
    
    // Remove existing error
    confirmInput.classList.remove('error');
    const existingError = confirmInput.parentNode.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    if (confirm && password !== confirm) {
        confirmInput.classList.add('error');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = 'Le password non corrispondono';
        confirmInput.parentNode.parentNode.appendChild(errorDiv);
        return false;
    }
    
    return true;
}

function validateField(input) {
    const value = input.value.trim();
    const name = input.name;
    const type = input.type;
    
    // Remove existing error state
    input.classList.remove('error');
    const existingError = input.parentNode.querySelector('.field-error') || 
                         input.parentNode.parentNode.querySelector('.field-error');
    if (existingError) {
        existingError.remove();
    }
    
    let error = '';
    
    if (input.required && !value) {
        error = 'Questo campo è obbligatorio';
    } else if (value) {
        switch (name) {
            case 'nome':
            case 'cognome':
                if (value.length < 2) {
                    error = 'Deve contenere almeno 2 caratteri';
                }
                break;
            case 'email':
                const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
                if (!emailRegex.test(value)) {
                    error = 'Inserisci un indirizzo email valido';
                }
                break;
            case 'telefono':
                if (value && !value.match(/^[0-9+\-\s]{8,20}$/)) {
                    error = 'Numero di telefono non valido';
                }
                break;
            case 'password':
                if (value.length < 8) {
                    error = 'La password deve contenere almeno 8 caratteri';
                } else if (!value.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/)) {
                    error = 'Deve contenere almeno una maiuscola, una minuscola e un numero';
                }
                break;
        }
    }
    
    if (error) {
        input.classList.add('error');
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = error;
        
        if (input.parentNode.classList.contains('password-input')) {
            input.parentNode.parentNode.appendChild(errorDiv);
        } else {
            input.parentNode.appendChild(errorDiv);
        }
        return false;
    }
    
    return true;
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

function socialRegister(provider) {
    // Placeholder for social registration implementation
    AgenziaPlinio.showToast(`Registrazione con ${provider} non ancora implementata`, 'info');
}
</script>

<?php include '../includes/footer.php'; ?>