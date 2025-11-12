<?php
/**
 * Configurazione del database e impostazioni generali
 * Agenzia Plinio - Sistema di gestione multiservizi
 */

// Configurazione database da .env
define('DB_HOST', '193.203.168.205');
define('DB_PORT', '3306');
define('DB_NAME', 'u427445037_agenziaplinio');
define('DB_USER', 'u427445037_agenziaplinio');
define('DB_PASSWORD', 'Giogiu2123@');

// Configurazione applicazione
define('APP_NAME', 'AG SERVIZI VIA PLINIO 72');
define('APP_DOMAIN', 'agenziaplinio.local');
define('APP_BASE_URL', '/');
define('SUPPORT_EMAIL', 'supporto@agenziaplinio.local');
define('GOOGLE_ANALYTICS_ID', ''); // Lasciare vuoto se non utilizzato

// Configurazione sicurezza
define('HASH_ALGO', PASSWORD_DEFAULT);
define('SESSION_TIMEOUT', 3600); // 1 ora
define('MAX_LOGIN_ATTEMPTS', 5);
define('LOGIN_LOCKOUT_TIME', 900); // 15 minuti

// Configurazione upload
define('UPLOAD_MAX_SIZE', 5242880); // 5MB
define('UPLOAD_ALLOWED_TYPES', ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'doc', 'docx']);

// Fuso orario
date_default_timezone_set('Europe/Rome');

/**
 * Connessione al database con gestione errori
 */
function getDBConnection() {
    static $pdo = null;
    
    if ($pdo === null) {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME . ";charset=utf8mb4";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_unicode_ci"
            ];
            
            $pdo = new PDO($dsn, DB_USER, DB_PASSWORD, $options);
        } catch (PDOException $e) {
            error_log("Errore connessione database: " . $e->getMessage());
            die("Errore di connessione al database. Riprova più tardi.");
        }
    }
    
    return $pdo;
}

/**
 * Funzione per l'escape sicuro dell'output
 */
function h($string) {
    return htmlspecialchars($string, ENT_QUOTES | ENT_HTML5, 'UTF-8');
}

/**
 * Funzione per la validazione e sanitizzazione input
 */
function sanitizeInput($input, $type = 'string') {
    $input = trim($input);
    
    switch ($type) {
        case 'email':
            return filter_var($input, FILTER_SANITIZE_EMAIL);
        case 'int':
            return filter_var($input, FILTER_SANITIZE_NUMBER_INT);
        case 'float':
            return filter_var($input, FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
        case 'url':
            return filter_var($input, FILTER_SANITIZE_URL);
        default:
            return htmlspecialchars($input, ENT_QUOTES | ENT_HTML5, 'UTF-8');
    }
}

/**
 * Generazione di token CSRF sicuri
 */
function generateCSRFToken() {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    
    return $_SESSION['csrf_token'];
}

/**
 * Verifica token CSRF
 */
function verifyCSRFToken($token) {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

/**
 * Logging delle attività
 */
function logActivity($user_id, $action, $details = '') {
    try {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO activity_logs (user_id, action, details, ip_address, user_agent, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
        $stmt->execute([
            $user_id,
            $action,
            $details,
            $_SERVER['REMOTE_ADDR'] ?? '',
            $_SERVER['HTTP_USER_AGENT'] ?? ''
        ]);
    } catch (Exception $e) {
        error_log("Errore logging: " . $e->getMessage());
    }
}

/**
 * Funzione per inviare email (placeholder per implementazione futura)
 */
function sendEmail($to, $subject, $message, $from = SUPPORT_EMAIL) {
    // Implementazione email
    return mail($to, $subject, $message, "From: " . $from);
}

/**
 * Redirect sicuro con validazione URL
 */
function safeRedirect($url, $default = '/') {
    $url = filter_var($url, FILTER_SANITIZE_URL);
    
    if (!filter_var($url, FILTER_VALIDATE_URL) && !preg_match('/^\/[a-zA-Z0-9\-_\/]*$/', $url)) {
        $url = $default;
    }
    
    header("Location: " . $url);
    exit;
}

// Inizializzazione sessioni sicure
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', isset($_SERVER['HTTPS']));
ini_set('session.use_strict_mode', 1);
?>