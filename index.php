<?php
$pageTitle = 'Benvenuti';
require_once __DIR__ . '/includes/header.php';

$serviceCategories = [
    [
        'title' => 'Pagamenti',
        'description' => 'Bollettini, F24, PagoPA, MAV/RAV, bollo auto e bonifici con DropPoint.',
        'href' => '/servizi/pagamenti.php'
    ],
    [
        'title' => 'Spedizioni',
        'description' => 'Spedizioni nazionali e internazionali con BRT, Poste Italiane, TNT/FedEx.',
        'href' => '/servizi/spedizioni.php'
    ],
    [
        'title' => 'Attivazioni Digitali',
        'description' => 'SPID, PEC, firma digitale Namirial, conservazione documentale e servizi trust provider.',
        'href' => '/servizi/attivazioni-digitali.php'
    ],
    [
        'title' => 'Telefonia e Utenze',
        'description' => 'Nuove linee, portabilità, offerte voce e dati per mobile, fisso, luce e gas.',
        'href' => '/servizi/telefonia.php'
    ],
    [
        'title' => 'CAF e Patronato',
        'description' => 'Assistenza completa su pratiche fiscali, previdenziali e servizi INPS/INAIL.',
        'href' => '/servizi/caf-patronato.php'
    ],
    [
        'title' => 'Servizi Postali',
        'description' => 'Raccomandate, posta prioritaria, plichi assicurati e gestione punto ritiro.',
        'href' => '/servizi/posta-telematica.php'
    ],
];

$stats = [
    ['label' => 'Clienti soddisfatti', 'value' => '180'],
    ['label' => 'Anni di esperienza', 'value' => '9'],
    ['label' => 'Servizi offerti', 'value' => '12'],
    ['label' => 'Pratiche gestite', 'value' => '600'],
];

$pillars = [
    [
        'title' => 'Professionalità',
        'copy' => 'Un team qualificato, aggiornato su normative e procedure per risposte rapide e corrette.'
    ],
    [
        'title' => 'Affidabilità',
        'copy' => 'Impegni mantenuti e processi monitorati per consegnare risultati concreti ai clienti.'
    ],
    [
        'title' => 'Vicini al territorio',
        'copy' => 'Siamo nel cuore di Castellammare di Stabia, punto di riferimento unico per famiglie e imprese.'
    ],
];

$testimonialHighlights = [
    [
        'quote' => 'Servizio impeccabile, pratiche chiuse in tempi rapidi con grande disponibilità.',
        'name'  => 'Giuseppe R.',
        'rating' => '5'
    ],
    [
        'quote' => 'Staff cortese e preparato, mi hanno guidato passo passo con il mio SPID.',
        'name'  => 'Francesca M.',
        'rating' => '5'
    ],
    [
        'quote' => 'Un partner affidabile per spedizioni e pagamenti. Consigliatissimi!',
        'name'  => 'Luca D.',
        'rating' => '4.8'
    ],
];
?>

<section id="hero" class="relative overflow-hidden rounded-[34px] border border-white/10 bg-gradient-to-br from-midnight-925 via-midnight-900 to-midnight-950 px-6 py-24 sm:py-28">
    <div class="absolute inset-0 -z-10 bg-[radial-gradient(circle_at_top,_rgba(96,165,250,0.22),_transparent_55%)] opacity-90"></div>
    <div class="mx-auto grid max-w-6xl items-center gap-16 lg:grid-cols-[1.15fr,0.85fr]">
        <div class="space-y-8">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-200">Agenzia multiservizi a Castellammare di Stabia</span>
            <h1 class="font-display text-4xl font-semibold leading-tight text-white md:text-5xl lg:text-6xl">Tutti i servizi di cui hai bisogno in un unico posto</h1>
            <p class="text-lg text-slate-300 md:text-xl">Pagamenti, spedizioni, attivazioni digitali, telefonia, CAF e Patronato. Con AG Servizi semplifichi la tua giornata con un team competente e sempre disponibile.</p>
            <div class="flex flex-wrap gap-4">
                <a class="inline-flex items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" href="/servizi.php">
                    Scopri i nostri servizi
                </a>
                <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-slate-200 transition hover:border-accent-500 hover:text-accent-300" href="/contatti.php">
                    Prenota un appuntamento
                </a>
            </div>
        </div>
        <div class="rounded-[32px] border border-white/10 bg-midnight-900/60 p-8 shadow-primary">
            <h2 class="text-2xl font-semibold text-white">Perché sceglierci</h2>
            <p class="mt-3 text-sm text-slate-300">Soluzioni rapide, assistenza dedicata e servizi certificati per privati, professionisti e aziende.</p>
            <dl class="mt-8 grid gap-4 sm:grid-cols-2">
                <?php foreach ($stats as $item): ?>
                    <div class="rounded-2xl border border-white/10 bg-white/5 px-5 py-4">
                        <dt class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400"><?= sanitize($item['label']); ?></dt>
                        <dd class="mt-2 text-3xl font-semibold text-accent-300" data-counter="<?= sanitize($item['value']); ?>">0</dd>
                    </div>
                <?php endforeach; ?>
            </dl>
        </div>
    </div>
</section>

<section id="services" class="mx-auto mt-24 max-w-6xl px-6">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div class="space-y-4">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-200">I nostri servizi</span>
            <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Un catalogo completo pensato per ogni esigenza</h2>
            <p class="max-w-2xl text-base text-slate-300 md:text-lg">Dalle pratiche burocratiche ai servizi digitali. Ci occupiamo di pagamenti, spedizioni, consulenza fiscale, attivazioni e molto altro con partner certificati.</p>
        </div>
        <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-slate-300 transition hover:border-accent-500 hover:text-accent-300" href="/servizi.php">
            Vedi tutti i servizi
        </a>
    </div>

    <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
        <?php foreach ($serviceCategories as $service): ?>
            <article class="flex h-full flex-col justify-between rounded-3xl border border-white/10 bg-midnight-900/60 p-6 shadow-md shadow-black/25">
                <div class="space-y-4">
                    <h3 class="text-xl font-semibold text-white"><?= sanitize($service['title']); ?></h3>
                    <p class="text-sm text-slate-300"><?= sanitize($service['description']); ?></p>
                </div>
                <a class="mt-6 inline-flex items-center gap-2 text-sm font-semibold text-accent-300 transition hover:text-accent-400" href="<?= sanitize($service['href']); ?>">
                    Scopri di più
                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </a>
            </article>
        <?php endforeach; ?>
    </div>
</section>

<section id="about" class="mx-auto mt-24 max-w-6xl px-6">
    <div class="rounded-[32px] border border-white/10 bg-midnight-900/60 p-10 shadow-primary">
        <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="space-y-6">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-200">Chi siamo</span>
                <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Una squadra dedicata al tuo tempo</h2>
                <p class="text-base text-slate-300 md:text-lg">AG Servizi nasce a Castellammare di Stabia per offrire in un unico punto tutto ciò che serve a cittadini e aziende: pagamenti, spedizioni, consulenze, attivazioni digitali e molto altro. La nostra missione è semplificare ogni pratica con serietà, esperienza e ascolto.</p>
                <div class="grid gap-4 md:grid-cols-2">
                    <?php foreach ($pillars as $pillar): ?>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <h3 class="text-lg font-semibold text-white"><?= sanitize($pillar['title']); ?></h3>
                            <p class="mt-2 text-sm text-slate-300"><?= sanitize($pillar['copy']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <div class="space-y-6">
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold text-white">Dove trovarci</h3>
                    <p class="mt-2 text-sm text-slate-300">Via Plinio il Vecchio 72, Castellammare di Stabia (NA).</p>
                    <p class="mt-4 text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Orari</p>
                    <p class="mt-1 text-sm text-slate-300">Lun-Ven: 9:00-13:20 / 16:00-19:20<br>Sabato: 9:00-13:00</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-white/5 p-6">
                    <h3 class="text-lg font-semibold text-white">Contattaci</h3>
                    <ul class="mt-3 space-y-2 text-sm text-slate-300">
                        <li>Telefono: <a class="text-accent-300" href="tel:+390810584542">+39 081 0584542</a></li>
                        <li>WhatsApp: <a class="text-accent-300" href="https://wa.me/393773798570" target="_blank" rel="noopener">+39 377 3798570</a></li>
                        <li>Email: <a class="text-accent-300" href="mailto:info@agenziaplinio.it">info@agenziaplinio.it</a></li>
                    </ul>
                    <div class="mt-4 flex gap-3 text-sm text-accent-300">
                        <a class="transition hover:text-accent-400" href="https://www.facebook.com/agserviziplinio.it" target="_blank" rel="noopener">Facebook</a>
                        <span class="text-slate-600">/</span>
                        <a class="transition hover:text-accent-400" href="https://www.instagram.com/agenziaplinio" target="_blank" rel="noopener">Instagram</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="testimonials" class="mx-auto mt-24 max-w-6xl px-6">
    <div class="flex flex-col gap-6 lg:flex-row lg:items-end lg:justify-between">
        <div class="space-y-3">
            <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-200">Cosa dicono i clienti</span>
            <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">La fiducia di chi ci sceglie ogni giorno</h2>
            <p class="max-w-2xl text-base text-slate-300 md:text-lg">Valutazione media 4.8 su 5, con recensioni che premiano competenza, cortesia e rapidità. Ecco alcune testimonianze.</p>
        </div>
        <span class="rounded-full border border-accent-400/40 bg-accent-500/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.32em] text-accent-300">4.8 ★ su 5</span>
    </div>

    <div class="mt-12 grid gap-6 md:grid-cols-3">
        <?php foreach ($testimonialHighlights as $testimonial): ?>
            <figure class="flex h-full flex-col justify-between rounded-3xl border border-white/10 bg-midnight-900/60 p-6 shadow-md">
                <blockquote class="text-sm text-slate-300">“<?= sanitize($testimonial['quote']); ?>”</blockquote>
                <figcaption class="mt-6">
                    <p class="text-sm font-semibold text-white"><?= sanitize($testimonial['name']); ?></p>
                    <p class="text-xs uppercase tracking-[0.3em] text-accent-300">Valutazione <?= sanitize($testimonial['rating']); ?>★</p>
                </figcaption>
            </figure>
        <?php endforeach; ?>
    </div>
</section>

<section id="promo" class="mx-auto mt-24 max-w-6xl px-6">
    <div class="rounded-[32px] border border-white/10 bg-gradient-to-br from-midnight-900 via-midnight-925 to-midnight-950 p-10 shadow-primary">
        <div class="grid gap-10 lg:grid-cols-[1.1fr,0.9fr] lg:items-center">
            <div class="space-y-4">
                <span class="inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs font-semibold uppercase tracking-[0.3em] text-slate-200">Offerta esclusiva</span>
                <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Iliad GIGA 120 – Solo da AG Servizi</h2>
                <ul class="space-y-2 text-sm text-slate-300">
                    <li>• 120 GB in 4G/4G+ per sempre</li>
                    <li>• Minuti e SMS illimitati, 7 GB in Europa</li>
                    <li>• Minuti illimitati verso 60 destinazioni</li>
                    <li>• Canone €7,99/mese – Attivazione promo €5,00</li>
                </ul>
                <div class="flex flex-wrap gap-4 pt-2">
                    <a class="inline-flex items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" href="/form/iliad-voucher.php">
                        Scarica il voucher
                    </a>
                    <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-slate-200 transition hover:border-accent-500 hover:text-accent-300" href="/contatti.php">
                        Richiedi supporto
                    </a>
                </div>
            </div>
            <div class="space-y-4 rounded-3xl border border-white/10 bg-midnight-900/60 p-8">
                <p class="text-xs font-semibold uppercase tracking-[0.35em] text-slate-400">Countdown</p>
                <div class="grid grid-cols-2 gap-4 text-center text-white sm:grid-cols-4">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-2xl font-semibold" data-counter="0">0</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.3em] text-slate-400">Giorni</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-2xl font-semibold" data-counter="0">00</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.3em] text-slate-400">Ore</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-2xl font-semibold" data-counter="0">00</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.3em] text-slate-400">Minuti</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-4">
                        <p class="text-2xl font-semibold" data-counter="0">00</p>
                        <p class="mt-1 text-xs uppercase tracking-[0.3em] text-slate-400">Secondi</p>
                    </div>
                </div>
                <p class="text-xs text-slate-400">Promo valida fino al 31 maggio ore 19:00 presso la nostra sede.</p>
            </div>
        </div>
    </div>
</section>

<section id="cta" class="mx-auto mt-24 max-w-6xl px-6 pb-16">
    <div class="rounded-[32px] border border-white/10 bg-midnight-900/60 p-10 shadow-primary">
        <div class="flex flex-col gap-8 lg:flex-row lg:items-center lg:justify-between">
            <div class="max-w-3xl space-y-4">
                <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Hai bisogno di assistenza immediata?</h2>
                <p class="text-base text-slate-300 md:text-lg">Siamo pronti ad ascoltare le tue esigenze, consigliarti il servizio migliore e seguirti fino alla conclusione della pratica.</p>
            </div>
            <div class="flex flex-wrap gap-4">
                <a class="inline-flex items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" href="mailto:info@agenziaplinio.it">
                    Scrivici ora
                </a>
                <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-slate-200 transition hover:border-accent-500 hover:text-accent-300" href="tel:+390810584542">
                    Chiamaci
                </a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
