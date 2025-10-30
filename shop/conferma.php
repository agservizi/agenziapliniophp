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
    flash('warning', 'Il carrello &egrave; vuoto.');
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
<section class="mx-auto max-w-5xl px-6" data-animate="fade-up">
    <div class="glass-panel overflow-hidden p-10 text-center md:p-14 md:text-left">
        <span class="badge-glow">Ordine in elaborazione</span>
        <h1 class="mt-6 font-display text-4xl font-semibold text-white md:text-5xl">Grazie <?= sanitize($ordine['nome']); ?>!</h1>
        <p class="mt-6 text-lg text-slate-300">Il nostro team ti contatter&agrave; entro breve per finalizzare il contratto e l&apos;attivazione dei servizi selezionati.</p>
    </div>
</section>

<section class="mx-auto mt-24 max-w-5xl px-6" data-animate="fade-up">
    <div class="glass-panel p-8 md:p-10">
        <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Riepilogo</p>
        <dl class="mt-6 space-y-4 text-sm text-slate-300">
            <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                <dt class="font-semibold text-slate-200">Cliente</dt>
                <dd><?= sanitize($ordine['nome'] . ' ' . $ordine['cognome']); ?></dd>
            </div>
            <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                <dt class="font-semibold text-slate-200">Email</dt>
                <dd><?= sanitize($ordine['email']); ?></dd>
            </div>
            <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                <dt class="font-semibold text-slate-200">Azienda</dt>
                <dd><?= sanitize($ordine['azienda']); ?></dd>
            </div>
            <div class="flex flex-col gap-1 md:flex-row md:items-center md:justify-between">
                <dt class="font-semibold text-slate-200">Totale</dt>
                <dd class="text-accent-300">&euro; <?= format_currency($totale); ?></dd>
            </div>
            <div class="flex flex-col gap-1 md:flex-row md:items-start md:justify-between">
                <dt class="font-semibold text-slate-200">Note</dt>
                <dd class="md:max-w-lg"><?= sanitize($ordine['note']); ?></dd>
            </div>
        </dl>
        <a class="button-liquid mt-8 inline-flex items-center gap-2 rounded-full bg-accent-500 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-midnight-950 transition hover:bg-accent-400" href="/user/dashboard.php">Vai alla dashboard</a>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
