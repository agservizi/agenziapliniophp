<?php
http_response_code(404);
$page_title = '404 - Pagina Non Trovata';
$page_description = 'La pagina che stai cercando non è disponibile.';
$current_page = '404';

// Don't include header if this is an AJAX request
$is_ajax = !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
           strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';

if ($is_ajax) {
    header('Content-Type: application/json');
    echo json_encode([
        'error' => true,
        'code' => 404,
        'message' => 'Risorsa non trovata',
        'redirect' => '/'
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
                    <span class="four">4</span>
                </div>
                <div class="error-icon">
                    <i class="icon-search"></i>
                </div>
            </div>
            
            <div class="error-text">
                <h1>Pagina Non Trovata</h1>
                <p>Ops! La pagina che stai cercando sembra essere scomparsa nel cyberspazio.</p>
                <p>Potrebbe essere stata spostata, eliminata o l'URL potrebbe essere errato.</p>
            </div>
            
            <div class="error-actions">
                <a href="/" class="btn btn-primary">
                    <i class="icon-home"></i>
                    Torna alla Home
                </a>
                <a href="/shop" class="btn btn-outline-primary">
                    <i class="icon-shopping-bag"></i>
                    Vai allo Shop
                </a>
                <button onclick="history.back()" class="btn btn-outline-secondary">
                    <i class="icon-arrow-left"></i>
                    Pagina Precedente
                </button>
            </div>
        </div>
        
        <div class="error-suggestions">
            <h3>Cosa puoi fare:</h3>
            <ul>
                <li>
                    <i class="icon-check"></i>
                    Controlla l'URL per eventuali errori di battitura
                </li>
                <li>
                    <i class="icon-check"></i>
                    Utilizza il menu di navigazione per trovare quello che cerchi
                </li>
                <li>
                    <i class="icon-check"></i>
                    Prova la nostra barra di ricerca
                </li>
                <li>
                    <i class="icon-check"></i>
                    <a href="/contatti">Contattaci</a> se hai bisogno di aiuto
                </li>
            </ul>
        </div>
        
        <div class="popular-pages">
            <h3>Pagine Popolari:</h3>
            <div class="pages-grid">
                <a href="/" class="page-card">
                    <i class="icon-home"></i>
                    <span>Homepage</span>
                </a>
                <a href="/servizi" class="page-card">
                    <i class="icon-layers"></i>
                    <span>I Nostri Servizi</span>
                </a>
                <a href="/shop" class="page-card">
                    <i class="icon-shopping-bag"></i>
                    <span>Shop Online</span>
                </a>
                <a href="/contatti" class="page-card">
                    <i class="icon-mail"></i>
                    <span>Contatti</span>
                </a>
                <a href="/area-cliente" class="page-card">
                    <i class="icon-user"></i>
                    <span>Area Cliente</span>
                </a>
                <a href="/chi-siamo" class="page-card">
                    <i class="icon-info"></i>
                    <span>Chi Siamo</span>
                </a>
            </div>
        </div>
    </div>
</main>

<style>
.error-page {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 4rem 1rem;
    background: linear-gradient(135deg, var(--light-background) 0%, white 100%);
}

.error-container {
    max-width: 800px;
    text-align: center;
    animation: fadeInUp 0.8s ease;
}

.error-content {
    margin-bottom: 4rem;
}

.error-animation {
    position: relative;
    margin-bottom: 3rem;
}

.error-number {
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 1rem;
    font-size: 8rem;
    font-weight: 800;
    color: var(--primary-color);
    text-shadow: 2px 2px 4px rgba(0,0,0,0.1);
    position: relative;
}

.error-number span {
    display: inline-block;
    animation: bounce 2s infinite;
}

.error-number .four:first-child {
    animation-delay: 0s;
}

.error-number .zero {
    animation-delay: 0.2s;
    position: relative;
}

.error-number .four:last-child {
    animation-delay: 0.4s;
}

.error-icon {
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    font-size: 3rem;
    color: var(--text-muted);
    opacity: 0.3;
    animation: pulse 2s infinite;
}

.error-text h1 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 1.5rem;
}

.error-text p {
    font-size: 1.1rem;
    color: var(--text-muted);
    line-height: 1.6;
    margin-bottom: 1rem;
}

.error-actions {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 1rem;
    margin: 3rem 0;
}

.error-suggestions {
    background: white;
    border-radius: 16px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
    margin-bottom: 3rem;
    text-align: left;
}

.error-suggestions h3 {
    color: var(--text-color);
    margin-bottom: 1.5rem;
    text-align: center;
}

.error-suggestions ul {
    list-style: none;
    padding: 0;
    margin: 0;
}

.error-suggestions li {
    display: flex;
    align-items: center;
    gap: 1rem;
    padding: 0.75rem 0;
    color: var(--text-color);
    border-bottom: 1px solid var(--border-color);
}

.error-suggestions li:last-child {
    border-bottom: none;
}

.error-suggestions li i {
    color: var(--success-color);
    flex-shrink: 0;
}

.error-suggestions a {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 500;
}

.error-suggestions a:hover {
    text-decoration: underline;
}

.popular-pages {
    text-align: center;
}

.popular-pages h3 {
    color: var(--text-color);
    margin-bottom: 2rem;
}

.pages-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(140px, 1fr));
    gap: 1rem;
}

.page-card {
    background: white;
    border: 2px solid var(--border-color);
    border-radius: 12px;
    padding: 1.5rem 1rem;
    text-decoration: none;
    color: var(--text-color);
    transition: all 0.3s ease;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.75rem;
}

.page-card:hover {
    border-color: var(--primary-color);
    background: rgba(var(--primary-color-rgb), 0.05);
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.15);
}

.page-card i {
    font-size: 2rem;
    color: var(--primary-color);
    transition: transform 0.3s ease;
}

.page-card:hover i {
    transform: scale(1.1);
}

.page-card span {
    font-size: 0.9rem;
    font-weight: 600;
    text-align: center;
}

@media (max-width: 768px) {
    .error-number {
        font-size: 5rem;
    }
    
    .error-text h1 {
        font-size: 2rem;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .error-actions .btn {
        width: 100%;
        max-width: 250px;
    }
    
    .pages-grid {
        grid-template-columns: repeat(2, 1fr);
    }
    
    .error-suggestions {
        padding: 1.5rem;
        margin-bottom: 2rem;
    }
}

@media (max-width: 480px) {
    .error-page {
        padding: 2rem 1rem;
    }
    
    .error-number {
        font-size: 4rem;
        gap: 0.5rem;
    }
    
    .error-icon {
        font-size: 2rem;
    }
    
    .error-text h1 {
        font-size: 1.5rem;
    }
    
    .error-text p {
        font-size: 1rem;
    }
}

@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

@keyframes bounce {
    0%, 20%, 53%, 80%, 100% {
        transform: translateY(0);
    }
    40%, 43% {
        transform: translateY(-20px);
    }
    70% {
        transform: translateY(-10px);
    }
    90% {
        transform: translateY(-4px);
    }
}

@keyframes pulse {
    0% {
        opacity: 0.3;
        transform: translate(-50%, -50%) scale(1);
    }
    50% {
        opacity: 0.1;
        transform: translate(-50%, -50%) scale(1.1);
    }
    100% {
        opacity: 0.3;
        transform: translate(-50%, -50%) scale(1);
    }
}
</style>

<script>
// Add some interactivity to the error page
document.addEventListener('DOMContentLoaded', function() {
    // Add click tracking for analytics
    document.querySelectorAll('.error-actions .btn, .page-card').forEach(link => {
        link.addEventListener('click', function() {
            // Track 404 recovery actions
            if (typeof gtag !== 'undefined') {
                gtag('event', '404_recovery', {
                    'event_category': 'Error Pages',
                    'event_label': this.href || this.textContent.trim()
                });
            }
        });
    });
    
    // Auto-suggest search if there's a query parameter
    const urlParams = new URLSearchParams(window.location.search);
    const query = urlParams.get('q') || extractQueryFromURL();
    
    if (query) {
        addSearchSuggestion(query);
    }
});

function extractQueryFromURL() {
    const path = window.location.pathname;
    const segments = path.split('/').filter(segment => segment.length > 0);
    return segments[segments.length - 1] || '';
}

function addSearchSuggestion(query) {
    const errorText = document.querySelector('.error-text');
    const searchSuggestion = document.createElement('div');
    searchSuggestion.className = 'search-suggestion';
    searchSuggestion.innerHTML = `
        <p style="margin-top: 1rem; padding: 1rem; background: rgba(var(--primary-color-rgb), 0.1); border-radius: 8px; border-left: 4px solid var(--primary-color);">
            <strong>Cercavi "${query}"?</strong><br>
            <a href="/ricerca?q=${encodeURIComponent(query)}" class="btn btn-sm btn-primary" style="margin-top: 0.5rem; display: inline-block;">
                <i class="icon-search"></i> Cerca nel sito
            </a>
        </p>
    `;
    errorText.appendChild(searchSuggestion);
}
</script>

<?php include '../includes/footer.php'; ?>