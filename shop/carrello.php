<?php
require_once __DIR__ . '/../includes/auth.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!validate_csrf()) {
        flash('danger', 'Token CSRF non valido.');
        header('Location: /shop/index.php');
        exit();
    }
    $id = (int) ($_POST['id'] ?? 0);
    $quantita = max(1, (int) ($_POST['quantita'] ?? 1));
    $prodotto = get_product_by_id($id);
    if ($prodotto) {
        $_SESSION['cart'][$id] = [
            'id' => $id,
            'nome' => $prodotto['nome'],
            'prezzo' => (float) $prodotto['prezzo'],
            'quantita' => ($_SESSION['cart'][$id]['quantita'] ?? 0) + $quantita,
        ];
        flash('success', 'Prodotto aggiunto al carrello.');
        header('Location: /shop/carrello.php');
        exit();
    }
    flash('warning', 'Prodotto non disponibile.');
    header('Location: /shop/index.php');
    exit();
}

if (isset($_GET['remove'])) {
    $removeId = (int) $_GET['remove'];
    unset($_SESSION['cart'][$removeId]);
    flash('success', 'Prodotto rimosso dal carrello.');
    header('Location: /shop/carrello.php');
    exit();
}

$cart = $_SESSION['cart'] ?? [];
$totale = array_reduce($cart, fn($carry, $item) => $carry + ($item['prezzo'] * $item['quantita']), 0.0);

$pageTitle = 'Carrello';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Carrello</h1>
        <p class="subtitle">Riepilogo moduli e soluzioni selezionate.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <?php if (!$cart): ?>
            <p>Il carrello è vuoto. <a href="/shop/index.php">Scopri i nostri prodotti.</a></p>
        <?php else: ?>
            <div class="table-container" data-animate="fade-up">
                <table class="table is-fullwidth is-dark">
                    <thead>
                        <tr>
                            <th>Prodotto</th>
                            <th>Quantità</th>
                            <th>Prezzo</th>
                            <th>Totale</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cart as $item): ?>
                            <tr>
                                <td><?= sanitize($item['nome']); ?></td>
                                <td><?= (int) $item['quantita']; ?></td>
                                <td>€ <?= format_currency($item['prezzo']); ?></td>
                                <td>€ <?= format_currency($item['prezzo'] * $item['quantita']); ?></td>
                                <td><a class="button is-small is-light" href="?remove=<?= (int) $item['id']; ?>">Rimuovi</a></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
            <div class="columns">
                <div class="column is-offset-8 is-4">
                    <div class="dashboard-widget" data-animate="fade-left">
                        <p class="heading">Totale</p>
                        <p class="title is-4">€ <?= format_currency($totale); ?></p>
                        <a class="button is-warning is-fullwidth" href="/shop/checkout.php">Procedi al checkout</a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>
<?php include __DIR__ . '/../includes/footer.php'; ?>
