<?php
require_once __DIR__ . '/../includes/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$prodotto = $id ? get_product_by_id($id) : null;

if (!$prodotto) {
    http_response_code(404);
    $pageTitle = 'Prodotto non trovato';
    require_once __DIR__ . '/../includes/header.php';
    echo '<section class="section"><div class="container"><h1 class="title">Prodotto non trovato</h1></div></section>';
    include __DIR__ . '/../includes/footer.php';
    return;
}

$pageTitle = sanitize($prodotto['nome']);
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark">
    <div class="container" data-animate="fade-up">
        <h1 class="title"><?= sanitize($prodotto['nome']); ?></h1>
        <p class="subtitle"><?= sanitize($prodotto['descrizione']); ?></p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns is-vcentered">
            <div class="column is-half" data-animate="fade-right">
                <figure class="image is-3by2" style="border-radius: 22px; overflow: hidden;">
                    <img src="<?= asset($prodotto['immagine']); ?>" alt="<?= sanitize($prodotto['nome']); ?>" loading="lazy">
                </figure>
            </div>
            <div class="column is-half" data-animate="fade-left">
                <div class="dashboard-widget">
                    <p class="heading">Incluso nel pacchetto</p>
                    <ul>
                        <li>Sessioni consulenza dedicate</li>
                        <li>Documentazione e toolkit esclusivo</li>
                        <li>Supporto premium e onboarding</li>
                    </ul>
                    <p class="title is-4" style="margin-top: 16px;">€ <?= format_currency((float) $prodotto['prezzo']); ?></p>
                    <form method="post" action="/shop/carrello.php" class="field">
                        <?= csrf_field(); ?>
                        <input type="hidden" name="id" value="<?= (int) $prodotto['id']; ?>">
                        <div class="field has-addons">
                            <div class="control">
                                <input class="input" type="number" name="quantita" value="1" min="1">
                            </div>
                            <div class="control">
                                <button class="button is-warning button-liquid" type="submit">Aggiungi al carrello</button>
                            </div>
                        </div>
                    </form>
                    <a href="/shop/index.php" class="button is-light" style="margin-top: 12px;">Torna allo shop</a>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
