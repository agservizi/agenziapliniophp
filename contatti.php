<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$page_title = 'Contatti - AG SERVIZI VIA PLINIO 72';
$page_description = 'Contattaci per qualsiasi informazione sui nostri servizi. Siamo qui per aiutarti.';
$current_page = 'contatti';

// Handle form submission
$success_message = '';
$error_message = '';
$form_data = [];

if ($_POST) {
    $csrf_valid = verifyCSRFToken($_POST['csrf_token'] ?? '');
    
    if (!$csrf_valid) {
        $error_message = 'Token di sicurezza non valido. Ricarica la pagina.';
    } else {
        $form_data = [
            'nome' => sanitizeInput($_POST['nome'] ?? ''),
            'email' => sanitizeInput($_POST['email'] ?? ''),
            'telefono' => sanitizeInput($_POST['telefono'] ?? ''),
            'oggetto' => sanitizeInput($_POST['oggetto'] ?? ''),
            'messaggio' => sanitizeInput($_POST['messaggio'] ?? ''),
            'servizio' => sanitizeInput($_POST['servizio'] ?? ''),
            'privacy_accepted' => isset($_POST['privacy_accepted'])
        ];
        
        // Validation
        $errors = [];
        
        if (empty($form_data['nome'])) {
            $errors[] = 'Il nome è obbligatorio';
        }
        
        if (empty($form_data['email'])) {
            $errors[] = 'L\'email è obbligatoria';
        } elseif (!filter_var($form_data['email'], FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Formato email non valido';
        }
        
        if (empty($form_data['oggetto'])) {
            $errors[] = 'L\'oggetto è obbligatorio';
        }
        
        if (empty($form_data['messaggio'])) {
            $errors[] = 'Il messaggio è obbligatorio';
        }
        
        if (!$form_data['privacy_accepted']) {
            $errors[] = 'Devi accettare la privacy policy';
        }
        
        if (empty($errors)) {
            try {
                $pdo = getDBConnection();
                
                // Insert contact form submission
                $stmt = $pdo->prepare("
                    INSERT INTO contatti_richieste 
                    (nome, email, telefono, oggetto, messaggio, servizio_interesse, ip_address, user_agent) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?)
                ");
                
                $stmt->execute([
                    $form_data['nome'],
                    $form_data['email'], 
                    $form_data['telefono'],
                    $form_data['oggetto'],
                    $form_data['messaggio'],
                    $form_data['servizio'],
                    $_SERVER['REMOTE_ADDR'],
                    $_SERVER['HTTP_USER_AGENT']
                ]);
                
                // Here you would typically send an email notification
                
                $success_message = 'Messaggio inviato con successo! Ti risponderemo entro 24 ore.';
                $form_data = []; // Clear form
                
            } catch (PDOException $e) {
                error_log("Contact form error: " . $e->getMessage());
                $error_message = 'Errore nell\'invio del messaggio. Riprova più tardi.';
            }
        } else {
            $error_message = implode('<br>', $errors);
        }
    }
}

include 'includes/header.php';
?>

<main class="contact-page">
    <!-- Page Hero -->
    <section class="page-hero contact-hero">
        <div class="container">
            <div class="hero-content">
                <h1>
                    <span class="hero-title">Contattaci</span>
                    <span class="hero-subtitle">Siamo qui per aiutarti</span>
                </h1>
                <p class="hero-description">
                    Hai domande sui nostri servizi? Vuoi un preventivo personalizzato? 
                    Il nostro team è pronto a rispondere a tutte le tue esigenze.
                </p>
            </div>
        </div>
        <div class="hero-background">
            <div class="hero-shape shape-1"></div>
            <div class="hero-shape shape-2"></div>
        </div>
    </section>

    <!-- Contact Info -->
    <section class="contact-info">
        <div class="container">
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-icon">
                        <i class="icon-map-pin"></i>
                    </div>
                    <div class="info-content">
                        <h3>Indirizzo</h3>
                        <p>Via Plinio 72<br>20900 Monza (MB)<br>Italia</p>
                        <a href="https://maps.google.com/?q=Via+Plinio+72,+Monza" target="_blank" class="info-link">
                            Visualizza su Maps <i class="icon-external-link"></i>
                        </a>
                    </div>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="icon-phone"></i>
                    </div>
                    <div class="info-content">
                        <h3>Telefono</h3>
                        <p><a href="tel:+390391234567">+39 039 123 4567</a></p>
                        <p><a href="tel:+393351234567">+39 335 123 4567</a> <small>(Mobile)</small></p>
                        <small class="info-hours">Lun-Ven: 9:00-18:00</small>
                    </div>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="icon-mail"></i>
                    </div>
                    <div class="info-content">
                        <h3>Email</h3>
                        <p><a href="mailto:info@agenziaplinio.it">info@agenziaplinio.it</a></p>
                        <p><a href="mailto:preventivi@agenziaplinio.it">preventivi@agenziaplinio.it</a></p>
                        <small class="info-hours">Risposta entro 24h</small>
                    </div>
                </div>
                
                <div class="info-card">
                    <div class="info-icon">
                        <i class="icon-clock"></i>
                    </div>
                    <div class="info-content">
                        <h3>Orari di Apertura</h3>
                        <p>Lunedì - Venerdì: 9:00 - 18:00</p>
                        <p>Sabato: 9:00 - 13:00</p>
                        <p>Domenica: Chiuso</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Form & Map -->
    <section class="contact-main">
        <div class="container">
            <div class="contact-grid">
                <!-- Contact Form -->
                <div class="contact-form-section">
                    <div class="form-header">
                        <h2>Invia un Messaggio</h2>
                        <p>Compila il modulo e ti ricontatteremo il prima possibile.</p>
                    </div>
                    
                    <?php if ($success_message): ?>
                        <div class="alert alert-success">
                            <i class="icon-check-circle"></i>
                            <?= htmlspecialchars($success_message) ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if ($error_message): ?>
                        <div class="alert alert-error">
                            <i class="icon-alert-circle"></i>
                            <?= $error_message ?>
                        </div>
                    <?php endif; ?>
                    
                    <form method="POST" class="contact-form" id="contactForm">
                        <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="nome">Nome *</label>
                                <input type="text" 
                                       id="nome" 
                                       name="nome" 
                                       value="<?= htmlspecialchars($form_data['nome'] ?? '') ?>"
                                       required
                                       placeholder="Il tuo nome">
                            </div>
                            
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" 
                                       id="email" 
                                       name="email" 
                                       value="<?= htmlspecialchars($form_data['email'] ?? '') ?>"
                                       required
                                       placeholder="la.tua@email.com">
                            </div>
                        </div>
                        
                        <div class="form-row">
                            <div class="form-group">
                                <label for="telefono">Telefono</label>
                                <input type="tel" 
                                       id="telefono" 
                                       name="telefono" 
                                       value="<?= htmlspecialchars($form_data['telefono'] ?? '') ?>"
                                       placeholder="+39 123 456 7890">
                            </div>
                            
                            <div class="form-group">
                                <label for="servizio">Servizio di Interesse</label>
                                <select id="servizio" name="servizio">
                                    <option value="">Seleziona un servizio</option>
                                    <option value="consulenza-aziendale" <?= ($form_data['servizio'] ?? '') === 'consulenza-aziendale' ? 'selected' : '' ?>>
                                        Consulenza Aziendale
                                    </option>
                                    <option value="sviluppo-web" <?= ($form_data['servizio'] ?? '') === 'sviluppo-web' ? 'selected' : '' ?>>
                                        Sviluppo Web
                                    </option>
                                    <option value="marketing-digitale" <?= ($form_data['servizio'] ?? '') === 'marketing-digitale' ? 'selected' : '' ?>>
                                        Marketing Digitale
                                    </option>
                                    <option value="e-commerce" <?= ($form_data['servizio'] ?? '') === 'e-commerce' ? 'selected' : '' ?>>
                                        E-commerce
                                    </option>
                                    <option value="grafica-design" <?= ($form_data['servizio'] ?? '') === 'grafica-design' ? 'selected' : '' ?>>
                                        Grafica e Design
                                    </option>
                                    <option value="altro" <?= ($form_data['servizio'] ?? '') === 'altro' ? 'selected' : '' ?>>
                                        Altro
                                    </option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label for="oggetto">Oggetto *</label>
                            <input type="text" 
                                   id="oggetto" 
                                   name="oggetto" 
                                   value="<?= htmlspecialchars($form_data['oggetto'] ?? '') ?>"
                                   required
                                   placeholder="Oggetto del messaggio">
                        </div>
                        
                        <div class="form-group">
                            <label for="messaggio">Messaggio *</label>
                            <textarea id="messaggio" 
                                      name="messaggio" 
                                      rows="6" 
                                      required
                                      placeholder="Descrivi la tua richiesta o domanda..."><?= htmlspecialchars($form_data['messaggio'] ?? '') ?></textarea>
                        </div>
                        
                        <div class="form-group">
                            <label class="checkbox-label">
                                <input type="checkbox" 
                                       name="privacy_accepted" 
                                       required
                                       <?= ($form_data['privacy_accepted'] ?? false) ? 'checked' : '' ?>>
                                <span class="checkmark"></span>
                                <span class="checkbox-text">
                                    Ho letto e accetto la 
                                    <a href="privacy-policy" target="_blank">Privacy Policy</a> *
                                </span>
                            </label>
                        </div>
                        
                        <button type="submit" class="btn btn-primary btn-large">
                            <i class="icon-send"></i>
                            <span>Invia Messaggio</span>
                            <div class="btn-loader" style="display: none;">
                                <div class="spinner"></div>
                            </div>
                        </button>
                    </form>
                </div>
                
                <!-- Map and Additional Info -->
                <div class="contact-sidebar">
                    <div class="map-container">
                        <h3><i class="icon-map"></i> Dove Siamo</h3>
                        <div class="map-placeholder">
                            <iframe 
                                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d2797.344!2d9.2744!3d45.5948!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4786c1db6e3bc45b%3A0x123456789abcdef0!2sVia%20Plinio%2C%2020900%20Monza%20MB!5e0!3m2!1sit!2sit!4v1234567890123"
                                width="100%" 
                                height="300" 
                                style="border:0; border-radius: 12px;" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                            </iframe>
                        </div>
                        <div class="map-info">
                            <p><strong>AG SERVIZI VIA PLINIO 72</strong></p>
                            <p>Via Plinio 72, 20900 Monza (MB)</p>
                            <p>Facilmente raggiungibile con mezzi pubblici e auto</p>
                        </div>
                    </div>
                    
                    <div class="quick-contact">
                        <h3><i class="icon-zap"></i> Contatto Rapido</h3>
                        <div class="quick-buttons">
                            <a href="tel:+390391234567" class="quick-btn">
                                <i class="icon-phone"></i>
                                <span>Chiamaci Ora</span>
                            </a>
                            <a href="mailto:info@agenziaplinio.it" class="quick-btn">
                                <i class="icon-mail"></i>
                                <span>Scrivi Email</span>
                            </a>
                            <a href="https://wa.me/393351234567" target="_blank" class="quick-btn whatsapp">
                                <i class="icon-message-circle"></i>
                                <span>WhatsApp</span>
                            </a>
                        </div>
                    </div>
                    
                    <div class="social-contact">
                        <h3><i class="icon-share-2"></i> Seguici</h3>
                        <div class="social-links">
                            <a href="#" class="social-link facebook">
                                <i class="icon-facebook"></i>
                                <span>Facebook</span>
                            </a>
                            <a href="#" class="social-link instagram">
                                <i class="icon-instagram"></i>
                                <span>Instagram</span>
                            </a>
                            <a href="#" class="social-link linkedin">
                                <i class="icon-linkedin"></i>
                                <span>LinkedIn</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- FAQ Section -->
    <section class="contact-faq">
        <div class="container">
            <div class="section-header">
                <h2>Domande Frequenti</h2>
                <p>Trova rapidamente le risposte alle domande più comuni</p>
            </div>
            
            <div class="faq-grid">
                <div class="faq-item">
                    <h3>Come posso richiedere un preventivo?</h3>
                    <p>Puoi richiedere un preventivo compilando il form sopra, chiamandoci direttamente o inviando un'email dettagliata con le tue esigenze.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Quanto tempo richiedono i vostri servizi?</h3>
                    <p>I tempi variano in base al tipo e alla complessità del progetto. Ti forniremo una stima precisa dopo aver analizzato le tue esigenze.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Offrite supporto post-vendita?</h3>
                    <p>Sì, offriamo supporto completo e assistenza continua per tutti i nostri servizi, con piani di manutenzione personalizzati.</p>
                </div>
                
                <div class="faq-item">
                    <h3>Lavorate con clienti fuori Monza?</h3>
                    <p>Certamente! Lavoriamo con clienti in tutta Italia e offriamo consulenze online per progetti internazionali.</p>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.contact-page {
    padding-top: 0;
}

.contact-hero {
    min-height: 60vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    position: relative;
    overflow: hidden;
}

.hero-content {
    position: relative;
    z-index: 2;
}

.hero-title {
    display: block;
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(45deg, #fff, #ffbf00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    display: block;
    font-size: 1.5rem;
    font-weight: 300;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.hero-description {
    font-size: 1.2rem;
    line-height: 1.6;
    opacity: 0.8;
    max-width: 600px;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 191, 0, 0.1);
    animation: float 6s ease-in-out infinite;
}

.hero-shape.shape-1 {
    width: 300px;
    height: 300px;
    top: -10%;
    right: -5%;
    animation-delay: 0s;
}

.hero-shape.shape-2 {
    width: 200px;
    height: 200px;
    bottom: -10%;
    left: -5%;
    animation-delay: 3s;
}

.contact-info {
    padding: 4rem 0;
    background: var(--light-background);
}

.info-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

.info-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    display: flex;
    align-items: flex-start;
    gap: 1.5rem;
}

.info-card:hover {
    transform: translateY(-5px);
}

.info-icon {
    width: 4rem;
    height: 4rem;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    flex-shrink: 0;
}

.info-content {
    flex: 1;
}

.info-content h3 {
    margin: 0 0 1rem 0;
    color: var(--text-color);
    font-size: 1.2rem;
}

.info-content p {
    margin: 0 0 0.5rem 0;
    color: var(--text-color);
    line-height: 1.5;
}

.info-content a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.info-content a:hover {
    text-decoration: underline;
}

.info-link {
    display: inline-flex;
    align-items: center;
    gap: 0.5rem;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.info-hours {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.contact-main {
    padding: 4rem 0;
}

.contact-grid {
    display: grid;
    grid-template-columns: 2fr 1fr;
    gap: 4rem;
    align-items: start;
}

.contact-form-section {
    background: white;
    border-radius: 16px;
    padding: 3rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.form-header {
    margin-bottom: 2rem;
}

.form-header h2 {
    margin: 0 0 1rem 0;
    color: var(--text-color);
    font-size: 2rem;
}

.form-header p {
    margin: 0;
    color: var(--text-muted);
    font-size: 1.1rem;
}

.contact-form {
    display: flex;
    flex-direction: column;
    gap: 1.5rem;
}

.form-row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1.5rem;
}

.form-group {
    display: flex;
    flex-direction: column;
}

.form-group label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.form-group input,
.form-group select,
.form-group textarea {
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
    background: white;
    font-family: inherit;
}

.form-group input:focus,
.form-group select:focus,
.form-group textarea:focus {
    outline: none;
    border-color: var(--primary-color);
    box-shadow: 0 0 0 3px rgba(var(--primary-color-rgb), 0.1);
}

.form-group textarea {
    resize: vertical;
    min-height: 120px;
}

.checkbox-label {
    display: flex;
    align-items: flex-start;
    gap: 0.75rem;
    cursor: pointer;
    font-size: 0.9rem;
    color: var(--text-color);
    line-height: 1.4;
}

.checkbox-label input {
    opacity: 0;
    position: absolute;
    width: 0;
    height: 0;
}

.checkmark {
    width: 20px;
    height: 20px;
    border: 2px solid var(--border-color);
    border-radius: 4px;
    position: relative;
    transition: all 0.3s ease;
    flex-shrink: 0;
    margin-top: 1px;
}

.checkbox-label input:checked + .checkmark {
    background: var(--primary-color);
    border-color: var(--primary-color);
}

.checkbox-label input:checked + .checkmark::after {
    content: '✓';
    position: absolute;
    color: white;
    font-size: 12px;
    font-weight: bold;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

.checkbox-text a {
    color: var(--primary-color);
    text-decoration: none;
}

.checkbox-text a:hover {
    text-decoration: underline;
}

.btn-large {
    padding: 1.25rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    position: relative;
    overflow: hidden;
}

.contact-sidebar {
    display: flex;
    flex-direction: column;
    gap: 2rem;
}

.map-container,
.quick-contact,
.social-contact {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.map-container h3,
.quick-contact h3,
.social-contact h3 {
    margin: 0 0 1.5rem 0;
    color: var(--text-color);
    font-size: 1.2rem;
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.map-container h3 i,
.quick-contact h3 i,
.social-contact h3 i {
    color: var(--primary-color);
}

.map-info {
    margin-top: 1rem;
    padding-top: 1rem;
    border-top: 1px solid var(--border-color);
}

.map-info p {
    margin: 0 0 0.5rem 0;
    color: var(--text-muted);
    line-height: 1.5;
}

.quick-buttons {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.quick-btn {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    text-decoration: none;
    color: var(--text-color);
    transition: all 0.3s ease;
    font-weight: 500;
}

.quick-btn:hover {
    border-color: var(--primary-color);
    background: rgba(var(--primary-color-rgb), 0.05);
    transform: translateX(5px);
}

.quick-btn.whatsapp:hover {
    border-color: #25d366;
    background: rgba(37, 211, 102, 0.05);
}

.quick-btn i {
    font-size: 1.2rem;
    color: var(--primary-color);
}

.quick-btn.whatsapp i {
    color: #25d366;
}

.social-links {
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
}

.social-link {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem;
    border-radius: 8px;
    text-decoration: none;
    color: var(--text-color);
    transition: all 0.3s ease;
}

.social-link:hover {
    transform: translateX(5px);
}

.social-link.facebook:hover {
    background: rgba(24, 119, 242, 0.1);
    color: #1877f2;
}

.social-link.instagram:hover {
    background: rgba(225, 48, 108, 0.1);
    color: #e1306c;
}

.social-link.linkedin:hover {
    background: rgba(14, 118, 168, 0.1);
    color: #0e76a8;
}

.contact-faq {
    padding: 4rem 0;
    background: var(--light-background);
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 1rem;
}

.section-header p {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.faq-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
    gap: 2rem;
}

.faq-item {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
}

.faq-item h3 {
    margin: 0 0 1rem 0;
    color: var(--text-color);
    font-size: 1.1rem;
}

.faq-item p {
    margin: 0;
    color: var(--text-muted);
    line-height: 1.6;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
    }
    
    .info-grid {
        grid-template-columns: 1fr;
    }
    
    .info-card {
        flex-direction: column;
        text-align: center;
    }
    
    .contact-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .contact-form-section {
        padding: 2rem;
    }
    
    .form-row {
        grid-template-columns: 1fr;
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    initializeContactForm();
});

function initializeContactForm() {
    const form = document.getElementById('contactForm');
    if (!form) return;
    
    const submitBtn = form.querySelector('button[type="submit"]');
    
    // Form submission handling
    form.addEventListener('submit', function(e) {
        const btnText = submitBtn.querySelector('span');
        const btnLoader = submitBtn.querySelector('.btn-loader');
        
        btnText.style.display = 'none';
        btnLoader.style.display = 'block';
        submitBtn.disabled = true;
        
        // Form will submit normally
        setTimeout(() => {
            if (document.querySelector('.alert-error')) {
                btnText.style.display = 'block';
                btnLoader.style.display = 'none';
                submitBtn.disabled = false;
            }
        }, 100);
    });
    
    // Auto-resize textarea
    const textarea = form.querySelector('textarea');
    if (textarea) {
        textarea.addEventListener('input', function() {
            this.style.height = 'auto';
            this.style.height = this.scrollHeight + 'px';
        });
    }
    
    // Form validation
    const inputs = form.querySelectorAll('input[required], textarea[required]');
    inputs.forEach(input => {
        input.addEventListener('blur', function() {
            validateField(this);
        });
    });
}

function validateField(field) {
    const value = field.value.trim();
    const name = field.name;
    
    // Remove existing error state
    field.classList.remove('error');
    
    let isValid = true;
    
    if (!value) {
        isValid = false;
    } else if (name === 'email') {
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(value)) {
            isValid = false;
        }
    }
    
    if (!isValid) {
        field.classList.add('error');
        field.style.borderColor = 'var(--error-color)';
    } else {
        field.style.borderColor = 'var(--success-color)';
    }
    
    return isValid;
}

// Add error styling
document.head.insertAdjacentHTML('beforeend', `
<style>
.form-group input.error,
.form-group textarea.error {
    border-color: var(--error-color);
    box-shadow: 0 0 0 3px rgba(220, 53, 69, 0.1);
}
</style>
`);
</script>

<?php include 'includes/footer.php'; ?>