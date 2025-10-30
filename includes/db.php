<?php
// Database connection handler using PDO.
if (!function_exists('db')) {
    function db(): PDO
    {
        static $pdo = null;

        if ($pdo instanceof PDO) {
            return $pdo;
        }

        $config = require __DIR__ . '/../config/settings.php';
        $charset = $config['database']['charset'] ?? 'utf8mb4';

        $envKeys = ['DB_HOST', 'DB_PORT', 'DB_NAME', 'DB_USER', 'DB_PASSWORD'];
        $credentials = [];

        foreach ($envKeys as $key) {
            $value = getenv($key);
            if ($value === false || $value === '') {
                throw new RuntimeException('Missing environment variable for database configuration: ' . $key);
            }

            $credentials[$key] = trim((string) $value);
        }

        if (!ctype_digit($credentials['DB_PORT'])) {
            throw new RuntimeException('Environment variable DB_PORT must be an integer.');
        }

        $dsn = sprintf(
            'mysql:host=%s;port=%s;dbname=%s;charset=%s',
            $credentials['DB_HOST'],
            $credentials['DB_PORT'],
            $credentials['DB_NAME'],
            $charset
        );

        try {
            $pdo = new PDO($dsn, $credentials['DB_USER'], $credentials['DB_PASSWORD'], [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ]);
        } catch (PDOException $exception) {
            error_log('Database connection failed: ' . $exception->getMessage());
            throw new RuntimeException('Database connection failed', 0, $exception);
        }

        return $pdo;
    }
}
