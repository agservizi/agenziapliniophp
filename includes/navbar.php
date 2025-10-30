<?php $user = current_user(); ?>
<header class="navbar-wrapper">
    <nav class="navbar is-transparent" role="navigation" aria-label="main navigation" data-nav>
        <div class="navbar-brand">
            <a class="navbar-item brand" href="/">
                <span class="brand-mark">AP</span>
                <span class="brand-text">Agenzia Plinio</span>
            </a>
            <a role="button" class="navbar-burger" data-target="mainNav" aria-label="menu" aria-expanded="false">
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
                <span aria-hidden="true"></span>
            </a>
        </div>
        <div id="mainNav" class="navbar-menu">
            <div class="navbar-start">
                <a class="navbar-item" href="/servizi.php">Servizi</a>
                <a class="navbar-item" href="/chi-siamo.php">Chi siamo</a>
                <a class="navbar-item" href="/contatti.php">Contatti</a>
                <a class="navbar-item" href="/shop/index.php">Shop</a>
            </div>
            <div class="navbar-end">
                <?php if ($user): ?>
                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            <span class="user-avatar" aria-hidden="true"></span>
                            <?= sanitize($user['nome']); ?>
                        </a>
                        <div class="navbar-dropdown is-right">
                            <a class="navbar-item" href="/user/dashboard.php">Dashboard</a>
                            <a class="navbar-item" href="/user/servizi-attivi.php">Servizi Attivi</a>
                            <a class="navbar-item" href="/user/documenti.php">Documenti</a>
                            <a class="navbar-item" href="/user/impostazioni.php">Impostazioni</a>
                            <?php if ($user['ruolo'] === 'admin'): ?>
                                <hr class="navbar-divider">
                                <a class="navbar-item" href="/admin/dashboard.php">Admin Panel</a>
                            <?php endif; ?>
                            <hr class="navbar-divider">
                            <form method="post" action="/user/logout.php">
                                <?= csrf_field(); ?>
                                <button type="submit" class="navbar-item logout-button">Esci</button>
                            </form>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-warning is-outlined" href="/user/login.php">Accedi</a>
                            <a class="button is-warning" href="/user/register.php">Registrati</a>
                        </div>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>
</header>
