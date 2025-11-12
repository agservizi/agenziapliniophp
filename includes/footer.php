    </main>
    
    <!-- Footer -->
    <footer class="site-footer" role="contentinfo">
        <div class="container">
            <!-- Footer Top -->
            <div class="footer-top">
                <div class="footer-section">
                    <div class="footer-logo">
                        <svg class="logo-icon" viewBox="0 0 100 100" fill="none">
                            <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="3"/>
                            <path d="M30 35h40v30h-40z" fill="currentColor"/>
                            <text x="50" y="55" text-anchor="middle" font-size="12" font-weight="bold" fill="var(--color-background)">AP</text>
                        </svg>
                        <div>
                            <h3><?= h(APP_NAME) ?></h3>
                            <p class="footer-tagline">La tua agenzia di fiducia per tutti i servizi digitali e non solo</p>
                        </div>
                    </div>
                    
                    <div class="footer-contact">
                        <div class="contact-item">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M12,2C8.13,2 5,5.13 5,9C5,14.25 12,22 12,22C12,22 19,14.25 19,9C19,5.13 15.87,2 12,2M12,11.5A2.5,2.5 0 0,1 9.5,9A2.5,2.5 0 0,1 12,6.5A2.5,2.5 0 0,1 14.5,9A2.5,2.5 0 0,1 12,11.5Z"/>
                            </svg>
                            <div>
                                <strong>Indirizzo</strong>
                                <span>Via Plinio 72, 20129 Milano</span>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                            </svg>
                            <div>
                                <strong>Telefono</strong>
                                <a href="tel:+390212345678">02 1234 5678</a>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                            </svg>
                            <div>
                                <strong>Email</strong>
                                <a href="mailto:<?= SUPPORT_EMAIL ?>"><?= SUPPORT_EMAIL ?></a>
                            </div>
                        </div>
                        
                        <div class="contact-item">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.7L16.2,16.2Z"/>
                            </svg>
                            <div>
                                <strong>Orari</strong>
                                <span>Lun-Ven: 9:00-18:00<br>Sabato: 9:00-13:00</span>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="footer-section">
                    <h4>Servizi Digitali</h4>
                    <ul class="footer-links">
                        <li><a href="/servizi.php#spid">SPID - Identità Digitale</a></li>
                        <li><a href="/servizi.php#pec">PEC - Posta Certificata</a></li>
                        <li><a href="/servizi.php#firma-digitale">Firma Digitale</a></li>
                        <li><a href="/servizi.php#cns">CNS - Carta Servizi</a></li>
                        <li><a href="/servizi.php#cie">CIE - Carta Identità</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Pagamenti & Ricariche</h4>
                    <ul class="footer-links">
                        <li><a href="/servizi.php#ricariche">Ricariche Telefoniche</a></li>
                        <li><a href="/servizi.php#bollettini">Pagamento Bollettini</a></li>
                        <li><a href="/servizi.php#f24">F24 e Tasse</a></li>
                        <li><a href="/servizi.php#bollo-auto">Bollo Auto</a></li>
                        <li><a href="/servizi.php#mav-rav">MAV e RAV</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Altri Servizi</h4>
                    <ul class="footer-links">
                        <li><a href="/servizi.php#spedizioni">Spedizioni</a></li>
                        <li><a href="/servizi.php#pratiche-auto">Pratiche Automobilistiche</a></li>
                        <li><a href="/servizi.php#contratti">Contratti Telefonici</a></li>
                        <li><a href="/servizi.php#assicurazioni">Assicurazioni</a></li>
                        <li><a href="/servizi.php#consulenze">Consulenze</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Account</h4>
                    <ul class="footer-links">
                        <?php if ($current_user): ?>
                            <li><a href="/area-cliente/">Area Cliente</a></li>
                            <li><a href="/area-cliente/ordini.php">I Miei Ordini</a></li>
                            <li><a href="/area-cliente/tickets.php">Assistenza</a></li>
                            <li><a href="/area-cliente/profilo.php">Il Mio Profilo</a></li>
                        <?php else: ?>
                            <li><a href="/login.php">Accedi</a></li>
                            <li><a href="/register.php">Registrati</a></li>
                            <li><a href="/recupera-password.php">Password Dimenticata</a></li>
                        <?php endif; ?>
                        <li><a href="/shop.php">Shop Online</a></li>
                        <li><a href="/contatti.php">Contattaci</a></li>
                    </ul>
                </div>
                
                <div class="footer-section">
                    <h4>Seguici</h4>
                    <div class="social-links">
                        <a href="#" class="social-link" aria-label="Facebook" title="Seguici su Facebook">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="Instagram" title="Seguici su Instagram">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M12.017 0C5.396 0 .029 5.367.029 11.987c0 6.62 5.367 11.987 11.988 11.987 6.62 0 11.987-5.367 11.987-11.987C24.014 5.367 18.637.001 12.017.001zM8.449 16.988c-1.297 0-2.448-.49-3.323-1.297C3.85 14.724 3.364 13.575 3.364 12.277s.486-2.447 1.297-3.323C5.537 7.979 6.688 7.493 7.986 7.493s2.448.486 3.323 1.297c.875.875 1.297 2.026 1.297 3.323s-.422 2.402-1.297 3.277c-.875.875-2.026 1.297-3.323 1.297z"/>
                            </svg>
                        </a>
                        <a href="#" class="social-link" aria-label="WhatsApp" title="Contattaci su WhatsApp">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893A11.821 11.821 0 0020.886 3.488"/>
                            </svg>
                        </a>
                    </div>
                    
                    <div class="newsletter-signup">
                        <h5>Newsletter</h5>
                        <p>Resta aggiornato sulle nostre offerte</p>
                        <form class="newsletter-form" action="/newsletter.php" method="post">
                            <input type="hidden" name="csrf_token" value="<?= generateCSRFToken() ?>">
                            <div class="input-group">
                                <input type="email" name="email" placeholder="La tua email" required>
                                <button type="submit" class="btn btn-primary">
                                    <svg class="icon" viewBox="0 0 24 24">
                                        <path d="M2,21L23,12L2,3V10L17,12L2,14V21Z"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <!-- Footer Bottom -->
            <div class="footer-bottom">
                <div class="footer-legal">
                    <p>&copy; <?= date('Y') ?> <?= h(APP_NAME) ?>. Tutti i diritti riservati.</p>
                    <div class="legal-links">
                        <a href="/privacy.php">Privacy Policy</a>
                        <a href="/termini.php">Termini di Servizio</a>
                        <a href="/cookie.php">Cookie Policy</a>
                    </div>
                </div>
                
                <div class="footer-certifications">
                    <p class="text-small">
                        Agenzia autorizzata per servizi SPID, PEC e Firma Digitale • 
                        P.IVA 12345678901 • 
                        REA MI-1234567
                    </p>
                </div>
            </div>
        </div>
    </footer>
    
    <!-- Floating Action Button (Chatbot) -->
    <div class="floating-chat" id="floating-chat">
        <button class="chat-toggle" aria-label="Apri chat assistenza">
            <svg class="icon icon-chat" viewBox="0 0 24 24">
                <path d="M12,3C17.5,3 22,6.58 22,11C22,15.42 17.5,19 12,19C10.76,19 9.57,18.82 8.47,18.5C5.55,21 2,21 2,21C4.33,18.67 4.7,17.1 4.75,16.5C3.05,15.07 2,13.13 2,11C2,6.58 6.5,3 12,3Z"/>
            </svg>
            <svg class="icon icon-close" viewBox="0 0 24 24">
                <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
            </svg>
        </button>
        <div class="chat-widget" id="chat-widget">
            <!-- Chat content will be loaded here -->
        </div>
    </div>
    
    <!-- Scroll to Top Button -->
    <button class="scroll-to-top" id="scroll-to-top" aria-label="Torna all'inizio">
        <svg class="icon" viewBox="0 0 24 24">
            <path d="M13,20H11V8L5.5,13.5L4.08,12.08L12,4.16L19.92,12.08L18.5,13.5L13,8V20Z"/>
        </svg>
    </button>
    
    <!-- Toast Notification Container -->
    <div class="toast-container" id="toast-container"></div>
    
    <!-- Modal Container -->
    <div class="modal-overlay" id="modal-overlay">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title" id="modal-title"></h3>
                <button class="modal-close" aria-label="Chiudi modal">
                    <svg class="icon" viewBox="0 0 24 24">
                        <path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/>
                    </svg>
                </button>
            </div>
            <div class="modal-body" id="modal-body"></div>
            <div class="modal-footer" id="modal-footer"></div>
        </div>
    </div>
    
    <!-- JavaScript -->
    <script src="/assets/js/utils.js"></script>
    <script src="/assets/js/theme.js"></script>
    <script src="/assets/js/navigation.js"></script>
    <script src="/assets/js/cart.js"></script>
    <script src="/assets/js/modal.js"></script>
    <script src="/assets/js/toast.js"></script>
    <script src="/assets/js/chatbot.js"></script>
    <script src="/assets/js/main.js"></script>
    
    <?php if (isset($additional_js)) : foreach ($additional_js as $js) : ?>
    <script src="<?= h($js) ?>"></script>
    <?php endforeach; endif; ?>
    
    <!-- Page specific inline scripts -->
    <?php if (isset($inline_js)) : ?>
    <script>
        <?= $inline_js ?>
    </script>
    <?php endif; ?>
    
    <!-- Analytics (placeholder) -->
    <?php if (defined('GOOGLE_ANALYTICS_ID') && GOOGLE_ANALYTICS_ID): ?>
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?= GOOGLE_ANALYTICS_ID ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag(){dataLayer.push(arguments);}
        gtag('js', new Date());
        gtag('config', '<?= GOOGLE_ANALYTICS_ID ?>');
    </script>
    <?php endif; ?>
</body>
</html>