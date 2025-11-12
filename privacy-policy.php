<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$page_title = 'Privacy Policy - AG SERVIZI VIA PLINIO 72';
$page_description = 'Informativa sulla privacy e trattamento dei dati personali secondo il GDPR.';
$current_page = 'privacy-policy';

include 'includes/header.php';
?>

<main class="privacy-page">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="header-content">
                <h1>Privacy Policy</h1>
                <p class="header-subtitle">
                    Informativa sulla privacy e trattamento dei dati personali
                </p>
                <div class="header-meta">
                    <span class="meta-item">
                        <i class="icon-calendar"></i>
                        Ultimo aggiornamento: <?= date('d/m/Y') ?>
                    </span>
                    <span class="meta-item">
                        <i class="icon-shield"></i>
                        Conforme GDPR 2018
                    </span>
                </div>
            </div>
        </div>
    </section>

    <!-- Privacy Content -->
    <section class="privacy-content">
        <div class="container">
            <div class="content-wrapper">
                <!-- Table of Contents -->
                <nav class="toc">
                    <h3>Indice dei contenuti</h3>
                    <ul>
                        <li><a href="#titolare">Titolare del trattamento</a></li>
                        <li><a href="#dati-raccolti">Dati raccolti</a></li>
                        <li><a href="#finalita">Finalità del trattamento</a></li>
                        <li><a href="#modalita">Modalità del trattamento</a></li>
                        <li><a href="#conservazione">Conservazione dei dati</a></li>
                        <li><a href="#diritti">Diritti dell'interessato</a></li>
                        <li><a href="#cookie">Politica sui cookie</a></li>
                        <li><a href="#modifiche">Modifiche alla privacy policy</a></li>
                        <li><a href="#contatti">Contatti</a></li>
                    </ul>
                </nav>

                <!-- Main Content -->
                <div class="privacy-main">
                    <section id="titolare" class="section">
                        <h2>1. Titolare del trattamento</h2>
                        <div class="section-content">
                            <p>
                                Il Titolare del trattamento dei dati personali è <strong>AG SERVIZI VIA PLINIO 72</strong> 
                                con sede in Via Plinio 72, 20900 Monza (MB), Italia.
                            </p>
                            <div class="contact-box">
                                <h4>Dati di contatto:</h4>
                                <ul>
                                    <li><strong>Email:</strong> privacy@agenziaplinio.it</li>
                                    <li><strong>Telefono:</strong> +39 039 123 4567</li>
                                    <li><strong>PEC:</strong> agenziaplinio@pec.it</li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <section id="dati-raccolti" class="section">
                        <h2>2. Dati raccolti</h2>
                        <div class="section-content">
                            <p>Raccogliamo e trattiamo le seguenti categorie di dati personali:</p>
                            
                            <h3>2.1 Dati di registrazione</h3>
                            <ul>
                                <li>Nome e cognome</li>
                                <li>Indirizzo email</li>
                                <li>Numero di telefono</li>
                                <li>Data di nascita</li>
                                <li>Codice fiscale (quando necessario)</li>
                                <li>Indirizzo di residenza</li>
                            </ul>

                            <h3>2.2 Dati di navigazione</h3>
                            <ul>
                                <li>Indirizzo IP</li>
                                <li>Tipo di browser e versione</li>
                                <li>Sistema operativo</li>
                                <li>Pagine visitate e tempo di permanenza</li>
                                <li>Fonte di traffico</li>
                            </ul>

                            <h3>2.3 Cookie e tecnologie simili</h3>
                            <ul>
                                <li>Cookie tecnici necessari per il funzionamento del sito</li>
                                <li>Cookie di preferenze per ricordare le impostazioni</li>
                                <li>Cookie analitici per misurare le performance del sito</li>
                            </ul>
                        </div>
                    </section>

                    <section id="finalita" class="section">
                        <h2>3. Finalità del trattamento</h2>
                        <div class="section-content">
                            <p>I tuoi dati personali sono trattati per le seguenti finalità:</p>
                            
                            <div class="purpose-grid">
                                <div class="purpose-card">
                                    <div class="purpose-icon">
                                        <i class="icon-user-check"></i>
                                    </div>
                                    <h4>Gestione account utente</h4>
                                    <p>Creazione e gestione del tuo account personale</p>
                                    <div class="legal-basis">Base giuridica: Contratto</div>
                                </div>

                                <div class="purpose-card">
                                    <div class="purpose-icon">
                                        <i class="icon-shopping-cart"></i>
                                    </div>
                                    <h4>Erogazione servizi</h4>
                                    <p>Fornitura dei servizi richiesti e gestione ordini</p>
                                    <div class="legal-basis">Base giuridica: Contratto</div>
                                </div>

                                <div class="purpose-card">
                                    <div class="purpose-icon">
                                        <i class="icon-headphones"></i>
                                    </div>
                                    <h4>Supporto clienti</h4>
                                    <p>Assistenza tecnica e risoluzione problemi</p>
                                    <div class="legal-basis">Base giuridica: Legittimo interesse</div>
                                </div>

                                <div class="purpose-card">
                                    <div class="purpose-icon">
                                        <i class="icon-mail"></i>
                                    </div>
                                    <h4>Comunicazioni</h4>
                                    <p>Invio di comunicazioni relative ai servizi</p>
                                    <div class="legal-basis">Base giuridica: Consenso</div>
                                </div>

                                <div class="purpose-card">
                                    <div class="purpose-icon">
                                        <i class="icon-shield"></i>
                                    </div>
                                    <h4>Sicurezza</h4>
                                    <p>Prevenzione frodi e protezione del sito</p>
                                    <div class="legal-basis">Base giuridica: Legittimo interesse</div>
                                </div>

                                <div class="purpose-card">
                                    <div class="purpose-icon">
                                        <i class="icon-scale"></i>
                                    </div>
                                    <h4>Obblighi legali</h4>
                                    <p>Adempimento di obblighi di legge</p>
                                    <div class="legal-basis">Base giuridica: Obbligo legale</div>
                                </div>
                            </div>
                        </div>
                    </section>

                    <section id="modalita" class="section">
                        <h2>4. Modalità del trattamento</h2>
                        <div class="section-content">
                            <p>I dati personali sono trattati con strumenti automatizzati per il tempo strettamente necessario a conseguire gli scopi per cui sono stati raccolti.</p>
                            
                            <h3>4.1 Misure di sicurezza</h3>
                            <ul>
                                <li>Crittografia dei dati sensibili</li>
                                <li>Accesso limitato ai dati con credenziali uniche</li>
                                <li>Backup automatici e sicuri</li>
                                <li>Monitoraggio continuo degli accessi</li>
                                <li>Aggiornamenti di sicurezza regolari</li>
                            </ul>

                            <h3>4.2 Personale autorizzato</h3>
                            <p>I dati sono accessibili solo al personale autorizzato e formato sul trattamento corretto dei dati personali.</p>
                        </div>
                    </section>

                    <section id="conservazione" class="section">
                        <h2>5. Conservazione dei dati</h2>
                        <div class="section-content">
                            <p>I dati personali sono conservati per il tempo necessario alle finalità per cui sono stati raccolti:</p>
                            
                            <div class="retention-table">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Tipo di dati</th>
                                            <th>Periodo di conservazione</th>
                                            <th>Motivazione</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td>Dati di account</td>
                                            <td>Fino alla cancellazione dell'account</td>
                                            <td>Gestione del servizio</td>
                                        </tr>
                                        <tr>
                                            <td>Dati di navigazione</td>
                                            <td>24 mesi</td>
                                            <td>Analisi e sicurezza</td>
                                        </tr>
                                        <tr>
                                            <td>Dati contabili</td>
                                            <td>10 anni</td>
                                            <td>Obblighi fiscali</td>
                                        </tr>
                                        <tr>
                                            <td>Comunicazioni marketing</td>
                                            <td>Fino alla revoca del consenso</td>
                                            <td>Consenso dell'utente</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </section>

                    <section id="diritti" class="section">
                        <h2>6. Diritti dell'interessato</h2>
                        <div class="section-content">
                            <p>Ai sensi del GDPR, hai diritto a:</p>
                            
                            <div class="rights-grid">
                                <div class="right-card">
                                    <div class="right-icon">
                                        <i class="icon-eye"></i>
                                    </div>
                                    <h4>Accesso</h4>
                                    <p>Ottenere informazioni sui tuoi dati personali</p>
                                </div>

                                <div class="right-card">
                                    <div class="right-icon">
                                        <i class="icon-edit"></i>
                                    </div>
                                    <h4>Rettifica</h4>
                                    <p>Correggere dati inesatti o incompleti</p>
                                </div>

                                <div class="right-card">
                                    <div class="right-icon">
                                        <i class="icon-trash"></i>
                                    </div>
                                    <h4>Cancellazione</h4>
                                    <p>Richiedere la cancellazione dei tuoi dati</p>
                                </div>

                                <div class="right-card">
                                    <div class="right-icon">
                                        <i class="icon-pause"></i>
                                    </div>
                                    <h4>Limitazione</h4>
                                    <p>Limitare il trattamento dei tuoi dati</p>
                                </div>

                                <div class="right-card">
                                    <div class="right-icon">
                                        <i class="icon-download"></i>
                                    </div>
                                    <h4>Portabilità</h4>
                                    <p>Ricevere i tuoi dati in formato strutturato</p>
                                </div>

                                <div class="right-card">
                                    <div class="right-icon">
                                        <i class="icon-x"></i>
                                    </div>
                                    <h4>Opposizione</h4>
                                    <p>Opporti al trattamento dei tuoi dati</p>
                                </div>
                            </div>

                            <div class="rights-action">
                                <h4>Come esercitare i tuoi diritti</h4>
                                <p>Per esercitare i tuoi diritti, contattaci tramite:</p>
                                <ul>
                                    <li>Email: <a href="mailto:privacy@agenziaplinio.it">privacy@agenziaplinio.it</a></li>
                                    <li>Modulo di contatto del sito web</li>
                                    <li>Posta ordinaria all'indirizzo della sede legale</li>
                                </ul>
                                <p><strong>Tempo di risposta:</strong> Ti risponderemo entro 30 giorni dalla richiesta.</p>
                            </div>
                        </div>
                    </section>

                    <section id="cookie" class="section">
                        <h2>7. Politica sui cookie</h2>
                        <div class="section-content">
                            <p>Il nostro sito utilizza cookie per migliorare la tua esperienza di navigazione:</p>
                            
                            <div class="cookie-types">
                                <div class="cookie-type">
                                    <h4><i class="icon-settings"></i> Cookie tecnici</h4>
                                    <p>Necessari per il funzionamento del sito. Non richiedono consenso.</p>
                                    <div class="cookie-examples">
                                        <strong>Esempi:</strong> Sessione utente, carrello, preferenze di lingua
                                    </div>
                                </div>

                                <div class="cookie-type">
                                    <h4><i class="icon-bar-chart"></i> Cookie analitici</h4>
                                    <p>Per analizzare l'uso del sito e migliorare le performance.</p>
                                    <div class="cookie-examples">
                                        <strong>Esempi:</strong> Google Analytics, Statistiche di utilizzo
                                    </div>
                                </div>

                                <div class="cookie-type">
                                    <h4><i class="icon-target"></i> Cookie di marketing</h4>
                                    <p>Per personalizzare la pubblicità e misurarne l'efficacia.</p>
                                    <div class="cookie-examples">
                                        <strong>Esempi:</strong> Pixel di Facebook, Remarketing Google
                                    </div>
                                </div>
                            </div>

                            <div class="cookie-management">
                                <h4>Gestione dei cookie</h4>
                                <p>Puoi gestire le tue preferenze sui cookie in qualsiasi momento:</p>
                                <button class="btn btn-outline cookie-settings-btn">
                                    <i class="icon-settings"></i>
                                    Gestisci preferenze cookie
                                </button>
                            </div>
                        </div>
                    </section>

                    <section id="modifiche" class="section">
                        <h2>8. Modifiche alla privacy policy</h2>
                        <div class="section-content">
                            <p>
                                Ci riserviamo il diritto di modificare questa Privacy Policy in qualsiasi momento. 
                                Le modifiche saranno pubblicate su questa pagina e, se significative, 
                                ti informeremo tramite email o notifica sul sito.
                            </p>
                            
                            <div class="update-info">
                                <h4>Cronologia aggiornamenti</h4>
                                <ul class="update-list">
                                    <li>
                                        <strong><?= date('d/m/Y') ?>:</strong> 
                                        Prima versione della Privacy Policy
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </section>

                    <section id="contatti" class="section">
                        <h2>9. Contatti</h2>
                        <div class="section-content">
                            <p>Per qualsiasi domanda relativa a questa Privacy Policy o al trattamento dei tuoi dati:</p>
                            
                            <div class="contact-grid">
                                <div class="contact-method">
                                    <div class="contact-icon">
                                        <i class="icon-mail"></i>
                                    </div>
                                    <h4>Email</h4>
                                    <p><a href="mailto:privacy@agenziaplinio.it">privacy@agenziaplinio.it</a></p>
                                </div>

                                <div class="contact-method">
                                    <div class="contact-icon">
                                        <i class="icon-phone"></i>
                                    </div>
                                    <h4>Telefono</h4>
                                    <p><a href="tel:+390391234567">+39 039 123 4567</a></p>
                                </div>

                                <div class="contact-method">
                                    <div class="contact-icon">
                                        <i class="icon-map-pin"></i>
                                    </div>
                                    <h4>Indirizzo</h4>
                                    <p>Via Plinio 72<br>20900 Monza (MB)<br>Italia</p>
                                </div>

                                <div class="contact-method">
                                    <div class="contact-icon">
                                        <i class="icon-shield"></i>
                                    </div>
                                    <h4>Autorità di controllo</h4>
                                    <p><a href="https://www.garanteprivacy.it" target="_blank">Garante Privacy</a></p>
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.privacy-page {
    font-size: 16px;
    line-height: 1.6;
}

.page-header {
    background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
    color: white;
    padding: 4rem 0;
    text-align: center;
}

.header-content h1 {
    font-size: 3rem;
    font-weight: 700;
    margin-bottom: 1rem;
}

.header-subtitle {
    font-size: 1.25rem;
    margin-bottom: 2rem;
    opacity: 0.9;
}

.header-meta {
    display: flex;
    justify-content: center;
    gap: 2rem;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
}

.privacy-content {
    padding: 4rem 0;
}

.content-wrapper {
    display: grid;
    grid-template-columns: 250px 1fr;
    gap: 3rem;
    align-items: start;
}

.toc {
    position: sticky;
    top: 2rem;
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.toc h3 {
    margin: 0 0 1.5rem 0;
    font-size: 1.1rem;
    color: var(--text-color);
}

.toc ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.toc li {
    margin-bottom: 0.75rem;
}

.toc a {
    color: var(--text-muted);
    text-decoration: none;
    font-size: 0.9rem;
    transition: color 0.3s ease;
    display: block;
    padding: 0.25rem 0;
}

.toc a:hover {
    color: var(--primary-color);
}

.privacy-main {
    max-width: none;
}

.section {
    margin-bottom: 3rem;
    padding: 2rem;
    background: white;
    border-radius: 12px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    scroll-margin-top: 2rem;
}

.section h2 {
    color: var(--primary-color);
    font-size: 1.8rem;
    font-weight: 600;
    margin: 0 0 1.5rem 0;
    padding-bottom: 1rem;
    border-bottom: 2px solid var(--light-background);
}

.section h3 {
    color: var(--text-color);
    font-size: 1.3rem;
    font-weight: 600;
    margin: 2rem 0 1rem 0;
}

.section h4 {
    color: var(--text-color);
    font-size: 1.1rem;
    font-weight: 600;
    margin: 1.5rem 0 0.75rem 0;
}

.contact-box {
    background: var(--light-background);
    padding: 1.5rem;
    border-radius: 8px;
    margin-top: 1rem;
}

.contact-box h4 {
    margin: 0 0 1rem 0;
    color: var(--primary-color);
}

.contact-box ul {
    margin: 0;
    padding-left: 1.5rem;
}

.contact-box li {
    margin-bottom: 0.5rem;
}

.purpose-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.purpose-card {
    background: var(--light-background);
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
}

.purpose-icon {
    width: 3rem;
    height: 3rem;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
    font-size: 1.25rem;
}

.purpose-card h4 {
    margin: 0 0 0.5rem 0;
    color: var(--text-color);
}

.purpose-card p {
    margin: 0 0 1rem 0;
    color: var(--text-muted);
    font-size: 0.9rem;
}

.legal-basis {
    background: var(--primary-color);
    color: white;
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
    display: inline-block;
}

.retention-table {
    overflow-x: auto;
    margin-top: 1.5rem;
}

.retention-table table {
    width: 100%;
    border-collapse: collapse;
    background: white;
    border-radius: 8px;
    overflow: hidden;
    box-shadow: 0 2px 10px rgba(0,0,0,0.05);
}

.retention-table th,
.retention-table td {
    padding: 1rem;
    text-align: left;
    border-bottom: 1px solid var(--border-color);
}

.retention-table th {
    background: var(--light-background);
    font-weight: 600;
    color: var(--text-color);
}

.retention-table td {
    color: var(--text-muted);
}

.rights-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.right-card {
    background: white;
    border: 2px solid var(--border-color);
    padding: 1.5rem;
    border-radius: 12px;
    text-align: center;
    transition: all 0.3s ease;
}

.right-card:hover {
    border-color: var(--primary-color);
    transform: translateY(-2px);
}

.right-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
    font-size: 1rem;
}

.right-card h4 {
    margin: 0 0 0.5rem 0;
    color: var(--text-color);
    font-size: 1rem;
}

.right-card p {
    margin: 0;
    color: var(--text-muted);
    font-size: 0.85rem;
}

.rights-action {
    background: var(--light-background);
    padding: 2rem;
    border-radius: 12px;
    margin-top: 2rem;
}

.rights-action h4 {
    color: var(--primary-color);
    margin: 0 0 1rem 0;
}

.cookie-types {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.cookie-type {
    background: var(--light-background);
    padding: 1.5rem;
    border-radius: 8px;
}

.cookie-type h4 {
    display: flex;
    align-items: center;
    gap: 0.75rem;
    margin: 0 0 0.75rem 0;
    color: var(--text-color);
}

.cookie-type h4 i {
    color: var(--primary-color);
}

.cookie-examples {
    margin-top: 0.75rem;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.cookie-management {
    background: white;
    border: 2px solid var(--primary-color);
    padding: 1.5rem;
    border-radius: 12px;
    margin-top: 2rem;
    text-align: center;
}

.cookie-settings-btn {
    margin-top: 1rem;
}

.update-info {
    background: var(--light-background);
    padding: 1.5rem;
    border-radius: 8px;
    margin-top: 1.5rem;
}

.update-list {
    margin: 0;
    padding-left: 1.5rem;
}

.update-list li {
    margin-bottom: 0.75rem;
}

.contact-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    margin-top: 1.5rem;
}

.contact-method {
    text-align: center;
    padding: 1.5rem;
    background: var(--light-background);
    border-radius: 12px;
}

.contact-icon {
    width: 3rem;
    height: 3rem;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1rem auto;
    font-size: 1.25rem;
}

.contact-method h4 {
    margin: 0 0 0.75rem 0;
    color: var(--text-color);
}

.contact-method p {
    margin: 0;
    color: var(--text-muted);
}

.contact-method a {
    color: var(--primary-color);
    text-decoration: none;
}

.contact-method a:hover {
    text-decoration: underline;
}

@media (max-width: 768px) {
    .content-wrapper {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .toc {
        position: static;
        order: 2;
    }
    
    .privacy-main {
        order: 1;
    }
    
    .header-meta {
        flex-direction: column;
        gap: 1rem;
    }
    
    .purpose-grid,
    .rights-grid {
        grid-template-columns: 1fr;
    }
    
    .section {
        padding: 1.5rem;
    }
    
    .header-content h1 {
        font-size: 2rem;
    }
    
    .retention-table {
        font-size: 0.85rem;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scrolling for TOC links
    const tocLinks = document.querySelectorAll('.toc a');
    tocLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Highlight current section in TOC
    const sections = document.querySelectorAll('.section');
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const id = entry.target.id;
                tocLinks.forEach(link => {
                    link.classList.remove('active');
                    if (link.getAttribute('href') === `#${id}`) {
                        link.classList.add('active');
                    }
                });
            }
        });
    }, {
        threshold: 0.3,
        rootMargin: '-100px 0px -70% 0px'
    });
    
    sections.forEach(section => {
        observer.observe(section);
    });
    
    // Cookie settings button
    const cookieBtn = document.querySelector('.cookie-settings-btn');
    if (cookieBtn) {
        cookieBtn.addEventListener('click', function() {
            alert('Funzionalità in sviluppo: qui si aprirà il pannello per gestire le preferenze sui cookie.');
        });
    }
});

// Add active state styling for TOC
document.head.insertAdjacentHTML('beforeend', `
<style>
.toc a.active {
    color: var(--primary-color);
    font-weight: 600;
    border-left: 3px solid var(--primary-color);
    padding-left: 0.75rem;
    margin-left: -0.75rem;
}
</style>
`);
</script>

<?php include 'includes/footer.php'; ?>