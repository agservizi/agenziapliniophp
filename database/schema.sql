-- Agenzia Plinio database schema
-- Run: mysql -u agenziaplinio_app -p agenziaplinio < database/schema.sql

CREATE DATABASE IF NOT EXISTS agenziaplinio CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE agenziaplinio;

CREATE TABLE IF NOT EXISTS utenti (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(80) NOT NULL,
    cognome VARCHAR(80) NOT NULL,
    email VARCHAR(160) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    ruolo ENUM('cliente','admin') NOT NULL DEFAULT 'cliente',
    data_creazione TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    ultimo_accesso TIMESTAMP NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS prodotti (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(160) NOT NULL,
    descrizione TEXT NOT NULL,
    prezzo DECIMAL(10,2) NOT NULL,
    immagine VARCHAR(255) DEFAULT NULL,
    categoria VARCHAR(120) NOT NULL,
    disponibile TINYINT(1) NOT NULL DEFAULT 1,
    data_creazione TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_aggiornamento TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_prodotti_categoria (categoria)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS servizi (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    nome VARCHAR(160) NOT NULL,
    descrizione TEXT NOT NULL,
    tipo VARCHAR(120) NOT NULL,
    attivo TINYINT(1) NOT NULL DEFAULT 1,
    immagine VARCHAR(255) DEFAULT NULL,
    prezzo DECIMAL(10,2) DEFAULT NULL,
    data_creazione TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    data_aggiornamento TIMESTAMP NULL DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_servizi_tipo (tipo)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ordini (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utente INT UNSIGNED NULL,
    totale DECIMAL(10,2) NOT NULL,
    stato VARCHAR(60) NOT NULL DEFAULT 'in revisione',
    payment_status VARCHAR(60) NOT NULL DEFAULT 'pending',
    payment_reference VARCHAR(120) DEFAULT NULL,
    note TEXT DEFAULT NULL,
    data_ordine TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_ordini_utente (id_utente),
    CONSTRAINT fk_ordini_utente FOREIGN KEY (id_utente) REFERENCES utenti (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS ordini_dettagli (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_ordine INT UNSIGNED NOT NULL,
    id_prodotto INT UNSIGNED NOT NULL,
    quantita INT UNSIGNED NOT NULL,
    prezzo_unitario DECIMAL(10,2) NOT NULL,
    INDEX idx_dettagli_ordine (id_ordine),
    INDEX idx_dettagli_prodotto (id_prodotto),
    CONSTRAINT fk_dettagli_ordine FOREIGN KEY (id_ordine) REFERENCES ordini (id)
        ON DELETE CASCADE ON UPDATE CASCADE,
    CONSTRAINT fk_dettagli_prodotto FOREIGN KEY (id_prodotto) REFERENCES prodotti (id)
        ON DELETE RESTRICT ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS richieste_servizi (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utente INT UNSIGNED NULL,
    id_servizio INT UNSIGNED NULL,
    stato VARCHAR(60) NOT NULL DEFAULT 'nuova',
    messaggio TEXT DEFAULT NULL,
    data_richiesta TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_richieste_utente (id_utente),
    INDEX idx_richieste_servizio (id_servizio),
    CONSTRAINT fk_richieste_utente FOREIGN KEY (id_utente) REFERENCES utenti (id)
        ON DELETE SET NULL ON UPDATE CASCADE,
    CONSTRAINT fk_richieste_servizio FOREIGN KEY (id_servizio) REFERENCES servizi (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS notifiche (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_utente INT UNSIGNED NULL,
    titolo VARCHAR(160) NOT NULL,
    messaggio TEXT NOT NULL,
    letta TINYINT(1) NOT NULL DEFAULT 0,
    data_creazione TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_notifiche_utente (id_utente),
    CONSTRAINT fk_notifiche_utente FOREIGN KEY (id_utente) REFERENCES utenti (id)
        ON DELETE SET NULL ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS pagamenti (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    id_ordine INT UNSIGNED NOT NULL,
    provider VARCHAR(60) NOT NULL,
    status VARCHAR(40) NOT NULL,
    reference VARCHAR(120) DEFAULT NULL,
    payload JSON DEFAULT NULL,
    data_creazione TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP,
    CONSTRAINT fk_pagamenti_ordine FOREIGN KEY (id_ordine) REFERENCES ordini (id)
        ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS allegati (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    percorso VARCHAR(255) NOT NULL,
    tipo VARCHAR(40) NOT NULL,
    dimensione INT UNSIGNED NOT NULL,
    meta JSON DEFAULT NULL,
    data_creazione TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
