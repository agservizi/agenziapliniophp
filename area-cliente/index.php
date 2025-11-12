<?php
require_once '../includes/config.php';
require_once '../includes/auth.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: login');
    exit;
}

$user = $_SESSION['user_data'];
$user_id = $_SESSION['utente_id'];

$page_title = 'Area Cliente - Dashboard';
$page_description = 'La tua area personale per gestire ordini, preferiti e profilo.';
$current_page = 'area-cliente';

try {
    $pdo = getDBConnection();
    
    // Get user statistics
    $stats_stmt = $pdo->prepare("
        SELECT 
            (SELECT COUNT(*) FROM ordini WHERE utente_id = :user_id) as total_orders,
            (SELECT COUNT(*) FROM ordini WHERE utente_id = :user_id AND stato = 'completato') as completed_orders,
            (SELECT COALESCE(SUM(totale), 0) FROM ordini WHERE utente_id = :user_id AND stato = 'completato') as total_spent,
            (SELECT COUNT(*) FROM ticket_assistenza WHERE utente_id = :user_id) as total_tickets,
            (SELECT COUNT(*) FROM ticket_assistenza WHERE utente_id = :user_id AND stato = 'aperto') as open_tickets
    ");
    $stats_stmt->execute(['user_id' => $user_id]);
    $stats = $stats_stmt->fetch(PDO::FETCH_ASSOC);
    
    // Get recent orders
    $orders_stmt = $pdo->prepare("
        SELECT o.*, COUNT(od.id) as items_count
        FROM ordini o
        LEFT JOIN ordini_dettagli od ON o.id = od.ordine_id
        WHERE o.utente_id = :user_id
        GROUP BY o.id
        ORDER BY o.created_at DESC
        LIMIT 5
    ");
    $orders_stmt->execute(['user_id' => $user_id]);
    $recent_orders = $orders_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recent tickets
    $tickets_stmt = $pdo->prepare("
        SELECT t.*
        FROM ticket_assistenza t
        WHERE t.utente_id = :user_id
        ORDER BY t.created_at DESC
        LIMIT 5
    ");
    $tickets_stmt->execute(['user_id' => $user_id]);
    $recent_tickets = $tickets_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Get recent activity
    $activity_stmt = $pdo->prepare("
        SELECT *
        FROM activity_logs
        WHERE utente_id = :user_id
        ORDER BY created_at DESC
        LIMIT 10
    ");
    $activity_stmt->execute(['user_id' => $user_id]);
    $recent_activity = $activity_stmt->fetchAll(PDO::FETCH_ASSOC);
    
} catch (PDOException $e) {
    error_log("Client area error: " . $e->getMessage());
    $stats = [
        'total_orders' => 0,
        'completed_orders' => 0,
        'total_spent' => 0,
        'total_tickets' => 0,
        'open_tickets' => 0
    ];
    $recent_orders = [];
    $recent_tickets = [];
    $recent_activity = [];
}

include '../includes/header.php';
?>

<main class="client-area">
    <!-- Page Header -->
    <section class="page-header">
        <div class="container">
            <div class="header-content">
                <div class="welcome-section">
                    <h1>Benvenuto, <?= htmlspecialchars($user['nome']) ?>!</h1>
                    <p>Gestisci i tuoi ordini, preferiti e impostazioni del profilo</p>
                </div>
                <div class="header-actions">
                    <a href="../shop" class="btn btn-outline-primary">
                        <i class="icon-shopping-bag"></i> Vai allo Shop
                    </a>
                    <a href="nuovo-ticket" class="btn btn-primary">
                        <i class="icon-headphones"></i> Assistenza
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Dashboard Stats -->
    <section class="dashboard-stats">
        <div class="container">
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-icon orders">
                        <i class="icon-shopping-bag"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?= $stats['total_orders'] ?></div>
                        <div class="stat-label">Ordini Totali</div>
                        <div class="stat-sublabel"><?= $stats['completed_orders'] ?> completati</div>
                    </div>
                    <a href="ordini" class="stat-link">
                        <i class="icon-arrow-right"></i>
                    </a>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon spending">
                        <i class="icon-euro"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">€<?= number_format($stats['total_spent'], 2) ?></div>
                        <div class="stat-label">Speso in Totale</div>
                        <div class="stat-sublabel">Da ordini completati</div>
                    </div>
                    <a href="ordini" class="stat-link">
                        <i class="icon-arrow-right"></i>
                    </a>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon tickets">
                        <i class="icon-headphones"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number"><?= $stats['total_tickets'] ?></div>
                        <div class="stat-label">Ticket Assistenza</div>
                        <div class="stat-sublabel">
                            <?= $stats['open_tickets'] ?> aperti
                        </div>
                    </div>
                    <a href="assistenza" class="stat-link">
                        <i class="icon-arrow-right"></i>
                    </a>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon profile">
                        <i class="icon-user"></i>
                    </div>
                    <div class="stat-content">
                        <div class="stat-number">
                            <?= ucfirst($user['ruolo']) ?>
                        </div>
                        <div class="stat-label">Livello Account</div>
                        <div class="stat-sublabel">
                            Membro dal <?= date('d/m/Y', strtotime($user['created_at'])) ?>
                        </div>
                    </div>
                    <a href="profilo" class="stat-link">
                        <i class="icon-arrow-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Quick Actions -->
    <section class="quick-actions">
        <div class="container">
            <h2>Azioni Rapide</h2>
            <div class="actions-grid">
                <a href="ordini" class="action-card">
                    <div class="action-icon">
                        <i class="icon-list"></i>
                    </div>
                    <div class="action-content">
                        <h3>I Miei Ordini</h3>
                        <p>Visualizza stato e cronologia ordini</p>
                    </div>
                </a>
                
                <a href="preferiti" class="action-card">
                    <div class="action-icon">
                        <i class="icon-heart"></i>
                    </div>
                    <div class="action-content">
                        <h3>Lista Preferiti</h3>
                        <p>Prodotti salvati nei preferiti</p>
                    </div>
                </a>
                
                <a href="assistenza" class="action-card">
                    <div class="action-icon">
                        <i class="icon-headphones"></i>
                    </div>
                    <div class="action-content">
                        <h3>Centro Assistenza</h3>
                        <p>Richiedi supporto o aiuto</p>
                    </div>
                </a>
                
                <a href="profilo" class="action-card">
                    <div class="action-icon">
                        <i class="icon-settings"></i>
                    </div>
                    <div class="action-content">
                        <h3>Impostazioni</h3>
                        <p>Gestisci profilo e preferenze</p>
                    </div>
                </a>
                
                <a href="../shop" class="action-card">
                    <div class="action-icon">
                        <i class="icon-shopping-bag"></i>
                    </div>
                    <div class="action-content">
                        <h3>Continua Shopping</h3>
                        <p>Esplora nuovi prodotti</p>
                    </div>
                </a>
                
                <a href="fatture" class="action-card">
                    <div class="action-icon">
                        <i class="icon-file-text"></i>
                    </div>
                    <div class="action-content">
                        <h3>Fatture</h3>
                        <p>Scarica fatture e ricevute</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Recent Content -->
    <section class="recent-content">
        <div class="container">
            <div class="content-grid">
                <!-- Recent Orders -->
                <div class="content-section">
                    <div class="section-header">
                        <h3>
                            <i class="icon-shopping-bag"></i>
                            Ordini Recenti
                        </h3>
                        <a href="ordini" class="view-all">Vedi tutti</a>
                    </div>
                    
                    <div class="content-list">
                        <?php if (empty($recent_orders)): ?>
                            <div class="empty-state">
                                <i class="icon-shopping-bag"></i>
                                <p>Non hai ancora effettuato ordini</p>
                                <a href="../shop" class="btn btn-primary">Inizia a comprare</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_orders as $order): ?>
                                <div class="list-item order-item">
                                    <div class="item-icon">
                                        <i class="icon-package"></i>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-header">
                                            <h4>Ordine #<?= $order['id'] ?></h4>
                                            <span class="status-badge status-<?= $order['stato'] ?>">
                                                <?= ucfirst($order['stato']) ?>
                                            </span>
                                        </div>
                                        <div class="item-details">
                                            <span><?= $order['items_count'] ?> prodott<?= $order['items_count'] !== 1 ? 'i' : 'o' ?></span>
                                            <span>€<?= number_format($order['totale'], 2) ?></span>
                                            <span><?= date('d/m/Y', strtotime($order['created_at'])) ?></span>
                                        </div>
                                    </div>
                                    <a href="ordine/<?= $order['id'] ?>" class="item-action">
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
                
                <!-- Recent Tickets -->
                <div class="content-section">
                    <div class="section-header">
                        <h3>
                            <i class="icon-headphones"></i>
                            Assistenza Recente
                        </h3>
                        <a href="assistenza" class="view-all">Vedi tutti</a>
                    </div>
                    
                    <div class="content-list">
                        <?php if (empty($recent_tickets)): ?>
                            <div class="empty-state">
                                <i class="icon-headphones"></i>
                                <p>Nessun ticket di assistenza</p>
                                <a href="nuovo-ticket" class="btn btn-primary">Richiedi aiuto</a>
                            </div>
                        <?php else: ?>
                            <?php foreach ($recent_tickets as $ticket): ?>
                                <div class="list-item ticket-item">
                                    <div class="item-icon">
                                        <i class="icon-message-square"></i>
                                    </div>
                                    <div class="item-content">
                                        <div class="item-header">
                                            <h4>#<?= $ticket['id'] ?> - <?= htmlspecialchars($ticket['oggetto']) ?></h4>
                                            <span class="status-badge status-<?= $ticket['stato'] ?>">
                                                <?= ucfirst($ticket['stato']) ?>
                                            </span>
                                        </div>
                                        <div class="item-details">
                                            <span><?= ucfirst($ticket['priorita']) ?> priorità</span>
                                            <span><?= date('d/m/Y', strtotime($ticket['created_at'])) ?></span>
                                        </div>
                                    </div>
                                    <a href="ticket/<?= $ticket['id'] ?>" class="item-action">
                                        <i class="icon-arrow-right"></i>
                                    </a>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            
            <!-- Recent Activity -->
            <div class="activity-section">
                <div class="section-header">
                    <h3>
                        <i class="icon-activity"></i>
                        Attività Recente
                    </h3>
                </div>
                
                <div class="activity-timeline">
                    <?php if (empty($recent_activity)): ?>
                        <div class="empty-state">
                            <i class="icon-activity"></i>
                            <p>Nessuna attività recente</p>
                        </div>
                    <?php else: ?>
                        <?php foreach ($recent_activity as $activity): ?>
                            <div class="timeline-item">
                                <div class="timeline-marker"></div>
                                <div class="timeline-content">
                                    <div class="activity-type"><?= ucfirst(str_replace('_', ' ', $activity['azione'])) ?></div>
                                    <div class="activity-description"><?= htmlspecialchars($activity['dettagli']) ?></div>
                                    <div class="activity-time">
                                        <?= getTimeAgo($activity['created_at']) ?>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </section>
</main>

<style>
.client-area {
    padding-top: 0;
}

.page-header {
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    padding: 3rem 0;
}

.header-content {
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 2rem;
}

.welcome-section h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 0.5rem;
}

.welcome-section p {
    font-size: 1.1rem;
    opacity: 0.9;
}

.header-actions {
    display: flex;
    gap: 1rem;
    flex-shrink: 0;
}

.dashboard-stats {
    padding: 3rem 0;
    background: var(--light-background);
}

.stats-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
}

.stat-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: transform 0.3s ease;
    position: relative;
    overflow: hidden;
}

.stat-card:hover {
    transform: translateY(-5px);
}

.stat-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 4px;
    background: var(--primary-color);
}

.stat-card {
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.stat-icon {
    width: 4rem;
    height: 4rem;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.5rem;
    color: white;
}

.stat-icon.orders {
    background: linear-gradient(135deg, #007bff, #0056b3);
}

.stat-icon.spending {
    background: linear-gradient(135deg, #28a745, #1e7e34);
}

.stat-icon.tickets {
    background: linear-gradient(135deg, #ffc107, #e0a800);
}

.stat-icon.profile {
    background: linear-gradient(135deg, #6f42c1, #563d7c);
}

.stat-content {
    flex: 1;
}

.stat-number {
    font-size: 2rem;
    font-weight: 700;
    color: var(--text-color);
    line-height: 1;
    margin-bottom: 0.5rem;
}

.stat-label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.25rem;
}

.stat-sublabel {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.stat-link {
    color: var(--primary-color);
    font-size: 1.2rem;
    transition: transform 0.3s ease;
}

.stat-link:hover {
    transform: translateX(3px);
}

.quick-actions {
    padding: 3rem 0;
}

.quick-actions h2 {
    margin-bottom: 2rem;
    text-align: center;
    color: var(--text-color);
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 1.5rem;
}

.action-card {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.08);
    text-decoration: none;
    color: var(--text-color);
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 1.5rem;
}

.action-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    color: var(--text-color);
}

.action-icon {
    width: 3rem;
    height: 3rem;
    background: var(--primary-color);
    color: white;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.3rem;
    flex-shrink: 0;
}

.action-content h3 {
    margin: 0 0 0.5rem 0;
    font-size: 1.2rem;
    font-weight: 600;
}

.action-content p {
    margin: 0;
    color: var(--text-muted);
    font-size: 0.9rem;
}

.recent-content {
    padding: 3rem 0;
    background: var(--light-background);
}

.content-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 3rem;
    margin-bottom: 3rem;
}

.content-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.section-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1.5rem;
    padding-bottom: 1rem;
    border-bottom: 1px solid var(--border-color);
}

.section-header h3 {
    margin: 0;
    color: var(--text-color);
    display: flex;
    align-items: center;
    gap: 0.5rem;
}

.view-all {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
    font-size: 0.9rem;
    transition: color 0.3s ease;
}

.view-all:hover {
    color: var(--primary-dark);
}

.content-list {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.list-item {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 1rem;
    border: 1px solid var(--border-color);
    border-radius: 8px;
    transition: all 0.3s ease;
}

.list-item:hover {
    border-color: var(--primary-color);
    background: rgba(var(--primary-color-rgb), 0.02);
}

.item-icon {
    width: 2.5rem;
    height: 2.5rem;
    background: var(--light-background);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--primary-color);
    flex-shrink: 0;
}

.item-content {
    flex: 1;
}

.item-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 0.5rem;
}

.item-header h4 {
    margin: 0;
    font-size: 0.95rem;
    font-weight: 600;
    color: var(--text-color);
}

.status-badge {
    padding: 0.2rem 0.6rem;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-badge.status-completato,
.status-badge.status-chiuso {
    background: rgba(40, 167, 69, 0.1);
    color: #28a745;
}

.status-badge.status-in-elaborazione,
.status-badge.status-aperto {
    background: rgba(255, 193, 7, 0.1);
    color: #ffc107;
}

.status-badge.status-spedito {
    background: rgba(23, 162, 184, 0.1);
    color: #17a2b8;
}

.status-badge.status-annullato {
    background: rgba(220, 53, 69, 0.1);
    color: #dc3545;
}

.item-details {
    display: flex;
    gap: 1rem;
    font-size: 0.85rem;
    color: var(--text-muted);
}

.item-action {
    color: var(--text-muted);
    font-size: 1.2rem;
    transition: all 0.3s ease;
}

.item-action:hover {
    color: var(--primary-color);
    transform: translateX(3px);
}

.activity-section {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.activity-timeline {
    position: relative;
}

.activity-timeline::before {
    content: '';
    position: absolute;
    left: 1rem;
    top: 0;
    bottom: 0;
    width: 2px;
    background: var(--border-color);
}

.timeline-item {
    position: relative;
    padding-left: 3rem;
    padding-bottom: 2rem;
}

.timeline-item:last-child {
    padding-bottom: 0;
}

.timeline-marker {
    position: absolute;
    left: 0.5rem;
    top: 0.5rem;
    width: 1rem;
    height: 1rem;
    background: var(--primary-color);
    border-radius: 50%;
    border: 2px solid white;
    box-shadow: 0 0 0 2px var(--border-color);
    z-index: 2;
}

.activity-type {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.25rem;
    font-size: 0.9rem;
}

.activity-description {
    color: var(--text-muted);
    font-size: 0.85rem;
    margin-bottom: 0.5rem;
}

.activity-time {
    font-size: 0.75rem;
    color: var(--text-muted);
}

.empty-state {
    text-align: center;
    padding: 3rem 1rem;
    color: var(--text-muted);
}

.empty-state i {
    font-size: 3rem;
    margin-bottom: 1rem;
    opacity: 0.5;
}

.empty-state p {
    margin-bottom: 1.5rem;
}

@media (max-width: 768px) {
    .header-content {
        flex-direction: column;
        align-items: flex-start;
        gap: 1.5rem;
    }
    
    .header-actions {
        width: 100%;
        justify-content: stretch;
    }
    
    .header-actions .btn {
        flex: 1;
        text-align: center;
    }
    
    .stats-grid {
        grid-template-columns: 1fr;
    }
    
    .actions-grid {
        grid-template-columns: 1fr;
    }
    
    .content-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .item-details {
        flex-direction: column;
        gap: 0.5rem;
    }
    
    .activity-timeline::before {
        left: 0.75rem;
    }
    
    .timeline-item {
        padding-left: 2.5rem;
    }
    
    .timeline-marker {
        left: 0.25rem;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
// Client area functionality
document.addEventListener('DOMContentLoaded', function() {
    // Initialize tooltips and interactive elements
    initializeClientArea();
});

function initializeClientArea() {
    // Add click tracking for stats cards
    document.querySelectorAll('.stat-card').forEach(card => {
        card.addEventListener('click', function() {
            const link = this.querySelector('.stat-link');
            if (link) {
                window.location.href = link.href;
            }
        });
    });
    
    // Add hover effects for action cards
    document.querySelectorAll('.action-card').forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-5px) scale(1.02)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = '';
        });
    });
    
    // Auto-refresh activity feed every 30 seconds
    setInterval(refreshActivityFeed, 30000);
}

function refreshActivityFeed() {
    // Implementation for refreshing activity feed
    console.log('Refreshing activity feed...');
}
</script>

<?php 
// Helper function for time ago
function getTimeAgo($datetime) {
    $time = time() - strtotime($datetime);
    
    if ($time < 60) return 'Pochi secondi fa';
    if ($time < 3600) return floor($time/60) . ' minuti fa';
    if ($time < 86400) return floor($time/3600) . ' ore fa';
    if ($time < 2629746) return floor($time/86400) . ' giorni fa';
    
    return date('d/m/Y H:i', strtotime($datetime));
}

include '../includes/footer.php'; 
?>