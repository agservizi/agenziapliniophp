<?php
$pageTitle = 'Servizi';
$services = require __DIR__ . '/includes/services-data.php';
require_once __DIR__ . '/includes/header.php';

$heroHighlights = [
    'Sportello certificato per pagamenti, pratiche fiscali e attivazioni digitali',
    'Consulenza dedicata per privati, professionisti e imprese',
    'Partnership con più di 20 operatori nazionali',
];

$heroStats = [
    ['value' => '3.500+', 'label' => 'Pratiche gestite ogni anno'],
    ['value' => '25+', 'label' => 'Partnership certificate'],
    ['value' => '9', 'label' => 'Aree di competenza presidiate'],
];

$pillars = [
    [
        'title' => 'Sportello unico',
        'description' => 'Coordiniamo pagamenti, pratiche fiscali, spedizioni e servizi digitali in un unico punto a Castellammare di Stabia.',
        'items' => [
            'Procedure certificate DropPoint, CAF e Patronato',
            'Flussi digitali tracciati con conservazione documentale',
            'Operatori qualificati e aggiornati sulle normative',
        ],
    ],
    [
        'title' => 'Consulenza su misura',
        'description' => 'Analizziamo ogni richiesta per proporre la soluzione più efficace, ottimizzando tempi e costi.',
        'items' => [
            'Analisi bollette, documentazione e scadenziari',
            'Supporto dedicato per aziende, professionisti e famiglie',
            'Agenda appuntamenti priority e promemoria automatici',
        ],
    ],
    [
        'title' => 'Partner di fiducia',
        'description' => 'Collaboriamo con corrieri, provider digitali e operatori nazionali per garantire continuità di servizio.',
        'items' => [
            'BRT, Poste Italiane, DHL, FedEx, GLS e UPS',
            'Namirial, PagoPA, Trenitalia, Italo, FlixBus e oltre 20 brand',
            'Offerte negoziate e tariffe trasparenti',
        ],
    ],
];

$journeySteps = [
    [
        'title' => 'Prenota o passa in agenzia',
        'description' => 'Gestiamo richieste su appuntamento o accesso diretto. Consigliamo di prenotare per pratiche complesse.',
    ],
    [
        'title' => 'Valutazione documenti',
        'description' => 'Verifichiamo insieme documentazione e requisiti, suggerendo eventuali integrazioni.',
    ],
    [
        'title' => 'Esecuzione certificata',
        'description' => 'Completiamo la pratica, rilasciando ricevute digitali e promemoria sullo stato di avanzamento.',
    ],
];
?>

<section class="section service-hero">
    <div class="container">
        <div class="columns is-vcentered is-variable is-6" data-animate="fade-up">
            <div class="column is-12-tablet is-7-desktop">
                <p class="service-eyebrow">Agenzia multiservizi certificata</p>
                <h1 class="title is-1">Servizi integrati per privati, professionisti e imprese</h1>
                <p class="subtitle">Pagamenti, pratiche amministrative, spedizioni e consulenza digitale con un unico partner a Castellammare di Stabia.</p>
                <ul class="service-hero__bullets">
                    <?php foreach ($heroHighlights as $item): ?>
                        <li><?= sanitize($item); ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="column is-12-tablet is-5-desktop">
                <div class="service-hero__stats">
                    <?php foreach ($heroStats as $stat): ?>
                        <div class="service-stat">
                            <span class="service-stat__value"><?= sanitize($stat['value']); ?></span>
                            <span class="service-stat__label"><?= sanitize($stat['label']); ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-light service-pillars">
    <div class="container">
        <div class="columns is-multiline is-variable is-5" data-stagger>
            <?php foreach ($pillars as $pillar): ?>
                <div class="column is-12-tablet is-one-third-desktop">
                    <div class="card service-pillar">
                        <div class="card-content">
                            <h3 class="title is-5"><?= sanitize($pillar['title']); ?></h3>
                            <p><?= sanitize($pillar['description']); ?></p>
                            <?php if (!empty($pillar['items'])): ?>
                                <ul class="service-list">
                                    <?php foreach ($pillar['items'] as $item): ?>
                                        <li><?= sanitize($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section service-directory">
    <div class="container">
        <div class="columns is-variable is-6">
            <aside class="column is-12-tablet is-4-desktop">
                <div class="service-nav" data-sticky>
                    <p class="service-nav__title">Percorsi rapidi</p>
                    <ul class="service-nav__list">
                        <?php foreach ($services as $service): ?>
                            <li>
                                <a class="service-nav__link" href="servizi/<?= sanitize($service['slug']); ?>.php">
                                    <?= sanitize($service['name']); ?>
                                </a>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="service-nav__cta">
                        <a class="button is-warning is-fullwidth" href="https://wa.me/393773798570?text=Vorrei%20parlare%20con%20un%20consulente" target="_blank" rel="noopener noreferrer">
                            Parla con un consulente
                        </a>
                    </div>
                </div>
            </aside>
            <div class="column is-12-tablet is-8-desktop">
                <div class="service-directory__grid" data-stagger>
                    <?php foreach ($services as $index => $service): ?>
                        <?php $focusItems = $service['focus'] ?? []; ?>
                        <?php $ctaItems = $service['cta'] ?? []; ?>
                        <article class="service-directory__card" data-animate="fade-up" data-delay="<?= (int) ($index * 60); ?>">
                            <header class="service-directory__header">
                                <span class="service-directory__icon" aria-hidden="true"><?= sanitize($service['icon']); ?></span>
                                <div>
                                    <h2 class="title is-4"><?= sanitize($service['name']); ?></h2>
                                    <p class="service-directory__tagline"><?= sanitize($service['tagline']); ?></p>
                                </div>
                            </header>
                            <p class="service-directory__intro"><?= sanitize($service['intro']); ?></p>

                            <?php if (!empty($focusItems)): ?>
                                <ul class="service-list service-directory__focus">
                                    <?php foreach (array_slice($focusItems, 0, 3) as $focus): ?>
                                        <li><?= sanitize($focus); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            <?php endif; ?>

                            <div class="service-directory__actions">
                                <a class="button is-warning" href="servizi/<?= sanitize($service['slug']); ?>.php">Approfondisci</a>
                                <?php if (!empty($ctaItems)): ?>
                                    <?php $primaryCta = $ctaItems[0]; ?>
                                    <a class="button is-light" href="<?= htmlspecialchars($primaryCta['url']); ?>"<?= !empty($primaryCta['external']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?= sanitize($primaryCta['label']); ?></a>
                                <?php endif; ?>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-light service-journey">
    <div class="container">
        <div class="service-journey__intro" data-animate="fade-up">
            <span class="service-eyebrow">Come lavoriamo</span>
            <h2 class="title is-3">Dal primo contatto alla consegna della pratica</h2>
            <p class="subtitle is-5">Ogni servizio è seguito da consulenti dedicati che monitorano lo stato della pratica e ti aggiornano con promemoria puntuali.</p>
        </div>
        <div class="columns is-variable is-5" data-stagger>
            <?php foreach ($journeySteps as $step): ?>
                <div class="column is-12-tablet is-one-third-desktop">
                    <div class="service-journey__step">
                        <h3 class="title is-5"><?= sanitize($step['title']); ?></h3>
                        <p><?= sanitize($step['description']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-light service-cta">
    <div class="container">
        <div class="columns is-variable is-6 is-vcentered">
            <div class="column is-12-tablet is-7-desktop">
                <h2 class="title is-3">Serve supporto dedicato?</h2>
                <p class="subtitle is-5">Il nostro team è a disposizione per gestire pratiche complesse, appuntamenti dedicati e integrazioni di servizi per aziende e professionisti.</p>
                <div class="service-contact-grid">
                    <div>
                        <p class="heading">Sportello fisico</p>
                        <p>Via Plinio il Vecchio 72<br>Castellammare di Stabia (NA)</p>
                    </div>
                    <div>
                        <p class="heading">Orari</p>
                        <p>Lun-Ven 9:00-13:20 / 16:00-19:20<br>Sab 9:00-13:00</p>
                    </div>
                </div>
            </div>
            <div class="column is-12-tablet is-5-desktop">
                <div class="box service-cta__box">
                    <p class="heading">Contatti diretti</p>
                    <ul class="service-contact-list">
                        <li><a href="tel:+390810584542">+39 081 0584542</a></li>
                        <li><a href="mailto:info@agenziaplinio.it">info@agenziaplinio.it</a></li>
                        <li><a href="https://wa.me/393773798570?text=Ho%20bisogno%20di%20assistenza" target="_blank" rel="noopener noreferrer">WhatsApp 377 3798570</a></li>
                    </ul>
                    <p class="service-cta__note">P.IVA 08442881218 • REA NA-985288 • Conforme al GDPR (UE) 2016/679</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
