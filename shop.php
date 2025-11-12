<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

$page_title = 'Shop - Prodotti e Servizi';
$page_description = 'Esplora il nostro catalogo completo di prodotti e servizi. Soluzioni digitali, consulenza aziendale e molto altro.';
$current_page = 'shop';

// Get categories and filters
$category_filter = isset($_GET['categoria']) ? sanitizeInput($_GET['categoria']) : '';
$search_filter = isset($_GET['ricerca']) ? sanitizeInput($_GET['ricerca']) : '';
$price_order = isset($_GET['ordine_prezzo']) ? sanitizeInput($_GET['ordine_prezzo']) : '';
$page = isset($_GET['page']) ? max(1, intval($_GET['page'])) : 1;
$per_page = 12;
$offset = ($page - 1) * $per_page;

try {
    $pdo = getDBConnection();
    
    // Get categories for filter
    $categories_stmt = $pdo->prepare("
        SELECT DISTINCT c.id, c.nome, c.slug, COUNT(p.id) as prodotti_count
        FROM categorie_prodotti c 
        LEFT JOIN prodotti p ON c.id = p.categoria_id AND p.attivo = 1
        WHERE c.attiva = 1
        GROUP BY c.id, c.nome, c.slug
        ORDER BY c.ordine ASC, c.nome ASC
    ");
    $categories_stmt->execute();
    $categories = $categories_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Build query for products
    $where_conditions = ["p.attivo = 1"];
    $params = [];
    
    if ($category_filter) {
        $where_conditions[] = "c.slug = :categoria";
        $params['categoria'] = $category_filter;
    }
    
    if ($search_filter) {
        $where_conditions[] = "(p.nome LIKE :ricerca OR p.descrizione_breve LIKE :ricerca OR p.descrizione LIKE :ricerca)";
        $params['ricerca'] = "%$search_filter%";
    }
    
    $where_clause = implode(' AND ', $where_conditions);
    
    // Order by clause
    $order_clause = "ORDER BY ";
    switch ($price_order) {
        case 'asc':
            $order_clause .= "p.prezzo ASC, p.nome ASC";
            break;
        case 'desc':
            $order_clause .= "p.prezzo DESC, p.nome ASC";
            break;
        default:
            $order_clause .= "p.in_evidenza DESC, p.created_at DESC, p.nome ASC";
            break;
    }
    
    // Get total count for pagination
    $count_stmt = $pdo->prepare("
        SELECT COUNT(DISTINCT p.id) as total
        FROM prodotti p
        LEFT JOIN categorie_prodotti c ON p.categoria_id = c.id
        WHERE $where_clause
    ");
    $count_stmt->execute($params);
    $total_products = $count_stmt->fetch(PDO::FETCH_ASSOC)['total'];
    
    // Get products
    $products_stmt = $pdo->prepare("
        SELECT p.*, c.nome as categoria_nome, c.slug as categoria_slug
        FROM prodotti p
        LEFT JOIN categorie_prodotti c ON p.categoria_id = c.id
        WHERE $where_clause
        $order_clause
        LIMIT :offset, :per_page
    ");
    
    // Bind parameters
    foreach ($params as $key => $value) {
        $products_stmt->bindValue(":$key", $value);
    }
    $products_stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
    $products_stmt->bindValue(':per_page', $per_page, PDO::PARAM_INT);
    
    $products_stmt->execute();
    $products = $products_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate pagination
    $total_pages = ceil($total_products / $per_page);
    
} catch (PDOException $e) {
    error_log("Shop page error: " . $e->getMessage());
    $categories = [];
    $products = [];
    $total_products = 0;
    $total_pages = 1;
}

include 'includes/header.php';
?>

<main class="shop-page">
    <!-- Hero Section -->
    <section class="page-hero">
        <div class="container">
            <div class="hero-content">
                <h1>
                    <span class="hero-title">Il Nostro Shop</span>
                    <span class="hero-subtitle">Prodotti e Servizi di Qualità</span>
                </h1>
                <p class="hero-description">
                    Scopri la nostra selezione di prodotti digitali, servizi di consulenza 
                    e soluzioni personalizzate per la tua azienda.
                </p>
            </div>
        </div>
        <div class="hero-background">
            <div class="hero-shape shape-1"></div>
            <div class="hero-shape shape-2"></div>
            <div class="hero-shape shape-3"></div>
        </div>
    </section>

    <!-- Filters Section -->
    <section class="shop-filters">
        <div class="container">
            <div class="filters-wrapper">
                <div class="filters-header">
                    <h2>Filtra Prodotti</h2>
                    <div class="results-count">
                        <?= $total_products ?> prodott<?= $total_products !== 1 ? 'i' : 'o' ?> 
                        <?php if ($search_filter): ?>
                            per "<?= htmlspecialchars($search_filter) ?>"
                        <?php endif; ?>
                    </div>
                </div>
                
                <form method="GET" class="filters-form" id="shopFilters">
                    <!-- Search -->
                    <div class="filter-group">
                        <label for="ricerca">Cerca prodotti</label>
                        <div class="search-wrapper">
                            <input type="text" 
                                   id="ricerca" 
                                   name="ricerca" 
                                   value="<?= htmlspecialchars($search_filter) ?>"
                                   placeholder="Cerca per nome o descrizione...">
                            <button type="submit" class="search-btn">
                                <i class="icon-search"></i>
                            </button>
                        </div>
                    </div>
                    
                    <!-- Categories -->
                    <div class="filter-group">
                        <label for="categoria">Categoria</label>
                        <select id="categoria" name="categoria" onchange="this.form.submit()">
                            <option value="">Tutte le categorie</option>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?= htmlspecialchars($category['slug']) ?>" 
                                        <?= $category_filter === $category['slug'] ? 'selected' : '' ?>>
                                    <?= htmlspecialchars($category['nome']) ?> (<?= $category['prodotti_count'] ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <!-- Price Order -->
                    <div class="filter-group">
                        <label for="ordine_prezzo">Ordina per prezzo</label>
                        <select id="ordine_prezzo" name="ordine_prezzo" onchange="this.form.submit()">
                            <option value="">Predefinito</option>
                            <option value="asc" <?= $price_order === 'asc' ? 'selected' : '' ?>>
                                Prezzo: crescente
                            </option>
                            <option value="desc" <?= $price_order === 'desc' ? 'selected' : '' ?>>
                                Prezzo: decrescente
                            </option>
                        </select>
                    </div>
                    
                    <!-- Clear Filters -->
                    <?php if ($category_filter || $search_filter || $price_order): ?>
                        <div class="filter-group">
                            <a href="shop" class="btn btn-outline-primary">
                                <i class="icon-refresh"></i> Reset Filtri
                            </a>
                        </div>
                    <?php endif; ?>
                </form>
            </div>
        </div>
    </section>

    <!-- Products Grid -->
    <section class="products-section">
        <div class="container">
            <?php if (empty($products)): ?>
                <!-- No Products Found -->
                <div class="no-products">
                    <div class="no-products-icon">
                        <i class="icon-search"></i>
                    </div>
                    <h3>Nessun prodotto trovato</h3>
                    <p>Prova a modificare i filtri di ricerca o esplora tutte le categorie.</p>
                    <a href="shop" class="btn btn-primary">Vedi tutti i prodotti</a>
                </div>
            <?php else: ?>
                <!-- Products Grid -->
                <div class="products-grid">
                    <?php foreach ($products as $product): ?>
                        <article class="product-card" data-product-id="<?= $product['id'] ?>">
                            <div class="product-image">
                                <?php if ($product['immagine']): ?>
                                    <img src="<?= htmlspecialchars($product['immagine']) ?>" 
                                         alt="<?= htmlspecialchars($product['nome']) ?>"
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="product-placeholder">
                                        <i class="icon-package"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($product['in_evidenza']): ?>
                                    <span class="product-badge badge-featured">In Evidenza</span>
                                <?php endif; ?>
                                
                                <?php if ($product['sconto'] > 0): ?>
                                    <span class="product-badge badge-discount">-<?= $product['sconto'] ?>%</span>
                                <?php endif; ?>
                                
                                <div class="product-actions">
                                    <button class="action-btn quick-view" 
                                            data-product-id="<?= $product['id'] ?>"
                                            title="Anteprima rapida">
                                        <i class="icon-eye"></i>
                                    </button>
                                    <button class="action-btn add-to-wishlist" 
                                            data-product-id="<?= $product['id'] ?>"
                                            title="Aggiungi ai preferiti">
                                        <i class="icon-heart"></i>
                                    </button>
                                </div>
                            </div>
                            
                            <div class="product-content">
                                <div class="product-category">
                                    <a href="shop?categoria=<?= urlencode($product['categoria_slug']) ?>">
                                        <?= htmlspecialchars($product['categoria_nome']) ?>
                                    </a>
                                </div>
                                
                                <h3 class="product-title">
                                    <a href="prodotto/<?= urlencode($product['slug']) ?>">
                                        <?= htmlspecialchars($product['nome']) ?>
                                    </a>
                                </h3>
                                
                                <p class="product-description">
                                    <?= htmlspecialchars($product['descrizione_breve']) ?>
                                </p>
                                
                                <div class="product-footer">
                                    <div class="product-price">
                                        <?php if ($product['sconto'] > 0): ?>
                                            <span class="price-original">€<?= number_format($product['prezzo'], 2) ?></span>
                                            <span class="price-discounted">
                                                €<?= number_format($product['prezzo'] * (1 - $product['sconto']/100), 2) ?>
                                            </span>
                                        <?php else: ?>
                                            <span class="price-current">€<?= number_format($product['prezzo'], 2) ?></span>
                                        <?php endif; ?>
                                    </div>
                                    
                                    <div class="product-actions-footer">
                                        <button class="btn btn-primary add-to-cart" 
                                                data-product-id="<?= $product['id'] ?>"
                                                data-product-name="<?= htmlspecialchars($product['nome']) ?>"
                                                data-product-price="<?= $product['sconto'] > 0 ? $product['prezzo'] * (1 - $product['sconto']/100) : $product['prezzo'] ?>"
                                                data-product-image="<?= htmlspecialchars($product['immagine']) ?>">
                                            <i class="icon-cart-plus"></i>
                                            <span>Aggiungi</span>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </section>

    <!-- Pagination -->
    <?php if ($total_pages > 1): ?>
        <section class="pagination-section">
            <div class="container">
                <nav class="pagination-wrapper">
                    <div class="pagination-info">
                        Pagina <?= $page ?> di <?= $total_pages ?> 
                        (<?= $total_products ?> prodott<?= $total_products !== 1 ? 'i' : 'o' ?> totali)
                    </div>
                    
                    <ul class="pagination">
                        <!-- Previous Page -->
                        <?php if ($page > 1): ?>
                            <li class="page-item">
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page - 1])) ?>" 
                                   class="page-link prev">
                                    <i class="icon-chevron-left"></i> Precedente
                                </a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Page Numbers -->
                        <?php
                        $start_page = max(1, $page - 2);
                        $end_page = min($total_pages, $page + 2);
                        
                        if ($start_page > 1):
                        ?>
                            <li class="page-item">
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => 1])) ?>" 
                                   class="page-link">1</a>
                            </li>
                            <?php if ($start_page > 2): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            <?php endif; ?>
                        <?php endif; ?>
                        
                        <?php for ($i = $start_page; $i <= $end_page; $i++): ?>
                            <li class="page-item <?= $i === $page ? 'active' : '' ?>">
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $i])) ?>" 
                                   class="page-link"><?= $i ?></a>
                            </li>
                        <?php endfor; ?>
                        
                        <?php if ($end_page < $total_pages): ?>
                            <?php if ($end_page < $total_pages - 1): ?>
                                <li class="page-item disabled">
                                    <span class="page-link">...</span>
                                </li>
                            <?php endif; ?>
                            <li class="page-item">
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $total_pages])) ?>" 
                                   class="page-link"><?= $total_pages ?></a>
                            </li>
                        <?php endif; ?>
                        
                        <!-- Next Page -->
                        <?php if ($page < $total_pages): ?>
                            <li class="page-item">
                                <a href="?<?= http_build_query(array_merge($_GET, ['page' => $page + 1])) ?>" 
                                   class="page-link next">
                                    Successiva <i class="icon-chevron-right"></i>
                                </a>
                            </li>
                        <?php endif; ?>
                    </ul>
                </nav>
            </div>
        </section>
    <?php endif; ?>

    <!-- Quick View Modal -->
    <div id="quickViewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Anteprima Prodotto</h3>
                <button class="close-modal">&times;</button>
            </div>
            <div class="modal-body">
                <div class="quick-view-content">
                    <!-- Content loaded via AJAX -->
                </div>
            </div>
        </div>
    </div>
</main>

<!-- Shop Specific Styles -->
<style>
.shop-page {
    padding-top: 0;
}

.page-hero {
    position: relative;
    min-height: 60vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%);
    color: white;
    overflow: hidden;
}

.hero-content {
    position: relative;
    z-index: 2;
    max-width: 600px;
}

.hero-title {
    display: block;
    font-size: 3.5rem;
    font-weight: 800;
    margin-bottom: 1rem;
    background: linear-gradient(45deg, #fff, #ffbf00);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
}

.hero-subtitle {
    display: block;
    font-size: 1.5rem;
    font-weight: 300;
    opacity: 0.9;
    margin-bottom: 2rem;
}

.hero-description {
    font-size: 1.2rem;
    line-height: 1.6;
    opacity: 0.8;
}

.hero-background {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 1;
}

.hero-shape {
    position: absolute;
    border-radius: 50%;
    background: rgba(255, 191, 0, 0.1);
    animation: float 6s ease-in-out infinite;
}

.hero-shape.shape-1 {
    width: 200px;
    height: 200px;
    top: 10%;
    right: 10%;
    animation-delay: 0s;
}

.hero-shape.shape-2 {
    width: 150px;
    height: 150px;
    bottom: 20%;
    left: 5%;
    animation-delay: 2s;
}

.hero-shape.shape-3 {
    width: 100px;
    height: 100px;
    top: 50%;
    right: 30%;
    animation-delay: 4s;
}

.shop-filters {
    background: var(--card-background);
    border-bottom: 1px solid var(--border-color);
    padding: 2rem 0;
}

.filters-wrapper {
    background: white;
    border-radius: 12px;
    padding: 2rem;
    box-shadow: 0 4px 20px rgba(0,0,0,0.1);
}

.filters-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 2rem;
}

.filters-header h2 {
    color: var(--text-color);
    margin: 0;
}

.results-count {
    color: var(--text-muted);
    font-weight: 500;
}

.filters-form {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: 1.5rem;
    align-items: end;
}

.filter-group {
    display: flex;
    flex-direction: column;
}

.filter-group label {
    font-weight: 600;
    color: var(--text-color);
    margin-bottom: 0.5rem;
    font-size: 0.9rem;
}

.search-wrapper {
    position: relative;
}

.search-wrapper input {
    width: 100%;
    padding: 0.75rem 3rem 0.75rem 1rem;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    font-size: 1rem;
    transition: border-color 0.3s ease;
}

.search-wrapper input:focus {
    outline: none;
    border-color: var(--primary-color);
}

.search-btn {
    position: absolute;
    right: 0.5rem;
    top: 50%;
    transform: translateY(-50%);
    background: var(--primary-color);
    color: white;
    border: none;
    border-radius: 6px;
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.search-btn:hover {
    background: var(--primary-dark);
}

.products-section {
    padding: 4rem 0;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
    gap: 2rem;
}

.product-card {
    background: white;
    border-radius: 16px;
    overflow: hidden;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
    position: relative;
}

.product-card:hover {
    transform: translateY(-8px);
    box-shadow: 0 12px 35px rgba(0,0,0,0.15);
}

.product-image {
    position: relative;
    height: 250px;
    background: var(--light-gray);
    overflow: hidden;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.3s ease;
}

.product-card:hover .product-image img {
    transform: scale(1.05);
}

.product-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 3rem;
}

.product-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.8rem;
    font-weight: 600;
    z-index: 2;
}

.badge-featured {
    background: var(--primary-color);
    color: white;
}

.badge-discount {
    background: var(--error-color);
    color: white;
}

.product-actions {
    position: absolute;
    top: 1rem;
    left: 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    opacity: 0;
    transform: translateX(-20px);
    transition: all 0.3s ease;
}

.product-card:hover .product-actions {
    opacity: 1;
    transform: translateX(0);
}

.action-btn {
    width: 2.5rem;
    height: 2.5rem;
    border-radius: 50%;
    background: white;
    color: var(--text-color);
    border: none;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.action-btn:hover {
    background: var(--primary-color);
    color: white;
    transform: scale(1.1);
}

.product-content {
    padding: 1.5rem;
}

.product-category {
    margin-bottom: 0.5rem;
}

.product-category a {
    color: var(--primary-color);
    text-decoration: none;
    font-size: 0.85rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.product-title {
    margin: 0 0 1rem 0;
    font-size: 1.2rem;
    font-weight: 700;
    line-height: 1.3;
}

.product-title a {
    color: var(--text-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.product-title a:hover {
    color: var(--primary-color);
}

.product-description {
    color: var(--text-muted);
    font-size: 0.9rem;
    line-height: 1.5;
    margin-bottom: 1.5rem;
    overflow: hidden;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
}

.product-footer {
    display: flex;
    justify-content: space-between;
    align-items: center;
}

.product-price {
    font-weight: 700;
}

.price-current {
    color: var(--primary-color);
    font-size: 1.2rem;
}

.price-original {
    color: var(--text-muted);
    text-decoration: line-through;
    font-size: 0.9rem;
    margin-right: 0.5rem;
}

.price-discounted {
    color: var(--error-color);
    font-size: 1.2rem;
}

.no-products {
    text-align: center;
    padding: 4rem 2rem;
    color: var(--text-muted);
}

.no-products-icon {
    font-size: 4rem;
    margin-bottom: 1.5rem;
    opacity: 0.5;
}

.no-products h3 {
    margin-bottom: 1rem;
    color: var(--text-color);
}

.pagination-section {
    padding: 2rem 0;
    background: var(--light-background);
    border-top: 1px solid var(--border-color);
}

.pagination-wrapper {
    display: flex;
    justify-content: space-between;
    align-items: center;
    flex-wrap: wrap;
    gap: 1rem;
}

.pagination-info {
    color: var(--text-muted);
    font-size: 0.9rem;
}

.pagination {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    gap: 0.25rem;
}

.page-item {
    display: flex;
}

.page-link {
    padding: 0.5rem 0.75rem;
    color: var(--text-color);
    text-decoration: none;
    border: 1px solid var(--border-color);
    border-radius: 6px;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    gap: 0.25rem;
}

.page-link:hover:not(.disabled) {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.page-item.active .page-link {
    background: var(--primary-color);
    color: white;
    border-color: var(--primary-color);
}

.page-item.disabled .page-link {
    color: var(--text-muted);
    cursor: not-allowed;
}

@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .hero-subtitle {
        font-size: 1.2rem;
    }
    
    .filters-form {
        grid-template-columns: 1fr;
    }
    
    .filters-header {
        flex-direction: column;
        align-items: flex-start;
        gap: 1rem;
    }
    
    .products-grid {
        grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
        gap: 1.5rem;
    }
    
    .pagination-wrapper {
        flex-direction: column;
        text-align: center;
    }
    
    .pagination {
        flex-wrap: wrap;
        justify-content: center;
    }
}

@keyframes float {
    0%, 100% {
        transform: translateY(0px) rotate(0deg);
    }
    50% {
        transform: translateY(-20px) rotate(180deg);
    }
}
</style>

<script>
// Shop specific JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Quick View functionality
    document.querySelectorAll('.quick-view').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            openQuickView(productId);
        });
    });
    
    // Add to cart from shop page
    document.querySelectorAll('.add-to-cart').forEach(btn => {
        btn.addEventListener('click', function() {
            const productData = {
                id: this.dataset.productId,
                name: this.dataset.productName,
                price: parseFloat(this.dataset.productPrice),
                image: this.dataset.productImage,
                quantity: 1
            };
            
            if (window.cart) {
                window.cart.addItem(productData);
                AgenziaPlinio.showToast('Prodotto aggiunto al carrello', 'success');
            }
        });
    });
    
    // Wishlist functionality
    document.querySelectorAll('.add-to-wishlist').forEach(btn => {
        btn.addEventListener('click', function() {
            const productId = this.dataset.productId;
            toggleWishlist(productId, this);
        });
    });
});

function openQuickView(productId) {
    const modal = document.getElementById('quickViewModal');
    const content = modal.querySelector('.quick-view-content');
    
    // Show loading
    content.innerHTML = '<div class="loading">Caricamento...</div>';
    modal.style.display = 'block';
    
    // Fetch product details
    fetch(`api/product-details.php?id=${productId}`)
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                content.innerHTML = generateQuickViewHTML(data.product);
            } else {
                content.innerHTML = '<div class="error">Errore nel caricamento del prodotto</div>';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            content.innerHTML = '<div class="error">Errore nel caricamento del prodotto</div>';
        });
}

function generateQuickViewHTML(product) {
    const discountedPrice = product.sconto > 0 ? 
        product.prezzo * (1 - product.sconto/100) : product.prezzo;
    
    return `
        <div class="quick-view-grid">
            <div class="quick-view-image">
                ${product.immagine ? 
                    `<img src="${product.immagine}" alt="${product.nome}">` :
                    '<div class="product-placeholder"><i class="icon-package"></i></div>'
                }
            </div>
            <div class="quick-view-details">
                <div class="product-category">
                    <a href="shop?categoria=${product.categoria_slug}">
                        ${product.categoria_nome}
                    </a>
                </div>
                <h3>${product.nome}</h3>
                <p class="product-description">${product.descrizione_breve}</p>
                <div class="product-price">
                    ${product.sconto > 0 ? 
                        `<span class="price-original">€${product.prezzo.toFixed(2)}</span>
                         <span class="price-discounted">€${discountedPrice.toFixed(2)}</span>` :
                        `<span class="price-current">€${product.prezzo.toFixed(2)}</span>`
                    }
                </div>
                <div class="quick-view-actions">
                    <button class="btn btn-primary add-to-cart" 
                            data-product-id="${product.id}"
                            data-product-name="${product.nome}"
                            data-product-price="${discountedPrice}"
                            data-product-image="${product.immagine || ''}">
                        <i class="icon-cart-plus"></i> Aggiungi al carrello
                    </button>
                    <a href="prodotto/${product.slug}" class="btn btn-outline-primary">
                        Vedi dettagli
                    </a>
                </div>
            </div>
        </div>
    `;
}

function toggleWishlist(productId, button) {
    // Check if user is logged in
    if (!AgenziaPlinio.user.isLoggedIn) {
        AgenziaPlinio.showToast('Devi effettuare l\'accesso per aggiungere ai preferiti', 'warning');
        return;
    }
    
    fetch('api/wishlist.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-Token': AgenziaPlinio.csrf_token
        },
        body: JSON.stringify({
            action: 'toggle',
            product_id: productId
        })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            button.classList.toggle('active', data.added);
            const message = data.added ? 
                'Prodotto aggiunto ai preferiti' : 
                'Prodotto rimosso dai preferiti';
            AgenziaPlinio.showToast(message, 'success');
        } else {
            AgenziaPlinio.showToast(data.message || 'Errore nell\'operazione', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        AgenziaPlinio.showToast('Errore nell\'operazione', 'error');
    });
}
</script>

<?php include 'includes/footer.php'; ?>