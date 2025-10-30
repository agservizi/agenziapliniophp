<?php
$pageTitle = 'Servizi';
require_once __DIR__ . '/includes/header.php';
?>
<section class="section section-dark">
    <div class="container" data-animate="fade-up">
        <h1 class="title">Servizi premium</h1>
        <p class="subtitle">Soluzioni modulari e scalabili per accelerare la trasformazione digitale della tua organizzazione.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns is-multiline" data-stagger>
            <?php
            $services = [
                ['icon' => '🧭', 'title' => 'Strategy Lab', 'desc' => 'Analisi strategica e piani di crescita trimestrali basati su insight di mercato.'],
                ['icon' => '⚙️', 'title' => 'Automation Hub', 'desc' => 'Workflow intelligenti, RPA e orchestrazione processi per ridurre il time-to-market.'],
                ['icon' => '📊', 'title' => 'Data Intelligence', 'desc' => 'Dashboard predittive, modellazione dati e monitoraggio KPI avanzato.'],
                ['icon' => '🛡️', 'title' => 'Secure Cloud', 'desc' => 'Infrastrutture cloud ibride, cybersecurity e compliance end-to-end.'],
                ['icon' => '🎨', 'title' => 'Brand Experience', 'desc' => 'Esperienze immersive, design system custom e motion design enterprise.'],
                ['icon' => '🤝', 'title' => 'Customer Success', 'desc' => 'Gestione richieste, ticketing avanzato e programmi loyalty intelligenti.'],
            ];
            foreach ($services as $service): ?>
                <div class="column is-one-third">
                    <div class="card service-card">
                        <h3 class="title is-4"><?= sanitize($service['icon'] . ' ' . $service['title']); ?></h3>
                        <p><?= sanitize($service['desc']); ?></p>
                        <a class="button is-warning is-light button-liquid" href="/contatti.php">Richiedi demo</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<section class="section section-dark">
    <div class="container">
        <div class="columns" data-animate="fade-up">
            <div class="column is-two-thirds">
                <h2 class="title">Servizi digitali gestiti</h2>
                <p class="subtitle">Monitora richieste, stato dei progetti, documenti e SLA direttamente dall&apos;area clienti con notifiche real-time.</p>
            </div>
        </div>
        <div class="columns is-variable is-6" data-stagger>
            <div class="column">
                <div class="dashboard-widget">
                    <p class="heading">Onboarding</p>
                    <p>Workshop dedicati, training e configurazione setup con team multidisciplinare.</p>
                </div>
            </div>
            <div class="column">
                <div class="dashboard-widget">
                    <p class="heading">Gestione servizi</p>
                    <p>Workflow personalizzati, automazioni e condivisione documenti con controlli granulari.</p>
                </div>
            </div>
            <div class="column">
                <div class="dashboard-widget">
                    <p class="heading">Supporto dedicato</p>
                    <p>Customer success manager, chat assistita e ticketing integrato multi-canale.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
