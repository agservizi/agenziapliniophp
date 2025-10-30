<?php
$pageTitle = 'Servizi';
require_once __DIR__ . '/includes/header.php';

$services = [
    [
        'title' => 'Pagamenti',
        'description' => 'Bollettini, F24, PagoPA, MAV/RAV, Bonifici con DropPoint.',
        'link' => 'https://www.agenziaplinio.it/servizi/pagamenti',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/service-image-1743606275426-pagamenti-uUXVejJrRwBKjHfIa5fw0z8o4HnnE5',
    ],
    [
        'title' => 'Biglietteria',
        'description' => 'Biglietti Italo e Trenitalia.',
        'link' => 'https://www.agenziaplinio.it/servizi/biglietteria',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/treno-YWoVrIKusxhlIG6eVmhOd0YiNsJ5A6.jpg',
    ],
    [
        'title' => 'Spedizioni',
        'description' => 'Spedizioni nazionali e internazionali con BRT, Poste Italiane, TNT/FedEx.',
        'link' => 'https://www.agenziaplinio.it/servizi/spedizioni',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/brt-XmfBclOgJHjfimzC2bpN17zzIQC5xT.jpg',
    ],
    [
        'title' => 'Attivazioni Digitali',
        'description' => 'SPID, PEC, Firma Digitale (Namirial).',
        'link' => 'https://www.agenziaplinio.it/servizi/attivazioni-digitali',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/namirial-qwWloPu8WTylnGifUpwOWoHEU28Uwb.png',
    ],
    [
        'title' => 'CAF e Patronato',
        'description' => 'Pratiche fiscali e assistenza previdenziale.',
        'link' => 'https://www.agenziaplinio.it/servizi/caf-patronato',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/cafpatronato-IYvk759MyjLrJWvwVmoWlFfqzKUFOB.jpg',
    ],
    [
        'title' => 'Visure',
        'description' => 'Visure CRIF, catastali, camerali, protestati.',
        'link' => 'https://www.agenziaplinio.it/servizi/visure',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/esempio-visura-camerale-YPfUuu8a7dXkH38cd4UcSSJNNvDPMX.jpg',
    ],
    [
        'title' => 'Telefonia, Luce e Gas',
        'description' => 'Contratti con Fastweb, Iliad, Windtre, Pianeta Fibra, Sky, A2A Energia, Enel Energia, Fastweb Energia.',
        'link' => 'https://www.agenziaplinio.it/servizi/telefonia-luce-gas',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/consulenza-utenze-mnvuZsScuMyQ7x7vzXJWfeVAj0Ju8l.jpg',
    ],
    [
        'title' => 'Invii Posta Telematica',
        'description' => 'Invio Email e PEC.',
        'link' => 'https://www.agenziaplinio.it/servizi/servizi-postali',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/invio-email-Bazxi14trtbK0Gpfy6B0imQrhGgAY1.png',
    ],
    [
        'title' => 'Punto di Ritiro Pacchi',
        'description' => 'PuntoPoste, BRT-Fermopoint, GLS Shop, FedEx Location.',
        'link' => 'https://www.agenziaplinio.it/servizi/punto-ritiro',
        'image' => 'https://qwyk4zaydta0yrkb.public.blob.vercel-storage.com/pudo-rOeNRrX3wtTc7XDpsj8AILJk9SKzZ3.png',
    ],
];
?>

<section class="section">
    <div class="container" data-animate="fade-up">
        <h1 class="title">I Nostri Servizi</h1>
        <p class="subtitle">Offriamo una vasta gamma di servizi per soddisfare tutte le tue esigenze quotidiane.</p>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="columns is-multiline is-variable is-6" data-stagger>
            <?php foreach ($services as $service): ?>
                <div class="column is-12-tablet is-one-third-desktop">
                    <div class="card service-card">
                        <div class="card-image">
                            <figure class="image is-4by3">
                                <img src="<?= htmlspecialchars($service['image']); ?>" alt="<?= sanitize($service['title']); ?>">
                            </figure>
                        </div>
                        <div class="card-content">
                            <h3 class="title is-4"><?= sanitize($service['title']); ?></h3>
                            <p><?= sanitize($service['description']); ?></p>
                            <a class="button is-warning is-light button-liquid" href="<?= htmlspecialchars($service['link']); ?>" target="_blank" rel="noopener noreferrer">Scopri di più</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>

<section class="section section-light">
    <div class="container">
        <div class="columns is-variable is-6">
            <div class="column">
                <h2 class="title">AG SERVIZI</h2>
                <p class="subtitle">La tua agenzia di servizi a Castellammare di Stabia. Offriamo una vasta gamma di servizi per soddisfare tutte le tue esigenze.</p>
                <div class="buttons">
                    <a class="button is-warning" href="https://www.facebook.com/agserviziplinio.it" target="_blank" rel="noopener noreferrer">Facebook</a>
                    <a class="button is-warning is-outlined" href="https://www.instagram.com/agenziaplinio" target="_blank" rel="noopener noreferrer">Instagram</a>
                </div>
            </div>
            <div class="column">
                <div class="columns">
                    <div class="column">
                        <h3 class="title is-5">Link Utili</h3>
                        <ul class="menu-list">
                            <li><a href="https://www.agenziaplinio.it/">Home</a></li>
                            <li><a href="https://www.agenziaplinio.it/chi-siamo">Chi Siamo</a></li>
                            <li><a href="https://www.agenziaplinio.it/dove-siamo">Dove Siamo</a></li>
                            <li><a href="https://www.agenziaplinio.it/contatti">Contatti</a></li>
                            <li><a href="https://www.agenziaplinio.it/faq">FAQ</a></li>
                            <li><a href="https://www.agenziaplinio.it/privacy-policy">Privacy Policy</a></li>
                            <li><a href="https://www.agenziaplinio.it/news">News</a></li>
                        </ul>
                    </div>
                    <div class="column">
                        <h3 class="title is-5">Link Legali</h3>
                        <ul class="menu-list">
                            <li><a href="https://www.agenziaplinio.it/privacy-policy">Privacy Policy</a></li>
                            <li><a href="https://www.agenziaplinio.it/cookie-policy">Cookie Policy</a></li>
                            <li><a href="https://www.agenziaplinio.it/termini-condizioni">Termini e Condizioni</a></li>
                            <li><a href="https://www.agenziaplinio.it/area-clienti">Area Clienti</a></li>
                            <li><a href="https://www.agenziaplinio.it/riscatto-voucher-iliad">Riscatto Voucher Iliad</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="columns is-variable is-6">
            <div class="column is-7">
                <h3 class="title is-4">Contatti</h3>
                <p>Via Plinio il Vecchio 72, Castellammare di Stabia (NA)</p>
                <p><a href="tel:+390810584542">+39 081 0584542</a></p>
                <p><a href="mailto:info@agenziaplinio.it">info@agenziaplinio.it</a></p>
                <p>Orari: Lun-Ven 9:00-13:20 / 16:00-19:20 &bull; Sab 9:00-13:00</p>
            </div>
            <div class="column is-5">
                <div class="box">
                    <p>&copy; 2025 AG SERVIZI VIA PLINIO 72. Tutti i diritti riservati.</p>
                    <p>P.IVA: 08442881218 &middot; REA: NA-985288</p>
                    <p>Conforme al GDPR (UE) 2016/679</p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
