<?php
require_once 'includes/config.php';
require_once 'includes/auth.php';

// Get product slug from URL
$slug = isset($_GET['slug']) ? sanitizeInput($_GET['slug']) : '';

if (empty($slug)) {
    header('Location: shop');
    exit;
}

try {
    $pdo = getDBConnection();
    
    // Get product details
    $product_stmt = $pdo->prepare("
        SELECT p.*, c.nome as categoria_nome, c.slug as categoria_slug
        FROM prodotti p
        LEFT JOIN categorie_prodotti c ON p.categoria_id = c.id
        WHERE p.slug = :slug AND p.attivo = 1
    ");
    $product_stmt->execute(['slug' => $slug]);
    $product = $product_stmt->fetch(PDO::FETCH_ASSOC);
    
    if (!$product) {
        header('Location: shop');
        exit;
    }
    
    // Get related products
    $related_stmt = $pdo->prepare("
        SELECT p.*, c.nome as categoria_nome, c.slug as categoria_slug
        FROM prodotti p
        LEFT JOIN categorie_prodotti c ON p.categoria_id = c.id
        WHERE p.categoria_id = :categoria_id 
        AND p.id != :product_id 
        AND p.attivo = 1
        ORDER BY p.in_evidenza DESC, RAND()
        LIMIT 4
    ");
    $related_stmt->execute([
        'categoria_id' => $product['categoria_id'],
        'product_id' => $product['id']
    ]);
    $related_products = $related_stmt->fetchAll(PDO::FETCH_ASSOC);
    
    // Calculate final price
    $final_price = $product['sconto'] > 0 ? 
        $product['prezzo'] * (1 - $product['sconto']/100) : 
        $product['prezzo'];
    
    // Set page meta
    $page_title = $product['nome'] . ' - ' . $product['categoria_nome'];
    $page_description = $product['descrizione_breve'];
    $current_page = 'prodotto';
    
    // Log product view
    if (isset($_SESSION['utente_id'])) {
        logActivity($_SESSION['utente_id'], 'product_view', "Visualizzato prodotto: {$product['nome']}");
    }
    
} catch (PDOException $e) {
    error_log("Product page error: " . $e->getMessage());
    header('Location: shop');
    exit;
}

include 'includes/header.php';
?>

<main class="product-page">
    <!-- Breadcrumb -->
    <nav class="breadcrumb" aria-label="breadcrumb">
        <div class="container">
            <ol class="breadcrumb-list">
                <li><a href="/">Home</a></li>
                <li><a href="shop">Shop</a></li>
                <li><a href="shop?categoria=<?= urlencode($product['categoria_slug']) ?>">
                    <?= htmlspecialchars($product['categoria_nome']) ?>
                </a></li>
                <li class="active" aria-current="page"><?= htmlspecialchars($product['nome']) ?></li>
            </ol>
        </div>
    </nav>

    <!-- Product Details -->
    <section class="product-details">
        <div class="container">
            <div class="product-grid">
                <!-- Product Images -->
                <div class="product-images">
                    <div class="main-image">
                        <?php if ($product['immagine']): ?>
                            <img src="<?= htmlspecialchars($product['immagine']) ?>" 
                                 alt="<?= htmlspecialchars($product['nome']) ?>"
                                 id="mainProductImage">
                        <?php else: ?>
                            <div class="image-placeholder">
                                <i class="icon-package"></i>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($product['in_evidenza']): ?>
                            <span class="product-badge badge-featured">In Evidenza</span>
                        <?php endif; ?>
                        
                        <?php if ($product['sconto'] > 0): ?>
                            <span class="product-badge badge-discount">-<?= $product['sconto'] ?>%</span>
                        <?php endif; ?>
                    </div>
                    
                    <!-- Image Gallery (placeholder for future implementation) -->
                    <div class="image-gallery">
                        <div class="gallery-item active">
                            <?php if ($product['immagine']): ?>
                                <img src="<?= htmlspecialchars($product['immagine']) ?>" 
                                     alt="<?= htmlspecialchars($product['nome']) ?>">
                            <?php else: ?>
                                <div class="gallery-placeholder">
                                    <i class="icon-package"></i>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <!-- Product Info -->
                <div class="product-info">
                    <div class="product-meta">
                        <a href="shop?categoria=<?= urlencode($product['categoria_slug']) ?>" 
                           class="product-category">
                            <?= htmlspecialchars($product['categoria_nome']) ?>
                        </a>
                        <div class="product-id">ID: <?= $product['id'] ?></div>
                    </div>
                    
                    <h1 class="product-title"><?= htmlspecialchars($product['nome']) ?></h1>
                    
                    <div class="product-price">
                        <?php if ($product['sconto'] > 0): ?>
                            <span class="price-original">€<?= number_format($product['prezzo'], 2) ?></span>
                            <span class="price-discounted">€<?= number_format($final_price, 2) ?></span>
                            <span class="savings">Risparmi €<?= number_format($product['prezzo'] - $final_price, 2) ?></span>
                        <?php else: ?>
                            <span class="price-current">€<?= number_format($final_price, 2) ?></span>
                        <?php endif; ?>
                    </div>
                    
                    <div class="product-description">
                        <p class="description-brief"><?= nl2br(htmlspecialchars($product['descrizione_breve'])) ?></p>
                    </div>
                    
                    <!-- Add to Cart Form -->
                    <form class="add-to-cart-form" id="addToCartForm">
                        <div class="quantity-selector">
                            <label for="quantity">Quantità:</label>
                            <div class="quantity-controls">
                                <button type="button" class="quantity-btn minus" onclick="changeQuantity(-1)">-</button>
                                <input type="number" 
                                       id="quantity" 
                                       name="quantity" 
                                       value="1" 
                                       min="1" 
                                       max="10" 
                                       readonly>
                                <button type="button" class="quantity-btn plus" onclick="changeQuantity(1)">+</button>
                            </div>
                        </div>
                        
                        <div class="product-actions">
                            <button type="button" 
                                    class="btn btn-primary btn-large add-to-cart"
                                    data-product-id="<?= $product['id'] ?>"
                                    data-product-name="<?= htmlspecialchars($product['nome']) ?>"
                                    data-product-price="<?= $final_price ?>"
                                    data-product-image="<?= htmlspecialchars($product['immagine']) ?>">
                                <i class="icon-cart-plus"></i>
                                <span>Aggiungi al Carrello</span>
                            </button>
                            
                            <button type="button" 
                                    class="btn btn-outline-primary wishlist-btn"
                                    data-product-id="<?= $product['id'] ?>"
                                    title="Aggiungi ai preferiti">
                                <i class="icon-heart"></i>
                            </button>
                            
                            <button type="button" 
                                    class="btn btn-outline-secondary share-btn"
                                    onclick="shareProduct()"
                                    title="Condividi prodotto">
                                <i class="icon-share"></i>
                            </button>
                        </div>
                    </form>
                    
                    <!-- Product Features -->
                    <div class="product-features">
                        <div class="feature">
                            <i class="icon-shield-check"></i>
                            <span>Garanzia qualità</span>
                        </div>
                        <div class="feature">
                            <i class="icon-truck"></i>
                            <span>Consegna rapida</span>
                        </div>
                        <div class="feature">
                            <i class="icon-headphones"></i>
                            <span>Supporto dedicato</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Product Tabs -->
    <section class="product-tabs">
        <div class="container">
            <div class="tabs-wrapper">
                <div class="tabs-nav">
                    <button class="tab-btn active" data-tab="description">
                        <i class="icon-file-text"></i> Descrizione
                    </button>
                    <button class="tab-btn" data-tab="specifications">
                        <i class="icon-list"></i> Specifiche
                    </button>
                    <button class="tab-btn" data-tab="reviews">
                        <i class="icon-star"></i> Recensioni
                    </button>
                </div>
                
                <div class="tabs-content">
                    <div class="tab-pane active" id="description">
                        <div class="description-content">
                            <?php if (!empty($product['descrizione'])): ?>
                                <?= nl2br(htmlspecialchars($product['descrizione'])) ?>
                            <?php else: ?>
                                <p>Descrizione dettagliata non disponibile.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="specifications">
                        <div class="specifications-content">
                            <table class="specs-table">
                                <tr>
                                    <td>Categoria</td>
                                    <td><?= htmlspecialchars($product['categoria_nome']) ?></td>
                                </tr>
                                <tr>
                                    <td>Prezzo</td>
                                    <td>€<?= number_format($final_price, 2) ?></td>
                                </tr>
                                <?php if ($product['sconto'] > 0): ?>
                                <tr>
                                    <td>Sconto</td>
                                    <td><?= $product['sconto'] ?>%</td>
                                </tr>
                                <?php endif; ?>
                                <tr>
                                    <td>Disponibilità</td>
                                    <td><span class="status-available">Disponibile</span></td>
                                </tr>
                                <tr>
                                    <td>ID Prodotto</td>
                                    <td><?= $product['id'] ?></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                    
                    <div class="tab-pane" id="reviews">
                        <div class="reviews-content">
                            <div class="reviews-summary">
                                <div class="rating-overview">
                                    <div class="rating-score">4.5</div>
                                    <div class="rating-stars">
                                        <i class="icon-star filled"></i>
                                        <i class="icon-star filled"></i>
                                        <i class="icon-star filled"></i>
                                        <i class="icon-star filled"></i>
                                        <i class="icon-star"></i>
                                    </div>
                                    <div class="rating-count">Basato su 12 recensioni</div>
                                </div>
                                
                                <div class="rating-breakdown">
                                    <div class="rating-row">
                                        <span>5 stelle</span>
                                        <div class="rating-bar">
                                            <div class="rating-fill" style="width: 80%"></div>
                                        </div>
                                        <span>8</span>
                                    </div>
                                    <div class="rating-row">
                                        <span>4 stelle</span>
                                        <div class="rating-bar">
                                            <div class="rating-fill" style="width: 20%"></div>
                                        </div>
                                        <span>2</span>
                                    </div>
                                    <div class="rating-row">
                                        <span>3 stelle</span>
                                        <div class="rating-bar">
                                            <div class="rating-fill" style="width: 10%"></div>
                                        </div>
                                        <span>1</span>
                                    </div>
                                    <div class="rating-row">
                                        <span>2 stelle</span>
                                        <div class="rating-bar">
                                            <div class="rating-fill" style="width: 5%"></div>
                                        </div>
                                        <span>1</span>
                                    </div>
                                    <div class="rating-row">
                                        <span>1 stella</span>
                                        <div class="rating-bar">
                                            <div class="rating-fill" style="width: 0%"></div>
                                        </div>
                                        <span>0</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="reviews-list">
                                <!-- Placeholder reviews -->
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">M</div>
                                            <div class="reviewer-details">
                                                <div class="reviewer-name">Marco R.</div>
                                                <div class="review-date">15 giorni fa</div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <i class="icon-star filled"></i>
                                            <i class="icon-star filled"></i>
                                            <i class="icon-star filled"></i>
                                            <i class="icon-star filled"></i>
                                            <i class="icon-star filled"></i>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <p>Ottimo prodotto, molto soddisfatto dell'acquisto. Servizio clienti eccellente e consegna rapida.</p>
                                    </div>
                                </div>
                                
                                <div class="review-item">
                                    <div class="review-header">
                                        <div class="reviewer-info">
                                            <div class="reviewer-avatar">A</div>
                                            <div class="reviewer-details">
                                                <div class="reviewer-name">Anna S.</div>
                                                <div class="review-date">1 mese fa</div>
                                            </div>
                                        </div>
                                        <div class="review-rating">
                                            <i class="icon-star filled"></i>
                                            <i class="icon-star filled"></i>
                                            <i class="icon-star filled"></i>
                                            <i class="icon-star filled"></i>
                                            <i class="icon-star"></i>
                                        </div>
                                    </div>
                                    <div class="review-content">
                                        <p>Buona qualità e prezzo competitivo. Consiglio questo prodotto.</p>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="write-review">
                                <h4>Scrivi una recensione</h4>
                                <form class="review-form" id="reviewForm">
                                    <div class="rating-input">
                                        <label>La tua valutazione:</label>
                                        <div class="star-rating" data-rating="0">
                                            <i class="icon-star" data-value="1"></i>
                                            <i class="icon-star" data-value="2"></i>
                                            <i class="icon-star" data-value="3"></i>
                                            <i class="icon-star" data-value="4"></i>
                                            <i class="icon-star" data-value="5"></i>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="reviewText">La tua recensione:</label>
                                        <textarea id="reviewText" 
                                                  name="review" 
                                                  rows="4" 
                                                  placeholder="Condividi la tua esperienza con questo prodotto..."></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary">Pubblica Recensione</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Related Products -->
    <?php if (!empty($related_products)): ?>
        <section class="related-products">
            <div class="container">
                <div class="section-header">
                    <h2>Prodotti Correlati</h2>
                    <p>Altri prodotti che potrebbero interessarti</p>
                </div>
                
                <div class="products-grid">
                    <?php foreach ($related_products as $related): ?>
                        <article class="product-card" data-product-id="<?= $related['id'] ?>">
                            <div class="product-image">
                                <?php if ($related['immagine']): ?>
                                    <img src="<?= htmlspecialchars($related['immagine']) ?>" 
                                         alt="<?= htmlspecialchars($related['nome']) ?>"
                                         loading="lazy">
                                <?php else: ?>
                                    <div class="product-placeholder">
                                        <i class="icon-package"></i>
                                    </div>
                                <?php endif; ?>
                                
                                <?php if ($related['in_evidenza']): ?>
                                    <span class="product-badge badge-featured">In Evidenza</span>
                                <?php endif; ?>
                                
                                <?php if ($related['sconto'] > 0): ?>
                                    <span class="product-badge badge-discount">-<?= $related['sconto'] ?>%</span>
                                <?php endif; ?>
                            </div>
                            
                            <div class="product-content">
                                <div class="product-category">
                                    <a href="shop?categoria=<?= urlencode($related['categoria_slug']) ?>">
                                        <?= htmlspecialchars($related['categoria_nome']) ?>
                                    </a>
                                </div>
                                
                                <h3 class="product-title">
                                    <a href="prodotto/<?= urlencode($related['slug']) ?>">
                                        <?= htmlspecialchars($related['nome']) ?>
                                    </a>
                                </h3>
                                
                                <div class="product-price">
                                    <?php $related_final_price = $related['sconto'] > 0 ? 
                                        $related['prezzo'] * (1 - $related['sconto']/100) : $related['prezzo']; ?>
                                    
                                    <?php if ($related['sconto'] > 0): ?>
                                        <span class="price-original">€<?= number_format($related['prezzo'], 2) ?></span>
                                        <span class="price-discounted">€<?= number_format($related_final_price, 2) ?></span>
                                    <?php else: ?>
                                        <span class="price-current">€<?= number_format($related_final_price, 2) ?></span>
                                    <?php endif; ?>
                                </div>
                                
                                <button class="btn btn-primary add-to-cart" 
                                        data-product-id="<?= $related['id'] ?>"
                                        data-product-name="<?= htmlspecialchars($related['nome']) ?>"
                                        data-product-price="<?= $related_final_price ?>"
                                        data-product-image="<?= htmlspecialchars($related['immagine']) ?>">
                                    <i class="icon-cart-plus"></i>
                                    Aggiungi
                                </button>
                            </div>
                        </article>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
</main>

<style>
.product-page {
    padding-top: 0;
}

.breadcrumb {
    background: var(--light-background);
    padding: 1rem 0;
    border-bottom: 1px solid var(--border-color);
}

.breadcrumb-list {
    display: flex;
    list-style: none;
    margin: 0;
    padding: 0;
    align-items: center;
    gap: 0.5rem;
}

.breadcrumb-list li {
    position: relative;
}

.breadcrumb-list li:not(:last-child)::after {
    content: '/';
    margin-left: 0.5rem;
    color: var(--text-muted);
}

.breadcrumb-list a {
    color: var(--primary-color);
    text-decoration: none;
    transition: color 0.3s ease;
}

.breadcrumb-list a:hover {
    color: var(--primary-dark);
}

.breadcrumb-list .active {
    color: var(--text-muted);
}

.product-details {
    padding: 4rem 0;
}

.product-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 4rem;
    align-items: start;
}

.product-images {
    position: sticky;
    top: 2rem;
}

.main-image {
    position: relative;
    background: white;
    border-radius: 16px;
    overflow: hidden;
    margin-bottom: 1rem;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
}

.main-image img {
    width: 100%;
    height: 500px;
    object-fit: cover;
}

.image-placeholder {
    width: 100%;
    height: 500px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: var(--text-muted);
    font-size: 4rem;
    background: var(--light-gray);
}

.product-badge {
    position: absolute;
    top: 1rem;
    right: 1rem;
    padding: 0.5rem 1rem;
    border-radius: 25px;
    font-size: 0.85rem;
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

.image-gallery {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
}

.gallery-item {
    flex: 0 0 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    cursor: pointer;
    border: 2px solid transparent;
    transition: border-color 0.3s ease;
}

.gallery-item.active {
    border-color: var(--primary-color);
}

.gallery-item img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.gallery-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: var(--light-gray);
    color: var(--text-muted);
}

.product-info {
    padding: 1rem 0;
}

.product-meta {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.product-category {
    color: var(--primary-color);
    text-decoration: none;
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.product-id {
    color: var(--text-muted);
    font-size: 0.85rem;
}

.product-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-color);
    margin: 0 0 1.5rem 0;
    line-height: 1.2;
}

.product-price {
    margin-bottom: 2rem;
}

.price-current {
    font-size: 2rem;
    font-weight: 700;
    color: var(--primary-color);
}

.price-original {
    font-size: 1.2rem;
    color: var(--text-muted);
    text-decoration: line-through;
    margin-right: 1rem;
}

.price-discounted {
    font-size: 2rem;
    font-weight: 700;
    color: var(--error-color);
    margin-right: 1rem;
}

.savings {
    display: inline-block;
    background: var(--success-color);
    color: white;
    padding: 0.3rem 0.8rem;
    border-radius: 20px;
    font-size: 0.85rem;
    font-weight: 600;
}

.product-description {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.description-brief {
    font-size: 1.1rem;
    line-height: 1.6;
    color: var(--text-color);
}

.add-to-cart-form {
    margin-bottom: 3rem;
}

.quantity-selector {
    margin-bottom: 2rem;
}

.quantity-selector label {
    display: block;
    font-weight: 600;
    margin-bottom: 0.5rem;
    color: var(--text-color);
}

.quantity-controls {
    display: flex;
    align-items: center;
    width: fit-content;
    border: 2px solid var(--border-color);
    border-radius: 8px;
    overflow: hidden;
}

.quantity-btn {
    width: 3rem;
    height: 3rem;
    border: none;
    background: var(--light-background);
    color: var(--text-color);
    font-size: 1.2rem;
    cursor: pointer;
    transition: background-color 0.3s ease;
}

.quantity-btn:hover {
    background: var(--primary-color);
    color: white;
}

.quantity-controls input {
    width: 4rem;
    height: 3rem;
    border: none;
    text-align: center;
    font-size: 1.1rem;
    font-weight: 600;
    background: white;
}

.product-actions {
    display: flex;
    gap: 1rem;
    align-items: center;
}

.btn-large {
    padding: 1rem 2rem;
    font-size: 1.1rem;
    font-weight: 600;
    min-width: 200px;
}

.product-features {
    display: flex;
    gap: 2rem;
    margin-top: 2rem;
    padding-top: 2rem;
    border-top: 1px solid var(--border-color);
}

.feature {
    display: flex;
    align-items: center;
    gap: 0.5rem;
    color: var(--text-muted);
    font-size: 0.9rem;
}

.feature i {
    color: var(--success-color);
    font-size: 1.2rem;
}

.product-tabs {
    background: var(--light-background);
    padding: 3rem 0;
}

.tabs-wrapper {
    background: white;
    border-radius: 16px;
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    overflow: hidden;
}

.tabs-nav {
    display: flex;
    background: var(--light-background);
    border-bottom: 1px solid var(--border-color);
}

.tab-btn {
    flex: 1;
    padding: 1.5rem 2rem;
    border: none;
    background: transparent;
    color: var(--text-muted);
    font-size: 1rem;
    font-weight: 600;
    cursor: pointer;
    transition: all 0.3s ease;
    display: flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
}

.tab-btn:hover {
    color: var(--primary-color);
    background: rgba(var(--primary-color-rgb), 0.1);
}

.tab-btn.active {
    color: var(--primary-color);
    background: white;
    border-bottom: 3px solid var(--primary-color);
}

.tabs-content {
    padding: 3rem;
}

.tab-pane {
    display: none;
}

.tab-pane.active {
    display: block;
    animation: fadeIn 0.3s ease;
}

.description-content {
    font-size: 1.1rem;
    line-height: 1.8;
    color: var(--text-color);
}

.specs-table {
    width: 100%;
    border-collapse: collapse;
}

.specs-table td {
    padding: 1rem;
    border-bottom: 1px solid var(--border-color);
    vertical-align: top;
}

.specs-table td:first-child {
    font-weight: 600;
    color: var(--text-color);
    width: 200px;
}

.specs-table td:last-child {
    color: var(--text-muted);
}

.status-available {
    color: var(--success-color);
    font-weight: 600;
}

.reviews-content {
    max-width: 800px;
}

.reviews-summary {
    display: grid;
    grid-template-columns: 1fr 2fr;
    gap: 3rem;
    margin-bottom: 3rem;
    padding-bottom: 3rem;
    border-bottom: 1px solid var(--border-color);
}

.rating-overview {
    text-align: center;
}

.rating-score {
    font-size: 3rem;
    font-weight: 700;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.rating-stars {
    font-size: 1.5rem;
    color: var(--primary-color);
    margin-bottom: 0.5rem;
}

.rating-count {
    color: var(--text-muted);
}

.rating-row {
    display: flex;
    align-items: center;
    gap: 1rem;
    margin-bottom: 0.5rem;
}

.rating-row span:first-child {
    width: 80px;
    font-size: 0.9rem;
    color: var(--text-muted);
}

.rating-bar {
    flex: 1;
    height: 8px;
    background: var(--light-gray);
    border-radius: 4px;
    overflow: hidden;
}

.rating-fill {
    height: 100%;
    background: var(--primary-color);
}

.rating-row span:last-child {
    width: 30px;
    text-align: right;
    font-size: 0.9rem;
    color: var(--text-muted);
}

.review-item {
    margin-bottom: 2rem;
    padding-bottom: 2rem;
    border-bottom: 1px solid var(--border-color);
}

.review-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 1rem;
}

.reviewer-info {
    display: flex;
    align-items: center;
    gap: 1rem;
}

.reviewer-avatar {
    width: 40px;
    height: 40px;
    background: var(--primary-color);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: 600;
}

.reviewer-name {
    font-weight: 600;
    color: var(--text-color);
}

.review-date {
    font-size: 0.85rem;
    color: var(--text-muted);
}

.review-rating {
    color: var(--primary-color);
}

.review-content {
    color: var(--text-color);
    line-height: 1.6;
}

.write-review {
    margin-top: 3rem;
    padding-top: 3rem;
    border-top: 1px solid var(--border-color);
}

.write-review h4 {
    margin-bottom: 2rem;
    color: var(--text-color);
}

.rating-input {
    margin-bottom: 1.5rem;
}

.rating-input label {
    display: block;
    margin-bottom: 0.5rem;
    font-weight: 600;
}

.star-rating {
    display: flex;
    gap: 0.25rem;
    font-size: 1.5rem;
}

.star-rating i {
    cursor: pointer;
    color: var(--light-gray);
    transition: color 0.3s ease;
}

.star-rating i:hover,
.star-rating i.filled {
    color: var(--primary-color);
}

.related-products {
    padding: 4rem 0;
}

.section-header {
    text-align: center;
    margin-bottom: 3rem;
}

.section-header h2 {
    font-size: 2.5rem;
    font-weight: 700;
    color: var(--text-color);
    margin-bottom: 1rem;
}

.section-header p {
    color: var(--text-muted);
    font-size: 1.1rem;
}

.products-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
    gap: 2rem;
}

@media (max-width: 768px) {
    .product-grid {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
    
    .product-title {
        font-size: 2rem;
    }
    
    .product-actions {
        flex-direction: column;
        align-items: stretch;
    }
    
    .btn-large {
        min-width: auto;
        width: 100%;
    }
    
    .product-features {
        flex-direction: column;
        gap: 1rem;
    }
    
    .tabs-nav {
        flex-direction: column;
    }
    
    .tabs-content {
        padding: 2rem 1rem;
    }
    
    .reviews-summary {
        grid-template-columns: 1fr;
        gap: 2rem;
    }
}

@keyframes fadeIn {
    from {
        opacity: 0;
        transform: translateY(10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}
</style>

<script>
// Product page functionality
document.addEventListener('DOMContentLoaded', function() {
    initializeProductPage();
});

function initializeProductPage() {
    // Tab functionality
    const tabButtons = document.querySelectorAll('.tab-btn');
    const tabPanes = document.querySelectorAll('.tab-pane');
    
    tabButtons.forEach(button => {
        button.addEventListener('click', function() {
            const tabId = this.dataset.tab;
            
            // Update active button
            tabButtons.forEach(btn => btn.classList.remove('active'));
            this.classList.add('active');
            
            // Update active pane
            tabPanes.forEach(pane => pane.classList.remove('active'));
            document.getElementById(tabId).classList.add('active');
        });
    });
    
    // Add to cart functionality
    const addToCartBtn = document.querySelector('.add-to-cart');
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', function() {
            const quantity = document.getElementById('quantity').value;
            const productData = {
                id: this.dataset.productId,
                name: this.dataset.productName,
                price: parseFloat(this.dataset.productPrice),
                image: this.dataset.productImage,
                quantity: parseInt(quantity)
            };
            
            if (window.cart) {
                window.cart.addItem(productData);
                AgenziaPlinio.showToast('Prodotto aggiunto al carrello', 'success');
                
                // Update button temporarily
                const originalText = this.innerHTML;
                this.innerHTML = '<i class="icon-check"></i> Aggiunto!';
                this.classList.add('success');
                
                setTimeout(() => {
                    this.innerHTML = originalText;
                    this.classList.remove('success');
                }, 2000);
            }
        });
    }
    
    // Related products add to cart
    document.querySelectorAll('.related-products .add-to-cart').forEach(btn => {
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
    const wishlistBtn = document.querySelector('.wishlist-btn');
    if (wishlistBtn) {
        wishlistBtn.addEventListener('click', function() {
            toggleWishlist(this.dataset.productId, this);
        });
    }
    
    // Star rating functionality
    const starRating = document.querySelector('.star-rating');
    if (starRating) {
        const stars = starRating.querySelectorAll('i');
        
        stars.forEach((star, index) => {
            star.addEventListener('mouseenter', function() {
                highlightStars(index + 1);
            });
            
            star.addEventListener('click', function() {
                setRating(index + 1);
            });
        });
        
        starRating.addEventListener('mouseleave', function() {
            const currentRating = parseInt(this.dataset.rating) || 0;
            highlightStars(currentRating);
        });
        
        function highlightStars(rating) {
            stars.forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('filled');
                } else {
                    star.classList.remove('filled');
                }
            });
        }
        
        function setRating(rating) {
            starRating.dataset.rating = rating;
            highlightStars(rating);
        }
    }
    
    // Review form submission
    const reviewForm = document.getElementById('reviewForm');
    if (reviewForm) {
        reviewForm.addEventListener('submit', function(e) {
            e.preventDefault();
            
            const rating = starRating ? parseInt(starRating.dataset.rating) : 0;
            const reviewText = document.getElementById('reviewText').value.trim();
            
            if (rating === 0) {
                AgenziaPlinio.showToast('Seleziona una valutazione', 'warning');
                return;
            }
            
            if (reviewText === '') {
                AgenziaPlinio.showToast('Scrivi una recensione', 'warning');
                return;
            }
            
            // Here you would typically send the review to the server
            AgenziaPlinio.showToast('Grazie per la tua recensione!', 'success');
            
            // Reset form
            starRating.dataset.rating = '0';
            highlightStars(0);
            document.getElementById('reviewText').value = '';
        });
    }
}

function changeQuantity(delta) {
    const quantityInput = document.getElementById('quantity');
    const currentValue = parseInt(quantityInput.value);
    const newValue = Math.max(1, Math.min(10, currentValue + delta));
    quantityInput.value = newValue;
}

function shareProduct() {
    const productTitle = document.querySelector('.product-title').textContent;
    const productUrl = window.location.href;
    
    if (navigator.share) {
        navigator.share({
            title: productTitle,
            url: productUrl,
            text: `Guarda questo prodotto: ${productTitle}`
        }).catch(console.error);
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(productUrl).then(() => {
            AgenziaPlinio.showToast('Link copiato negli appunti', 'success');
        }).catch(() => {
            AgenziaPlinio.showToast('Impossibile copiare il link', 'error');
        });
    }
}

function toggleWishlist(productId, button) {
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
            const icon = button.querySelector('i');
            if (data.added) {
                icon.className = 'icon-heart-filled';
                button.style.color = 'var(--error-color)';
            } else {
                icon.className = 'icon-heart';
                button.style.color = '';
            }
            
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