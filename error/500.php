<?php
http_response_code(500);
$page_title = '500 - Errore del Server';
$page_description = 'Si è verificato un errore interno del server.';
$current_page = '500';

// Log the error for debugging (in production)
error_log("500 Error on: " . $_SERVER['REQUEST_URI'] . " | Referer: " . ($_SERVER['HTTP_REFERER'] ?? 'Direct'));

// Don't include header if this is an AJAX request
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($is_ajax) {
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'code' => 500,
        'message' => 'Errore interno del server',
        'retry' => true
    ]);
    exit;
}

include '../includes/header.php';
?>

<main class="error-page server-error">
    <div class="error-container">
        <div class="error-content">
            <div class="error-animation">
                <div class="error-number">
                    <span class="five">5</span>
                    <span class="zero">0</span>
                    <span class="zero">0</span>
                </div>
                <div class="error-icon">
                    <i class="icon-alert-triangle"></i>
                </div>
            </div>
            
            <div class="error-text">
                <h1>Errore del Server</h1>
                <p>Ci dispiace, si è verificato un problema temporaneo sui nostri server.</p>
                <p>Il nostro team tecnico è già stato notificato e sta lavorando per risolvere il problema.</p>
            </div>
            
            <div class="error-actions">
                <button onclick="location.reload()" class="btn btn-primary">
                    <i class="icon-refresh-cw"></i>
                    Riprova
                </button>
                <a href="/" class="btn btn-outline-primary">
                    <i class="icon-home"></i>
                    Torna alla Home
                </a>
                <a href="/contatti" class="btn btn-outline-secondary">
                    <i class="icon-mail"></i>
                    Segnala il Problema
                </a>
            </div>
        </div>
        
        <div class="error-suggestions">
            <h3>Cosa puoi fare mentre risolviamo:</h3>
            <ul>
                <li>
                    <i class="icon-check"></i>
                    Ricarica la pagina tra qualche minuto
                </li>
                <li>
                    <i class="icon-check"></i>
                    Controlla la tua connessione internet
                </li>
                <li>
                    <i class="icon-check"></i>
                    Prova a navigare in altre sezioni del sito
                </li>
                <li>
                    <i class="icon-check"></i>
                    <a href="/contatti">Contattaci</a> se il problema persiste
                </li>
            </ul>
        </div>
        
        <div class="status-info">
            <div class="status-card">
                <div class="status-header">
                    <i class="icon-activity"></i>
                    <h3>Stato del Sistema</h3>
                </div>
                <div class="status-content">
                    <div class="status-item">
                        <span class="status-label">Sito Web</span>
                        <span class="status-indicator status-warning">In Manutenzione</span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">Database</span>
                        <span class="status-indicator status-ok">Operativo</span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">API</span>
                        <span class="status-indicator status-ok">Operativo</span>
                    </div>
                    <div class="status-item">
                        <span class="status-label">E-commerce</span>
                        <span class="status-indicator status-warning">Limitato</span>
                    </div>
                </div>
                <div class="status-footer">
                    <small>Ultimo aggiornamento: <span id="statusTime"></span></small>
                </div>
            </div>
        </div>
        
        <div class="alternative-actions">
            <h3>Nel frattempo, puoi:</h3>
            <div class="actions-grid">
                <a href="/shop" class="action-card">
                    <i class="icon-shopping-bag"></i>
                    <span>Continua lo Shopping</span>
                    <small>Esplora i nostri prodotti</small>
                </a>
                
                <a href="/servizi" class="action-card">
                    <i class="icon-layers"></i>
                    <span>I Nostri Servizi</span>
                    <small>Scopri cosa offriamo</small>
                </a>
                
                <a href="/contatti" class="action-card">
                    <i class="icon-phone"></i>
                    <span>Contattaci</span>
                    <small>Assistenza diretta</small>
                </a>
                
                <a href="/area-cliente" class="action-card">
                    <i class="icon-user"></i>
                    <span>Area Cliente</span>
                    <small>Gestisci il tuo account</small>
                </a>
            </div>
        </div>
    </div>
</main>

<style>
.server-error {
    background: linear-gradient(135deg, #fee2e2 0%, #fef2f2 100%);
}

.error-number .five {
    animation-delay: 0s;
}

.error-number .zero:first-of-type {
    animation-delay: 0.2s;
}

.error-number .zero:last-of-type {
    animation-delay: 0.4s;
}

.status-info {
    margin: 3rem 0;
}

.status-card {
    background: white;
    border-radius: 16px;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    overflow: hidden;
    max-width: 400px;
    margin: 0 auto;
}

.status-header {
    background: var(--primary-color);
    color: white;
    padding: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.75rem;
}

.status-header h3 {
    margin: 0;
    font-size: 1.2rem;
}

.status-content {
    padding: 1.5rem;
}

.status-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0.75rem 0;
    border-bottom: 1px solid var(--border-color);
}

.status-item:last-child {
    border-bottom: none;
}

.status-label {
    font-weight: 500;
    color: var(--text-color);
}

.status-indicator {
    padding: 0.25rem 0.75rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.status-indicator.status-ok {
    background: rgba(34, 197, 94, 0.1);
    color: #22c55e;
}

.status-indicator.status-warning {
    background: rgba(245, 158, 11, 0.1);
    color: #f59e0b;
}

.status-indicator.status-error {
    background: rgba(239, 68, 68, 0.1);
    color: #ef4444;
}

.status-footer {
    padding: 1rem 1.5rem;
    background: var(--light-background);
    text-align: center;
}

.status-footer small {
    color: var(--text-muted);
}

.alternative-actions {
    margin-top: 3rem;
    text-align: center;
}

.alternative-actions h3 {
    color: var(--text-color);
    margin-bottom: 2rem;
}

.actions-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(160px, 1fr));
    gap: 1.5rem;
}

.action-card {
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 16px;
    padding: 2rem 1rem;
    text-decoration: none;
    color: var(--text-color);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
    text-align: center;
}

.action-card:hover {
    border-color: var(--primary-color);
    background: rgba(var(--primary-color-rgb), 0.05);
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.action-card i {
    font-size: 2.5rem;
    color: var(--primary-color);
    transition: transform 0.3s ease;
}

.action-card:hover i {
    transform: scale(1.1);
}

.action-card span {
    font-weight: 600;
    font-size: 1rem;
}

.action-card small {
    color: var(--text-muted);
    font-size: 0.85rem;
}

@media (max-width: 768px) {
    .actions-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .action-card {
        padding: 1.5rem 0.75rem;
    }
    
    .action-card i {
        font-size: 2rem;
    }
}

@media (max-width: 480px) {
    .actions-grid {
        grid-template-columns: 1fr;
    }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    updateStatusTime();
    
    // Auto-refresh every 30 seconds to check if the issue is resolved
    let refreshCount = 0;
    const maxRefreshes = 10; // Limit auto-refreshes
    
    const autoRefresh = setInterval(() => {
        refreshCount++;
        
        if (refreshCount >= maxRefreshes) {
            clearInterval(autoRefresh);
            return;
        }
        
        // Check if the server is back online
        fetch('/', { 
            method: 'HEAD',
            cache: 'no-cache'
        })
        .then(response => {
            if (response.ok) {
                clearInterval(autoRefresh);
                showRecoveryNotification();
            }
        })
        .catch(() => {
            // Server still down, continue checking
        });
        
    }, 30000);
    
    // Add retry button functionality
    document.querySelectorAll('.btn[onclick*="reload"]').forEach(btn => {
        btn.addEventListener('click', function() {
            this.innerHTML = '<i class="icon-loader"></i> Ricaricamento...';
            this.disabled = true;
        });
    });
});

function updateStatusTime() {
    const statusTime = document.getElementById('statusTime');
    if (statusTime) {
        statusTime.textContent = new Date().toLocaleTimeString('it-IT');
    }
}

function showRecoveryNotification() {
    const notification = document.createElement('div');
    notification.className = 'recovery-notification';
    notification.innerHTML = `
        <div class="notification-content">
            <i class="icon-check-circle"></i>
            <span>Il sito è tornato online! Ricarica la pagina.</span>
            <button onclick="location.reload()" class="btn btn-sm btn-primary">Ricarica</button>
        </div>
    `;
    
    notification.style.cssText = `
        position: fixed;
        top: 2rem;
        right: 2rem;
        background: var(--success-color);
        color: white;
        padding: 1rem;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.2);
        z-index: 10000;
        animation: slideInRight 0.5s ease;
    `;
    
    document.body.appendChild(notification);
    
    // Auto-remove after 10 seconds
    setTimeout(() => {
        notification.remove();
    }, 10000);
}
</script>

<?php include '../includes/footer.php'; ?>