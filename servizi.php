<?php
$pageTitle = 'Servizi';
require_once __DIR__ . '/includes/header.php';

$serviceCards = [
    ['id' => 'pagamenti', 'icon' => '💳', 'title' => 'Pagamenti', 'summary' => 'Bollettini, F24, PagoPA, MAV/RAV e bonifici DropPoint con ricevuta immediata.'],
    ['id' => 'biglietteria', 'icon' => '🚆', 'title' => 'Biglietteria', 'summary' => 'Trenitalia, Italo e Flixbus con consulenza sulle migliori tariffe e abbonamenti.'],
    ['id' => 'spedizioni', 'icon' => '📦', 'title' => 'Spedizioni', 'summary' => 'Invii nazionali e internazionali con BRT, Poste Italiane, TNT/FedEx, DHL e UPS.'],
    ['id' => 'attivazioni-digitali', 'icon' => '🆔', 'title' => 'Attivazioni Digitali', 'summary' => 'SPID, PEC e firma digitale Namirial con riconoscimento e rinnovi assistiti.'],
    ['id' => 'caf-patronato', 'icon' => '🗂️', 'title' => 'CAF e Patronato', 'summary' => 'Modelli 730, ISEE, pratiche previdenziali e assistenza INPS/INAIL.'],
    ['id' => 'visure', 'icon' => '🔍', 'title' => 'Visure', 'summary' => 'Visure CRIF, catastali, PRA, camerali, protesti e report immobiliari.'],
    ['id' => 'telefonia', 'icon' => '📡', 'title' => 'Telefonia, Luce e Gas', 'summary' => 'Nuove attivazioni, portabilità e comparazione offerte Fastweb, Iliad, WindTre, Sky, A2A, Enel e altri partner.'],
    ['id' => 'posta-telematica', 'icon' => '📨', 'title' => 'Invii Posta Telematica', 'summary' => 'Raccomandate, PEC, servizi postali digitali e gestione comunicazioni ufficiali.'],
    ['id' => 'punto-ritiro', 'icon' => '📮', 'title' => 'Punto di Ritiro Pacchi', 'summary' => 'Locker e pick-up PuntoPoste, BRT-Fermopoint, GLS Shop e FedEx Location con deposito sicuro.'],
];

$serviceSections = [
    [
        'id' => 'pagamenti',
        'title' => 'Servizi di Pagamento',
        'intro' => 'Gestiamo pagamenti quotidiani con sportello DropPoint certificato: bollettini, modelli F24, pagamenti PagoPA e bonifici nazionali o esteri con assistenza completa.',
        'highlights' => [
            'Pagamento immediato con ricevuta conservata per 5 anni',
            'Assistenza nella compilazione di modelli F24 e PagoPA',
            'Tariffe trasparenti e nessuna fila agli sportelli',
        ],
        'offers' => [
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
            ['label' => 'Scrivici su WhatsApp', 'url' => 'https://wa.me/393773798570?text=Vorrei%20informazioni%20sui%20servizi%20di%20pagamento', 'external' => true],
            ['label' => 'Chiamaci', 'url' => 'tel:+390810584542', 'external' => false],
        ],
    ],
    [
        'id' => 'biglietteria',
        'title' => 'Biglietteria',
        'intro' => 'Emettiamo biglietti Trenitalia, Italo e Flixbus, oltre ad abbonamenti e carte sconto. Ti guidiamo nella scelta delle tariffe più convenienti e gestiamo richieste last minute.',
        'highlights' => [
            'Prenotazioni Frecce, Intercity, Regionali e Italo',
            'Vendita biglietti autobus nazionali e internazionali Flixbus',
            'Consulenza personalizzata senza attese né code',
        ],
        'offers' => [
            ['title' => 'Treni Trenitalia', 'items' => ['Alta velocità Frecciarossa e Frecciargento', 'Intercity giorno/notte', 'Regionalissimi con posti riservati', 'Carte sconto e abbonamenti aziendali']],
            ['title' => 'Treni Italo', 'items' => ['Tariffe Smart, Prima e Club Executive', 'Servizio Italo Più e voucher', 'Supporto a cambi e servizi di bordo']],
            ['title' => 'Autobus & Servizi collegati', 'items' => ['Linee Flixbus nazionali e internazionali', 'Navette aeroportuali e servizi turistici', 'Emissione bagagli aggiuntivi e upgrade']],
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
            ['label' => 'Richiedi disponibilità', 'url' => 'https://wa.me/393773798570?text=Vorrei%20informazioni%20sui%20biglietti', 'external' => true],
            ['label' => 'Chiama la biglietteria', 'url' => 'tel:+390810584542', 'external' => false],
        ],
    ],
    [
        'id' => 'spedizioni',
        'title' => 'Spedizioni nazionali e internazionali',
        'intro' => 'Collaboriamo con i migliori corrieri per spedizioni rapide, tracciabili e sicure in Italia e nel mondo. Offriamo anche servizio di imballaggio professionale.',
        'highlights' => [
            'Partnership con BRT, Poste Italiane, TNT/FedEx, DHL e UPS',
            'Tracciamento in tempo reale e assistenza sulle pratiche doganali',
            'Imballaggi su misura per materiali fragili e documenti',
        ],
        'offers' => [
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
            ['label' => 'Richiedi un preventivo', 'url' => 'https://wa.me/393773798570?text=Vorrei%20un%20preventivo%20spedizioni', 'external' => true],
            ['label' => 'Supporto telefonico', 'url' => 'tel:+390810584542', 'external' => false],
        ],
    ],
    [
        'id' => 'attivazioni-digitali',
        'title' => 'Attivazioni digitali Namirial',
        'intro' => 'Attiviamo identità digitale e strumenti di firma certificata con riconoscimento assistito, sia in presenza che in modalità remota.',
        'highlights' => [
            'SPID livello 1, 2 e 3 rilasciato rapidamente',
            'Caselle PEC professionali e rinnovi gestiti in agenzia',
            'Firma digitale Namirial su smart card, token USB e kit remoti',
        ],
        'offers' => [
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
            ['label' => 'Prenota un’attivazione', 'url' => 'https://wa.me/393773798570?text=Vorrei%20attivare%20SPID%20o%20firma%20digitale', 'external' => true],
        ],
    ],
    [
        'id' => 'caf-patronato',
        'title' => 'CAF e Patronato',
        'intro' => 'Seguiamo pratiche fiscali e previdenziali con operatori accreditati: modelli dichiarativi, agevolazioni, prestazioni INPS e tutela del lavoro.',
        'highlights' => [
            'Compilazione Modello 730, Unico e Dichiarazione IMU',
            'ISEE, bonus, assegni familiari e pratiche scolastiche',
            'Supporto patronale per pensioni, invalidità, NASpI e maternità',
        ],
        'offers' => [
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
            ['label' => 'Prenota un appuntamento', 'url' => 'https://wa.me/393773798570?text=Vorrei%20prenotare%20un%20appuntamento%20CAF%2FPatronato', 'external' => true],
        ],
    ],
    [
        'id' => 'visure',
        'title' => 'Visure e report',
        'intro' => 'Forniamo visure aggiornate per persone e imprese: dati catastali, finanziari e camerali con consegna immediata in formato digitale.',
        'highlights' => [
            'Visure CRIF per verificare la propria posizione creditizia',
            'Visure catastali e ipotecarie con planimetrie su richiesta',
            'Report camerali, PRA, protesti e schede imprese',
        ],
        'offers' => [
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
    ],
    [
        'id' => 'telefonia',
        'title' => 'Telefonia, Luce e Gas',
        'intro' => 'Compariamo soluzioni per casa e aziende con i principali operatori nazionali di telefonia, fibra e utilities, seguendo ogni step di attivazione e migrazione.',
        'highlights' => [
            'Partner Fastweb, Iliad, WindTre, Pianeta Fibra, Sky WiFi, A2A Energia, Enel Energia e Fastweb Energia',
            'Portabilità numeri fissi e mobili con gestione pratiche',
            'Analisi bollette per ottimizzare costi e consumi',
        ],
        'offers' => [
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
    ],
    [
        'id' => 'posta-telematica',
        'title' => 'Invii posta telematica e servizi postali',
        'intro' => 'Spediamo comunicazioni ufficiali e documenti certificati con canali digitali: PEC, raccomandate elettroniche e stampa recapito.',
        'highlights' => [
            'Invio PEC con ricevute di accettazione e consegna',
            'Raccomandate online e posta ibrida con tracciabilità',
            'Gestione atti giudiziari e notifiche a valore legale',
        ],
        'offers' => [
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
    ],
    [
        'id' => 'punto-ritiro',
        'title' => 'Punto di ritiro pacchi',
        'intro' => 'Siamo hub autorizzato PuntoPoste, BRT-Fermopoint, GLS Shop e FedEx Location: puoi ritirare, depositare e gestire resi in modo semplice.',
        'highlights' => [
            'Notifica di arrivo pacco via SMS o email',
            'Deposito gratuito per più giorni con sicurezza garantita',
            'Servizio di reso con etichette corriere pronte in agenzia',
        ],
        'offers' => [
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
    ],
];
?>

<section class="section">
    <div class="container" data-animate="fade-up">
        <h1 class="title">I Nostri Servizi</h1>
        <p class="subtitle">Offriamo una gamma completa di servizi per privati, professionisti e aziende: scegli l’area di interesse e approfondisci le soluzioni dedicate.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="columns is-multiline is-variable is-5" data-stagger>
            <?php foreach ($serviceCards as $card): ?>
                <div class="column is-12-tablet is-one-third-desktop">
                    <div class="card service-card service-card--compact">
                        <div class="card-content">
                            <h3 class="title is-4"><span class="service-icon" aria-hidden="true"><?= sanitize($card['icon']); ?></span><?= sanitize($card['title']); ?></h3>
                            <p><?= sanitize($card['summary']); ?></p>
                            <a class="button is-warning is-light" href="#<?= sanitize($card['id']); ?>">Approfondisci</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<?php foreach ($serviceSections as $index => $service): ?>
    <section id="<?= sanitize($service['id']); ?>" class="section <?= $index % 2 === 0 ? 'section-light' : ''; ?>">
        <div class="container">
            <div class="columns is-variable is-6" data-animate="fade-up">
                <div class="column is-7">
                    <h2 class="title"><?= sanitize($service['title']); ?></h2>
                    <p class="subtitle"><?= sanitize($service['intro']); ?></p>
                </div>
                <?php if (!empty($service['highlights'])): ?>
                    <div class="column is-5">
                        <div class="box service-highlight-box">
                            <p class="heading">In breve</p>
                            <ul class="service-highlights">
                                <?php foreach ($service['highlights'] as $highlight): ?>
                                    <li><?= sanitize($highlight); ?></li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                <?php endif; ?>
            </div>

            <?php if (!empty($service['offers'])): ?>
                <div class="columns is-multiline is-variable is-5" data-stagger>
                    <?php foreach ($service['offers'] as $offer): ?>
                        <div class="column is-12-tablet is-one-third-desktop">
                            <div class="box service-detail">
                                <h3 class="title is-5"><?= sanitize($offer['title']); ?></h3>
                                <ul class="service-list">
                                    <?php foreach ($offer['items'] as $item): ?>
                                        <li><?= sanitize($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($service['requirements']) || !empty($service['reminders']) || !empty($service['cta'])): ?>
                <div class="columns is-variable is-6">
                    <?php if (!empty($service['requirements'])): ?>
                        <div class="column">
                            <div class="box">
                                <p class="heading">Cosa portare</p>
                                <ul class="service-list">
                                    <?php foreach ($service['requirements'] as $requirement): ?>
                                        <li><?= sanitize($requirement); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($service['reminders'])): ?>
                        <div class="column">
                            <div class="box">
                                <p class="heading">Promemoria utili</p>
                                <ul class="service-list">
                                    <?php foreach ($service['reminders'] as $reminder): ?>
                                        <li><?= sanitize($reminder); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($service['cta'])): ?>
                <div class="buttons">
                    <?php foreach ($service['cta'] as $cta): ?>
                        <a class="button is-warning <?= !empty($cta['external']) ? 'is-outlined' : ''; ?>" href="<?= htmlspecialchars($cta['url']); ?>"<?= !empty($cta['external']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>>
                            <?= sanitize($cta['label']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>
<?php endforeach; ?>

<section class="section">
    <div class="container">
        <div class="columns is-variable is-6">
            <div class="column is-7">
                <h3 class="title is-4">Contattaci</h3>
                <p>Via Plinio il Vecchio 72, Castellammare di Stabia (NA)</p>
                <p><a href="tel:+390810584542">+39 081 0584542</a> &bull; <a href="mailto:info@agenziaplinio.it">info@agenziaplinio.it</a></p>
                <p>Orari: Lun-Ven 9:00-13:20 / 16:00-19:20 &bull; Sab 9:00-13:00</p>
            </div>
            <div class="column is-5">
                <div class="box">
                    <p>&copy; 2025 AG SERVIZI VIA PLINIO 72. Tutti i diritti riservati.</p>
                    <p>P.IVA: 08442881218 &middot; REA: NA-985288</p>
                    <p>Conforme al GDPR (UE) 2016/679</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
