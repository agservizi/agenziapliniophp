<?php
$pageTitle = 'Benvenuti';
require_once __DIR__ . '/includes/header.php';
?>
<section class="hero is-fullheight" data-parallax data-intensity="12">
    <div class="parallax-scene">
    <div class="parallax-layer background" data-parallax-layer data-depth="0.2" style="background-image: url('assets/img/hero-background.svg');"></div>
    <div class="parallax-layer midground" data-parallax-layer data-depth="0.5" style="background-image: url('assets/img/hero-mid.svg');"></div>
    <div class="parallax-layer foreground" data-parallax-layer data-depth="0.9" style="background-image: url('assets/img/hero-fore.svg');"></div>
        <div class="parallax-overlay"></div>
    </div>
    <div class="hero-body">
        <div class="container" data-animate="fade-up">
            <h1 class="hero-title">Strategie Digitali per Aziende Visionarie</h1>
            <p class="hero-subtitle">Un portale integrato che unisce consulenza, servizi gestionali e vendita prodotti premium con un ecosistema digitale fluido.</p>
            <div class="hero-cta">
                <a class="button is-warning button-liquid" href="/servizi.php">Esplora servizi</a>
                <a class="button is-light is-outlined" href="/shop/index.php">Scopri lo shop</a>
            </div>
        </div>
    </div>
</section>
<section class="section section-light" id="digital">
    <div class="container">
        <div class="columns is-vcentered">
            <div class="column" data-animate="fade-right">
                <h2 class="title section-title">Soluzioni digitali end-to-end</h2>
                <p class="section-subtitle">Dalla strategia alla realizzazione, trasformiamo i processi aziendali con tecnologie avanzate, monitoraggio continuo e supporto consulenziale dedicato.</p>
                <div class="columns" data-stagger>
                    <div class="column">
                        <div class="dashboard-widget">
                            <p class="heading">Progetti completati</p>
                            <p class="dashboard-metric" data-counter="128">0</p>
                        </div>
                    </div>
                    <div class="column">
                        <div class="dashboard-widget">
                            <p class="heading">Clienti attivi</p>
                            <p class="dashboard-metric" data-counter="86">0</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="column" data-animate="fade-left">
                <div class="card service-card">
                    <h3 class="title is-4">Pianificazione Strategica Continua</h3>
                    <p>Workshops, analisi dati e roadmap trimestrali con i nostri strategist dedicati per accelerare la crescita.</p>
                </div>
                <div class="card service-card" style="margin-top: 24px;">
                    <h3 class="title is-4">Integrazione Tecnologica</h3>
                    <p>Soluzioni cloud, CRM e automazioni integrate con la tua suite esistente senza frizioni operative.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section section-dark" id="branding">
    <div class="container">
        <div class="columns">
            <div class="column" data-animate="fade-up">
                <h2 class="title section-title">Brand Experience immersiva</h2>
                <p class="section-subtitle">Narrazioni coinvolgenti, design system dinamici e attivazioni omnicanale per posizionare il tuo brand in modo memorabile.</p>
            </div>
        </div>
        <div class="columns is-multiline" data-stagger>
            <div class="column is-one-third">
                <div class="card service-card">
                    <h4 class="title is-5">Esperienze Interattive</h4>
                    <p>Prototipi immersivi, storytelling motion e micro-interazioni progettate per engagement elevato.</p>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="card service-card">
                    <h4 class="title is-5">Design System Enterprise</h4>
                    <p>Librerie componenti responsive e guideline complete per marketing e prodotto.</p>
                </div>
            </div>
            <div class="column is-one-third">
                <div class="card service-card">
                    <h4 class="title is-5">Insight & Analytics</h4>
                    <p>Suite dashboard avanzata con KPI real-time, heatmap comportamentali e sentiment analysis.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<section class="section" id="automation">
    <div class="container">
        <div class="columns is-vcentered">
            <div class="column" data-animate="fade-right">
                <h2 class="title section-title">Automazione e scalabilità</h2>
                <p class="section-subtitle">Moduli verticali per gestione delle richieste digitali, ticketing e distribuzione documentale con workflow configurabili.</p>
            </div>
            <div class="column" data-animate="fade-left">
                <div class="columns is-multiline" data-stagger>
                    <div class="column is-half">
                        <div class="dashboard-widget">
                            <p class="heading">Ticket risolti</p>
                            <p class="dashboard-metric" data-counter="742">0</p>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="dashboard-widget">
                            <p class="heading">SLA rispettati</p>
                            <p class="dashboard-metric" data-counter="98">0</p>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="dashboard-widget">
                            <p class="heading">Automazioni attive</p>
                            <p class="dashboard-metric" data-counter="54">0</p>
                        </div>
                    </div>
                    <div class="column is-half">
                        <div class="dashboard-widget">
                            <p class="heading">Documenti digitali</p>
                            <p class="dashboard-metric" data-counter="1520">0</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/includes/footer.php'; ?>
