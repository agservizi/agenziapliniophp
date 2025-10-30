<?php
require_once __DIR__ . '/../includes/auth.php';

$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;
$prodotto = $id ? get_product_by_id($id) : null;

if (!$prodotto) {
    http_response_code(404);
    $pageTitle = 'Prodotto non trovato';
    require_once __DIR__ . '/../includes/header.php';
    echo '<section class="mx-auto max-w-4xl px-6" data-animate="fade-up"><div class="glass-panel p-10 text-center"><h1 class="font-display text-3xl font-semibold text-white">Prodotto non trovato</h1><p class="mt-4 text-sm text-slate-300">Verifica il link oppure esplora le soluzioni disponibili nello shop.</p><a class="button-liquid mt-6 inline-flex items-center gap-2 rounded-full bg-accent-500 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-midnight-950 transition hover:bg-accent-400" href="/shop/index.php">Torna allo shop</a></div></section>';
    include __DIR__ . '/../includes/footer.php';
    return;
}

$pageTitle = sanitize($prodotto['nome']);
require_once __DIR__ . '/../includes/header.php';
?>
<section class="mx-auto max-w-6xl px-6" data-animate="fade-up">
    <div class="glass-panel overflow-hidden p-10 md:p-14">
        <div class="flex flex-col gap-4">
            <span class="badge-glow">Soluzione premium</span>
            <h1 class="font-display text-4xl font-semibold text-white md:text-5xl"><?= sanitize($prodotto['nome']); ?></h1>
            <p class="text-lg text-slate-300"><?= sanitize($prodotto['descrizione']); ?></p>
        </div>
    </div>
</section>

<section class="mx-auto mt-24 max-w-6xl px-6">
    <div class="grid gap-12 lg:grid-cols-[1.1fr,0.9fr]">
        <div data-animate="fade-right">
            <figure class="glass-panel overflow-hidden">
                <img class="h-full w-full object-cover" src="<?= asset($prodotto['immagine']); ?>" alt="<?= sanitize($prodotto['nome']); ?>" loading="lazy">
            </figure>
        </div>
        <div data-animate="fade-left">
            <div class="glass-panel p-8 md:p-10">
                <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Incluso nel pacchetto</p>
                <ul class="mt-5 space-y-3 text-sm text-slate-300">
                    <li class="flex items-start gap-3"><span class="mt-2 h-2 w-2 rounded-full bg-accent-400"></span><span>Sessioni consulenza dedicate</span></li>
                    <li class="flex items-start gap-3"><span class="mt-2 h-2 w-2 rounded-full bg-accent-400"></span><span>Documentazione e toolkit esclusivo</span></li>
                    <li class="flex items-start gap-3"><span class="mt-2 h-2 w-2 rounded-full bg-accent-400"></span><span>Supporto premium e onboarding</span></li>
                </ul>
                <p class="mt-8 text-2xl font-semibold text-accent-300">&euro; <?= format_currency((float) $prodotto['prezzo']); ?></p>
                <form class="mt-8 space-y-4" method="post" action="/shop/carrello.php">
                    <?= csrf_field(); ?>
                    <input type="hidden" name="id" value="<?= (int) $prodotto['id']; ?>">
                    <div class="flex items-center gap-4">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="quantita">Quantit&agrave;</label>
                        <input class="w-24 rounded-2xl border border-white/15 bg-midnight-900/70 px-3 py-2 text-sm text-slate-200 focus:border-accent-400 focus:outline-none" type="number" id="quantita" name="quantita" value="1" min="1">
                    </div>
                    <button class="button-liquid inline-flex items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" type="submit">Aggiungi al carrello</button>
                </form>
                <a class="mt-6 inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/shop/index.php">Torna allo shop</a>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
