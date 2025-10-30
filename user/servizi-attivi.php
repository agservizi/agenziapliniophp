<?php
require_once __DIR__ . '/../includes/auth.php';
require_auth();

$servizi = [
    ['nome' => 'Automation Hub', 'stato' => 'Attivo', 'scadenza' => '31/12/2025', 'descrizione' => 'Automazione processi lead e CRM integrato.'],
    ['nome' => 'Strategy Lab', 'stato' => 'In onboarding', 'scadenza' => '31/03/2025', 'descrizione' => 'Roadmap strategica con workshop mensili.'],
    ['nome' => 'Brand Experience', 'stato' => 'In evoluzione', 'scadenza' => '30/06/2025', 'descrizione' => 'Design system multi-touchpoint in rollout.'],
];

$pageTitle = 'Servizi attivi';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Servizi attivi</h1>
        <p class="subtitle">Gestisci gli stati di avanzamento e richiedi nuove attivazioni.</p>
    </div>
</section>
<section class="section">
    <div class="container" data-stagger>
        <?php foreach ($servizi as $servizio): ?>
            <div class="card service-card" style="margin-bottom: 24px;">
                <div class="columns is-vcentered">
                    <div class="column">
                        <h2 class="title is-4"><?= sanitize($servizio['nome']); ?></h2>
                        <p><?= sanitize($servizio['descrizione']); ?></p>
                    </div>
                    <div class="column is-one-quarter">
                        <span class="tag is-warning is-light">Stato: <?= sanitize($servizio['stato']); ?></span>
                    </div>
                    <div class="column is-one-quarter">
                        <p>Scadenza: <?= sanitize($servizio['scadenza']); ?></p>
                        <a class="button is-warning is-small" href="#">Apri dettagli</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
