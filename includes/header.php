<?php
/**
 * Header del sito - Agenzia Plinio
 */

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

require_once dirname(__FILE__) . '/config.php';
require_once dirname(__FILE__) . '/auth.php';

$auth = new Auth();
$current_user = $auth->getCurrentUser();
$page_title = isset($page_title) ? $page_title . ' | ' . APP_NAME : APP_NAME;
$page_description = isset($page_description) ? $page_description : 'Agenzia multiservizi a Milano - SPID, PEC, Ricariche, Spedizioni e molto altro';
$current_page = basename($_SERVER['PHP_SELF'], '.php');
?>
<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    
    <!-- Meta SEO -->
    <title><?= h($page_title) ?></title>
    <meta name="description" content="<?= h($page_description) ?>">
    <meta name="keywords" content="agenzia multiservizi milano, spid, pec, ricariche telefoniche, spedizioni, bollettini, via plinio 72">
    <meta name="author" content="<?= APP_NAME ?>">
    <meta name="robots" content="index, follow">
    
    <!-- Meta Open Graph -->
    <meta property="og:title" content="<?= h($page_title) ?>">
    <meta property="og:description" content="<?= h($page_description) ?>">
    <meta property="og:type" content="website">
    <meta property="og:url" content="<?= 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] ?>">
    <meta property="og:image" content="/assets/images/og-image.jpg">
    <meta property="og:locale" content="it_IT">
    
    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="/assets/icons/favicon.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="/assets/icons/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/assets/icons/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/assets/icons/favicon-16x16.png">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- CSS -->
    <link rel="stylesheet" href="/assets/css/main.css">
    <link rel="stylesheet" href="/assets/css/components.css">
    <link rel="stylesheet" href="/assets/css/responsive.css">
    <link rel="stylesheet" href="/assets/css/js-components.css">
    <?php if (isset($additional_css)) : foreach ($additional_css as $css) : ?>
    <link rel="stylesheet" href="<?= h($css) ?>">
    <?php endforeach; endif; ?>
    
    <!-- Schema.org Structured Data -->
    <script type="application/ld+json">
    {
        "@context": "https://schema.org",
        "@type": "LocalBusiness",
        "name": "<?= h(APP_NAME) ?>",
        "description": "Agenzia multiservizi specializzata in SPID, PEC, ricariche telefoniche e spedizioni",
        "url": "<?= 'http' . (isset($_SERVER['HTTPS']) ? 's' : '') . '://' . $_SERVER['HTTP_HOST'] ?>",
        "telephone": "+39-02-1234567",
        "address": {
            "@type": "PostalAddress",
            "streetAddress": "Via Plinio 72",
            "addressLocality": "Milano",
            "postalCode": "20129",
            "addressCountry": "IT"
        },
        "geo": {
            "@type": "GeoCoordinates",
            "latitude": "45.4642",
            "longitude": "9.1900"
        },
        "openingHours": ["Mo-Fr 09:00-18:00", "Sa 09:00-13:00"],
        "paymentAccepted": ["Cash", "Credit Card"],
        "priceRange": "€"
    }
    </script>
    
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?= generateCSRFToken() ?>">
</head>
<body class="<?= $current_page ?>-page" data-theme="auto">
    
    <!-- Skip to main content -->
    <a href="#main-content" class="skip-link">Salta al contenuto principale</a>
    
    <!-- Header -->
    <header class="site-header" id="site-header">
        <div class="container">
            <!-- Top Bar -->
            <div class="header-top">
                <div class="contact-info">
                    <span class="contact-item">
                        <svg class="icon icon-phone" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M6.62,10.79C8.06,13.62 10.38,15.94 13.21,17.38L15.41,15.18C15.69,14.9 16.08,14.82 16.43,14.93C17.55,15.3 18.75,15.5 20,15.5A1,1 0 0,1 21,16.5V20A1,1 0 0,1 20,21A17,17 0 0,1 3,4A1,1 0 0,1 4,3H7.5A1,1 0 0,1 8.5,4C8.5,5.25 8.7,6.45 9.07,7.57C9.18,7.92 9.1,8.31 8.82,8.59L6.62,10.79Z"/>
                        </svg>
                        <a href="tel:+390212345678">02 1234 5678</a>
                    </span>
                    <span class="contact-item">
                        <svg class="icon icon-email" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M20,8L12,13L4,8V6L12,11L20,6M20,4H4C2.89,4 2,4.89 2,6V18A2,2 0 0,0 4,20H20A2,2 0 0,0 22,18V6C22,4.89 21.1,4 20,4Z"/>
                        </svg>
                        <a href="mailto:<?= SUPPORT_EMAIL ?>"><?= SUPPORT_EMAIL ?></a>
                    </span>
                    <span class="contact-item">
                        <svg class="icon icon-clock" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M12,2A10,10 0 0,0 2,12A10,10 0 0,0 12,22A10,10 0 0,0 22,12A10,10 0 0,0 12,2M16.2,16.2L11,13V7H12.5V12.2L17,14.7L16.2,16.2Z"/>
                        </svg>
                        Lun-Ven 9:00-18:00, Sab 9:00-13:00
                    </span>
                </div>
                <div class="header-actions">
                    <?php if ($current_user): ?>
                        <div class="user-menu">
                            <button class="user-menu-toggle" aria-label="Menu utente">
                                <span class="user-avatar"><?= strtoupper(substr($current_user['nome'], 0, 1)) ?></span>
                                <span class="user-name"><?= h($current_user['nome']) ?></span>
                                <svg class="icon icon-chevron-down" viewBox="0 0 24 24">
                                    <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
                                </svg>
                            </button>
                            <div class="user-dropdown">
                                <a href="/area-cliente/" class="dropdown-item">
                                    <svg class="icon" viewBox="0 0 24 24"><path d="M12,4A4,4 0 0,1 16,8A4,4 0 0,1 12,12A4,4 0 0,1 8,8A4,4 0 0,1 12,4M12,14C16.42,14 20,15.79 20,18V20H4V18C4,15.79 7.58,14 12,14Z"/></svg>
                                    Area Cliente
                                </a>
                                <?php if ($current_user['ruolo'] === 'admin'): ?>
                                <a href="/area-admin/" class="dropdown-item">
                                    <svg class="icon" viewBox="0 0 24 24"><path d="M12,15C12.81,15 13.5,14.7 14.11,14.11C14.7,13.5 15,12.81 15,12C15,11.19 14.7,10.5 14.11,9.89C13.5,9.3 12.81,9 12,9C11.19,9 10.5,9.3 9.89,9.89C9.3,10.5 9,11.19 9,12C9,12.81 9.3,13.5 9.89,14.11C10.5,14.7 11.19,15 12,15M21,16V10.5L19.5,9.5L21,8.5V7A1,1 0 0,0 20,6H4A1,1 0 0,0 3,7V17A1,1 0 0,0 4,18H20A1,1 0 0,0 21,17V16Z"/></svg>
                                    Area Admin
                                </a>
                                <?php endif; ?>
                                <hr class="dropdown-divider">
                                <a href="/logout.php" class="dropdown-item text-danger">
                                    <svg class="icon" viewBox="0 0 24 24"><path d="M16,17V14H9V10H16V7L21,12L16,17M14,2A2,2 0 0,1 16,4V6H14V4H5V20H14V18H16V20A2,2 0 0,1 14,22H5A2,2 0 0,1 3,20V4A2,2 0 0,1 5,2H14Z"/></svg>
                                    Logout
                                </a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/login.php" class="btn btn-outline">Accedi</a>
                        <a href="/register.php" class="btn btn-primary">Registrati</a>
                    <?php endif; ?>
                    
                    <!-- Theme Toggle -->
                    <button class="theme-toggle" aria-label="Cambia tema" title="Cambia tema">
                        <svg class="icon icon-sun" viewBox="0 0 24 24">
                            <path d="M12,8A4,4 0 0,0 8,12A4,4 0 0,0 12,16A4,4 0 0,0 16,12A4,4 0 0,0 12,8M12,18A6,6 0 0,1 6,12A6,6 0 0,1 12,6A6,6 0 0,1 18,12A6,6 0 0,1 12,18M20,8.69V4H15.31L12,0.69L8.69,4H4V8.69L0.69,12L4,15.31V20H8.69L12,23.31L15.31,20H20V15.31L23.31,12L20,8.69Z"/>
                        </svg>
                        <svg class="icon icon-moon" viewBox="0 0 24 24">
                            <path d="M17.75,4.09L15.22,6.03L16.13,9.09L13.5,7.28L10.87,9.09L11.78,6.03L9.25,4.09L12.44,4L13.5,1L14.56,4L17.75,4.09M21.25,11L19.61,12.25L20.2,14.23L18.5,13.06L16.8,14.23L17.39,12.25L15.75,11L17.81,10.95L18.5,9L19.19,10.95L21.25,11M18.97,15.95C19.8,15.87 20.69,17.05 20.16,17.8C19.84,18.25 19.5,18.67 19.08,19.07C15.17,23 8.84,23 4.94,19.07C1.03,15.17 1.03,8.83 4.94,4.93C5.34,4.53 5.76,4.17 6.21,3.85C6.96,3.32 8.14,4.21 8.06,5.04C7.79,7.9 8.75,10.87 10.95,13.06C13.14,15.26 16.1,16.22 18.97,15.95M17.33,17.97C14.5,17.81 11.7,16.64 9.53,14.5C7.36,12.31 6.2,9.5 6.04,6.68C3.23,9.82 3.34,14.4 6.35,17.41C9.37,20.43 14,20.54 17.33,17.97Z"/>
                        </svg>
                    </button>
                </div>
            </div>
            
            <!-- Main Navigation -->
            <nav class="main-nav" role="navigation" aria-label="Navigazione principale">
                <div class="nav-container">
                    <!-- Logo -->
                    <div class="site-logo">
                        <a href="/" aria-label="Torna alla homepage">
                            <svg class="logo-icon" viewBox="0 0 100 100" fill="none">
                                <circle cx="50" cy="50" r="45" stroke="currentColor" stroke-width="3"/>
                                <path d="M30 35h40v30h-40z" fill="currentColor"/>
                                <text x="50" y="55" text-anchor="middle" font-size="12" font-weight="bold" fill="var(--color-background)">AP</text>
                            </svg>
                            <span class="logo-text">
                                <span class="logo-main"><?= h(APP_NAME) ?></span>
                                <span class="logo-sub">Multiservizi Milano</span>
                            </span>
                        </a>
                    </div>
                    
                    <!-- Mobile Menu Toggle -->
                    <button class="mobile-menu-toggle" aria-label="Menu di navigazione" aria-expanded="false">
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                        <span class="hamburger-line"></span>
                    </button>
                    
                    <!-- Navigation Menu -->
                    <ul class="nav-menu" id="nav-menu">
                        <li class="nav-item">
                            <a href="/" class="nav-link <?= $current_page === 'index' ? 'active' : '' ?>">
                                Home
                            </a>
                        </li>
                        <li class="nav-item has-dropdown">
                            <a href="/servizi.php" class="nav-link <?= $current_page === 'servizi' ? 'active' : '' ?>">
                                Servizi
                                <svg class="icon icon-chevron-down" viewBox="0 0 24 24">
                                    <path d="M7.41,8.58L12,13.17L16.59,8.58L18,10L12,16L6,10L7.41,8.58Z"/>
                                </svg>
                            </a>
                            <div class="mega-menu">
                                <div class="mega-menu-content">
                                    <div class="mega-menu-section">
                                        <h4>Servizi Digitali</h4>
                                        <ul>
                                            <li><a href="/servizi.php#spid">SPID - Identità Digitale</a></li>
                                            <li><a href="/servizi.php#pec">PEC - Posta Certificata</a></li>
                                            <li><a href="/servizi.php#firma-digitale">Firma Digitale</a></li>
                                            <li><a href="/servizi.php#cns">CNS - Carta Servizi</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-section">
                                        <h4>Pagamenti</h4>
                                        <ul>
                                            <li><a href="/servizi.php#ricariche">Ricariche Telefoniche</a></li>
                                            <li><a href="/servizi.php#bollettini">Pagamento Bollettini</a></li>
                                            <li><a href="/servizi.php#f24">F24 e Tasse</a></li>
                                            <li><a href="/servizi.php#bollo-auto">Bollo Auto</a></li>
                                        </ul>
                                    </div>
                                    <div class="mega-menu-section">
                                        <h4>Altri Servizi</h4>
                                        <ul>
                                            <li><a href="/servizi.php#spedizioni">Spedizioni</a></li>
                                            <li><a href="/servizi.php#pratiche-auto">Pratiche Auto</a></li>
                                            <li><a href="/servizi.php#contratti">Contratti Telefonici</a></li>
                                            <li><a href="/servizi.php#assicurazioni">Assicurazioni</a></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <li class="nav-item">
                            <a href="/shop.php" class="nav-link <?= $current_page === 'shop' ? 'active' : '' ?>">
                                Shop
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/contatti.php" class="nav-link <?= $current_page === 'contatti' ? 'active' : '' ?>">
                                Contatti
                            </a>
                        </li>
                        
                        <!-- Mobile Only Links -->
                        <li class="nav-item mobile-only">
                            <?php if ($current_user): ?>
                                <a href="/area-cliente/" class="nav-link">Area Cliente</a>
                                <?php if ($current_user['ruolo'] === 'admin'): ?>
                                <a href="/area-admin/" class="nav-link">Area Admin</a>
                                <?php endif; ?>
                                <a href="/logout.php" class="nav-link">Logout</a>
                            <?php else: ?>
                                <a href="/login.php" class="nav-link">Accedi</a>
                                <a href="/register.php" class="nav-link">Registrati</a>
                            <?php endif; ?>
                        </li>
                    </ul>
                    
                    <!-- Cart Icon -->
                    <div class="cart-icon">
                        <a href="/cart.php" class="cart-link" aria-label="Carrello">
                            <svg class="icon" viewBox="0 0 24 24">
                                <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,3H1M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
                            </svg>
                            <span class="cart-count" id="cart-count">0</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>
    
    <!-- Mobile Menu Overlay -->
    <div class="mobile-menu-overlay" id="mobile-menu-overlay"></div>
    
    <!-- Main Content Wrapper -->
    <main id="main-content" class="main-content" role="main">