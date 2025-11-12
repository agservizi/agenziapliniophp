<?php
/**
 * Script di installazione database
 * Agenzia Plinio - Sistema di gestione multiservizi
 */

require_once 'includes/config.php';

try {
    $pdo = getDBConnection();
    
    echo "🚀 Inizializzazione database in corso...\n\n";
    
    // Tabella utenti
    $sql_users = "CREATE TABLE IF NOT EXISTS utenti (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        cognome VARCHAR(100) NOT NULL,
        email VARCHAR(255) UNIQUE NOT NULL,
        telefono VARCHAR(20),
        password_hash VARCHAR(255) NOT NULL,
        ruolo ENUM('cliente', 'admin') DEFAULT 'cliente',
        attivo BOOLEAN DEFAULT TRUE,
        email_verificata BOOLEAN DEFAULT FALSE,
        ultimo_accesso DATETIME,
        tentativi_login INT DEFAULT 0,
        bloccato_fino DATETIME NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_email (email),
        INDEX idx_ruolo (ruolo),
        INDEX idx_attivo (attivo)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_users);
    echo "✅ Tabella 'utenti' creata\n";
    
    // Tabella categorie prodotti
    $sql_categories = "CREATE TABLE IF NOT EXISTS categorie_prodotti (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(100) NOT NULL,
        descrizione TEXT,
        icona VARCHAR(100),
        attiva BOOLEAN DEFAULT TRUE,
        ordine_visualizzazione INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        INDEX idx_attiva (attiva),
        INDEX idx_ordine (ordine_visualizzazione)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_categories);
    echo "✅ Tabella 'categorie_prodotti' creata\n";
    
    // Tabella prodotti
    $sql_products = "CREATE TABLE IF NOT EXISTS prodotti (
        id INT AUTO_INCREMENT PRIMARY KEY,
        categoria_id INT,
        nome VARCHAR(255) NOT NULL,
        descrizione TEXT,
        prezzo DECIMAL(10,2) NOT NULL,
        prezzo_scontato DECIMAL(10,2) NULL,
        immagine VARCHAR(255),
        tipo_prodotto ENUM('digitale', 'fisico', 'servizio') DEFAULT 'digitale',
        disponibile BOOLEAN DEFAULT TRUE,
        quantita_disponibile INT DEFAULT 0,
        tags VARCHAR(500),
        meta_title VARCHAR(255),
        meta_description VARCHAR(500),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (categoria_id) REFERENCES categorie_prodotti(id) ON DELETE SET NULL,
        INDEX idx_categoria (categoria_id),
        INDEX idx_disponibile (disponibile),
        INDEX idx_tipo (tipo_prodotto),
        INDEX idx_prezzo (prezzo)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_products);
    echo "✅ Tabella 'prodotti' creata\n";
    
    // Tabella ordini
    $sql_orders = "CREATE TABLE IF NOT EXISTS ordini (
        id INT AUTO_INCREMENT PRIMARY KEY,
        utente_id INT NOT NULL,
        numero_ordine VARCHAR(50) UNIQUE NOT NULL,
        stato ENUM('in_attesa', 'confermato', 'in_elaborazione', 'completato', 'annullato') DEFAULT 'in_attesa',
        totale DECIMAL(10,2) NOT NULL,
        metodo_pagamento VARCHAR(50),
        note_cliente TEXT,
        note_interne TEXT,
        data_consegna_prevista DATE,
        indirizzo_spedizione JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE,
        INDEX idx_utente (utente_id),
        INDEX idx_stato (stato),
        INDEX idx_numero_ordine (numero_ordine),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_orders);
    echo "✅ Tabella 'ordini' creata\n";
    
    // Tabella dettagli ordini
    $sql_order_items = "CREATE TABLE IF NOT EXISTS ordini_dettagli (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ordine_id INT NOT NULL,
        prodotto_id INT NOT NULL,
        quantita INT NOT NULL,
        prezzo_unitario DECIMAL(10,2) NOT NULL,
        totale_riga DECIMAL(10,2) NOT NULL,
        note VARCHAR(255),
        FOREIGN KEY (ordine_id) REFERENCES ordini(id) ON DELETE CASCADE,
        FOREIGN KEY (prodotto_id) REFERENCES prodotti(id) ON DELETE RESTRICT,
        INDEX idx_ordine (ordine_id),
        INDEX idx_prodotto (prodotto_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_order_items);
    echo "✅ Tabella 'ordini_dettagli' creata\n";
    
    // Tabella servizi
    $sql_services = "CREATE TABLE IF NOT EXISTS servizi (
        id INT AUTO_INCREMENT PRIMARY KEY,
        nome VARCHAR(255) NOT NULL,
        descrizione_breve VARCHAR(500),
        descrizione_completa TEXT,
        icona VARCHAR(100),
        prezzo_da DECIMAL(10,2),
        tempo_evasione VARCHAR(100),
        attivo BOOLEAN DEFAULT TRUE,
        in_evidenza BOOLEAN DEFAULT FALSE,
        ordine_visualizzazione INT DEFAULT 0,
        meta_title VARCHAR(255),
        meta_description VARCHAR(500),
        slug VARCHAR(255) UNIQUE,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_attivo (attivo),
        INDEX idx_evidenza (in_evidenza),
        INDEX idx_ordine (ordine_visualizzazione),
        INDEX idx_slug (slug)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_services);
    echo "✅ Tabella 'servizi' creata\n";
    
    // Tabella FAQ Chatbot
    $sql_faq = "CREATE TABLE IF NOT EXISTS faq_chatbot (
        id INT AUTO_INCREMENT PRIMARY KEY,
        domanda VARCHAR(500) NOT NULL,
        risposta TEXT NOT NULL,
        parole_chiave JSON,
        categoria VARCHAR(100),
        priorita INT DEFAULT 0,
        attiva BOOLEAN DEFAULT TRUE,
        contatore_utilizzo INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        INDEX idx_categoria (categoria),
        INDEX idx_attiva (attiva),
        INDEX idx_priorita (priorita),
        FULLTEXT idx_domanda_risposta (domanda, risposta)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_faq);
    echo "✅ Tabella 'faq_chatbot' creata\n";
    
    // Tabella conversazioni chatbot
    $sql_chat_conversations = "CREATE TABLE IF NOT EXISTS chat_conversazioni (
        id INT AUTO_INCREMENT PRIMARY KEY,
        utente_id INT,
        session_id VARCHAR(255) NOT NULL,
        messaggio_utente TEXT NOT NULL,
        risposta_bot TEXT NOT NULL,
        faq_utilizzata_id INT,
        valutazione ENUM('positiva', 'negativa') NULL,
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE SET NULL,
        FOREIGN KEY (faq_utilizzata_id) REFERENCES faq_chatbot(id) ON DELETE SET NULL,
        INDEX idx_utente (utente_id),
        INDEX idx_session (session_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_chat_conversations);
    echo "✅ Tabella 'chat_conversazioni' creata\n";
    
    // Tabella ticket assistenza
    $sql_tickets = "CREATE TABLE IF NOT EXISTS ticket_assistenza (
        id INT AUTO_INCREMENT PRIMARY KEY,
        utente_id INT NOT NULL,
        numero_ticket VARCHAR(50) UNIQUE NOT NULL,
        oggetto VARCHAR(255) NOT NULL,
        descrizione TEXT NOT NULL,
        priorita ENUM('bassa', 'media', 'alta', 'urgente') DEFAULT 'media',
        stato ENUM('aperto', 'in_lavorazione', 'in_attesa_cliente', 'risolto', 'chiuso') DEFAULT 'aperto',
        categoria VARCHAR(100),
        assegnato_a INT,
        ultimo_aggiornamento TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        risolto_il DATETIME NULL,
        valutazione_cliente INT CHECK (valutazione_cliente >= 1 AND valutazione_cliente <= 5),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE,
        FOREIGN KEY (assegnato_a) REFERENCES utenti(id) ON DELETE SET NULL,
        INDEX idx_utente (utente_id),
        INDEX idx_stato (stato),
        INDEX idx_priorita (priorita),
        INDEX idx_numero_ticket (numero_ticket),
        INDEX idx_assegnato (assegnato_a)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_tickets);
    echo "✅ Tabella 'ticket_assistenza' creata\n";
    
    // Tabella risposte ticket
    $sql_ticket_replies = "CREATE TABLE IF NOT EXISTS ticket_risposte (
        id INT AUTO_INCREMENT PRIMARY KEY,
        ticket_id INT NOT NULL,
        utente_id INT NOT NULL,
        messaggio TEXT NOT NULL,
        tipo_utente ENUM('cliente', 'staff') NOT NULL,
        allegati JSON,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (ticket_id) REFERENCES ticket_assistenza(id) ON DELETE CASCADE,
        FOREIGN KEY (utente_id) REFERENCES utenti(id) ON DELETE CASCADE,
        INDEX idx_ticket (ticket_id),
        INDEX idx_utente (utente_id),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_ticket_replies);
    echo "✅ Tabella 'ticket_risposte' creata\n";
    
    // Tabella log attività
    $sql_activity_logs = "CREATE TABLE IF NOT EXISTS activity_logs (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT,
        action VARCHAR(255) NOT NULL,
        details TEXT,
        ip_address VARCHAR(45),
        user_agent TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        FOREIGN KEY (user_id) REFERENCES utenti(id) ON DELETE SET NULL,
        INDEX idx_user (user_id),
        INDEX idx_action (action),
        INDEX idx_created_at (created_at)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci";
    
    $pdo->exec($sql_activity_logs);
    echo "✅ Tabella 'activity_logs' creata\n";
    
    // Inserimento dati iniziali
    echo "\n📝 Inserimento dati di esempio...\n";
    
    // Utente admin predefinito
    $admin_password = password_hash('admin123!', HASH_ALGO);
    $stmt = $pdo->prepare("INSERT IGNORE INTO utenti (nome, cognome, email, password_hash, ruolo, email_verificata) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute(['Admin', 'Sistema', 'admin@agenziaplinio.local', $admin_password, 'admin', true]);
    echo "👤 Utente admin creato (email: admin@agenziaplinio.local, password: admin123!)\n";
    
    // Categorie prodotti di esempio
    $categories = [
        ['Ricariche Telefoniche', 'Ricariche per tutti gli operatori italiani', 'phone', 1],
        ['Servizi Digitali', 'SPID, PEC, Firma Digitale e altri servizi online', 'digital', 2],
        ['Bollettini e Pagamenti', 'Pagamento bollettini, F24, bollo auto', 'payment', 3],
        ['Spedizioni', 'Spedizioni nazionali e internazionali', 'shipping', 4],
        ['Contratti Telefonici', 'Attivazione e gestione contratti telefonici', 'contract', 5]
    ];
    
    foreach ($categories as $category) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO categorie_prodotti (nome, descrizione, icona, ordine_visualizzazione) VALUES (?, ?, ?, ?)");
        $stmt->execute($category);
    }
    echo "📦 Categorie prodotti inserite\n";
    
    // Servizi di esempio ispirati ad agenziaplinio.it
    $services = [
        [
            'SPID - Sistema Pubblico di Identità Digitale',
            'Identità digitale per accedere ai servizi online della PA',
            'La tua identità digitale per accedere in modo sicuro e veloce ai servizi online della Pubblica Amministrazione. Con SPID puoi accedere a tutti i portali istituzionali con un unico accesso.',
            'spid-icon',
            15.00,
            '24-48 ore',
            true,
            true,
            1,
            'spid-identita-digitale'
        ],
        [
            'PEC - Posta Elettronica Certificata',
            'Email con valore legale per privati e aziende',
            'La Posta Elettronica Certificata garantisce valore legale alle tue comunicazioni digitali. Indispensabile per comunicazioni con la PA e per le attività professionali.',
            'pec-icon',
            25.00,
            '2-4 ore',
            true,
            true,
            2,
            'pec-posta-certificata'
        ],
        [
            'Firma Digitale',
            'Sottoscrizione documenti con valore legale',
            'La Firma Digitale ti permette di sottoscrivere digitalmente documenti con pieno valore legale, sostituendo la firma autografa tradizionale.',
            'signature-icon',
            35.00,
            '24-48 ore',
            true,
            true,
            3,
            'firma-digitale'
        ],
        [
            'CNS - Carta Nazionale dei Servizi',
            'Smart card per accesso ai servizi telematici',
            'La Carta Nazionale dei Servizi permette l\'accesso ai servizi erogati dalle pubbliche amministrazioni attraverso la rete internet.',
            'card-icon',
            20.00,
            '3-5 giorni',
            true,
            false,
            4,
            'cns-carta-servizi'
        ],
        [
            'Ricariche Telefoniche',
            'Ricariche per tutti gli operatori',
            'Effettua ricariche telefoniche per tutti gli operatori italiani: TIM, Vodafone, WindTre, Iliad, PosteMobile e molti altri.',
            'phone-icon',
            0.00,
            'Immediato',
            true,
            true,
            5,
            'ricariche-telefoniche'
        ],
        [
            'Pagamento Bollettini',
            'Paga bollettini postali e bancari',
            'Servizio di pagamento per bollettini postali, MAV, RAV, bolletti bancari e altre tipologie di pagamento.',
            'bill-icon',
            2.00,
            '24 ore',
            true,
            true,
            6,
            'pagamento-bollettini'
        ],
        [
            'Spedizioni',
            'Spedizioni nazionali e internazionali',
            'Servizio completo di spedizioni con i migliori corrieri: Poste Italiane, GLS, UPS, DHL. Tariffe competitive e tracking completo.',
            'shipping-icon',
            5.00,
            '1-3 giorni',
            true,
            false,
            7,
            'spedizioni'
        ],
        [
            'Pratiche Automobilistiche',
            'Rinnovo patenti, bollo auto, revisioni',
            'Assistenza completa per tutte le pratiche automobilistiche: rinnovo patenti, pagamento bollo auto, prenotazione revisioni.',
            'car-icon',
            15.00,
            '2-5 giorni',
            true,
            false,
            8,
            'pratiche-auto'
        ]
    ];
    
    foreach ($services as $service) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO servizi (nome, descrizione_breve, descrizione_completa, icona, prezzo_da, tempo_evasione, attivo, in_evidenza, ordine_visualizzazione, slug) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute($service);
    }
    echo "🔧 Servizi inseriti\n";
    
    // FAQ Chatbot di esempio
    $faqs = [
        [
            'Come posso richiedere SPID?',
            'Per richiedere SPID presso la nostra agenzia devi portare: documento di identità valido, tessera sanitaria o codice fiscale, numero di cellulare e indirizzo email. Il costo è di €15 e il rilascio avviene in 24-48 ore.',
            json_encode(['spid', 'identità digitale', 'documento', 'richiesta']),
            'Servizi Digitali',
            10
        ],
        [
            'Quanto costa la PEC?',
            'La PEC (Posta Elettronica Certificata) ha un costo di €25 per un anno. Include 1GB di spazio di archiviazione e assistenza tecnica. L\'attivazione avviene in 2-4 ore.',
            json_encode(['pec', 'costo', 'prezzo', 'posta certificata']),
            'Servizi Digitali',
            9
        ],
        [
            'Quali operatori supportate per le ricariche?',
            'Supportiamo tutti i principali operatori: TIM, Vodafone, WindTre, Iliad, PosteMobile, Fastweb Mobile, ho.Mobile, Kena Mobile e molti altri operatori virtuali.',
            json_encode(['ricariche', 'operatori', 'tim', 'vodafone', 'windtre', 'iliad']),
            'Ricariche',
            8
        ],
        [
            'Come funziona il pagamento bollettini?',
            'Puoi pagare bollettini postali, MAV, RAV e bolletti bancari con una commissione di €2. Basta portare il bollettino in agenzia o inviare una foto leggibile via WhatsApp.',
            json_encode(['bollettini', 'pagamento', 'mav', 'rav', 'commissione']),
            'Pagamenti',
            7
        ],
        [
            'Che documenti servono per la Firma Digitale?',
            'Per la Firma Digitale serve: documento di identità valido, tessera sanitaria, numero di cellulare. Il costo è di €35 e include il kit USB e certificato valido 3 anni.',
            json_encode(['firma digitale', 'documenti', 'usb', 'certificato']),
            'Servizi Digitali',
            8
        ],
        [
            'Fate spedizioni?',
            'Sì, offriamo spedizioni nazionali e internazionali con Poste Italiane, GLS, UPS e DHL. Tariffe competitive a partire da €5. Puoi tracciare la spedizione online.',
            json_encode(['spedizioni', 'corriere', 'tracking', 'nazionale', 'internazionale']),
            'Spedizioni',
            6
        ],
        [
            'Orari di apertura?',
            'Siamo aperti dal lunedì al venerdì dalle 9:00 alle 18:00, sabato dalle 9:00 alle 13:00. Chiusi la domenica e festivi.',
            json_encode(['orari', 'apertura', 'lunedì', 'venerdì', 'sabato']),
            'Informazioni',
            9
        ],
        [
            'Dove siete ubicati?',
            'Ci trovi in Via Plinio 72, Milano. Facilmente raggiungibile con i mezzi pubblici, parcheggio disponibile nelle vicinanze.',
            json_encode(['indirizzo', 'dove', 'via plinio', 'milano', 'ubicazione']),
            'Informazioni',
            5
        ]
    ];
    
    foreach ($faqs as $faq) {
        $stmt = $pdo->prepare("INSERT IGNORE INTO faq_chatbot (domanda, risposta, parole_chiave, categoria, priorita) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute($faq);
    }
    echo "🤖 FAQ Chatbot inserite\n";
    
    echo "\n✅ Database inizializzato con successo!\n";
    echo "🌐 Il sito è ora pronto per essere utilizzato.\n\n";
    echo "📋 Credenziali admin:\n";
    echo "   Email: admin@agenziaplinio.local\n";
    echo "   Password: admin123!\n\n";
    
} catch (Exception $e) {
    echo "❌ Errore durante l'installazione: " . $e->getMessage() . "\n";
    die();
}
?>