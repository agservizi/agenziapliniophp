<?php
$pageTitle = 'Contatti';
require_once __DIR__ . '/includes/header.php';
?>

<section class="mx-auto max-w-4xl px-6" data-animate="fade-up">
    <div class="glass-panel overflow-hidden p-10 text-center md:p-14 md:text-left">
        <span class="badge-glow">Parliamo del tuo progetto</span>
        <h1 class="mt-6 font-display text-4xl font-semibold text-white md:text-5xl">Un canale diretto con il nostro team</h1>
        <p class="mt-6 text-lg text-slate-300">Compila il form e sarai ricontattato entro 24 ore lavorative con una proposta personalizzata e i prossimi step operativi.</p>
    </div>
</section>

<section class="mx-auto mt-24 max-w-6xl px-6">
    <div class="grid gap-12 lg:grid-cols-[1.05fr,0.95fr]">
        <div data-animate="fade-right">
            <form class="glass-panel p-8 md:p-10" method="post" action="/form/contatti.php" novalidate>
                <?= csrf_field(); ?>
                <div class="space-y-6">
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="nome">Nome e cognome</label>
                        <input type="text" id="nome" name="nome" required>
                    </div>
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="email">Email aziendale</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="azienda">Azienda</label>
                        <input type="text" id="azienda" name="azienda" required>
                    </div>
                    <div class="form-field">
                        <label class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400" for="messaggio">Messaggio</label>
                        <textarea id="messaggio" name="messaggio" rows="5" required></textarea>
                    </div>
                    <div class="flex justify-end">
                        <button type="submit" class="button-liquid inline-flex items-center gap-2 rounded-full bg-accent-500 px-6 py-3 text-sm font-semibold uppercase tracking-[0.24em] text-midnight-950 transition hover:bg-accent-400">Invia richiesta</button>
                    </div>
                </div>
            </form>
        </div>
        <div data-animate="fade-left">
            <div class="glass-panel p-8 md:p-10">
                <h2 class="text-2xl font-semibold text-white">Hub Milano</h2>
                <p class="mt-3 text-sm text-slate-300">Via Innovazione 21, 20159 Milano</p>
                <p class="text-sm text-slate-300">supporto@agenziaplinio.local</p>
                <p class="text-sm text-slate-300">+39 02 1234 5678</p>
                <div class="my-6 h-px w-full bg-white/10"></div>
                <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Orari</p>
                <p class="mt-3 text-sm text-slate-300">Lun-Ven 09:00-18:30</p>
                <p class="text-sm text-slate-300">Disponibilit&agrave; meeting anche in remoto con il team multidisciplinare.</p>
                <div class="mt-6 rounded-2xl border border-white/10 bg-midnight-900/60 p-6">
                    <p class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-400">Preferisci un contatto diretto?</p>
                    <div class="mt-4 space-y-3 text-sm text-slate-200">
                        <a class="block transition hover:text-accent-300" href="tel:+390810584542">Chiama la sede centrale</a>
                        <a class="block transition hover:text-accent-300" href="mailto:info@agenziaplinio.it">Scrivi al supporto</a>
                        <a class="block transition hover:text-accent-300" href="https://wa.me/393773798570?text=Ho%20bisogno%20di%20assistenza" target="_blank" rel="noopener noreferrer">Apri chat WhatsApp</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php include __DIR__ . '/includes/footer.php'; ?>
