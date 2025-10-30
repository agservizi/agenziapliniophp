<?php
// Shared utility functions for the portal.
require_once __DIR__ . '/db.php';

function app_config(string $key, $default = null)
{
    static $config = null;
    if ($config === null) {
        $config = require __DIR__ . '/../config/settings.php';
    }

    $segments = explode('.', $key);
    $value = $config;
    foreach ($segments as $segment) {
        if (!isset($value[$segment])) {
            return $default;
        }
        $value = $value[$segment];
    }
    return $value;
}

function asset(string $path): string
{
    return rtrim(app_config('app.base_url'), '/') . '/' . trim($path, '/');
}

function csrf_token(): string
{
    $name = app_config('security.csrf_token_name');
    if (!isset($_SESSION[$name])) {
        $_SESSION[$name] = bin2hex(random_bytes(32));
    }
    return $_SESSION[$name];
}

function csrf_field(): string
{
    $name = app_config('security.csrf_token_name');
    return '<input type="hidden" name="' . htmlspecialchars($name) . '" value="' . htmlspecialchars(csrf_token()) . '">';
}

function validate_csrf(): bool
{
    $name = app_config('security.csrf_token_name');
    $submitted = $_POST[$name] ?? $_GET[$name] ?? '';
    return hash_equals($_SESSION[$name] ?? '', $submitted);
}

function sanitize(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

function fetch_all(string $sql, array $params = []): array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    return $stmt->fetchAll();
}

function fetch_one(string $sql, array $params = []): ?array
{
    $stmt = db()->prepare($sql);
    $stmt->execute($params);
    $result = $stmt->fetch();
    return $result ?: null;
}

function execute_query(string $sql, array $params = []): bool
{
    $stmt = db()->prepare($sql);
    return $stmt->execute($params);
}

function format_currency(float $value): string
{
    return number_format($value, 2, ',', '.');
}

function flash(string $type, string $message): void
{
    $_SESSION['flash'][] = ['type' => $type, 'message' => $message];
}

function get_flash(): array
{
    $messages = $_SESSION['flash'] ?? [];
    unset($_SESSION['flash']);
    return $messages;
}

function project_root(): string
{
    return realpath(__DIR__ . '/..');
}

function upload_config(string $key, $default = null)
{
    $config = app_config('uploads', []);
    return $config[$key] ?? $default;
}

function store_uploaded_image(array $file, string $bucket, ?string $currentPath = null): ?string
{
    $error = $file['error'] ?? UPLOAD_ERR_NO_FILE;
    if ($error === UPLOAD_ERR_NO_FILE) {
        return $currentPath;
    }
    if ($error !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Errore durante l\'upload del file.');
    }

    $maxSize = upload_config('max_size', 2 * 1024 * 1024);
    if (($file['size'] ?? 0) > $maxSize) {
        throw new RuntimeException('Il file supera la dimensione massima consentita.');
    }

    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime = $finfo->file($file['tmp_name']) ?: 'application/octet-stream';
    $allowed = upload_config('allowed_mimes', []);
    if ($allowed && !in_array($mime, $allowed, true)) {
        throw new RuntimeException('Formato immagine non supportato.');
    }

    $extension = match ($mime) {
        'image/jpeg' => 'jpg',
        'image/png' => 'png',
        'image/webp' => 'webp',
        default => strtolower(pathinfo($file['name'] ?? 'file', PATHINFO_EXTENSION)) ?: 'bin',
    };

    $relativeDir = trim(upload_config($bucket, 'uploads'), '/');
    $absoluteDir = project_root() . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, $relativeDir);
    if (!is_dir($absoluteDir) && !mkdir($absoluteDir, 0775, true) && !is_dir($absoluteDir)) {
        throw new RuntimeException('Impossibile creare la cartella di destinazione.');
    }

    $filename = uniqid($bucket . '_', true) . '.' . $extension;
    $absolutePath = $absoluteDir . DIRECTORY_SEPARATOR . $filename;

    if (!move_uploaded_file($file['tmp_name'], $absolutePath)) {
        throw new RuntimeException('Impossibile salvare il file caricato.');
    }

    if ($currentPath) {
        $currentAbsolute = project_root() . DIRECTORY_SEPARATOR . str_replace('/', DIRECTORY_SEPARATOR, ltrim($currentPath, '/'));
        if (is_file($currentAbsolute)) {
            @unlink($currentAbsolute);
        }
    }

    return $relativeDir . '/' . $filename;
}

function get_products_directory(): string
{
    return upload_config('products', 'uploads/products');
}

function get_products(array $filters = []): array
{
    try {
        $sql = 'SELECT * FROM prodotti WHERE 1=1';
        $params = [];
        if (!empty($filters['categoria'])) {
            $sql .= ' AND categoria = :categoria';
            $params['categoria'] = $filters['categoria'];
        }
        if (isset($filters['disponibile'])) {
            $sql .= ' AND disponibile = :disponibile';
            $params['disponibile'] = (int) $filters['disponibile'];
        }
        $sql .= ' ORDER BY nome ASC';
        return fetch_all($sql, $params);
    } catch (Throwable $exception) {
        error_log('get_products fallback: ' . $exception->getMessage());
        $catalogue = [
            ['id' => 1, 'nome' => 'Suite Strategica', 'descrizione' => 'Toolkit digitale completo con consulenza trimestrale.', 'prezzo' => 2890.00, 'immagine' => 'assets/img/prodotto-suite.svg', 'categoria' => 'Consulenza', 'disponibile' => 1],
            ['id' => 2, 'nome' => 'Pacchetto Automazione', 'descrizione' => 'Automazione processi e integrazione CRM.', 'prezzo' => 1890.00, 'immagine' => 'assets/img/prodotto-automation.svg', 'categoria' => 'Automazione', 'disponibile' => 1],
            ['id' => 3, 'nome' => 'Brand Refresh', 'descrizione' => 'Design system e brand identity cross-media.', 'prezzo' => 1490.00, 'immagine' => 'assets/img/prodotto-brand.svg', 'categoria' => 'Branding', 'disponibile' => 1],
        ];
        if (!empty($filters['categoria'])) {
            $catalogue = array_values(array_filter($catalogue, fn($item) => $item['categoria'] === $filters['categoria']));
        }
        return $catalogue;
    }
}

function get_product_by_id(int $id): ?array
{
    try {
        return fetch_one('SELECT * FROM prodotti WHERE id = :id', ['id' => $id]);
    } catch (Throwable $exception) {
        error_log('get_product_by_id fallback: ' . $exception->getMessage());
        foreach (get_products() as $product) {
            if ((int) $product['id'] === $id) {
                return $product;
            }
        }
        return null;
    }
}

function get_services(array $filters = []): array
{
    try {
        $sql = 'SELECT * FROM servizi WHERE 1=1';
        $params = [];
        if (!empty($filters['tipo'])) {
            $sql .= ' AND tipo = :tipo';
            $params['tipo'] = $filters['tipo'];
        }
        if (isset($filters['attivo'])) {
            $sql .= ' AND attivo = :attivo';
            $params['attivo'] = (int) $filters['attivo'];
        }
        $sql .= ' ORDER BY nome ASC';
        return fetch_all($sql, $params);
    } catch (Throwable $exception) {
        error_log('get_services fallback: ' . $exception->getMessage());
        $mock = [
            ['id' => 1, 'nome' => 'Automation Hub', 'descrizione' => 'Workflow intelligenti e integrazioni.', 'tipo' => 'Digital', 'attivo' => 1, 'immagine' => null, 'prezzo' => null],
            ['id' => 2, 'nome' => 'Strategy Lab', 'descrizione' => 'Roadmap di crescita e advisory.', 'tipo' => 'Consulting', 'attivo' => 1, 'immagine' => null, 'prezzo' => null],
        ];
        if (!empty($filters['tipo'])) {
            $mock = array_values(array_filter($mock, fn($item) => $item['tipo'] === $filters['tipo']));
        }
        return $mock;
    }
}

function get_service_by_id(int $id): ?array
{
    try {
        return fetch_one('SELECT * FROM servizi WHERE id = :id', ['id' => $id]);
    } catch (Throwable $exception) {
        error_log('get_service_by_id fallback: ' . $exception->getMessage());
        foreach (get_services() as $service) {
            if ((int) $service['id'] === $id) {
                return $service;
            }
        }
        return null;
    }
}

function find_user_by_email(string $email): ?array
{
    try {
        return fetch_one('SELECT * FROM utenti WHERE email = :email LIMIT 1', ['email' => $email]);
    } catch (Throwable $exception) {
        error_log('find_user_by_email fallback: ' . $exception->getMessage());
        static $mockUsers = null;
        if ($mockUsers === null) {
            $mockUsers = [
                'admin@agenziaplinio.local' => [
                    'id' => 1,
                    'nome' => 'Admin',
                    'cognome' => 'Portal',
                    'email' => 'admin@agenziaplinio.local',
                    'password' => '$2y$10$EJY0g1LV0ksg4i8Hr9L5K.4NGoC4QSCLcuHhk9pzQblSihB7rsULe', // hash for "password"
                    'ruolo' => 'admin',
                ],
            ];
        }
        if (isset($_SESSION['mock_users'][$email])) {
            return $_SESSION['mock_users'][$email];
        }
        return $mockUsers[$email] ?? null;
    }
}

function create_user(array $data): bool
{
    try {
        return execute_query('INSERT INTO utenti (nome, cognome, email, password, ruolo, data_creazione) VALUES (:nome, :cognome, :email, :password, :ruolo, NOW())', [
            'nome' => $data['nome'],
            'cognome' => $data['cognome'],
            'email' => $data['email'],
            'password' => $data['password'],
            'ruolo' => $data['ruolo'] ?? 'cliente',
        ]);
    } catch (Throwable $exception) {
        error_log('create_user fallback: ' . $exception->getMessage());
        $_SESSION['mock_users'][$data['email']] = [
            'id' => random_int(10, 9999),
            'nome' => $data['nome'],
            'cognome' => $data['cognome'],
            'email' => $data['email'],
            'password' => $data['password'],
            'ruolo' => $data['ruolo'] ?? 'cliente',
        ];
        return true;
    }
}
