<?php
require_once __DIR__ . '/../includes/auth.php';
require_auth();

$user = current_user();
$widgets = [
    ['label' => 'Servizi attivi', 'value' => 4],
    ['label' => 'Richieste aperte', 'value' => 2],
    ['label' => 'Documenti disponibili', 'value' => 9],
    ['label' => 'Ticket risolti', 'value' => 18],
];

$pageTitle = 'Dashboard cliente';
require_once __DIR__ . '/../includes/header.php';
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Bentornato <?= sanitize($user['nome']); ?></h1>
        <p class="subtitle">Monitora i tuoi servizi, documenti e richieste in tempo reale.</p>
    </div>
</section>
<section class="section">
    <div class="container" data-stagger>
        <div class="columns is-multiline">
            <?php foreach ($widgets as $widget): ?>
                <div class="column is-one-quarter">
                    <div class="dashboard-widget" data-counter="<?= (int) $widget['value']; ?>">
                        <p class="heading"><?= sanitize($widget['label']); ?></p>
                        <p class="dashboard-metric">0</p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="columns" data-animate="fade-up">
            <div class="column">
                <div class="dashboard-widget">
                    <p class="heading">Stato richieste</p>
                    <canvas id="requestsChart" height="140"></canvas>
                </div>
            </div>
            <div class="column">
                <div class="dashboard-widget">
                    <p class="heading">Timeline attività</p>
                    <ul class="timeline">
                        <li><span class="dot"></span> Richiesta onboarding automatizzazioni approvata.</li>
                        <li><span class="dot"></span> Nuovo documento disponibile: Report trimestrale KPI.</li>
                        <li><span class="dot"></span> Ticket #245 risolto con esito positivo.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    const canvas = document.getElementById('requestsChart');
    if (!canvas) {
        return;
    }
    const ctx = canvas.getContext('2d');
    const ratio = window.devicePixelRatio || 1;
    canvas.width = canvas.clientWidth * ratio;
    canvas.height = canvas.clientHeight * ratio || 140 * ratio;
    ctx.scale(ratio, ratio);
    const bars = [60, 35, 20];
    const labels = ['In corso', 'In revisione', 'Completate'];
    const width = canvas.clientWidth;
    const height = canvas.clientHeight || 140;
    const barWidth = width / bars.length - 40;

    ctx.clearRect(0, 0, width, height);
    ctx.font = '14px Poppins';
    ctx.fillStyle = '#ffbf00';

    bars.forEach((value, index) => {
        const x = 40 + index * (barWidth + 40);
        const barHeight = (value / 100) * (height - 40);
        const y = height - barHeight - 20;
        const gradient = ctx.createLinearGradient(0, y, 0, height);
        gradient.addColorStop(0, 'rgba(255, 191, 0, 0.9)');
        gradient.addColorStop(1, 'rgba(255, 191, 0, 0.3)');
        ctx.fillStyle = gradient;
        ctx.fillRect(x, y, barWidth, barHeight);
        ctx.fillStyle = '#ffbf00';
        ctx.fillText(labels[index], x, height - 2);
    });
})();
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
