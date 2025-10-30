    </main>
    <footer class="site-footer has-text-centered">
        <div class="container">
            <div class="columns is-variable is-6">
                <div class="column">
                    <h3 class="title is-5 has-text-warning">Agenzia Plinio</h3>
                    <p class="subtitle is-6">Strategie digitali, consulenza e soluzioni su misura per imprese visionarie.</p>
                    <div class="footer-socials">
                        <a href="#" aria-label="LinkedIn" class="social-link">LinkedIn</a>
                        <a href="#" aria-label="Instagram" class="social-link">Instagram</a>
                        <a href="#" aria-label="YouTube" class="social-link">YouTube</a>
                    </div>
                </div>
                <div class="column">
                    <h4 class="title is-6">Servizi</h4>
                    <ul>
                        <li><a href="/servizi.php#digital">Trasformazione Digitale</a></li>
                        <li><a href="/servizi.php#branding">Brand Strategy</a></li>
                        <li><a href="/servizi.php#automation">Automazione Processi</a></li>
                    </ul>
                </div>
                <div class="column">
                    <h4 class="title is-6">Newsletter</h4>
                    <form method="post" action="/form/newsletter.php" class="newsletter-form" data-animate>
                        <?= csrf_field(); ?>
                        <div class="field has-addons">
                            <div class="control is-expanded">
                                <input class="input" type="email" name="newsletter_email" placeholder="Email aziendale" required>
                            </div>
                            <div class="control">
                                <button class="button is-warning" type="submit">Invia</button>
                            </div>
                        </div>
                        <p class="is-size-7">Ricevi insight esclusivi e trend di mercato.</p>
                    </form>
                </div>
            </div>
            <div class="footer-bottom">
                <p>&copy; <?= date('Y'); ?> Agenzia Plinio. Tutti i diritti riservati.</p>
            </div>
        </div>
    </footer>
    <button id="scrollTop" aria-label="Torna su" class="scroll-top" data-scroll-top>
        <span class="icon">&#9650;</span>
    </button>
    <script src="<?= asset('assets/js/parallax.js'); ?>"></script>
    <script src="<?= asset('assets/js/ui-effects.js'); ?>"></script>
    <script src="<?= asset('assets/js/main.js'); ?>"></script>
</body>
</html>
