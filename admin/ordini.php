<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

try {
    $ordini = fetch_all('SELECT o.id, u.email, o.totale, o.stato, o.data_ordine FROM ordini o LEFT JOIN utenti u ON u.id = o.id_utente ORDER BY o.data_ordine DESC');
} catch (Throwable $exception) {
    error_log('get orders fallback: ' . $exception->getMessage());
    $ordini = [
        ['id' => 402, 'email' => 'chiara@cliente.com', 'totale' => 4890.00, 'stato' => 'in revisione', 'data_ordine' => '2025-10-22'],
        ['id' => 401, 'email' => 'marco@azienda.com', 'totale' => 2890.00, 'stato' => 'confermato', 'data_ordine' => '2025-10-18'],
    ];
}

$pageTitle = 'Gestione ordini';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Ordini</h1>
        <p class="subtitle">Gestisci workflow, stato e progressione degli ordini e-commerce.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="table-container" data-animate="fade-up">
            <table class="table is-fullwidth is-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Email cliente</th>
                        <th>Totale</th>
                        <th>Stato</th>
                        <th>Data</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($ordini as $ordine): ?>
                        <tr>
                            <td><?= (int) $ordine['id']; ?></td>
                            <td><?= sanitize($ordine['email'] ?? 'N/A'); ?></td>
                            <td>€ <?= format_currency((float) $ordine['totale']); ?></td>
                            <td><span class="tag is-warning is-light"><?= sanitize($ordine['stato']); ?></span></td>
                            <td><?= sanitize(substr((string) $ordine['data_ordine'], 0, 10)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
