<?php
require_once __DIR__ . '/../includes/auth.php';

$categoria = $_GET['categoria'] ?? '';
$prodotti = get_products(['categoria' => $categoria]);

$pageTitle = 'Shop';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="mx-auto max-w-6xl px-6" data-animate="fade-up">
    <div class="glass-panel overflow-hidden p-10 md:p-14">
        <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
            <div class="space-y-3">
                <span class="badge-glow">Soluzioni e prodotti</span>
                <h1 class="font-display text-4xl font-semibold text-white md:text-5xl">Espandi il tuo ecosistema digitale</h1>
                <p class="text-lg text-slate-300">Seleziona moduli e servizi premium per potenziare i tuoi processi con onboarding rapido e supporto dedicato.</p>
            </div>
            <form method="get" class="flex flex-wrap items-center gap-4 text-sm text-slate-200">
                <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="categoria">Categoria</label>
                <select id="categoria" name="categoria" class="rounded-full border border-white/15 bg-midnight-900/70 px-4 py-2 text-sm text-slate-200 focus:border-accent-400 focus:outline-none" onchange="this.form.submit()">
                    <option value="">Tutte le categorie</option>
                    <option value="Consulenza" <?= $categoria === 'Consulenza' ? 'selected' : ''; ?>>Consulenza</option>
                    <option value="Automazione" <?= $categoria === 'Automazione' ? 'selected' : ''; ?>>Automazione</option>
                    <option value="Branding" <?= $categoria === 'Branding' ? 'selected' : ''; ?>>Branding</option>
                </select>
                <?php if ($categoria): ?>
                    <a class="inline-flex items-center gap-2 rounded-full border border-white/10 px-4 py-2 text-xs font-semibold uppercase tracking-[0.28em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/shop/index.php">Reset</a>
                <?php endif; ?>
            </form>
        </div>
    </div>
</section>

<section class="mx-auto mt-24 max-w-6xl px-6">
    <?php if (!$prodotti): ?>
        <div class="glass-panel p-10 text-center text-slate-300">
            Nessun prodotto disponibile in questa categoria.
        </div>
    <?php else: ?>
        <div class="grid gap-8 md:grid-cols-2 xl:grid-cols-3" data-stagger>
            <?php foreach ($prodotti as $prodotto): ?>
                <article class="glass-panel overflow-hidden p-6">
                    <figure class="relative overflow-hidden rounded-3xl">
                        <img class="h-56 w-full object-cover" src="<?= asset($prodotto['immagine']); ?>" alt="<?= sanitize($prodotto['nome']); ?>" loading="lazy">
                    </figure>
                    <h3 class="mt-6 text-xl font-semibold text-white"><?= sanitize($prodotto['nome']); ?></h3>
                    <p class="mt-3 text-sm text-slate-300"><?= sanitize($prodotto['descrizione']); ?></p>
                    <p class="mt-4 text-lg font-semibold text-accent-300">&euro; <?= format_currency((float) $prodotto['prezzo']); ?></p>
                    <div class="mt-6 flex flex-wrap gap-3">
                        <a class="button-liquid inline-flex items-center gap-2 rounded-full bg-accent-500 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-midnight-950 transition hover:bg-accent-400" href="/shop/prodotto.php?id=<?= (int) $prodotto['id']; ?>">Dettagli</a>
                        <form class="inline-flex" method="post" action="/shop/carrello.php">
                            <?= csrf_field(); ?>
                            <input type="hidden" name="id" value="<?= (int) $prodotto['id']; ?>">
                            <input type="hidden" name="quantita" value="1">
                            <button class="inline-flex items-center gap-2 rounded-full border border-white/10 px-5 py-2.5 text-xs font-semibold uppercase tracking-[0.32em] text-slate-200 transition hover:border-accent-500 hover:text-accent-400" data-add-cart type="submit">Aggiungi</button>
                        </form>
                    </div>
                </article>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
