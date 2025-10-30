<?php
$pageTitle = 'Servizi';
require_once __DIR__ . '/includes/header.php';

$heroHighlights = [
    'Sportello certificato per pagamenti, pratiche fiscali e attivazioni digitali',
    'Consulenza dedicata per privati, professionisti e imprese',
    'Partnership con i principali operatori nazionali',
];

$heroStats = [
    ['value' => '3.500+', 'label' => 'Pratiche gestite ogni anno'],
    ['value' => '25+', 'label' => 'Partnership certificate'],
    ['value' => '9', 'label' => 'Aree di competenza integrate'],
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
            'Namirial, PagoPA, Trenitalia, Italo, FlixBus e più di 20 brand',
            'Offerte negoziate e tariffe trasparenti',
        ],
    ],
];

$serviceAreas = [
    [
        'id' => 'pagamenti',
        'icon' => '💳',
        'title' => 'Pagamenti e tributi',
        'tagline' => 'Sportello DropPoint certificato con ricevuta immediata',
        'intro' => 'Gestiamo pagamenti quotidiani con sportello DropPoint certificato: bollettini, modelli F24, pagamenti PagoPA e bonifici nazionali o esteri con assistenza completa.',
        'focus' => [
            'Pagamento immediato con ricevuta conservata per 5 anni',
            'Assistenza nella compilazione di modelli F24 e PagoPA',
            'Tariffe trasparenti e nessuna fila agli sportelli',
        ],
        'solutions' => [
            ['title' => 'Pagamenti immediati', 'items' => ['Bollettini postali premarcati e bianchi', 'Bollette di luce, gas, acqua e telefono', 'MAV/RAV e bollo auto o moto']],
            ['title' => 'F24 e tributi', 'items' => ['Modello F24 semplificato', 'Modello F24 ordinario', 'F24 elementi identificativi ed F24 accise', 'Supporto alla compilazione prima dell’invio']],
            ['title' => 'Bonifici DropPoint', 'items' => ['Bonifici SEPA in giornata lavorativa', 'Bonifici internazionali assistiti', 'Verifica IBAN e causale prima dell’operazione']],
        ],
        'requirements' => [
            'Documento di identità valido e codice fiscale',
            'Bollettino o modello F24 da saldare già compilato o dati completi per la compilazione',
            'Per bonifici: IBAN del beneficiario e causale del pagamento',
        ],
        'reminders' => [
            'Tariffe indicative: bollettini €1,50 (over 70 €1,20), bonifici €1,80, F24 €1,50',
            'Metodi accettati: contanti, bancomat, carte di credito e prepagate',
            'Orari sportello: lun-ven 9:00-13:20 / 16:00-19:20 • sab 9:00-13:00',
        ],
        'cta' => [
            ['label' => 'Scrivici su WhatsApp', 'url' => 'https://wa.me/393773798570?text=Vorrei%20informazioni%20sui%20servizi%20di%20pagamento', 'external' => true, 'class' => 'is-outlined'],
            ['label' => 'Chiamaci', 'url' => 'tel:+390810584542'],
        ],
    ],
    [
        'id' => 'biglietteria',
        'icon' => '🚆',
        'title' => 'Biglietteria & mobilità',
        'tagline' => 'Treni, autobus e servizi di viaggio con assistenza dedicata',
        'intro' => 'Emettiamo biglietti Trenitalia, Italo e Flixbus, oltre ad abbonamenti e carte sconto. Ti guidiamo nella scelta delle tariffe più convenienti e gestiamo richieste last minute.',
        'focus' => [
            'Prenotazioni Frecce, Intercity, Regionali e Italo',
            'Vendita biglietti autobus nazionali e internazionali Flixbus',
            'Consulenza personalizzata senza attese né code',
        ],
        'solutions' => [
            ['title' => 'Treni Trenitalia', 'items' => ['Alta velocità Frecciarossa e Frecciargento', 'Intercity giorno/notte', 'Regionalissimi con posti riservati', 'Carte sconto e abbonamenti aziendali']],
            ['title' => 'Treni Italo', 'items' => ['Tariffe Smart, Prima e Club Executive', 'Servizio Italo Più e voucher', 'Supporto a cambi e servizi di bordo']],
            ['title' => 'Autobus & collegamenti', 'items' => ['Linee Flixbus nazionali e internazionali', 'Navette aeroportuali e servizi turistici', 'Emissione bagagli aggiuntivi e upgrade']],
        ],
        'requirements' => [
            'Data e orario di partenza desiderati',
            'Stazione o fermata di partenza e destinazione',
            'Numero passeggeri e dati anagrafici ove richiesti dal vettore',
        ],
        'reminders' => [
            'Pagamenti con contanti, bancomat e carte di credito',
            'Le modifiche dipendono dalle condizioni del vettore; richiedi assistenza in agenzia',
            'Suggeriamo prenotazioni anticipate in alta stagione',
        ],
        'cta' => [
            ['label' => 'Richiedi disponibilità', 'url' => 'https://wa.me/393773798570?text=Vorrei%20informazioni%20sui%20biglietti', 'external' => true, 'class' => 'is-outlined'],
            ['label' => 'Chiama la biglietteria', 'url' => 'tel:+390810584542'],
        ],
    ],
    [
        'id' => 'spedizioni',
        'icon' => '📦',
        'title' => 'Spedizioni e logistica',
        'tagline' => 'Invii nazionali e internazionali con corrieri premium',
        'intro' => 'Collaboriamo con i migliori corrieri per spedizioni rapide, tracciabili e sicure in Italia e nel mondo. Offriamo anche servizio di imballaggio professionale.',
        'focus' => [
            'Partnership con BRT, Poste Italiane, TNT/FedEx, DHL e UPS',
            'Tracciamento in tempo reale e assistenza sulle pratiche doganali',
            'Imballaggi su misura per materiali fragili e documenti',
        ],
        'solutions' => [
            ['title' => 'Spedizioni nazionali', 'items' => ['Consegna 1-3 giorni lavorativi', 'Servizi express e standard', 'Ritiro e consegna pianificati con notifica al destinatario']],
            ['title' => 'Spedizioni internazionali', 'items' => ['Copertura worldwide con corrieri premium', 'Gestione documenti doganali e dichiarazioni', 'Opzioni economy o priority a seconda della destinazione']],
            ['title' => 'Imballaggi e materiali', 'items' => ['Scatole certificate, buste imbottite e pluriball', 'Imballaggi per vino, elettronica e fragili', 'Servizio confezionamento professionale in sede']],
        ],
        'requirements' => [
            'Plico o pacco già preparato oppure oggetto da imballare in agenzia',
            'Indirizzo completo del destinatario e recapito telefonico',
            'Per l’estero: eventuale fattura o proforma e documenti richiesti dal Paese di destinazione',
        ],
        'reminders' => [
            'Preventivi personalizzati in base a peso, volume e destinazione',
            'Metodi di pagamento: contanti, bancomat, carte di credito e prepagate',
            'Codice di tracking consegnato al cliente alla chiusura della spedizione',
        ],
        'cta' => [
            ['label' => 'Richiedi un preventivo', 'url' => 'https://wa.me/393773798570?text=Vorrei%20un%20preventivo%20spedizioni', 'external' => true, 'class' => 'is-outlined'],
            ['label' => 'Supporto telefonico', 'url' => 'tel:+390810584542'],
        ],
    ],
    [
        'id' => 'attivazioni-digitali',
        'icon' => '🆔',
        'title' => 'Identità e firme digitali',
        'tagline' => 'SPID, PEC e firma digitale Namirial',
        'intro' => 'Attiviamo identità digitale e strumenti di firma certificata con riconoscimento assistito, sia in presenza che in modalità remota.',
        'focus' => [
            'SPID livello 1, 2 e 3 rilasciato rapidamente',
            'Caselle PEC professionali e rinnovi gestiti in agenzia',
            'Firma digitale Namirial su smart card, token USB e kit remoti',
        ],
        'solutions' => [
            ['title' => 'Identità digitale SPID', 'items' => ['Riconoscimento de visu o da remoto', 'Supporto alla configurazione iniziale', 'Assistenza recupero credenziali e rinnovi']],
            ['title' => 'Posta elettronica certificata', 'items' => ['Caselle PEC personali e aziendali', 'Migrazione da altri gestori', 'Rinnovo e ampliamento spazio di archiviazione']],
            ['title' => 'Firma digitale', 'items' => ['Kit smart card e lettore', 'Token USB e firma remota OTP', 'Manuali d’uso e assistenza post vendita']],
        ],
        'requirements' => [
            'Documento di identità in corso di validità e codice fiscale',
            'Indirizzo email e numero di cellulare personali attivi',
            'Per PEC/firme aziendali: visura camerale o delega del legale rappresentante',
        ],
        'reminders' => [
            'Rinnovi gestiti con promemoria automatici',
            'Disponibile supporto tecnico per installazione software e driver',
            'Consulenza sull’uso degli strumenti digitali per PA e imprese',
        ],
        'cta' => [
            ['label' => 'Prenota un’attivazione', 'url' => 'https://wa.me/393773798570?text=Vorrei%20attivare%20SPID%20o%20firma%20digitale', 'external' => true, 'class' => 'is-outlined'],
        ],
    ],
    [
        'id' => 'caf-patronato',
        'icon' => '🗂️',
        'title' => 'CAF e patronato',
        'tagline' => 'Pratiche fiscali e previdenziali con operatori accreditati',
        'intro' => 'Seguiamo pratiche fiscali e previdenziali con operatori accreditati: modelli dichiarativi, agevolazioni, prestazioni INPS e tutela del lavoro.',
        'focus' => [
            'Compilazione Modello 730, Unico e Dichiarazione IMU',
            'ISEE, bonus, assegni familiari e pratiche scolastiche',
            'Supporto patronale per pensioni, invalidità, NASpI e maternità',
        ],
        'solutions' => [
            ['title' => 'Servizi CAF', 'items' => ['Modello 730 con conguagli rapidi', 'ISEE ordinario, corrente e prestazioni sociali', 'Dichiarazioni IMU/TASI e contratti di locazione', 'Gestione bonus edilizi e superbonus']],
            ['title' => 'Patronato', 'items' => ['Domande pensionistiche e riscatti contributivi', 'NASpI, DIS-COLL e sostegni al reddito', 'Pratiche di maternità, paternità e assegni familiari', 'Invalidità civile, accompagnamento e indennità INAIL']],
            ['title' => 'Assistenza dedicata', 'items' => ['Verifica documentazione e scadenziario', 'Invio telematico certificato agli enti competenti', 'Supporto nella gestione notifiche e comunicazioni INPS']],
        ],
        'requirements' => [
            'Documento di identità, codice fiscale e tessera sanitaria',
            'Documentazione reddituale, CU e spese detraibili',
            'Certificazioni INPS/INAIL o deleghe per pratiche previdenziali',
        ],
        'reminders' => [
            'Calendario scadenze fiscali aggiornato durante l’anno',
            'Assistenza su appuntamento per pratiche complesse',
            'Convenzioni dedicate a famiglie e professionisti',
        ],
        'cta' => [
            ['label' => 'Prenota un appuntamento', 'url' => 'https://wa.me/393773798570?text=Vorrei%20prenotare%20un%20appuntamento%20CAF%2FPatronato', 'external' => true, 'class' => 'is-outlined'],
        ],
    ],
    [
        'id' => 'visure',
        'icon' => '🔍',
        'title' => 'Visure e report',
        'tagline' => 'Informazioni aggiornate per persone, immobili e imprese',
        'intro' => 'Forniamo visure aggiornate per persone e imprese: dati catastali, finanziari e camerali con consegna immediata in formato digitale.',
        'focus' => [
            'Visure CRIF per verificare la propria posizione creditizia',
            'Visure catastali e ipotecarie con planimetrie su richiesta',
            'Report camerali, PRA, protesti e schede imprese',
        ],
        'solutions' => [
            ['title' => 'Visure persone fisiche', 'items' => ['CRIF e sistemi di informazione creditizia', 'Visure protesti e pregiudizievoli', 'Certificati di residenza e stato di famiglia']],
            ['title' => 'Visure immobiliari', 'items' => ['Catastali attuali e storiche', 'Ispezioni ipotecarie e planimetrie', 'Rendite catastali per calcolo IMU']],
            ['title' => 'Visure imprese', 'items' => ['Camerali ordinarie e storiche', 'Bilanci depositati e assetti societari', 'Visure PRA e targa veicoli aziendali']],
        ],
        'requirements' => [
            'Dati anagrafici del soggetto o denominazione azienda',
            'Codice fiscale/partita IVA e provincia di riferimento',
            'Per planimetrie: delega o titolo di proprietà',
        ],
        'reminders' => [
            'Consegna immediata via email o cartacea in agenzia',
            'Tariffe differenziate in base al tipo di banca dati richiesta',
            'Supporto nella lettura dei dati e nel reperimento documenti integrativi',
        ],
        'cta' => [],
    ],
    [
        'id' => 'telefonia',
        'icon' => '📡',
        'title' => 'Telefonia, luce e gas',
        'tagline' => 'Attivazioni e portabilità con i principali operatori',
        'intro' => 'Compariamo soluzioni per casa e aziende con i principali operatori nazionali di telefonia, fibra e utilities, seguendo ogni step di attivazione e migrazione.',
        'focus' => [
            'Partner Fastweb, Iliad, WindTre, Pianeta Fibra, Sky WiFi, A2A Energia, Enel Energia e Fastweb Energia',
            'Portabilità numeri fissi e mobili con gestione pratiche',
            'Analisi bollette per ottimizzare costi e consumi',
        ],
        'solutions' => [
            ['title' => 'Telefonia mobile', 'items' => ['Nuove SIM e portabilità', 'Offerte ricaricabili e business', 'Gestione eSIM e dispositivi abbinati']],
            ['title' => 'Fibra e internet', 'items' => ['Fibra FTTH/FTTC e connessioni wireless', 'Router e modem certificati', 'Assistenza tecnica e configurazione apparati']],
            ['title' => 'Energia e gas', 'items' => ['Contratti luce e gas per privati e PMI', 'Variazioni intestatario e volture', 'Monitoraggio consumi e consigli di risparmio']],
        ],
        'requirements' => [
            'Documento di identità e codice fiscale dell’intestatario',
            'Ultima bolletta o codice POD/PDR per luce e gas',
            'IBAN per domiciliazione o metodo di pagamento preferito',
        ],
        'reminders' => [
            'Attivazioni seguite fino alla messa in servizio',
            'Sportello dedicato per clienti business con offerte dedicate',
            'Supporto post-attivazione per assistenza tecnica o fatturazione',
        ],
        'cta' => [],
    ],
    [
        'id' => 'posta-telematica',
        'icon' => '📨',
        'title' => 'Posta telematica e atti',
        'tagline' => 'Invii certificati con prova di consegna digitale',
        'intro' => 'Spediamo comunicazioni ufficiali e documenti certificati con canali digitali: PEC, raccomandate elettroniche e stampa recapito.',
        'focus' => [
            'Invio PEC con ricevute di accettazione e consegna',
            'Raccomandate online e posta ibrida con tracciabilità',
            'Gestione atti giudiziari e notifiche a valore legale',
        ],
        'solutions' => [
            ['title' => 'Posta elettronica certificata', 'items' => ['Invio assistito di PEC per privati e aziende', 'Conservazione ricevute e protocolli', 'Creazione modelli e rubriche per invii ricorrenti']],
            ['title' => 'Raccomandate digitali', 'items' => ['Raccomandate AR e 1 con recapito cartaceo', 'Posta ibrida (invio digitale, recapito fisico)', 'Gestione allegati voluminosi e stampa certificata']],
            ['title' => 'Comunicazioni speciali', 'items' => ['Atti giudiziari con prova di consegna', 'Invii massivi per aziende e professionisti', 'Notifiche a enti pubblici e amministrazioni']],
        ],
        'requirements' => [
            'Documento di identità e recapito del mittente',
            'Indirizzo PEC o postale del destinatario',
            'Documentazione da inviare in formato digitale o cartaceo',
        ],
        'reminders' => [
            'Archivio digitale delle ricevute disponibile su richiesta',
            'Tariffe variabili in base a tipologia di invio e servizi accessori',
            'Servizio ideale per professionisti, amministratori di condominio e PMI',
        ],
        'cta' => [],
    ],
    [
        'id' => 'punto-ritiro',
        'icon' => '📮',
        'title' => 'Punto di ritiro pacchi',
        'tagline' => 'Locker e pick-up per resi e consegne garantite',
        'intro' => 'Siamo hub autorizzato PuntoPoste, BRT-Fermopoint, GLS Shop e FedEx Location: puoi ritirare, depositare e gestire resi in modo semplice.',
        'focus' => [
            'Notifica di arrivo pacco via SMS o email',
            'Deposito gratuito per più giorni con sicurezza garantita',
            'Servizio di reso con etichette corriere pronte in agenzia',
        ],
        'solutions' => [
            ['title' => 'Ritiro pacchi', 'items' => ['PuntoPoste e locker Poste Italiane', 'BRT-Fermopoint e FedEx Location', 'GLS Shop con gestione deleghe']],
            ['title' => 'Resi facilitati', 'items' => ['Stampa etichette di reso e predisposizione pacchi', 'Restituzione marketplace (Amazon, Zalando, ecc.)', 'Pratiche di reso con codice QR o PIN']],
            ['title' => 'Servizi aggiuntivi', 'items' => ['Avvisi automatizzati via SMS/Email', 'Prolungamento deposito previa richiesta', 'Supporto per spedizioni dal punto di ritiro']],
        ],
        'requirements' => [
            'Documento di identità del destinatario o delega firmata',
            'Codice di ritiro o QR fornito dal corriere',
            'Per resi: etichetta o codice di reso del marketplace',
        ],
        'reminders' => [
            'Deposito standard 9 giorni (varia in base al corriere partner)',
            'Servizio disponibile negli orari di apertura dell’agenzia',
            'Consigliato prenotare ritiri voluminosi per garantire spazio in magazzino',
        ],
        'cta' => [],
    ],
];
?>

<section class="section service-hero">
    <div class="container">
        <div class="columns is-vcentered is-variable is-6" data-animate="fade-up">
            <div class="column is-12-tablet is-7-desktop">
                <p class="service-eyebrow">Agenzia multiservizi certificata</p>
                <h1 class="title is-1">Servizi integrati per privati e imprese</h1>
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

<section class="section service-catalog">
    <div class="container">
        <div class="columns is-variable is-6">
            <aside class="column is-12-tablet is-4-desktop">
                <div class="service-nav" data-sticky>
                    <p class="service-nav__title">Aree di competenza</p>
                    <ul class="service-nav__list">
                        <?php foreach ($serviceAreas as $area): ?>
                            <li><a class="service-nav__link" href="#<?= sanitize($area['id']); ?>"><?= sanitize($area['title']); ?></a></li>
                        <?php endforeach; ?>
                    </ul>
                    <div class="service-nav__cta">
                        <a class="button is-warning is-fullwidth" href="https://wa.me/393773798570?text=Vorrei%20parlare%20con%20un%20consulente" target="_blank" rel="noopener noreferrer">
                            Parla con un consulente
                        </a>
                    </div>
                </div>
            </aside>
            <div class="column is-12-tablet is-8-desktop service-catalog__content">
                <?php foreach ($serviceAreas as $index => $area): ?>
                    <article id="<?= sanitize($area['id']); ?>" class="service-area" data-animate="fade-up">
                        <header class="service-area__header">
                            <span class="service-area__icon" aria-hidden="true"><?= sanitize($area['icon']); ?></span>
                            <div>
                                <h2 class="title is-3"><?= sanitize($area['title']); ?></h2>
                                <p class="service-area__tagline"><?= sanitize($area['tagline']); ?></p>
                            </div>
                        </header>
                        <p class="service-area__intro"><?= sanitize($area['intro']); ?></p>

                        <?php if (!empty($area['focus'])): ?>
                            <div class="service-chip-row">
                                <?php foreach ($area['focus'] as $focus): ?>
                                    <span class="tag is-warning is-light service-chip"><?= sanitize($focus); ?></span>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($area['solutions'])): ?>
                            <div class="columns is-multiline is-variable is-4" data-stagger>
                                <?php foreach ($area['solutions'] as $solution): ?>
                                    <div class="column is-12-tablet is-6-desktop">
                                        <div class="box service-solution">
                                            <h3 class="title is-5"><?= sanitize($solution['title']); ?></h3>
                                            <ul class="service-list">
                                                <?php foreach ($solution['items'] as $item): ?>
                                                    <li><?= sanitize($item); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($area['requirements']) || !empty($area['reminders'])): ?>
                            <div class="columns is-variable is-5 service-meta">
                                <?php if (!empty($area['requirements'])): ?>
                                    <div class="column">
                                        <div class="service-meta-box">
                                            <p class="heading">Cosa portare</p>
                                            <ul class="service-list">
                                                <?php foreach ($area['requirements'] as $requirement): ?>
                                                    <li><?= sanitize($requirement); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                                <?php if (!empty($area['reminders'])): ?>
                                    <div class="column">
                                        <div class="service-meta-box">
                                            <p class="heading">Promemoria</p>
                                            <ul class="service-list">
                                                <?php foreach ($area['reminders'] as $reminder): ?>
                                                    <li><?= sanitize($reminder); ?></li>
                                                <?php endforeach; ?>
                                            </ul>
                                        </div>
                                    </div>
                                <?php endif; ?>
                            </div>
                        <?php endif; ?>

                        <?php if (!empty($area['cta'])): ?>
                            <div class="buttons">
                                <?php foreach ($area['cta'] as $cta): ?>
                                    <a class="button is-warning<?= !empty($cta['class']) ? ' ' . htmlspecialchars($cta['class']) : ''; ?>" href="<?= htmlspecialchars($cta['url']); ?>"<?= !empty($cta['external']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?= sanitize($cta['label']); ?></a>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </article>

                    <?php if ($index < count($serviceAreas) - 1): ?>
                        <hr class="service-divider">
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
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

<?php include __DIR__ . '/includes/footer.php'; ?>
