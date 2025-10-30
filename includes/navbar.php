<?php
$user = current_user();
$navLinks = [
    ['label' => 'Inizio', 'href' => '/#intro'],
    ['label' => 'Chi siamo', 'href' => '/#chi-siamo'],
    ['label' => 'Servizi', 'href' => '/#servizi'],
    ['label' => 'Processo', 'href' => '/#processo'],
    ['label' => 'Shop', 'href' => '/#shop'],
    ['label' => 'Contatti', 'href' => '/#contatti'],
];
?>
<header class="fixed inset-x-0 top-0 z-[998]">
    <div class="mx-auto max-w-8xl px-6">
        <nav class="nav-surface relative overflow-hidden rounded-3xl border border-white/10 bg-midnight-900/80 px-4 shadow-frosted backdrop-blur-xl transition-colors duration-500 sm:px-6" data-nav>
            <div class="flex h-20 items-center justify-between">
                <a class="flex items-center gap-3 font-display text-lg font-semibold text-white" href="/">
                    <span class="grid h-11 w-11 place-items-center rounded-2xl bg-gradient-to-br from-accent-500 to-accent-600 text-midnight-950">AP</span>
                    <span class="tracking-wide">Agenzia Plinio</span>
                </a>
                <div class="hidden items-center gap-10 md:flex">
                    <?php foreach ($navLinks as $link): ?>
                        <a class="text-xs font-semibold uppercase tracking-[0.32em] text-slate-300 transition hover:text-accent-400" href="<?= htmlspecialchars($link['href']); ?>" data-nav-link>
                            <?= sanitize($link['label']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="hidden items-center gap-4 md:flex">
                    <?php if ($user): ?>
                        <span class="hidden text-sm text-slate-300 lg:inline-flex lg:items-center lg:gap-2">
                            <span class="grid h-9 w-9 place-items-center rounded-2xl bg-accent-500/20 text-accent-300 text-xs uppercase">
                                <?= sanitize(mb_substr($user['nome'], 0, 2)); ?>
                            </span>
                            <?= sanitize($user['nome']); ?>
                        </span>
                        <a class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/user/dashboard.php">Dashboard</a>
                        <?php if (($user['ruolo'] ?? '') === 'admin'): ?>
                            <a class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/admin/dashboard.php">Admin</a>
                        <?php endif; ?>
                        <form method="post" action="/user/logout.php">
                            <?= csrf_field(); ?>
                            <button type="submit" class="rounded-full bg-accent-500 px-4 py-2 text-sm font-semibold text-midnight-950 transition hover:bg-accent-400">Esci</button>
                        </form>
                    <?php else: ?>
                        <a class="rounded-full border border-white/10 px-4 py-2 text-sm font-medium text-slate-200 transition hover:border-accent-500 hover:text-accent-400" href="/user/login.php">Accedi</a>
                        <a class="rounded-full bg-accent-500 px-4 py-2 text-sm font-semibold text-midnight-950 transition hover:bg-accent-400" href="/user/register.php">Registrati</a>
                    <?php endif; ?>
                </div>
                <button type="button" class="inline-flex h-11 w-11 items-center justify-center rounded-2xl border border-white/10 text-slate-200 transition hover:text-accent-400 md:hidden" data-nav-toggle aria-expanded="false" aria-label="Apri men&ugrave;">
                    <svg class="h-5 w-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 7h16M4 12h16M4 17h16" />
                    </svg>
                </button>
            </div>
            <div class="hidden flex-col gap-4 border-t border-white/10 py-6 md:hidden" data-nav-panel>
                <div class="flex flex-col gap-3">
                    <?php foreach ($navLinks as $link): ?>
                        <a class="rounded-2xl border border-transparent px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-accent-500/40 hover:text-accent-400" href="<?= htmlspecialchars($link['href']); ?>" data-nav-link>
                            <?= sanitize($link['label']); ?>
                        </a>
                    <?php endforeach; ?>
                </div>
                <div class="h-px bg-white/10"></div>
                <div class="flex flex-col gap-3">
                    <?php if ($user): ?>
                        <span class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-medium text-slate-300">
                            <?= sanitize($user['nome']); ?>
                        </span>
                        <a class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-accent-500/40 hover:text-accent-400" href="/user/dashboard.php">Dashboard</a>
                        <?php if (($user['ruolo'] ?? '') === 'admin'): ?>
                            <a class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-accent-500/40 hover:text-accent-400" href="/admin/dashboard.php">Admin</a>
                        <?php endif; ?>
                        <form method="post" action="/user/logout.php">
                            <?= csrf_field(); ?>
                            <button type="submit" class="w-full rounded-2xl bg-accent-500 px-4 py-3 text-sm font-semibold text-midnight-950 transition hover:bg-accent-400">Esci</button>
                        </form>
                    <?php else: ?>
                        <a class="rounded-2xl border border-white/10 px-4 py-3 text-sm font-medium text-slate-200 transition hover:border-accent-500/40 hover:text-accent-400" href="/user/login.php">Accedi</a>
                        <a class="rounded-2xl bg-accent-500 px-4 py-3 text-sm font-semibold text-midnight-950 transition hover:bg-accent-400" href="/user/register.php">Registrati</a>
                    <?php endif; ?>
                </div>
            </div>
        </nav>
    </div>
</header>
