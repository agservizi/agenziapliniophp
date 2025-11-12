<?php
http_response_code(403);
$page_title = '403 - Accesso Negato';
$page_description = 'Non hai i permessi necessari per accedere a questa risorsa.';
$current_page = '403';

// Don't include header if this is an AJAX request
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($is_ajax) {
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'code' => 403,
        'message' => 'Accesso negato',
        'redirect' => '/area-cliente/login'
    ]);
    exit;
}

include '../includes/header.php';
?>

<main class="error-page">
    <div class="error-container">
        <div class="error-content">
            <div class="error-animation">
                <div class="error-number">
                    <span class="four">4</span>
                    <span class="zero">0</span>
                    <span class="three">3</span>
                </div>
                <div class="error-icon">
                    <i class="icon-shield-off"></i>
                </div>
            </div>
            
            <div class="error-text">
                <h1>Accesso Negato</h1>
                <p>Non hai i permessi necessari per accedere a questa risorsa.</p>
                <p>Potrebbe essere necessario effettuare l'accesso o avere privilegi specifici.</p>
            </div>
            
            <div class="error-actions">
                <a href="/area-cliente/login" class="btn btn-primary">
                    <i class="icon-log-in"></i>
                    Accedi
                </a>
                <a href="/" class="btn btn-outline-primary">
                    <i class="icon-home"></i>
                    Torna alla Home
                </a>
                <button onclick="history.back()" class="btn btn-outline-secondary">
                    <i class="icon-arrow-left"></i>
                    Pagina Precedente
                </button>
            </div>
        </div>
        
        <div class="error-suggestions">
            <h3>Possibili soluzioni:</h3>
            <ul>
                <li>
                    <i class="icon-check"></i>
                    Effettua l'accesso al tuo account
                </li>
                <li>
                    <i class="icon-check"></i>
                    Verifica di avere i permessi necessari
                </li>
                <li>
                    <i class="icon-check"></i>
                    Controlla se la tua sessione è scaduta
                </li>
                <li>
                    <i class="icon-check"></i>
                    <a href="/contatti">Contatta il supporto</a> per assistenza
                </li>
            </ul>
        </div>
        
        <div class="access-info">
            <div class="info-card">
                <h3><i class="icon-users"></i> Area Cliente</h3>
                <p>Accedi alla tua area personale per gestire ordini, preferiti e impostazioni.</p>
                <a href="/area-cliente/login" class="btn btn-sm btn-primary">Accedi</a>
            </div>
            
            <div class="info-card">
                <h3><i class="icon-user-plus"></i> Nuovo Cliente?</h3>
                <p>Registrati gratuitamente e scopri tutti i vantaggi riservati ai nostri clienti.</p>
                <a href="/area-cliente/register" class="btn btn-sm btn-outline-primary">Registrati</a>
            </div>
            
            <div class="info-card">
                <h3><i class="icon-headphones"></i> Serve Aiuto?</h3>
                <p>Il nostro team di supporto è sempre pronto ad aiutarti.</p>
                <a href="/contatti" class="btn btn-sm btn-outline-secondary">Contattaci</a>
            </div>
        </div>
    </div>
</main>

<style>
.error-page .error-number .three {
    animation-delay: 0.4s;
}

.access-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 2rem;
    margin-top: 3rem;
}

.info-card {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    text-align: center;
    transition: transform 0.3s ease;
}

.info-card:hover {
    transform: translateY(-5px);
}

.info-card h3 {
    color: var(--text-color);
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.info-card h3 i {
    color: var(--primary-color);
    font-size: 1.5rem;
}

.info-card p {
    color: var(--text-muted);
    margin-bottom: 1.5rem;
    line-height: 1.5;
}

@media (max-width: 768px) {
    .access-info {
        grid-template-columns: 1fr;
        gap: 1.5rem;
    }
    
    .info-card {
        padding: 1.5rem;
    }
}
</style>

<?php include '../includes/footer.php'; ?>