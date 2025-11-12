<?php
/**
 * Sistema di autenticazione sicuro
 * Agenzia Plinio - Login, registrazione e gestione sessioni
 */

require_once 'config.php';

class Auth {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDBConnection();
        $this->initSession();
    }
    
    /**
     * Inizializzazione sicura delle sessioni
     */
    private function initSession() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Rigenerazione ID sessione per sicurezza
        if (!isset($_SESSION['created'])) {
            $_SESSION['created'] = time();
        } elseif (time() - $_SESSION['created'] > 1800) {
            session_regenerate_id(true);
            $_SESSION['created'] = time();
        }
        
        // Controllo timeout sessione
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > SESSION_TIMEOUT)) {
            $this->logout();
        }
        $_SESSION['last_activity'] = time();
    }
    
    /**
     * Login utente con protezione brute force
     */
    public function login($email, $password, $remember_me = false) {
        try {
            $email = sanitizeInput($email, 'email');
            
            // Controllo rate limiting
            if ($this->isAccountLocked($email)) {
                return [
                    'success' => false,
                    'message' => 'Account temporaneamente bloccato per troppi tentativi falliti. Riprova tra ' . (LOGIN_LOCKOUT_TIME / 60) . ' minuti.'
                ];
            }
            
            // Recupero dati utente
            $stmt = $this->pdo->prepare("SELECT id, nome, cognome, email, password_hash, ruolo, attivo, email_verificata FROM utenti WHERE email = ?");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if (!$user || !password_verify($password, $user['password_hash'])) {
                $this->recordFailedAttempt($email);
                return [
                    'success' => false,
                    'message' => 'Email o password non corretti.'
                ];
            }
            
            // Controllo account attivo
            if (!$user['attivo']) {
                return [
                    'success' => false,
                    'message' => 'Account disattivato. Contatta il supporto.'
                ];
            }
            
            // Login riuscito
            $this->clearFailedAttempts($email);
            $this->createUserSession($user);
            $this->updateLastAccess($user['id']);
            
            // Remember me functionality
            if ($remember_me) {
                $this->setRememberMeToken($user['id']);
            }
            
            logActivity($user['id'], 'login', 'Login effettuato');
            
            return [
                'success' => true,
                'message' => 'Login effettuato con successo.',
                'user' => $user,
                'redirect' => $this->getRedirectUrl($user['ruolo'])
            ];
            
        } catch (Exception $e) {
            error_log("Errore login: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Errore durante il login. Riprova.'
            ];
        }
    }
    
    /**
     * Registrazione nuovo utente
     */
    public function register($data) {
        try {
            // Validazione dati
            $validation = $this->validateRegistrationData($data);
            if (!$validation['valid']) {
                return [
                    'success' => false,
                    'message' => $validation['message'],
                    'errors' => $validation['errors']
                ];
            }
            
            // Controllo email esistente
            if ($this->emailExists($data['email'])) {
                return [
                    'success' => false,
                    'message' => 'Email già registrata.'
                ];
            }
            
            // Hash password
            $password_hash = password_hash($data['password'], HASH_ALGO);
            
            // Inserimento utente
            $stmt = $this->pdo->prepare("
                INSERT INTO utenti (nome, cognome, email, telefono, password_hash, ruolo) 
                VALUES (?, ?, ?, ?, ?, 'cliente')
            ");
            
            $result = $stmt->execute([
                sanitizeInput($data['nome']),
                sanitizeInput($data['cognome']),
                sanitizeInput($data['email'], 'email'),
                sanitizeInput($data['telefono']),
                $password_hash
            ]);
            
            if ($result) {
                $user_id = $this->pdo->lastInsertId();
                
                // Invio email di verifica (placeholder)
                $this->sendVerificationEmail($data['email'], $user_id);
                
                logActivity($user_id, 'register', 'Nuovo utente registrato');
                
                return [
                    'success' => true,
                    'message' => 'Registrazione completata! Controlla la tua email per verificare l\'account.',
                    'user_id' => $user_id
                ];
            }
            
            return [
                'success' => false,
                'message' => 'Errore durante la registrazione.'
            ];
            
        } catch (Exception $e) {
            error_log("Errore registrazione: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Errore durante la registrazione. Riprova.'
            ];
        }
    }
    
    /**
     * Logout utente
     */
    public function logout() {
        if (isset($_SESSION['user_id'])) {
            logActivity($_SESSION['user_id'], 'logout', 'Logout effettuato');
        }
        
        // Rimozione remember me token
        if (isset($_COOKIE['remember_token'])) {
            $this->clearRememberMeToken($_COOKIE['remember_token']);
            setcookie('remember_token', '', time() - 3600, '/');
        }
        
        // Distruzione sessione
        session_destroy();
        session_start();
        session_regenerate_id(true);
        
        return ['success' => true, 'message' => 'Logout effettuato con successo.'];
    }
    
    /**
     * Controllo se utente è loggato
     */
    public function isLoggedIn() {
        return isset($_SESSION['user_id']) && isset($_SESSION['user_email']);
    }
    
    /**
     * Controllo se utente è admin
     */
    public function isAdmin() {
        return $this->isLoggedIn() && $_SESSION['user_role'] === 'admin';
    }
    
    /**
     * Ottieni utente corrente
     */
    public function getCurrentUser() {
        if (!$this->isLoggedIn()) {
            return null;
        }
        
        try {
            $stmt = $this->pdo->prepare("SELECT id, nome, cognome, email, ruolo, ultimo_accesso FROM utenti WHERE id = ?");
            $stmt->execute([$_SESSION['user_id']]);
            return $stmt->fetch();
        } catch (Exception $e) {
            error_log("Errore getCurrentUser: " . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Reset password
     */
    public function resetPassword($email) {
        try {
            $email = sanitizeInput($email, 'email');
            
            $stmt = $this->pdo->prepare("SELECT id FROM utenti WHERE email = ? AND attivo = 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            
            if (!$user) {
                return [
                    'success' => false,
                    'message' => 'Email non trovata.'
                ];
            }
            
            // Genera token di reset
            $reset_token = bin2hex(random_bytes(32));
            $expires = date('Y-m-d H:i:s', time() + 3600); // 1 ora
            
            // Salva token (necessaria tabella password_resets)
            $stmt = $this->pdo->prepare("
                INSERT INTO password_resets (user_id, token, expires_at) 
                VALUES (?, ?, ?) 
                ON DUPLICATE KEY UPDATE token = VALUES(token), expires_at = VALUES(expires_at)
            ");
            $stmt->execute([$user['id'], $reset_token, $expires]);
            
            // Invio email (placeholder)
            $reset_url = APP_BASE_URL . "reset-password.php?token=" . $reset_token;
            // sendEmail($email, "Reset Password", "Clicca qui per resettare la password: " . $reset_url);
            
            return [
                'success' => true,
                'message' => 'Email di reset inviata. Controlla la tua casella di posta.'
            ];
            
        } catch (Exception $e) {
            error_log("Errore reset password: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Errore durante il reset. Riprova.'
            ];
        }
    }
    
    /**
     * Validazione dati registrazione
     */
    private function validateRegistrationData($data) {
        $errors = [];
        
        if (empty($data['nome']) || strlen($data['nome']) < 2) {
            $errors['nome'] = 'Nome obbligatorio (min 2 caratteri)';
        }
        
        if (empty($data['cognome']) || strlen($data['cognome']) < 2) {
            $errors['cognome'] = 'Cognome obbligatorio (min 2 caratteri)';
        }
        
        if (empty($data['email']) || !filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email valida obbligatoria';
        }
        
        if (empty($data['password']) || strlen($data['password']) < 8) {
            $errors['password'] = 'Password obbligatoria (min 8 caratteri)';
        }
        
        if ($data['password'] !== $data['confirm_password']) {
            $errors['confirm_password'] = 'Le password non corrispondono';
        }
        
        if (!empty($data['telefono']) && !preg_match('/^[0-9+\-\s]{8,20}$/', $data['telefono'])) {
            $errors['telefono'] = 'Numero di telefono non valido';
        }
        
        return [
            'valid' => empty($errors),
            'errors' => $errors,
            'message' => empty($errors) ? 'Dati validi' : 'Controlla i campi evidenziati'
        ];
    }
    
    /**
     * Controllo email esistente
     */
    private function emailExists($email) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) FROM utenti WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }
    
    /**
     * Controllo account bloccato per troppi tentativi
     */
    private function isAccountLocked($email) {
        $stmt = $this->pdo->prepare("SELECT tentativi_login, bloccato_fino FROM utenti WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch();
        
        if (!$user) {
            return false;
        }
        
        if ($user['tentativi_login'] >= MAX_LOGIN_ATTEMPTS) {
            if ($user['bloccato_fino'] && strtotime($user['bloccato_fino']) > time()) {
                return true;
            }
        }
        
        return false;
    }
    
    /**
     * Registra tentativo fallito
     */
    private function recordFailedAttempt($email) {
        $stmt = $this->pdo->prepare("
            UPDATE utenti 
            SET tentativi_login = tentativi_login + 1, 
                bloccato_fino = IF(tentativi_login + 1 >= ?, DATE_ADD(NOW(), INTERVAL ? SECOND), bloccato_fino)
            WHERE email = ?
        ");
        $stmt->execute([MAX_LOGIN_ATTEMPTS, LOGIN_LOCKOUT_TIME, $email]);
    }
    
    /**
     * Azzera tentativi falliti
     */
    private function clearFailedAttempts($email) {
        $stmt = $this->pdo->prepare("UPDATE utenti SET tentativi_login = 0, bloccato_fino = NULL WHERE email = ?");
        $stmt->execute([$email]);
    }
    
    /**
     * Crea sessione utente
     */
    private function createUserSession($user) {
        session_regenerate_id(true);
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_email'] = $user['email'];
        $_SESSION['user_name'] = $user['nome'] . ' ' . $user['cognome'];
        $_SESSION['user_role'] = $user['ruolo'];
        $_SESSION['logged_in'] = true;
    }
    
    /**
     * Aggiorna ultimo accesso
     */
    private function updateLastAccess($user_id) {
        $stmt = $this->pdo->prepare("UPDATE utenti SET ultimo_accesso = NOW() WHERE id = ?");
        $stmt->execute([$user_id]);
    }
    
    /**
     * URL di redirect dopo login
     */
    private function getRedirectUrl($role) {
        return $role === 'admin' ? '/area-admin/' : '/area-cliente/';
    }
    
    /**
     * Remember me token (implementazione base)
     */
    private function setRememberMeToken($user_id) {
        $token = bin2hex(random_bytes(32));
        $expires = time() + (30 * 24 * 60 * 60); // 30 giorni
        
        setcookie('remember_token', $token, $expires, '/', '', true, true);
        
        // Salva token nel database (necessaria tabella remember_tokens)
        try {
            $stmt = $this->pdo->prepare("INSERT INTO remember_tokens (user_id, token, expires_at) VALUES (?, ?, ?)");
            $stmt->execute([$user_id, hash('sha256', $token), date('Y-m-d H:i:s', $expires)]);
        } catch (Exception $e) {
            error_log("Errore remember token: " . $e->getMessage());
        }
    }
    
    /**
     * Rimozione remember me token
     */
    private function clearRememberMeToken($token) {
        try {
            $stmt = $this->pdo->prepare("DELETE FROM remember_tokens WHERE token = ?");
            $stmt->execute([hash('sha256', $token)]);
        } catch (Exception $e) {
            error_log("Errore clear token: " . $e->getMessage());
        }
    }
    
    /**
     * Invio email di verifica (placeholder)
     */
    private function sendVerificationEmail($email, $user_id) {
        // Implementazione invio email
        return true;
    }
    
    /**
     * Middleware per proteggere pagine
     */
    public function requireAuth($admin_only = false) {
        if (!$this->isLoggedIn()) {
            header('Location: /login.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
            exit;
        }
        
        if ($admin_only && !$this->isAdmin()) {
            header('Location: /');
            exit;
        }
    }
    
    /**
     * Verifica CSRF token
     */
    public function verifyCSRF($token) {
        return verifyCSRFToken($token);
    }
}

// Helper functions for easier usage
function isLoggedIn() {
    return isset($_SESSION['utente_id']) && isset($_SESSION['user_data']);
}

function getCurrentUser() {
    return isset($_SESSION['user_data']) ? $_SESSION['user_data'] : null;
}

function requireLogin($redirect = 'area-cliente/login') {
    if (!isLoggedIn()) {
        header("Location: $redirect");
        exit;
    }
}

function requireRole($role, $redirect = '/') {
    if (!isLoggedIn()) {
        header("Location: area-cliente/login");
        exit;
    }
    
    $user = getCurrentUser();
    if ($user['ruolo'] !== $role) {
        header("Location: $redirect");
        exit;
    }
}
?>