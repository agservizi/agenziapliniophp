<?php
/**
 * Homepage - Agenzia Plinio
 * Sito web aziendale con hero section, servizi in evidenza e call to action
 */

$page_title = "Agenzia Multiservizi Milano";
$page_description = "Agenzia multiservizi a Milano specializzata in SPID, PEC, ricariche telefoniche, spedizioni e molto altro. Via Plinio 72 - Servizi professionali e affidabili.";

require_once 'includes/header.php';

try {
    $pdo = getDBConnection();
    
    // Recupera servizi in evidenza
    $stmt_services = $pdo->prepare("SELECT * FROM servizi WHERE attivo = 1 AND in_evidenza = 1 ORDER BY ordine_visualizzazione LIMIT 6");
    $stmt_services->execute();
    $featured_services = $stmt_services->fetchAll();
    
    // Statistiche per hero section
    $stmt_stats = $pdo->prepare("SELECT COUNT(*) as total_users FROM utenti WHERE ruolo = 'cliente'");
    $stmt_stats->execute();
    $stats = $stmt_stats->fetch();
    
} catch (Exception $e) {
    error_log("Errore homepage: " . $e->getMessage());
    $featured_services = [];
    $stats = ['total_users' => 0];
}
?>

<!-- Hero Section -->
<section class="hero-section" id="hero">
    <div class="hero-background">
        <div class="hero-video-overlay"></div>
        <div class="hero-particles" id="hero-particles"></div>
    </div>
    
    <div class="container hero-container">
        <div class="hero-content">
            <div class="hero-text">
                <h1 class="hero-title">
                    <span class="hero-title-main">La tua agenzia</span>
                    <span class="hero-title-highlight">multiservizi</span>
                    <span class="hero-title-sub">di fiducia a Milano</span>
                </h1>
                
                <p class="hero-description">
                    Dalla digitalizzazione alla vita quotidiana: SPID, PEC, ricariche telefoniche, spedizioni e molto altro. 
                    <strong>Oltre 5000 clienti soddisfatti</strong> si affidano ai nostri servizi professionali.
                </p>
                
                <div class="hero-features">
                    <div class="feature-item">
                        <svg class="feature-icon" viewBox="0 0 24 24">
                            <path d="M9,12L11,14L15,10M21,5V19A2,2 0 0,1 19,21H5A2,2 0 0,1 3,19V5A2,2 0 0,1 5,3H19A2,2 0 0,1 21,5Z"/>
                        </svg>
                        <span>Servizi certificati</span>
                    </div>
                    <div class="feature-item">
                        <svg class="feature-icon" viewBox="0 0 24 24">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M12,7C13.4,7 14.8,8.6 14.8,10V11.5C15.4,11.4 16,11.9 16,12.5V16.5C16,17.1 15.6,17.5 15,17.5H9C8.4,17.5 8,17.1 8,16.5V12.5C8,11.9 8.4,11.5 9,11.5V10C9,8.6 10.6,7 12,7M12,8.2C11.2,8.2 10.2,9.2 10.2,10V11.5H13.8V10C13.8,9.2 12.8,8.2 12,8.2Z"/>
                        </svg>
                        <span>Sicurezza garantita</span>
                    </div>
                    <div class="feature-item">
                        <svg class="feature-icon" viewBox="0 0 24 24">
                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.7L16.2,16.2Z"/>
                        </svg>
                        <span>Servizio rapido</span>
                    </div>
                </div>
                
                <div class="hero-actions">
                    <a href="/servizi.php" class="btn btn-primary btn-large">
                        <span>Scopri i nostri servizi</span>
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"/>
                        </svg>
                    </a>
                    <a href="/contatti.php" class="btn btn-outline btn-large">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                        </svg>
                        <span>Contattaci</span>
                    </a>
                </div>
            </div>
            
            <div class="hero-visual">
                <div class="hero-image-container">
                    <div class="hero-floating-card card-1">
                        <svg class="card-icon" viewBox="0 0 24 24">
                            <path d="M22,18V22H18V19H15V16H12L9.74,13.74C9.19,13.91 8.61,14 8,14A6,6 0 0,1 2,8A6,6 0 0,1 8,2A6,6 0 0,1 14,8C14,8.61 13.91,9.19 13.74,9.74L22,18M7,5A1,1 0 0,0 6,6A1,1 0 0,0 7,7A1,1 0 0,0 8,6A1,1 0 0,0 7,5Z"/>
                        </svg>
                        <span>SPID</span>
                    </div>
                    
                    <div class="hero-floating-card card-2">
                        <svg class="card-icon" viewBox="0 0 24 24">
                            <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                        </svg>
                        <span>PEC</span>
                    </div>
                    
                    <div class="hero-floating-card card-3">
                        <svg class="card-icon" viewBox="0 0 24 24">
                            <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                        </svg>
                        <span>Ricariche</span>
                    </div>
                    
                    <div class="hero-main-graphic">
                        <svg viewBox="0 0 400 300" class="hero-svg">
                            <!-- Sfondo -->
                            <defs>
                                <linearGradient id="heroGradient" x1="0%" y1="0%" x2="100%" y2="100%">
                                    <stop offset="0%" style="stop-color:#ffbf00;stop-opacity:0.1"/>
                                    <stop offset="100%" style="stop-color:#ff8800;stop-opacity:0.2"/>
                                </linearGradient>
                            </defs>
                            
                            <!-- Elementi grafici stilizzati -->
                            <circle cx="200" cy="150" r="100" fill="url(#heroGradient)" stroke="var(--color-primary)" stroke-width="2" opacity="0.8"/>
                            <rect x="150" y="100" width="100" height="100" rx="10" fill="var(--color-primary)" opacity="0.9"/>
                            <text x="200" y="160" text-anchor="middle" font-size="18" font-weight="bold" fill="var(--color-background)">AG</text>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Stats Counter -->
        <div class="hero-stats">
            <div class="stat-item">
                <span class="stat-number" data-count="<?= $stats['total_users'] + 5000 ?>">0</span>
                <span class="stat-label">Clienti Soddisfatti</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="15">0</span>
                <span class="stat-label">Anni di Esperienza</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="50">0</span>
                <span class="stat-label">Servizi Disponibili</span>
            </div>
            <div class="stat-item">
                <span class="stat-number" data-count="98">0</span>
                <span class="stat-label">% Soddisfazione</span>
            </div>
        </div>
    </div>
    
    <!-- Scroll indicator -->
    <div class="scroll-indicator">
        <div class="scroll-icon">
            <svg viewBox="0 0 24 24">
                <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
            </svg>
        </div>
    </div>
</section>

<!-- Services Section -->
<section class="services-section" id="services">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">I nostri servizi in evidenza</h2>
            <p class="section-subtitle">
                Soluzioni digitali e tradizionali per semplificare la tua vita quotidiana
            </p>
        </div>
        
        <div class="services-grid">
            <?php if (!empty($featured_services)): ?>
                <?php foreach ($featured_services as $service): ?>
                <div class="service-card" data-aos="fade-up">
                    <div class="service-icon">
                        <svg class="icon" viewBox="0 0 24 24">
                            <?php
                            // Icone SVG per ogni tipo di servizio
                            $icons = [
                                'spid-icon' => '<path d="M22,18V22H18V19H15V16H12L9.74,13.74C9.19,13.91 8.61,14 8,14A6,6 0 0,1 2,8A6,6 0 0,1 8,2A6,6 0 0,1 14,8C14,8.61 13.91,9.19 13.74,9.74L22,18M7,5A1,1 0 0,0 6,6A1,1 0 0,0 7,7A1,1 0 0,0 8,6A1,1 0 0,0 7,5Z"/>',
                                'pec-icon' => '<path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>',
                                'signature-icon' => '<path d="M14,17H22V19H14V17M13,9H22V7H13V9M22,13V11H13V13H22M4,7V9H11V11H2V7H4M11,13V15H2V13H11M11,17V19H2V17H11Z"/>',
                                'phone-icon' => '<path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>',
                                'bill-icon' => '<path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>',
                                'default' => '<path d="M12,2A10,10 0 0,1 22,12A10,10 0 0,1 12,22A10,10 0 0,1 2,12A10,10 0 0,1 12,2Z"/>'
                            ];
                            echo $icons[$service['icona']] ?? $icons['default'];
                            ?>
                        </svg>
                    </div>
                    
                    <div class="service-content">
                        <h3 class="service-title"><?= h($service['nome']) ?></h3>
                        <p class="service-description"><?= h($service['descrizione_breve']) ?></p>
                        
                        <div class="service-meta">
                            <?php if ($service['prezzo_da'] > 0): ?>
                                <span class="service-price">da €<?= number_format($service['prezzo_da'], 2, ',', '.') ?></span>
                            <?php endif; ?>
                            <span class="service-time"><?= h($service['tempo_evasione']) ?></span>
                        </div>
                    </div>
                    
                    <div class="service-actions">
                        <a href="/servizi.php#<?= h($service['slug']) ?>" class="btn btn-outline btn-small">
                            Scopri di più
                        </a>
                    </div>
                </div>
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Fallback se non ci sono servizi -->
                <div class="service-card" data-aos="fade-up">
                    <div class="service-icon">
                        <svg class="icon" viewBox="0 0 24 24">
                            <path d="M22,18V22H18V19H15V16H12L9.74,13.74C9.19,13.91 8.61,14 8,14A6,6 0 0,1 2,8A6,6 0 0,1 8,2A6,6 0 0,1 14,8C14,8.61 13.91,9.19 13.74,9.74L22,18M7,5A1,1 0 0,0 6,6A1,1 0 0,0 7,7A1,1 0 0,0 8,6A1,1 0 0,0 7,5Z"/>
                        </svg>
                    </div>
                    <div class="service-content">
                        <h3 class="service-title">SPID - Identità Digitale</h3>
                        <p class="service-description">La tua identità digitale per accedere ai servizi della PA</p>
                        <div class="service-meta">
                            <span class="service-price">da €15,00</span>
                            <span class="service-time">24-48 ore</span>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        
        <div class="section-actions">
            <a href="/servizi.php" class="btn btn-primary btn-large">
                <span>Vedi tutti i servizi</span>
                <svg class="icon" viewBox="0 0 24 24">
                    <path d="M4,11V13H16L10.5,18.5L11.92,19.92L19.84,12L11.92,4.08L10.5,5.5L16,11H4Z"/>
                </svg>
            </a>
        </div>
    </div>
</section>

<!-- Why Choose Us Section -->
<section class="why-us-section" id="why-us">
    <div class="container">
        <div class="section-header">
            <h2 class="section-title">Perché scegliere la nostra agenzia</h2>
            <p class="section-subtitle">
                Esperienza, professionalità e tecnologia al tuo servizio
            </p>
        </div>
        
        <div class="features-grid">
            <div class="feature-card" data-aos="fade-right">
                <div class="feature-number">01</div>
                <div class="feature-content">
                    <h3>Esperienza consolidata</h3>
                    <p>Oltre 15 anni di esperienza nel settore dei servizi digitali e tradizionali. Conosciamo le tue esigenze.</p>
                </div>
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12,2A3,3 0 0,1 15,5V11A3,3 0 0,1 12,14A3,3 0 0,1 9,11V5A3,3 0 0,1 12,2M19,11C19,14.53 16.39,17.44 13,17.93V21H11V17.93C7.61,17.44 5,14.53 5,11H7A5,5 0 0,0 12,16A5,5 0 0,0 17,11H19Z"/>
                    </svg>
                </div>
            </div>
            
            <div class="feature-card" data-aos="fade-up">
                <div class="feature-number">02</div>
                <div class="feature-content">
                    <h3>Certificazioni ufficiali</h3>
                    <p>Siamo un'agenzia autorizzata per SPID, PEC, Firma Digitale e tutti i servizi digitali della PA.</p>
                </div>
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M23,12L20.56,9.22L20.9,5.54L17.29,4.72L15.4,1.54L12,3L8.6,1.54L6.71,4.72L3.1,5.53L3.44,9.21L1,12L3.44,14.78L3.1,18.47L6.71,19.29L8.6,22.47L12,21L15.4,22.46L17.29,19.28L20.9,18.46L20.56,14.78L23,12M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                    </svg>
                </div>
            </div>
            
            <div class="feature-card" data-aos="fade-left">
                <div class="feature-number">03</div>
                <div class="feature-content">
                    <h3>Assistenza personalizzata</h3>
                    <p>Ti seguiamo passo dopo passo in ogni pratica. Nessun servizio automatico, solo supporto umano qualificato.</p>
                </div>
                <div class="feature-icon">
                    <svg viewBox="0 0 24 24">
                        <path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/>
                    </svg>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
    <div class="container">
        <div class="cta-content">
            <div class="cta-text">
                <h2>Hai bisogno di aiuto con i tuoi servizi digitali?</h2>
                <p>Il nostro team è pronto ad assisterti con professionalità e competenza. Contattaci senza impegno per una consulenza gratuita.</p>
            </div>
            
            <div class="cta-actions">
                <a href="/contatti.php" class="btn btn-primary btn-large">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                    </svg>
                    <span>Contattaci ora</span>
                </a>
                <a href="tel:+390212345678" class="btn btn-outline btn-large">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                    </svg>
                    <span>02 1234 5678</span>
                </a>
            </div>
        </div>
    </div>
</section>

<?php
$additional_js = [
    '/assets/js/animations.js',
    '/assets/js/counters.js',
    '/assets/js/particles.js'
];

$inline_js = '
// Inizializzazione homepage
document.addEventListener("DOMContentLoaded", function() {
    // Inizializza animazioni parallax
    initParallax();
    
    // Inizializza contatori
    initCounters();
    
    // Inizializza particelle hero
    initHeroParticles();
    
    // Smooth scroll per scroll indicator
    const scrollIndicator = document.querySelector(".scroll-indicator");
    if (scrollIndicator) {
        scrollIndicator.addEventListener("click", () => {
            document.querySelector("#services").scrollIntoView({ 
                behavior: "smooth" 
            });
        });
    }
});
';

require_once 'includes/footer.php';
?>