<?php
/**
 * Pagina Servizi - Agenzia Plinio
 * Elenco dettagliato di tutti i servizi offerti
 */

$page_title = "I nostri Servizi";
$page_description = "Scopri tutti i servizi dell'agenzia: SPID, PEC, Firma Digitale, ricariche telefoniche, spedizioni, pagamento bollettini e molto altro. Professionalità e convenienza a Milano.";

require_once 'includes/header.php';

try {
    $pdo = getDBConnection();
    
    // Recupera tutti i servizi attivi
    $stmt_services = $pdo->prepare("SELECT * FROM servizi WHERE attivo = 1 ORDER BY ordine_visualizzazione, nome");
    $stmt_services->execute();
    $services = $stmt_services->fetchAll();
    
    // Raggruppa servizi per categoria
    $categories = [
        'digitali' => [
            'title' => 'Servizi Digitali',
            'description' => 'SPID, PEC, Firma Digitale e tutti i servizi per la digitalizzazione',
            'icon' => 'digital',
            'services' => []
        ],
        'pagamenti' => [
            'title' => 'Pagamenti e Ricariche',
            'description' => 'Bollettini, F24, ricariche telefoniche e servizi di pagamento',
            'icon' => 'payment',
            'services' => []
        ],
        'spedizioni' => [
            'title' => 'Spedizioni e Logistica',
            'description' => 'Spedizioni nazionali e internazionali con tutti i corrieri',
            'icon' => 'shipping',
            'services' => []
        ],
        'pratiche' => [
            'title' => 'Pratiche e Documenti',
            'description' => 'Assistenza per pratiche automobilistiche, assicurative e burocratiche',
            'icon' => 'documents',
            'services' => []
        ]
    ];
    
    // Classifica servizi per categoria in base al nome/descrizione
    foreach ($services as $service) {
        $name_lower = strtolower($service['nome']);
        
        if (strpos($name_lower, 'spid') !== false || 
            strpos($name_lower, 'pec') !== false || 
            strpos($name_lower, 'firma') !== false || 
            strpos($name_lower, 'cns') !== false) {
            $categories['digitali']['services'][] = $service;
        } elseif (strpos($name_lower, 'ricariche') !== false || 
                  strpos($name_lower, 'bolletti') !== false || 
                  strpos($name_lower, 'f24') !== false || 
                  strpos($name_lower, 'pagamento') !== false ||
                  strpos($name_lower, 'bollo') !== false) {
            $categories['pagamenti']['services'][] = $service;
        } elseif (strpos($name_lower, 'spedizione') !== false || 
                  strpos($name_lower, 'corriere') !== false) {
            $categories['spedizioni']['services'][] = $service;
        } else {
            $categories['pratiche']['services'][] = $service;
        }
    }
    
} catch (Exception $e) {
    error_log("Errore pagina servizi: " . $e->getMessage());
    $categories = [];
}

// Definizione icone per servizi
$service_icons = [
    'spid-icon' => '<path d="M22,18V22H18V19H15V16H12L9.74,13.74C9.19,13.91 8.61,14 8,14A6,6 0 0,1 2,8A6,6 0 0,1 8,2A6,6 0 0,1 14,8C14,8.61 13.91,9.19 13.74,9.74L22,18M7,5A1,1 0 0,0 6,6A1,1 0 0,0 7,7A1,1 0 0,0 8,6A1,1 0 0,0 7,5Z"/>',
    'pec-icon' => '<path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>',
    'signature-icon' => '<path d="M14,17H22V19H14V17M13,9H22V7H13V9M22,13V11H13V13H22M4,7V9H11V11H2V7H4M11,13V15H2V13H11M11,17V19H2V17H11Z"/>',
    'card-icon' => '<path d="M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4M20,11H4V8H20V11Z"/>',
    'phone-icon' => '<path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>',
    'bill-icon' => '<path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>',
    'shipping-icon' => '<path d="M3,4A2,2 0 0,0 1,6V17H3A3,3 0 0,0 6,20A3,3 0 0,0 9,17H15A3,3 0 0,0 18,20A3,3 0 0,0 21,17H23V12L20,8H17V4M10,6L14,10L10,14V11H4V9H10M17,9.5H19.5L21.47,12H17M6,15.5A1.5,1.5 0 0,1 7.5,17A1.5,1.5 0 0,1 6,18.5A1.5,1.5 0 0,1 4.5,17A1.5,1.5 0 0,1 6,15.5M18,15.5A1.5,1.5 0 0,1 19.5,17A1.5,1.5 0 0,1 18,18.5A1.5,1.5 0 0,1 16.5,17A1.5,1.5 0 0,1 18,15.5Z"/>',
    'car-icon' => '<path d="M5,11L6.5,6.5H17.5L19,11M17.5,16A1.5,1.5 0 0,1 16,14.5A1.5,1.5 0 0,1 17.5,13A1.5,1.5 0 0,1 19,14.5A1.5,1.5 0 0,1 17.5,16M6.5,16A1.5,1.5 0 0,1 5,14.5A1.5,1.5 0 0,1 6.5,13A1.5,1.5 0 0,1 8,14.5A1.5,1.5 0 0,1 6.5,16M18.92,6C18.72,5.42 18.16,5 17.5,5H6.5C5.84,5 5.28,5.42 5.08,6L3,12V20A1,1 0 0,0 4,21H5A1,1 0 0,0 6,20V19H18V20A1,1 0 0,0 19,21H20A1,1 0 0,0 21,20V12L18.92,6Z"/>',
    'default' => '<path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2Z"/>'
];

$category_icons = [
    'digital' => '<path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2M12,4A8,8 0 0,0 4,12A8,8 0 0,0 12,20A8,8 0 0,0 20,12A8,8 0 0,0 12,4M12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8Z"/>',
    'payment' => '<path d="M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4M20,18H4V12H20V18M20,8H4V6H20V8Z"/>',
    'shipping' => '<path d="M3,4A2,2 0 0,0 1,6V17H3A3,3 0 0,0 6,20A3,3 0 0,0 9,17H15A3,3 0 0,0 18,20A3,3 0 0,0 21,17H23V12L20,8H17V4M10,6L14,10L10,14V11H4V9H10M17,9.5H19.5L21.47,12H17M6,15.5A1.5,1.5 0 0,1 7.5,17A1.5,1.5 0 0,1 6,18.5A1.5,1.5 0 0,1 4.5,17A1.5,1.5 0 0,1 6,15.5M18,15.5A1.5,1.5 0 0,1 19.5,17A1.5,1.5 0 0,1 18,18.5A1.5,1.5 0 0,1 16.5,17A1.5,1.5 0 0,1 18,15.5Z"/>',
    'documents' => '<path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>'
];
?>

<!-- Page Header -->
<section class="page-header">
    <div class="container">
        <div class="page-header-content">
            <h1 class="page-title">I nostri Servizi</h1>
            <p class="page-subtitle">
                Soluzioni complete per privati e aziende. Dalla digitalizzazione alla vita quotidiana, 
                siamo il tuo partner di fiducia per ogni esigenza.
            </p>
            
            <div class="page-stats">
                <div class="stat-item">
                    <span class="stat-number"><?= count($services) ?>+</span>
                    <span class="stat-label">Servizi Disponibili</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">15</span>
                    <span class="stat-label">Anni di Esperienza</span>
                </div>
                <div class="stat-item">
                    <span class="stat-number">5000+</span>
                    <span class="stat-label">Clienti Serviti</span>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Services Navigation -->
<section class="services-nav">
    <div class="container">
        <nav class="services-menu">
            <?php foreach ($categories as $key => $category): ?>
                <?php if (!empty($category['services'])): ?>
                <a href="#categoria-<?= $key ?>" class="service-nav-link" data-category="<?= $key ?>">
                    <svg class="nav-icon" viewBox="0 0 24 24">
                        <?= $category_icons[$category['icon']] ?>
                    </svg>
                    <span><?= h($category['title']) ?></span>
                    <span class="service-count"><?= count($category['services']) ?></span>
                </a>
                <?php endif; ?>
            <?php endforeach; ?>
        </nav>
    </div>
</section>

<!-- Services Content -->
<?php foreach ($categories as $key => $category): ?>
    <?php if (!empty($category['services'])): ?>
    <section class="service-category" id="categoria-<?= $key ?>">
        <div class="container">
            <div class="category-header" data-aos="fade-up">
                <div class="category-icon">
                    <svg viewBox="0 0 24 24">
                        <?= $category_icons[$category['icon']] ?>
                    </svg>
                </div>
                <div class="category-info">
                    <h2 class="category-title"><?= h($category['title']) ?></h2>
                    <p class="category-description"><?= h($category['description']) ?></p>
                </div>
            </div>
            
            <div class="services-grid">
                <?php foreach ($category['services'] as $index => $service): ?>
                <div class="service-detail-card" id="<?= h($service['slug']) ?>" data-aos="fade-up" data-aos-delay="<?= $index * 100 ?>">
                    <div class="service-header">
                        <div class="service-icon">
                            <svg viewBox="0 0 24 24">
                                <?= $service_icons[$service['icona']] ?? $service_icons['default'] ?>
                            </svg>
                        </div>
                        <div class="service-title-area">
                            <h3 class="service-title"><?= h($service['nome']) ?></h3>
                            <p class="service-brief"><?= h($service['descrizione_breve']) ?></p>
                        </div>
                    </div>
                    
                    <div class="service-content">
                        <div class="service-description">
                            <?= nl2br(h($service['descrizione_completa'])) ?>
                        </div>
                        
                        <div class="service-features">
                            <?php
                            $features = [];
                            $service_name = strtolower($service['nome']);
                            
                            if (strpos($service_name, 'spid') !== false) {
                                $features = [
                                    'Identità digitale unica e sicura',
                                    'Accesso a tutti i servizi PA',
                                    'Attivazione in 24-48 ore',
                                    'Supporto completo all\'attivazione'
                                ];
                            } elseif (strpos($service_name, 'pec') !== false) {
                                $features = [
                                    'Valore legale garantito',
                                    '1GB di spazio incluso',
                                    'Certificazione delivery e accettazione',
                                    'Supporto configurazione client email'
                                ];
                            } elseif (strpos($service_name, 'firma') !== false) {
                                $features = [
                                    'Certificato qualificato',
                                    'Validità 3 anni',
                                    'Kit USB incluso',
                                    'Software di firma gratuito'
                                ];
                            } elseif (strpos($service_name, 'ricariche') !== false) {
                                $features = [
                                    'Tutti gli operatori supportati',
                                    'Accredito immediato',
                                    'Nessuna commissione aggiuntiva',
                                    'Scontrino fiscale rilasciato'
                                ];
                            } elseif (strpos($service_name, 'bolletti') !== false) {
                                $features = [
                                    'Pagamento immediato',
                                    'Ricevuta di pagamento',
                                    'Tutti i bollettini accettati',
                                    'Commissioni competitive'
                                ];
                            } else {
                                $features = [
                                    'Servizio professionale',
                                    'Assistenza personalizzata',
                                    'Tempi di evasione rapidi',
                                    'Prezzi competitivi'
                                ];
                            }
                            ?>
                            
                            <ul class="feature-list">
                                <?php foreach ($features as $feature): ?>
                                <li class="feature-item">
                                    <svg class="feature-check" viewBox="0 0 24 24">
                                        <path d="M21,7L9,19L3.5,13.5L4.91,12.09L9,16.17L19.59,5.59L21,7Z"/>
                                    </svg>
                                    <?= h($feature) ?>
                                </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                        
                        <div class="service-meta">
                            <div class="service-pricing">
                                <?php if ($service['prezzo_da'] > 0): ?>
                                    <span class="price-label">A partire da</span>
                                    <span class="price">€<?= number_format($service['prezzo_da'], 2, ',', '.') ?></span>
                                <?php else: ?>
                                    <span class="price-label">Prezzo</span>
                                    <span class="price">Su richiesta</span>
                                <?php endif; ?>
                            </div>
                            <div class="service-timing">
                                <svg class="timing-icon" viewBox="0 0 24 24">
                                    <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.7L16.2,16.2Z"/>
                                </svg>
                                <span class="timing-text"><?= h($service['tempo_evasione']) ?></span>
                            </div>
                        </div>
                        
                        <div class="service-actions">
                            <a href="/contatti.php?servizio=<?= urlencode($service['slug']) ?>" class="btn btn-primary">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                                </svg>
                                Richiedi informazioni
                            </a>
                            <a href="tel:+390212345678" class="btn btn-outline">
                                <svg class="icon" viewBox="0 0 24 24">
                                    <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                                </svg>
                                Chiamaci ora
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>
    <?php endif; ?>
<?php endforeach; ?>

<!-- FAQ Section -->
<section class="services-faq">
    <div class="container">
        <div class="section-header" data-aos="fade-up">
            <h2 class="section-title">Domande Frequenti</h2>
            <p class="section-subtitle">
                Trova le risposte alle domande più comuni sui nostri servizi
            </p>
        </div>
        
        <div class="faq-container">
            <div class="faq-item" data-aos="fade-up">
                <button class="faq-question" aria-expanded="false">
                    <span>Quanto tempo serve per attivare SPID?</span>
                    <svg class="faq-icon" viewBox="0 0 24 24">
                        <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
                    </svg>
                </button>
                <div class="faq-answer">
                    <p>L'attivazione di SPID richiede solitamente 24-48 ore lavorative. Ti seguiamo in tutto il processo e ti notifichiamo non appena l'identità digitale è pronta per l'uso.</p>
                </div>
            </div>
            
            <div class="faq-item" data-aos="fade-up">
                <button class="faq-question" aria-expanded="false">
                    <span>La PEC ha valore legale?</span>
                    <svg class="faq-icon" viewBox="0 0 24 24">
                        <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
                    </svg>
                </button>
                <div class="faq-answer">
                    <p>Sì, la PEC (Posta Elettronica Certificata) ha lo stesso valore legale della raccomandata con ricevuta di ritorno ed è riconosciuta dalla legge italiana per tutte le comunicazioni ufficiali.</p>
                </div>
            </div>
            
            <div class="faq-item" data-aos="fade-up">
                <button class="faq-question" aria-expanded="false">
                    <span>Posso pagare bollettini online?</span>
                    <svg class="faq-icon" viewBox="0 0 24 24">
                        <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
                    </svg>
                </button>
                <div class="faq-answer">
                    <p>Puoi portare i bollettini direttamente in agenzia o inviarci una foto chiara via WhatsApp. Processieremo il pagamento entro 24 ore e ti invieremo la ricevuta.</p>
                </div>
            </div>
            
            <div class="faq-item" data-aos="fade-up">
                <button class="faq-question" aria-expanded="false">
                    <span>Che documenti servono per i servizi digitali?</span>
                    <svg class="faq-icon" viewBox="0 0 24 24">
                        <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
                    </svg>
                </button>
                <div class="faq-answer">
                    <p>Per SPID, PEC e Firma Digitale servono: documento di identità valido, tessera sanitaria/codice fiscale, numero di cellulare e indirizzo email. Ti aiutiamo con tutta la procedura.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Contact CTA -->
<section class="contact-cta">
    <div class="container">
        <div class="cta-content" data-aos="fade-up">
            <h2>Non trovi il servizio che cerchi?</h2>
            <p>Contattaci per una consulenza personalizzata. Il nostro team è sempre pronto ad aiutarti con soluzioni su misura per le tue esigenze.</p>
            
            <div class="cta-actions">
                <a href="/contatti.php" class="btn btn-primary btn-large">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                    </svg>
                    Contattaci
                </a>
                <a href="https://wa.me/393123456789" class="btn btn-outline btn-large" target="_blank">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.488"/>
                    </svg>
                    WhatsApp
                </a>
            </div>
        </div>
    </div>
</section>

<?php
$additional_css = ['/assets/css/services.css'];
$additional_js = ['/assets/js/services.js'];

$inline_js = '
// Smooth scroll per navigation
document.querySelectorAll(".service-nav-link").forEach(link => {
    link.addEventListener("click", (e) => {
        e.preventDefault();
        const targetId = link.getAttribute("href");
        const targetElement = document.querySelector(targetId);
        
        if (targetElement) {
            targetElement.scrollIntoView({
                behavior: "smooth",
                block: "start"
            });
            
            // Update active nav
            document.querySelectorAll(".service-nav-link").forEach(l => l.classList.remove("active"));
            link.classList.add("active");
        }
    });
});

// FAQ accordion
document.querySelectorAll(".faq-question").forEach(button => {
    button.addEventListener("click", () => {
        const faqItem = button.closest(".faq-item");
        const answer = faqItem.querySelector(".faq-answer");
        const isOpen = button.getAttribute("aria-expanded") === "true";
        
        // Close all other FAQ items
        document.querySelectorAll(".faq-item").forEach(item => {
            if (item !== faqItem) {
                const otherButton = item.querySelector(".faq-question");
                const otherAnswer = item.querySelector(".faq-answer");
                otherButton.setAttribute("aria-expanded", "false");
                otherAnswer.style.maxHeight = "0";
                item.classList.remove("active");
            }
        });
        
        // Toggle current FAQ item
        if (isOpen) {
            button.setAttribute("aria-expanded", "false");
            answer.style.maxHeight = "0";
            faqItem.classList.remove("active");
        } else {
            button.setAttribute("aria-expanded", "true");
            answer.style.maxHeight = answer.scrollHeight + "px";
            faqItem.classList.add("active");
        }
    });
});

// Active navigation on scroll
const observerOptions = {
    threshold: 0.1,
    rootMargin: "-20% 0px -70% 0px"
};

const sectionObserver = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            const sectionId = "#" + entry.target.id;
            const navLink = document.querySelector(`[href="${sectionId}"]`);
            
            if (navLink) {
                document.querySelectorAll(".service-nav-link").forEach(l => l.classList.remove("active"));
                navLink.classList.add("active");
            }
        }
    });
}, observerOptions);

document.querySelectorAll(".service-category").forEach(section => {
    sectionObserver.observe(section);
});
';

require_once 'includes/footer.php';
?>