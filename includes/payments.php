<?php
require_once __DIR__ . '/functions.php';

function process_payment(array $orderData, array $cartItems, array $customer): array
{
    $config = app_config('payments');
    $provider = $config['provider'] ?? 'sandbox';

    // Placeholder for integration with providers (Stripe, etc.)
    if ($provider === 'stripe' && !empty($config['stripe']['secret_key'])) {
        // Here you would call Stripe\PaymentIntent API using the secret key.
        // This demo returns a simulated response to keep the project self-contained.
    }

    $reference = $provider . '_' . bin2hex(random_bytes(6));
    $status = 'authorized';

    try {
        execute_query(
            'INSERT INTO pagamenti (id_ordine, provider, status, reference, payload) VALUES (:id_ordine, :provider, :status, :reference, :payload)',
            [
                'id_ordine' => $orderData['id'],
                'provider' => $provider,
                'status' => $status,
                'reference' => $reference,
                'payload' => json_encode([
                    'order' => $orderData,
                    'items' => $cartItems,
                    'customer' => $customer,
                ], JSON_THROW_ON_ERROR),
            ]
        );
    } catch (Throwable $exception) {
        error_log('process_payment log failure: ' . $exception->getMessage());
    }

    return [
        'status' => $status,
        'reference' => $reference,
    ];
}
