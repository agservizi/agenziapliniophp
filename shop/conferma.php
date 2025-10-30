<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../includes/payments.php';
require_once __DIR__ . '/../includes/notifications.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !validate_csrf()) {
    flash('danger', 'Sessione scaduta. Riprova.');
    header('Location: /shop/checkout.php');
    exit();
}

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    flash('warning', 'Il carrello è vuoto.');
    header('Location: /shop/index.php');
    exit();
}

$totale = array_reduce($cart, fn($carry, $item) => $carry + ($item['prezzo'] * $item['quantita']), 0.0);

$ordine = [
    'nome' => $_POST['nome'] ?? '',
    'cognome' => $_POST['cognome'] ?? '',
    'email' => $_POST['email'] ?? '',
    'azienda' => $_POST['azienda'] ?? '',
    'piva' => $_POST['piva'] ?? '',
    'indirizzo' => $_POST['indirizzo'] ?? '',
    'citta' => $_POST['citta'] ?? '',
    'note' => $_POST['note'] ?? '',
];

try {
    $pdo = db();
    $pdo->beginTransaction();
    execute_query('INSERT INTO ordini (id_utente, totale, stato, data_ordine, note) VALUES (:id_utente, :totale, :stato, NOW(), :note)', [
        'id_utente' => current_user()['id'] ?? null,
        'totale' => $totale,
        'stato' => 'in revisione',
        'note' => $ordine['note'] ?? null,
    ]);
    $orderId = (int) $pdo->lastInsertId();
    foreach ($cart as $item) {
        execute_query('INSERT INTO ordini_dettagli (id_ordine, id_prodotto, quantita, prezzo_unitario) VALUES (:id_ordine, :id_prodotto, :quantita, :prezzo)', [
            'id_ordine' => $orderId,
            'id_prodotto' => $item['id'],
            'quantita' => $item['quantita'],
            'prezzo' => $item['prezzo'],
        ]);
    }

    $orderData = ['id' => $orderId, 'totale' => $totale];
    $customer = ['nome' => $ordine['nome'], 'email' => $ordine['email']];
    $payment = process_payment($orderData, array_values($cart), $customer);

    execute_query('UPDATE ordini SET payment_status = :status, payment_reference = :reference WHERE id = :id', [
        'status' => $payment['status'],
        'reference' => $payment['reference'],
        'id' => $orderId,
    ]);

    $pdo->commit();
    notify_admins('Nuovo ordine', 'Ordine #' . $orderId . ' ricevuto dal cliente ' . ($ordine['email'] ?: 'sconosciuto'));
} catch (Throwable $exception) {
    if (isset($pdo) && $pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('checkout fallback: ' . $exception->getMessage());
}

unset($_SESSION['cart']);

$pageTitle = 'Conferma ordine';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Ordine in elaborazione</h1>
        <p class="subtitle">Grazie <?= sanitize($ordine['nome']); ?>, il nostro team ti contatterà entro breve per finalizzare il contratto e l&apos;attivazione dei servizi.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="dashboard-widget" data-animate="fade-up">
            <p class="heading">Riepilogo</p>
            <p>Cliente: <?= sanitize($ordine['nome'] . ' ' . $ordine['cognome']); ?></p>
            <p>Email: <?= sanitize($ordine['email']); ?></p>
            <p>Azienda: <?= sanitize($ordine['azienda']); ?></p>
            <p>Totale: € <?= format_currency($totale); ?></p>
            <p>Note: <?= sanitize($ordine['note']); ?></p>
            <a class="button is-warning" href="/user/dashboard.php" style="margin-top: 18px;">Vai alla dashboard</a>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
