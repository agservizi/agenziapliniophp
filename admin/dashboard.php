<?php
require_once __DIR__ . '/../includes/auth.php';
require_admin();
$pageTitle = 'Admin Dashboard';
require_once __DIR__ . '/../includes/header.php';

$stats = [
    ['label' => 'Fatturato mensile', 'value' => '€ 48.900'],
    ['label' => 'Ordini attivi', 'value' => '32'],
    ['label' => 'Utenti attivi', 'value' => '156'],
    ['label' => 'Servizi in rollout', 'value' => '12'],
];
?>
<section class="section section-dark" data-animate="fade-up">
    <div class="container">
        <h1 class="title">Dashboard amministrativa</h1>
        <p class="subtitle">Monitora KPI, gestisci utenti, ordini e servizi.</p>
    </div>
</section>
<section class="section">
    <div class="container">
        <div class="columns is-multiline" data-stagger>
            <?php foreach ($stats as $stat): ?>
                <div class="column is-one-quarter">
                    <div class="dashboard-widget">
                        <p class="heading"><?= sanitize($stat['label']); ?></p>
                        <p class="dashboard-metric"><?= sanitize($stat['value']); ?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="columns" data-animate="fade-up">
            <div class="column">
                <div class="dashboard-widget">
                    <p class="heading">Andamento ordini</p>
                    <canvas id="ordersChart" height="140"></canvas>
                </div>
            </div>
            <div class="column">
                <div class="dashboard-widget">
                    <p class="heading">Notifiche recenti</p>
                    <ul class="timeline">
                        <li><span class="dot"></span> Ordine #402 confermato in data odierna.</li>
                        <li><span class="dot"></span> Nuovo account enterprise registrato.</li>
                        <li><span class="dot"></span> Servizio Automation Hub aggiornato alla versione 4.2.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
(function () {
    const canvas = document.getElementById('ordersChart');
    if (!canvas) { return; }
    const ctx = canvas.getContext('2d');
    const ratio = window.devicePixelRatio || 1;
    canvas.width = canvas.clientWidth * ratio;
    canvas.height = canvas.clientHeight * ratio || 140 * ratio;
    ctx.scale(ratio, ratio);
    const points = [32, 45, 38, 52, 61, 55];
    const width = canvas.clientWidth;
    const height = canvas.clientHeight || 140;
    ctx.clearRect(0, 0, width, height);
    ctx.strokeStyle = '#ffbf00';
    ctx.lineWidth = 3;
    ctx.beginPath();
    points.forEach((value, index) => {
        const x = (width / (points.length - 1)) * index;
        const y = height - (value / 70) * (height - 20) - 10;
        if (index === 0) { ctx.moveTo(x, y); } else { ctx.lineTo(x, y); }
    });
    ctx.stroke();
})();
</script>
<?php include __DIR__ . '/../includes/footer.php'; ?>
