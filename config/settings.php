<?php
// Global configuration settings for Agenzia Plinio portal.
return [
    'app' => [
        'name' => 'Agenzia Plinio',
        'domain' => 'agenziaplinio.local',
        'base_url' => '/',
        'support_email' => 'supporto@agenziaplinio.local',
    ],
    'database' => [
        'host' => getenv('DB_HOST') ?: '127.0.0.1',
        'port' => (int) (getenv('DB_PORT') ?: 3306),
        'name' => getenv('DB_NAME') ?: 'agenziaplinio',
        'user' => getenv('DB_USER') ?: 'agenziaplinio_app',
        'password' => getenv('DB_PASSWORD') ?: 'ChangeMe123!',
        'charset' => 'utf8mb4',
        'collation' => 'utf8mb4_unicode_ci',
    ],
    'security' => [
        'session_name' => 'agenzia_session',
        'csrf_token_name' => 'csrf_token',
        'remember_lifetime' => 60 * 60 * 24 * 7, // 7 days
    ],
    'uploads' => [
        'products' => 'uploads/products',
        'services' => 'uploads/services',
        'documents' => 'uploads/documents',
        'max_size' => 4 * 1024 * 1024, // 4MB
        'allowed_mimes' => ['image/jpeg', 'image/png', 'image/webp'],
    ],
    'payments' => [
        'provider' => getenv('PAYMENT_PROVIDER') ?: 'sandbox',
        'stripe' => [
            'secret_key' => getenv('STRIPE_SECRET') ?: '',
            'publishable_key' => getenv('STRIPE_PUBLISHABLE') ?: '',
        ],
        'webhook_secret' => getenv('PAYMENT_WEBHOOK_SECRET') ?: '',
    ],
    'notifications' => [
        'email_from' => 'no-reply@agenziaplinio.local',
    ],
];
