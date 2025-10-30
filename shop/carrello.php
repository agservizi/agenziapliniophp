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
<section class="mx-auto max-w-6xl px-6" data-animate="fade-up">
    <div class="glass-panel overflow-hidden p-10 md:p-14">
        <span class="badge-glow">Riepilogo acquisti</span>
        <h1 class="mt-4 font-display text-4xl font-semibold text-white md:text-5xl">Carrello</h1>
        <p class="mt-3 text-lg text-slate-300">Controlla i moduli selezionati prima di procedere al checkout.</p>
    </div>
</section>

<section class="mx-auto mt-24 max-w-6xl px-6">
    <?php if (!$cart): ?>
        <div class="glass-panel p-10 text-center text-slate-300">
            Il carrello &egrave; vuoto. <a class="text-accent-300 underline-offset-4 transition hover:text-accent-200" href="/shop/index.php">Scopri i nostri prodotti.</a>
        </div>
    <?php else: ?>
        <div class="grid gap-8 lg:grid-cols-[1.1fr,0.9fr]">
            <div class="space-y-6" data-stagger>
                <?php foreach ($cart as $item): ?>
                    <article class="glass-panel p-6">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <div>
                                <h2 class="text-lg font-semibold text-white"><?= sanitize($item['nome']); ?></h2>
                                <div class="mt-3 flex flex-wrap gap-4 text-sm text-slate-300">
                                    <span class="rounded-full border border-white/10 px-3 py-1 uppercase tracking-[0.28em]">Quantit&agrave; <?= (int) $item['quantita']; ?></span>
                                    <span class="rounded-full border border-white/10 px-3 py-1 uppercase tracking-[0.28em]">Prezzo &euro; <?= format_currency($item['prezzo']); ?></span>
                                </div>
                            </div>
                            <div class="flex flex-col items-end gap-3 text-right">
                                <span class="text-base font-semibold text-accent-300">Totale &euro; <?= format_currency($item['prezzo'] * $item['quantita']); ?></span>
                                <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.32em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="?remove=<?= (int) $item['id']; ?>">Rimuovi</a>
                            </div>
                        </div>
                    </article>
                <?php endforeach; ?>
            </div>
            <div class="space-y-6" data-animate="fade-left">
                <div class="glass-panel p-8">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Totale ordine</p>
                    <p class="mt-4 text-3xl font-semibold text-accent-300">&euro; <?= format_currency($totale); ?></p>
                    <p class="mt-2 text-sm text-slate-300">Le tasse saranno calcolate al momento del checkout.</p>
                    <a class="button-liquid mt-6 inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" href="/shop/checkout.php">Procedi al checkout</a>
                </div>
                <div class="rounded-3xl border border-white/10 bg-midnight-900/50 p-6 text-sm text-slate-300">
                    <p><strong class="text-slate-100">Suggerimento:</strong> puoi modificare le quantit&agrave; dei prodotti nella pagina di dettaglio prima di aggiornare il carrello.</p>
                </div>
            </div>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
