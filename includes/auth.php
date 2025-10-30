<?php
// Authentication helper functions.
require_once __DIR__ . '/db.php';
require_once __DIR__ . '/functions.php';

if (session_status() !== PHP_SESSION_ACTIVE) {
    $config = require __DIR__ . '/../config/settings.php';

    session_name($config['security']['session_name']);
    session_set_cookie_params([
        'lifetime' => 0,
        'path' => '/',
        'domain' => '',
        'secure' => isset($_SERVER['HTTPS']),
        'httponly' => true,
        'samesite' => 'Lax',
    ]);

    session_start();
    session_regenerate_id(true);
}

function current_user(): ?array
{
    return $_SESSION['user'] ?? null;
}

function is_authenticated(): bool
{
    return current_user() !== null;
}

function require_auth(): void
{
    if (!is_authenticated()) {
        header('Location: /user/login.php');
        exit();
    }
}

function require_admin(): void
{
    require_auth();
    if ((current_user()['ruolo'] ?? null) !== 'admin') {
        http_response_code(403);
        exit('Accesso negato.');
    }
}

function login_user(array $user): void
{
    $_SESSION['user'] = [
        'id' => $user['id'],
        'nome' => $user['nome'],
        'cognome' => $user['cognome'],
        'email' => $user['email'],
        'ruolo' => $user['ruolo'],
    ];
    session_regenerate_id(true);
}

function logout_user(): void
{
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000, $params['path'], $params['domain'], $params['secure'], $params['httponly']);
    }
    session_destroy();
}
