<?php
require_once __DIR__ . '/../includes/functions.php';

if (!isset($serviceSlug) || !is_string($serviceSlug)) {
    header('Location: ' . asset('servizi.php'));
    exit;
}

$services = require __DIR__ . '/../includes/services-data.php';
$service = null;
foreach ($services as $item) {
    if (($item['slug'] ?? '') === $serviceSlug) {
        $service = $item;
        break;
    }
}

if ($service === null) {
    header('Location: ' . asset('servizi.php'));
    exit;
}

$pageTitle = $service['name'] ?? 'Servizio';
require_once __DIR__ . '/../includes/header.php';

$tagline = $service['tagline'] ?? '';
$intro = $service['intro'] ?? '';
$focusItems = $service['focus'] ?? [];
$ctaItems = $service['cta'] ?? [];
$solutions = $service['solutions'] ?? [];
$requirements = $service['requirements'] ?? [];
$reminders = $service['reminders'] ?? [];
$otherServices = array_filter($services, static function (array $item) use ($serviceSlug): bool {
    return ($item['slug'] ?? null) !== $serviceSlug;
});
?>

<section class="section service-detail-hero">
    <div class="container" data-animate="fade-up">
        <a class="service-breadcrumb" href="<?= asset('servizi.php'); ?>">&larr; Tutti i servizi</a>
        <div class="service-detail-hero__card">
            <div class="service-detail-hero__header">
                <span class="service-detail-icon" aria-hidden="true"><?= sanitize($service['icon'] ?? '⭐'); ?></span>
                <div>
                    <p class="service-eyebrow">Servizio certificato</p>
                    <h1 class="title is-2"><?= sanitize($service['name']); ?></h1>
                    <?php if ($tagline !== ''): ?>
                        <p class="service-detail-tagline"><?= sanitize($tagline); ?></p>
                    <?php endif; ?>
                </div>
            </div>
            <?php if ($intro !== ''): ?>
                <p class="service-detail-intro"><?= sanitize($intro); ?></p>
            <?php endif; ?>

            <?php if (!empty($focusItems)): ?>
                <div class="service-detail-focus" role="list">
                    <?php foreach ($focusItems as $focus): ?>
                        <span class="service-detail-chip" role="listitem"><?= sanitize($focus); ?></span>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <?php if (!empty($ctaItems)): ?>
                <div class="service-detail-actions">
                    <?php foreach ($ctaItems as $cta): ?>
                        <a class="button is-warning<?= !empty($cta['class']) ? ' ' . htmlspecialchars($cta['class']) : ''; ?>" href="<?= htmlspecialchars($cta['url']); ?>"<?= !empty($cta['external']) ? ' target="_blank" rel="noopener noreferrer"' : ''; ?>><?= sanitize($cta['label']); ?></a>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section>

<section class="section service-detail-body">
    <div class="container">
        <?php if (!empty($solutions)): ?>
            <div class="service-detail-section" data-animate="fade-up">
                <h2 class="title is-3">Cosa possiamo fare per te</h2>
                <div class="columns is-multiline is-variable is-5">
                    <?php foreach ($solutions as $solution): ?>
                        <div class="column is-12-tablet is-6-desktop">
                            <div class="service-detail-solution">
                                <h3 class="title is-5"><?= sanitize($solution['title']); ?></h3>
                                <?php if (!empty($solution['items'])): ?>
                                    <ul class="service-list">
                                        <?php foreach ($solution['items'] as $item): ?>
                                            <li><?= sanitize($item); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endif; ?>

        <?php if (!empty($requirements) || !empty($reminders)): ?>
            <div class="service-detail-section" data-animate="fade-up">
                <div class="columns is-variable is-5">
                    <?php if (!empty($requirements)): ?>
                        <div class="column">
                            <div class="service-detail-meta">
                                <p class="heading">Cosa portare</p>
                                <ul class="service-list">
                                    <?php foreach ($requirements as $item): ?>
                                        <li><?= sanitize($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (!empty($reminders)): ?>
                        <div class="column">
                            <div class="service-detail-meta">
                                <p class="heading">Promemoria</p>
                                <ul class="service-list">
                                    <?php foreach ($reminders as $item): ?>
                                        <li><?= sanitize($item); ?></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</section>

<?php if (!empty($otherServices)): ?>
<section class="section section-light service-detail-related">
    <div class="container" data-animate="fade-up">
        <div class="service-detail-related__header">
            <span class="service-eyebrow">Esplora anche</span>
            <h2 class="title is-4">Altri servizi disponibili in agenzia</h2>
        </div>
        <div class="service-detail-related__grid">
            <?php foreach ($otherServices as $item): ?>
                <a class="service-detail-related__card" href="<?= asset('servizi/' . $item['slug'] . '.php'); ?>">
                    <span class="service-detail-related__icon" aria-hidden="true"><?= sanitize($item['icon']); ?></span>
                    <div>
                        <p class="service-detail-related__name"><?= sanitize($item['name']); ?></p>
                        <p class="service-detail-related__tagline"><?= sanitize($item['tagline']); ?></p>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>

<?php require_once __DIR__ . '/../includes/footer.php'; ?>
