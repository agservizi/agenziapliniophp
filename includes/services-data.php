<?php
return [
    [
        'slug' => 'pagamenti',
        'icon' => '💳',
        'name' => 'Pagamenti e tributi',
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
        'slug' => 'biglietteria',
        'icon' => '🚆',
        'name' => 'Biglietteria & mobilità',
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
        'slug' => 'spedizioni',
        'icon' => '📦',
        'name' => 'Spedizioni e logistica',
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
        'slug' => 'attivazioni-digitali',
        'icon' => '🆔',
        'name' => 'Identità e firme digitali',
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
        'slug' => 'caf-patronato',
        'icon' => '🗂️',
        'name' => 'CAF e patronato',
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
        'slug' => 'visure',
        'icon' => '🔍',
        'name' => 'Visure e report',
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
        'slug' => 'telefonia',
        'icon' => '📡',
        'name' => 'Telefonia, luce e gas',
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
        'slug' => 'posta-telematica',
        'icon' => '📨',
        'name' => 'Posta telematica e atti',
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
        'slug' => 'punto-ritiro',
        'icon' => '📮',
        'name' => 'Punto di ritiro pacchi',
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
