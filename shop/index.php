<?php
require_once __DIR__ . '/../includes/auth.php';

$categoria = $_GET['categoria'] ?? '';
$prodotti = get_products(['categoria' => $categoria]);

$pageTitle = 'Shop';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark">
    <div class="container" data-animate="fade-up">
        <h1 class="title">Soluzioni e prodotti</h1>
        <p class="subtitle">Seleziona moduli e servizi premium per espandere il tuo ecosistema digitale.</p>
        <form method="get" class="field is-grouped" style="margin-top: 24px;">
            <div class="control">
                <div class="select">
                    <select name="categoria" onchange="this.form.submit()">
                        <option value="">Tutte le categorie</option>
                        <option value="Consulenza" <?= $categoria === 'Consulenza' ? 'selected' : ''; ?>>Consulenza</option>
                        <option value="Automazione" <?= $categoria === 'Automazione' ? 'selected' : ''; ?>>Automazione</option>
                        <option value="Branding" <?= $categoria === 'Branding' ? 'selected' : ''; ?>>Branding</option>
                    </select>
                </div>
            </div>
            <?php if ($categoria): ?>
                <div class="control">
                    <a href="/shop/index.php" class="button is-light">Reset</a>
                </div>
            <?php endif; ?>
        </form>
    </div>
</section>
<section class="section">
    <div class="container">
        <?php if (!$prodotti): ?>
            <p>Nessun prodotto disponibile in questa categoria.</p>
        <?php else: ?>
            <div class="columns is-multiline" data-stagger>
                <?php foreach ($prodotti as $prodotto): ?>
                    <div class="column is-one-third">
                        <div class="card service-card">
                            <figure class="image is-4by3" style="border-radius: 16px; overflow: hidden; margin-bottom: 16px;">
                                <img src="<?= asset($prodotto['immagine']); ?>" alt="<?= sanitize($prodotto['nome']); ?>" loading="lazy">
                            </figure>
                            <h3 class="title is-4"><?= sanitize($prodotto['nome']); ?></h3>
                            <p><?= sanitize($prodotto['descrizione']); ?></p>
                            <p class="title is-5" style="margin: 12px 0;">€ <?= format_currency((float) $prodotto['prezzo']); ?></p>
                            <div class="buttons">
                                <a class="button is-warning button-liquid" href="/shop/prodotto.php?id=<?= (int) $prodotto['id']; ?>">Dettagli</a>
                                <form method="post" action="/shop/carrello.php">
                                    <?= csrf_field(); ?>
                                    <input type="hidden" name="id" value="<?= (int) $prodotto['id']; ?>">
                                    <input type="hidden" name="quantita" value="1">
                                    <button class="button is-warning is-outlined" data-add-cart type="submit">Aggiungi</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
