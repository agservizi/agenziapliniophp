<?php
require_once __DIR__ . '/../includes/auth.php';

$cart = $_SESSION['cart'] ?? [];
if (!$cart) {
    flash('warning', 'Il carrello &egrave; vuoto.');
    header('Location: /shop/index.php');
    exit();
}

$totale = array_reduce($cart, fn($carry, $item) => $carry + ($item['prezzo'] * $item['quantita']), 0.0);

$pageTitle = 'Checkout';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="mx-auto max-w-6xl px-6" data-animate="fade-up">
    <div class="glass-panel overflow-hidden p-10 md:p-14">
        <span class="badge-glow">Checkout</span>
        <h1 class="mt-4 font-display text-4xl font-semibold text-white md:text-5xl">Inserisci i dati di fatturazione</h1>
        <p class="mt-3 text-lg text-slate-300">Conferma l&apos;ordine completando i campi richiesti. Riceverai la fattura e il contratto digitale entro poche ore.</p>
    </div>
</section>

<section class="mx-auto mt-24 max-w-6xl px-6">
    <div class="grid gap-12 lg:grid-cols-[1.15fr,0.85fr]">
        <div data-animate="fade-right">
            <form class="glass-panel p-8 md:p-10" method="post" action="/shop/conferma.php">
                <?= csrf_field(); ?>
                <div class="grid gap-6 md:grid-cols-2">
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="nome">Nome</label>
                        <input id="nome" name="nome" required>
                    </div>
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="cognome">Cognome</label>
                        <input id="cognome" name="cognome" required>
                    </div>
                </div>
                <div class="mt-6 space-y-6">
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="email">Email</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="azienda">Azienda</label>
                        <input id="azienda" name="azienda" required>
                    </div>
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="piva">P.IVA / Codice fiscale</label>
                        <input id="piva" name="piva" required>
                    </div>
                    <div class="grid gap-6 md:grid-cols-2">
                        <div class="form-field">
                            <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="indirizzo">Indirizzo</label>
                            <input id="indirizzo" name="indirizzo" required>
                        </div>
                        <div class="form-field">
                            <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="citta">Citt&agrave;</label>
                            <input id="citta" name="citta" required>
                        </div>
                    </div>
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="note">Note</label>
                        <textarea id="note" name="note" rows="3"></textarea>
                    </div>
                </div>
                <button class="button-liquid mt-8 inline-flex w-full items-center justify-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400" type="submit">Conferma ordine</button>
            </form>
        </div>
        <div data-animate="fade-left">
            <div class="glass-panel p-8 md:p-10">
                <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Riepilogo ordine</p>
                <ul class="mt-5 space-y-3 text-sm text-slate-300">
                    <?php foreach ($cart as $item): ?>
                        <li class="flex items-center justify-between">
                            <span><?= sanitize($item['nome']); ?></span>
                            <span class="rounded-full border border-white/10 px-3 py-1 text-xs uppercase tracking-[0.3em]">&times; <?= (int) $item['quantita']; ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
                <p class="mt-8 text-2xl font-semibold text-accent-300">Totale &euro; <?= format_currency($totale); ?></p>
                <p class="mt-3 text-xs uppercase tracking-[0.3em] text-slate-400">Pagamento sicuro con conferma contrattuale successiva.</p>
                <p class="mt-4 text-xs text-slate-400">Procedendo accetti le condizioni generali e autorizzi il trattamento dei dati per finalit&agrave; amministrative.</p>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/../includes/footer.php'; ?>
