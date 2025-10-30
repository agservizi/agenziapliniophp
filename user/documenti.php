<?php
require_once __DIR__ . '/../includes/auth.php';
require_auth();

$documenti = [
    ['titolo' => 'Report KPI Q3', 'data' => '15/10/2025', 'link' => '#', 'tipo' => 'Analitica'],
    ['titolo' => 'Contratto servizio Automation Hub', 'data' => '01/07/2025', 'link' => '#', 'tipo' => 'Contrattuale'],
    ['titolo' => 'Linee guida brand', 'data' => '22/09/2025', 'link' => '#', 'tipo' => 'Design'],
];

$pageTitle = 'Documenti';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Documenti</h1>
        <p class="subtitle">Scarica report, contratti e deliverable aggiornati.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="table-container" data-animate="fade-up">
            <table class="table is-fullwidth is-dark">
                <thead>
                    <tr>
                        <th>Titolo</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th>Azione</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($documenti as $doc): ?>
                        <tr>
                            <td><?= sanitize($doc['titolo']); ?></td>
                            <td><?= sanitize($doc['tipo']); ?></td>
                            <td><?= sanitize($doc['data']); ?></td>
                            <td><a class="button is-small is-warning" href="<?= $doc['link']; ?>">Download</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
