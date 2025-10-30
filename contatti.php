<?php
$pageTitle = 'Contatti';
require_once __DIR__ . '/includes/header.php';
?>
<section class="section section-dark">
    <div class="container" data-animate="fade-up">
        <h1 class="title">Parliamo del tuo progetto</h1>
        <p class="subtitle">Compila il form e il nostro team ti ricontatterà entro 24 ore lavorative con una proposta personalizzata.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns is-variable is-8">
            <div class="column" data-animate="fade-right">
                <form class="box" method="post" action="/form/contatti.php" novalidate>
                    <?= csrf_field(); ?>
                    <div class="field">
                        <label class="label" for="nome">Nome e cognome</label>
                        <div class="control">
                            <input class="input" type="text" id="nome" name="nome" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="email">Email aziendale</label>
                        <div class="control">
                            <input class="input" type="email" id="email" name="email" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="azienda">Azienda</label>
                        <div class="control">
                            <input class="input" type="text" id="azienda" name="azienda" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label" for="messaggio">Messaggio</label>
                        <div class="control">
                            <textarea class="textarea" id="messaggio" name="messaggio" rows="5" required></textarea>
                        </div>
                    </div>
                    <div class="field is-grouped is-grouped-right">
                        <div class="control">
                            <button type="submit" class="button is-warning button-liquid">Invia richiesta</button>
                        </div>
                    </div>
                </form>
            </div>
            <div class="column" data-animate="fade-left">
                <div class="dashboard-widget">
                    <h2 class="title is-4">Hub Milano</h2>
                    <p>Via Innovazione 21, 20159 Milano</p>
                    <p>supporto@agenziaplinio.local</p>
                    <p>+39 02 1234 5678</p>
                    <hr>
                    <p>Orari: Lun-Ven 09:00-18:30</p>
                    <p>Disponibilità meeting anche in remoto con il team multi-disciplinare.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
