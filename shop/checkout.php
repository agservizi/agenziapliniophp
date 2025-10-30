<?php
require_once __DIR__ . '/../includes/auth.php';

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    flash('warning', 'Il carrello è vuoto.');
    header('Location: /shop/index.php');
    exit();
}

$totale = array_reduce($cart, fn($carry, $item) => $carry + ($item['prezzo'] * $item['quantita']), 0.0);

$pageTitle = 'Checkout';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Checkout</h1>
        <p class="subtitle">Inserisci i dati di fatturazione e conferma l&apos;ordine.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns">
            <div class="column is-two-thirds" data-animate="fade-right">
                <form class="box" method="post" action="/shop/conferma.php">
                    <?= csrf_field(); ?>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Nome</label>
                                <div class="control">
                                    <input class="input" name="nome" required>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Cognome</label>
                                <div class="control">
                                    <input class="input" name="cognome" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Email</label>
                        <div class="control">
                            <input class="input" type="email" name="email" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Azienda</label>
                        <div class="control">
                            <input class="input" name="azienda" required>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">P.IVA / Codice fiscale</label>
                        <div class="control">
                            <input class="input" name="piva" required>
                        </div>
                    </div>
                    <div class="columns">
                        <div class="column">
                            <div class="field">
                                <label class="label">Indirizzo</label>
                                <div class="control">
                                    <input class="input" name="indirizzo" required>
                                </div>
                            </div>
                        </div>
                        <div class="column">
                            <div class="field">
                                <label class="label">Città</label>
                                <div class="control">
                                    <input class="input" name="citta" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="field">
                        <label class="label">Note</label>
                        <div class="control">
                            <textarea class="textarea" name="note" rows="3"></textarea>
                        </div>
                    </div>
                    <button class="button is-warning is-fullwidth" type="submit">Conferma ordine</button>
                </form>
            </div>
            <div class="column" data-animate="fade-left">
                <div class="dashboard-widget">
                    <p class="heading">Riepilogo ordine</p>
                    <ul>
                        <?php foreach ($cart as $item): ?>
                            <li><?= sanitize($item['nome']); ?> × <?= (int) $item['quantita']; ?></li>
                        <?php endforeach; ?>
                    </ul>
                    <p class="title is-4" style="margin-top: 18px;">Totale: € <?= format_currency($totale); ?></p>
                    <p class="is-size-7">Pagamento sicuro con conferma contrattuale successiva.</p>
                </div>
            </div>
        </div>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
