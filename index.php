<?php
$pageTitle = 'Benvenuti';
require_once __DIR__ . '/includes/header.php';
?>
<section id="intro" class="relative overflow-hidden rounded-[34px] border border-white/10 bg-midnight-900/70 shadow-frosted" data-parallax data-intensity="12">
    <div class="parallax-scene">
        <div class="parallax-layer background" data-parallax-layer data-depth="0.2" style="background-image: url('assets/img/hero-background.svg');"></div>
        <div class="parallax-layer midground" data-parallax-layer data-depth="0.5" style="background-image: url('assets/img/hero-mid.svg');"></div>
        <div class="parallax-layer foreground" data-parallax-layer data-depth="0.9" style="background-image: url('assets/img/hero-fore.svg');"></div>
        <div class="parallax-overlay"></div>
    </div>
    <div class="relative z-10 mx-auto grid min-h-[72vh] max-w-6xl items-center px-6 py-24 sm:py-28 lg:min-h-[80vh] lg:py-32">
        <div class="max-w-3xl space-y-8" data-animate="fade-up">
            <span class="badge-glow">Consulenza. Servizi. Prodotti.</span>
            <h1 class="font-display text-4xl font-semibold leading-tight text-white md:text-5xl lg:text-6xl">Strategie digitali per aziende visionarie</h1>
            <p class="text-lg text-slate-300 md:text-xl">Un portale integrato che connette consulenza strategica, servizi gestionali e vendita di soluzioni premium, mantenendo un unico flusso operativo.</p>
            <div class="flex flex-wrap items-center gap-4">
                <a class="button-liquid inline-flex items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" href="/servizi.php">
                    <span>Esplora servizi</span>
                </a>
                <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/shop/index.php">
                    <span>Scopri lo shop</span>
                </a>
            </div>
        </div>
        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:mt-16" data-stagger>
            <div class="stat-card rounded-3xl p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-300">Progetti completati</p>
                <p class="mt-3 text-3xl font-semibold text-accent-300" data-counter="128">0</p>
            </div>
            <div class="stat-card rounded-3xl p-6">
                <p class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-300">Clienti attivi</p>
                <p class="mt-3 text-3xl font-semibold text-accent-300" data-counter="86">0</p>
            </div>
        </div>
    </div>
</section>

<section id="chi-siamo" class="mx-auto mt-24 max-w-6xl px-6">
    <div class="grid gap-16 lg:grid-cols-[1.1fr,0.9fr]">
        <div class="space-y-6" data-animate="fade-right">
            <span class="badge-glow">Soluzioni end-to-end</span>
            <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Dalla strategia alla realizzazione</h2>
            <p class="text-lg text-slate-300">Accompagniamo il tuo team con workshop dedicati, roadmap trimestrali e dashboard condivise. Ogni iniziativa &egrave; monitorata in tempo reale e supportata da specialisti verticali.</p>
            <p class="text-lg text-slate-300">Integriamo processi, persone e tecnologie per liberare potenziale. Le nostre release cicliche ti permettono di scalare con sicurezza e rapidit&agrave;.</p>
            <div class="grid gap-4 sm:grid-cols-2" data-stagger>
                <div class="glass-panel p-6">
                    <h3 class="text-lg font-semibold text-white">Pianificazione continua</h3>
                    <p class="mt-2 text-sm text-slate-300">Analisi dati, roadmap e governance condivisa per mantenere il ritmo dell'innovazione.</p>
                </div>
                <div class="glass-panel p-6">
                    <h3 class="text-lg font-semibold text-white">Integrazione tecnologica</h3>
                    <p class="mt-2 text-sm text-slate-300">Soluzioni cloud, CRM e automazioni cucite sul tuo stack esistente senza frizioni.</p>
                </div>
            </div>
        </div>
        <div class="glass-panel p-10" data-animate="fade-left">
            <div class="space-y-6">
                <h3 class="text-2xl font-semibold text-white">Metriche decisive</h3>
                <p class="text-slate-300">Monitoriamo KPI operativi e customer journey per alimentare decisioni basate su dati. Ogni insight &egrave; condiviso con il tuo team tramite board interattive.</p>
                <div class="grid gap-4 sm:grid-cols-2" data-stagger>
                    <div class="rounded-2xl border border-white/10 bg-midnight-900/40 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Soddisfazione</p>
                        <p class="mt-2 text-3xl font-semibold text-accent-300" data-counter="97">0</p>
                        <p class="text-xs text-slate-400">Customer satisfaction</p>
                    </div>
                    <div class="rounded-2xl border border-white/10 bg-midnight-900/40 p-5">
                        <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Tempistiche</p>
                        <p class="mt-2 text-3xl font-semibold text-accent-300" data-counter="32">0</p>
                        <p class="text-xs text-slate-400">Giorni medi di rilascio</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="servizi" class="mx-auto mt-32 max-w-6xl px-6">
    <div class="glass-panel overflow-hidden p-10" data-animate="fade-up">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <span class="badge-glow">Brand experience</span>
                <h2 class="mt-4 font-display text-3xl font-semibold text-white md:text-4xl">Design system e narrazioni immersive</h2>
            </div>
            <p class="max-w-xl text-sm text-slate-300 md:text-base">Costruiamo esperienze digitali coerenti con il tuo posizionamento. Dai componenti UI all'automazione di marketing, ogni touchpoint &egrave; progettato per coinvolgere.</p>
        </div>
        <div class="mt-12 grid gap-8 md:grid-cols-2 xl:grid-cols-3" data-stagger>
            <article class="service-card p-8">
                <h3 class="text-xl font-semibold text-white">Esperienze interattive</h3>
                <p class="mt-3 text-sm text-slate-300">Prototipi immersivi, motion storytelling e micro-interazioni ottimizzate per incrementare l'engagement.</p>
            </article>
            <article class="service-card p-8">
                <h3 class="text-xl font-semibold text-white">Design system enterprise</h3>
                <p class="mt-3 text-sm text-slate-300">Librerie componenti responsive, guideline globali e governance condivisa tra marketing e prodotto.</p>
            </article>
            <article class="service-card p-8">
                <h3 class="text-xl font-semibold text-white">Insight & analytics</h3>
                <p class="mt-3 text-sm text-slate-300">Suite dashboard avanzata con KPI real-time, heatmap comportamentali e sentiment analysis.</p>
            </article>
            <article class="service-card p-8">
                <h3 class="text-xl font-semibold text-white">Lead management</h3>
                <p class="mt-3 text-sm text-slate-300">Flussi automatici per il nurturing, scoring personalizzato e handover fluido al team commerciale.</p>
            </article>
            <article class="service-card p-8">
                <h3 class="text-xl font-semibold text-white">Knowledge hub</h3>
                <p class="mt-3 text-sm text-slate-300">Portali self-service, documentazione smart e percorsi formativi on-demand per clienti e partner.</p>
            </article>
            <article class="service-card p-8">
                <h3 class="text-xl font-semibold text-white">Supporto dedicato</h3>
                <p class="mt-3 text-sm text-slate-300">Team ibridi con specialisti digital, UX e data analyst per accompagnarti dalla discovery al rollout.</p>
            </article>
        </div>
    </div>
</section>

<section id="processo" class="mx-auto mt-32 max-w-6xl px-6">
    <div class="rounded-[32px] border border-white/10 bg-midnight-900/60 p-10 shadow-primary" data-animate="fade-up">
        <div class="flex flex-col gap-6 lg:flex-row lg:items-start lg:justify-between">
            <div class="max-w-xl space-y-4">
                <span class="badge-glow">Metodo collaudato</span>
                <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Un ciclo operativo ritmato</h2>
                <p class="text-base text-slate-300 md:text-lg">Ogni trimestre avviamo un ciclo completo di analisi, progettazione e rilascio. Il team lavora in sprint coordinati con stand-up dedicati e workshop cross-funzionali.</p>
            </div>
            <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-slate-300 transition hover:border-accent-500 hover:text-accent-400" href="/chi-siamo.php">
                Scopri il team
            </a>
        </div>
        <ol class="mt-12 grid gap-6 md:grid-cols-2">
            <li class="glass-panel p-6">
                <span class="text-xs font-semibold uppercase tracking-[0.32em] text-accent-300">01 · Discovery</span>
                <h3 class="mt-3 text-xl font-semibold text-white">Analisi e definizione KPI</h3>
                <p class="mt-2 text-sm text-slate-300">Workshop stakeholder, audit tecnici e fotografia dei processi per identificare priorit&agrave; e metriche di impatto.</p>
            </li>
            <li class="glass-panel p-6">
                <span class="text-xs font-semibold uppercase tracking-[0.32em] text-accent-300">02 · Design</span>
                <h3 class="mt-3 text-xl font-semibold text-white">Prototipazione e validazione</h3>
                <p class="mt-2 text-sm text-slate-300">UX flow, design system, architecture board e proof of concept condivise per ottenere feedback rapidi.</p>
            </li>
            <li class="glass-panel p-6">
                <span class="text-xs font-semibold uppercase tracking-[0.32em] text-accent-300">03 · Delivery</span>
                <h3 class="mt-3 text-xl font-semibold text-white">Sviluppo e QA collaborativo</h3>
                <p class="mt-2 text-sm text-slate-300">Sprint bisettimanali, ambienti di test dedicati e QA continuo con retrospettive aperte al tuo team.</p>
            </li>
            <li class="glass-panel p-6">
                <span class="text-xs font-semibold uppercase tracking-[0.32em] text-accent-300">04 · Growth</span>
                <h3 class="mt-3 text-xl font-semibold text-white">Ottimizzazione e scaling</h3>
                <p class="mt-2 text-sm text-slate-300">Automazioni, enablement del personale e misurazione continua per spingere l'adozione e scalare le performance.</p>
            </li>
        </ol>
    </div>
</section>

<section id="shop" class="mx-auto mt-32 max-w-6xl px-6">
    <div class="grid gap-14 lg:grid-cols-[1.1fr,0.9fr]">
        <div class="space-y-6" data-animate="fade-right">
            <span class="badge-glow">E-commerce integrato</span>
            <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Un catalogo di soluzioni premium</h2>
            <p class="text-lg text-slate-300">Prodotti fisici e digitali, licenze software e pacchetti formativi: tutto orchestrato nel tuo ecosistema, con pagamenti sicuri e fulfillment tracciato.</p>
            <div class="grid gap-4 sm:grid-cols-2" data-stagger>
                <div class="rounded-2xl border border-white/10 bg-midnight-900/50 p-5">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-300">Pagamento flessibile</h3>
                    <p class="mt-2 text-sm text-slate-400">Supporto a subscription, rateizzazioni e wallet aziendali.</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-midnight-900/50 p-5">
                    <h3 class="text-sm font-semibold uppercase tracking-[0.3em] text-slate-300">Logistica smart</h3>
                    <p class="mt-2 text-sm text-slate-400">Tracking real-time, gestione resi e documentazione automatica.</p>
                </div>
            </div>
            <div class="flex flex-wrap gap-4 pt-2">
                <a class="button-liquid inline-flex items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" href="/shop/index.php">Vai allo shop</a>
                <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/shop/carrello.php">Visualizza carrello</a>
            </div>
        </div>
        <div class="glass-panel p-10" data-animate="fade-left">
            <h3 class="text-2xl font-semibold text-white">Numeri del canale shop</h3>
            <p class="mt-3 text-sm text-slate-300">Un flusso commerciale che integra CRM, fatturazione e fulfillment per garantire esperienze impeccabili.</p>
            <div class="mt-8 grid gap-4 sm:grid-cols-2" data-stagger>
                <div class="rounded-2xl border border-white/10 bg-midnight-900/40 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Ticket risolti</p>
                    <p class="mt-2 text-3xl font-semibold text-accent-300" data-counter="742">0</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-midnight-900/40 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">SLA rispettati</p>
                    <p class="mt-2 text-3xl font-semibold text-accent-300" data-counter="98">0</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-midnight-900/40 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Automazioni attive</p>
                    <p class="mt-2 text-3xl font-semibold text-accent-300" data-counter="54">0</p>
                </div>
                <div class="rounded-2xl border border-white/10 bg-midnight-900/40 p-5">
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-slate-400">Documenti digitali</p>
                    <p class="mt-2 text-3xl font-semibold text-accent-300" data-counter="1520">0</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section id="contatti" class="mx-auto mt-32 max-w-6xl px-6">
    <div class="glass-panel overflow-hidden p-10" data-animate="fade-up">
        <div class="grid gap-10 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="space-y-5">
                <span class="badge-glow">Parliamone</span>
                <h2 class="font-display text-3xl font-semibold text-white md:text-4xl">Programma una sessione di allineamento</h2>
                <p class="text-lg text-slate-300">Condividi obiettivi, processi e strumenti in uso. Prepariamo noi la roadmap, con analisi delle opportunit&agrave; e primi quick win.</p>
                <div class="flex flex-wrap gap-4">
                    <a class="button-liquid inline-flex items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" href="/contatti.php">Prenota ora</a>
                    <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/form/newsletter.php">Iscriviti alla newsletter</a>
                </div>
            </div>
            <div class="rounded-[28px] border border-white/10 bg-midnight-900/60 p-8">
                <h3 class="text-lg font-semibold text-white">Supporto continuo</h3>
                <p class="mt-3 text-sm text-slate-300">Accesso a community privata, knowledge base e canali di assistenza multilingua attivi 7/7.</p>
                <ul class="mt-6 space-y-3 text-sm text-slate-300">
                    <li class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-2xl bg-accent-500/15 text-accent-300">01</span>
                        <span>Onboarding operativo in 5 giorni</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-2xl bg-accent-500/15 text-accent-300">02</span>
                        <span>Referente dedicato per area funzionale</span>
                    </li>
                    <li class="flex items-center gap-3">
                        <span class="grid h-9 w-9 place-items-center rounded-2xl bg-accent-500/15 text-accent-300">03</span>
                        <span>Reportistica avanzata e insight condivisi</span>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
