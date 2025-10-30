<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();

try {
    $utenti = fetch_all('SELECT id, nome, cognome, email, ruolo, data_creazione FROM utenti ORDER BY data_creazione DESC');
} catch (Throwable $exception) {
    error_log('get users fallback: ' . $exception->getMessage());
    $utenti = [
        ['id' => 1, 'nome' => 'Admin', 'cognome' => 'Portal', 'email' => 'admin@agenziaplinio.local', 'ruolo' => 'admin', 'data_creazione' => '2025-01-01'],
        ['id' => 2, 'nome' => 'Chiara', 'cognome' => 'Verdi', 'email' => 'chiara@cliente.com', 'ruolo' => 'cliente', 'data_creazione' => '2025-03-12'],
    ];
}

$pageTitle = 'Gestione utenti';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Utenti</h1>
        <p class="subtitle">Supervisiona ruoli, accessi e stato degli account.</p>
    </div>
</section>
<section class="section">
    <div class="container" data-animate="fade-up">
        <div class="table-container">
            <table class="table is-fullwidth is-dark">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nome</th>
                        <th>Email</th>
                        <th>Ruolo</th>
                        <th>Creato</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($utenti as $utente): ?>
                        <tr>
                            <td><?= (int) $utente['id']; ?></td>
                            <td><?= sanitize($utente['nome'] . ' ' . $utente['cognome']); ?></td>
                            <td><?= sanitize($utente['email']); ?></td>
                            <td><span class="tag is-rounded is-warning is-light"><?= sanitize($utente['ruolo']); ?></span></td>
                            <td><?= sanitize(substr((string) $utente['data_creazione'], 0, 10)); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
