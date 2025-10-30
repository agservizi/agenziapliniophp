<?php
$pageTitle = 'Servizi';
$services = require __DIR__ . '/includes/services-data.php';
require_once __DIR__ . '/includes/header.php';

$heroHighlights = [
    'Sportello certificato per pagamenti, pratiche fiscali e attivazioni digitali',
    'Consulenza dedicata per privati, professionisti e imprese',
    'Partnership con pi&ugrave; di 20 operatori nazionali',
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
        'description' => 'Analizziamo ogni richiesta per proporre la soluzione pi&ugrave; efficace, ottimizzando tempi e costi.',
        'items' => [
            'Analisi bollette, documentazione e scadenziari',
            'Supporto dedicato per aziende, professionisti e famiglie',
            'Agenda appuntamenti priority e promemoria automatici',
        ],
    ],
    [
        'title' => 'Partner di fiducia',
        'description' => 'Collaboriamo con corrieri, provider digitali e operatori nazionali per garantire continuit&agrave; di servizio.',
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

<section class="mx-auto max-w-6xl px-6" data-animate="fade-up">
    <div class="glass-panel overflow-hidden p-10 md:p-14">
        <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="space-y-6">
                <span class="badge-glow">Agenzia multiservizi certificata</span>
                <h1 class="font-display text-4xl font-semibold text-white md:text-5xl">Servizi integrati per privati, professionisti e imprese</h1>
                <p class="text-lg text-slate-300">Pagamenti, pratiche amministrative, spedizioni e consulenza digitale con un unico partner a Castellammare di Stabia.</p>
                <ul class="mt-8 space-y-4 text-sm text-slate-300">
                    <?php foreach ($heroHighlights as $item): ?>
                        <li class="flex items-start gap-3">
                            <span class="mt-2 h-2.5 w-2.5 rounded-full bg-accent-400"></span>
                            <span><?= sanitize($item); ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <div class="grid gap-4 sm:grid-cols-2" data-stagger>
                <?php foreach ($heroStats as $stat): ?>
                    <div class="stat-card rounded-3xl p-6 text-center">
                        <span class="text-3xl font-semibold text-accent-300"><?= sanitize($stat['value']); ?></span>
                        <p class="mt-2 text-xs font-semibold uppercase tracking-[0.32em] text-slate-400"><?= sanitize($stat['label']); ?></p>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>

<section class="mx-auto mt-28 max-w-6xl px-6">
    <div class="flex flex-col gap-4 text-center md:text-left">
        <span class="badge-glow mx-auto md:mx-0">Pilastri operativi</span>
        <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Processi orchestrati per ogni esigenza</h2>
        <p class="text-base text-slate-300 md:max-w-3xl md:text-lg">Ogni servizio &egrave; progettato per ridurre attriti, ottimizzare tempi e offrire continuit&agrave; al cliente finale.</p>
    </div>
    <div class="mt-12 grid gap-8 md:grid-cols-2 xl:grid-cols-3" data-stagger>
        <?php foreach ($pillars as $pillar): ?>
            <article class="service-card p-8">
                <h3 class="text-xl font-semibold text-white"><?= sanitize($pillar['title']); ?></h3>
                <p class="mt-3 text-sm text-slate-300"><?= sanitize($pillar['description']); ?></p>
                <?php if (!empty($pillar['items'])): ?>
                    <ul class="mt-6 space-y-3 text-sm text-slate-300">
                        <?php foreach ($pillar['items'] as $item): ?>
                            <li class="flex items-start gap-3">
                                <span class="mt-2 h-2 w-2 rounded-full bg-accent-400"></span>
                                <span><?= sanitize($item); ?></span>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                <?php endif; ?>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="mx-auto mt-32 max-w-6xl px-6">
    <div class="grid gap-12 lg:grid-cols-[0.38fr,1fr]">
        <aside class="glass-panel sticky top-32 p-8" data-animate="fade-right" data-stagger>
            <span class="badge-glow">Percorsi rapidi</span>
            <ul class="mt-6 space-y-2">
                <?php foreach ($services as $service): ?>
                    <li>
                        <a class="flex items-center justify-between rounded-2xl border border-white/5 bg-white/5 px-5 py-3 text-sm font-semibold text-slate-200 transition hover:border-accent-400 hover:text-accent-300" href="servizi/<?= sanitize($service['slug']); ?>.php">
                            <span><?= sanitize($service['name']); ?></span>
                            <span class="text-xs uppercase tracking-[0.32em] text-slate-400">Apri</span>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <div class="mt-6 flex">
                <a class="button-liquid inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" href="https://wa.me/393773798570?text=Vorrei%20parlare%20con%20un%20consulente" target="_blank" rel="noopener noreferrer">
                    Parla con un consulente
                </a>
            </div>
        </aside>
        <div class="space-y-10" data-stagger>
            <?php foreach ($services as $index => $service): ?>
                <?php $focusItems = $service['focus'] ?? []; ?>
                <?php $ctaItems = $service['cta'] ?? []; ?>
                <article class="glass-panel p-8" data-animate="fade-up" data-delay="<?= (int) ($index * 60); ?>">
                    <header class="flex items-start gap-4">
                        <span class="grid h-12 w-12 place-items-center rounded-2xl border border-white/10 bg-white/5 text-lg text-accent-300" aria-hidden="true"><?= sanitize($service['icon']); ?></span>
                        <div>
                            <h2 class="text-2xl font-semibold text-white"><?= sanitize($service['name']); ?></h2>
                            <p class="mt-1 text-xs uppercase tracking-[0.3em] text-slate-400"><?= sanitize($service['tagline']); ?></p>
                        </div>
                    </header>
                    <p class="mt-6 text-sm text-slate-300"><?= sanitize($service['intro']); ?></p>

                    <?php if (!empty($focusItems)): ?>
                        <ul class="mt-6 space-y-3 text-sm text-slate-300">
                            <?php foreach (array_slice($focusItems, 0, 3) as $focus): ?>
                                <li class="flex items-start gap-3">
                                    <span class="mt-2 h-2 w-2 rounded-full bg-accent-400"></span>
                                    <span><?= sanitize($focus); ?></span>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a class="button-liquid inline-flex items-center gap-2 rounded-full bg-accent-500 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-midnight-950 transition hover:bg-accent-400" href="servizi/<?= sanitize($service['slug']); ?>.php">Approfondisci</a>
                        <?php if (!empty($ctaItems)): ?>
                            <?php $primaryCta = $ctaItems[0]; ?>
                            <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="<?= htmlspecialchars($primaryCta['url']); ?>"<?= !empty($primaryCta['external']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?= sanitize($primaryCta['label']); ?></a>
                        <?php endif; ?>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="mx-auto mt-32 max-w-6xl px-6">
    <div class="flex flex-col gap-4 text-center md:text-left" data-animate="fade-up">
        <span class="badge-glow mx-auto md:mx-0">Come lavoriamo</span>
        <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Dal primo contatto alla consegna certificata</h2>
        <p class="text-base text-slate-300 md:max-w-3xl md:text-lg">Ogni pratica &egrave; seguita da consulenti dedicati che monitorano tempi, documentazione e aggiornamenti per evitare rallentamenti.</p>
    </div>
    <div class="mt-12 grid gap-8 md:grid-cols-2 xl:grid-cols-3" data-stagger>
        <?php foreach ($journeySteps as $step): ?>
            <article class="glass-panel p-8">
                <h3 class="text-xl font-semibold text-white"><?= sanitize($step['title']); ?></h3>
                <p class="mt-3 text-sm text-slate-300"><?= sanitize($step['description']); ?></p>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section class="mx-auto mt-32 max-w-6xl px-6" data-animate="fade-up">
    <div class="glass-panel p-10">
        <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="space-y-6">
                <span class="badge-glow">Serve supporto dedicato?</span>
                <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Gestiamo pratiche complesse con team dedicati</h2>
                <p class="text-lg text-slate-300">Coordiniamo appuntamenti priority, integrazioni documentali e flussi personalizzati per aziende, professionisti e famiglie.</p>
                <div class="grid gap-6 sm:grid-cols-2">
                    <div class="rounded-2xl border border-white/10 bg-midnight-900/50 p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Sportello fisico</p>
                        <p class="mt-3 text-sm text-slate-300">Via Plinio il Vecchio 72<br>Castellammare di Stabia (NA)</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-midnight-900/50 p-6">
                        <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Orari</p>
                        <p class="mt-3 text-sm text-slate-300">Lun-Ven 9:00-13:20 / 16:00-19:20<br>Sab 9:00-13:00</p>
                    </div>
                </div>
            </div>
            <div class="rounded-[28px] border border-white/10 bg-midnight-900/60 p-8">
                <h3 class="text-lg font-semibold text-white">Contatti diretti</h3>
                <ul class="mt-4 space-y-2 text-sm text-slate-200">
                    <li><a class="transition hover:text-accent-300" href="tel:+390810584542">+39 081 0584542</a></li>
                    <li><a class="transition hover:text-accent-300" href="mailto:info@agenziaplinio.it">info@agenziaplinio.it</a></li>
                    <li><a class="transition hover:text-accent-300" href="https://wa.me/393773798570?text=Ho%20bisogno%20di%20assistenza" target="_blank" rel="noopener noreferrer">WhatsApp 377 3798570</a></li>
                </ul>
                <p class="mt-6 text-xs uppercase tracking-[0.3em] text-slate-500">P.IVA 08442881218 &bull; REA NA-985288 &bull; Conforme GDPR (UE) 2016/679</p>
                <div class="mt-6 flex flex-wrap gap-3">
                    <a class="button-liquid inline-flex items-center gap-2 rounded-full bg-accent-500 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-midnight-950 transition hover:bg-accent-400" href="/contatti.php">Prenota una call</a>
                    <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/form/newsletter.php">Iscriviti alla newsletter</a>
                </div>
            </div>
        </div>
    </div>
</section>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
