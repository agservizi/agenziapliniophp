/**
 * Gestione Carrello Shopping - JavaScript Vanilla
 * Agenzia Plinio E-commerce
 */

window.ShoppingCart = {
  items: [],
  total: 0,
  
  init: function() {
    this.loadFromStorage();
    this.updateCartUI();
    this.bindEvents();
    console.log('🛒 Sistema carrello inizializzato');
  },
  
  // Carica carrello da localStorage
  loadFromStorage: function() {
    const saved = localStorage.getItem('cart_items');
    if (saved) {
      try {
        this.items = JSON.parse(saved);
        this.calculateTotal();
      } catch (e) {
        console.error('Errore caricamento carrello:', e);
        this.items = [];
      }
    }
  },
  
  // Salva carrello in localStorage
  saveToStorage: function() {
    try {
      localStorage.setItem('cart_items', JSON.stringify(this.items));
    } catch (e) {
      console.error('Errore salvataggio carrello:', e);
    }
  },
  
  // Aggiunge prodotto al carrello
  addItem: function(product) {
    const existingItem = this.items.find(item => item.id === product.id);
    
    if (existingItem) {
      existingItem.quantity += product.quantity || 1;
    } else {
      this.items.push({
        id: product.id,
        nome: product.nome,
        prezzo: product.prezzo,
        immagine: product.immagine || '',
        quantity: product.quantity || 1,
        tipo: product.tipo || 'digitale'
      });
    }
    
    this.calculateTotal();
    this.saveToStorage();
    this.updateCartUI();
    this.showAddedNotification(product);
    
    // Trigger evento personalizzato
    this.triggerEvent('itemAdded', { product, cart: this.items });
  },
  
  // Rimuove prodotto dal carrello
  removeItem: function(productId) {
    const itemIndex = this.items.findIndex(item => item.id === productId);
    
    if (itemIndex !== -1) {
      const removedItem = this.items.splice(itemIndex, 1)[0];
      this.calculateTotal();
      this.saveToStorage();
      this.updateCartUI();
      
      window.AgenziaPlinio.showToast(`${removedItem.nome} rimosso dal carrello`, 'info');
      
      this.triggerEvent('itemRemoved', { productId, cart: this.items });
    }
  },
  
  // Aggiorna quantità prodotto
  updateQuantity: function(productId, newQuantity) {
    const item = this.items.find(item => item.id === productId);
    
    if (item) {
      if (newQuantity <= 0) {
        this.removeItem(productId);
      } else {
        item.quantity = newQuantity;
        this.calculateTotal();
        this.saveToStorage();
        this.updateCartUI();
        
        this.triggerEvent('quantityUpdated', { productId, quantity: newQuantity, cart: this.items });
      }
    }
  },
  
  // Svuota carrello
  clearCart: function() {
    this.items = [];
    this.total = 0;
    this.saveToStorage();
    this.updateCartUI();
    
    window.AgenziaPlinio.showToast('Carrello svuotato', 'info');
    this.triggerEvent('cartCleared', { cart: this.items });
  },
  
  // Calcola totale carrello
  calculateTotal: function() {
    this.total = this.items.reduce((sum, item) => {
      return sum + (parseFloat(item.prezzo) * item.quantity);
    }, 0);
  },
  
  // Aggiorna UI del carrello
  updateCartUI: function() {
    this.updateCartCount();
    this.updateCartDropdown();
    this.updateCartPage();
  },
  
  // Aggiorna contatore carrello
  updateCartCount: function() {
    const countElement = document.getElementById('cart-count');
    if (countElement) {
      const totalItems = this.items.reduce((sum, item) => sum + item.quantity, 0);
      countElement.textContent = totalItems;
      
      if (totalItems > 0) {
        countElement.style.display = 'flex';
      } else {
        countElement.style.display = 'none';
      }
    }
  },
  
  // Aggiorna dropdown carrello (se presente)
  updateCartDropdown: function() {
    const dropdown = document.getElementById('cart-dropdown');
    if (!dropdown) return;
    
    if (this.items.length === 0) {
      dropdown.innerHTML = `
        <div class="cart-empty">
          <svg class="cart-empty-icon" viewBox="0 0 24 24">
            <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,3H1M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
          </svg>
          <p>Il carrello è vuoto</p>
          <a href="/shop.php" class="btn btn-primary btn-small">Inizia a comprare</a>
        </div>
      `;
    } else {
      let itemsHTML = this.items.map(item => `
        <div class="cart-item" data-product-id="${item.id}">
          <div class="cart-item-image">
            <img src="${item.immagine || '/assets/images/placeholder.jpg'}" alt="${item.nome}">
          </div>
          <div class="cart-item-details">
            <h4>${item.nome}</h4>
            <div class="cart-item-price">€${parseFloat(item.prezzo).toFixed(2)}</div>
            <div class="cart-item-quantity">
              <button class="quantity-btn minus" data-action="decrease">-</button>
              <span class="quantity">${item.quantity}</span>
              <button class="quantity-btn plus" data-action="increase">+</button>
            </div>
          </div>
          <button class="cart-item-remove" data-action="remove" title="Rimuovi">
            <svg viewBox="0 0 24 24"><path d="M19,6.41L17.59,5L12,10.59L6.41,5L5,6.41L10.59,12L5,17.59L6.41,19L12,13.41L17.59,19L19,17.59L13.41,12L19,6.41Z"/></svg>
          </button>
        </div>
      `).join('');
      
      dropdown.innerHTML = `
        <div class="cart-items">
          ${itemsHTML}
        </div>
        <div class="cart-footer">
          <div class="cart-total">
            <strong>Totale: €${this.total.toFixed(2)}</strong>
          </div>
          <div class="cart-actions">
            <a href="/cart.php" class="btn btn-outline btn-small">Visualizza carrello</a>
            <a href="/checkout.php" class="btn btn-primary btn-small">Checkout</a>
          </div>
        </div>
      `;
    }
  },
  
  // Aggiorna pagina carrello completa
  updateCartPage: function() {
    const cartPage = document.getElementById('cart-page-content');
    if (!cartPage) return;
    
    if (this.items.length === 0) {
      cartPage.innerHTML = `
        <div class="cart-empty-state">
          <svg class="cart-empty-icon" viewBox="0 0 24 24">
            <path d="M17,18C15.89,18 15,18.89 15,20A2,2 0 0,0 17,22A2,2 0 0,0 19,20C19,18.89 18.1,18 17,18M1,2V4H3L6.6,11.59L5.24,14.04C5.09,14.32 5,14.65 5,15A2,2 0 0,0 7,17H19V15H7.42A0.25,0.25 0 0,1 7.17,14.75C7.17,14.7 7.18,14.66 7.2,14.63L8.1,13H15.55C16.3,13 16.96,12.58 17.3,11.97L20.88,5H5.21L4.27,3H1M7,18C5.89,18 5,18.89 5,20A2,2 0 0,0 7,22A2,2 0 0,0 9,20C9,18.89 8.1,18 7,18Z"/>
          </svg>
          <h2>Il tuo carrello è vuoto</h2>
          <p>Non hai ancora aggiunto prodotti al carrello. Esplora il nostro shop per trovare quello che fa per te.</p>
          <a href="/shop.php" class="btn btn-primary btn-large">Vai allo Shop</a>
        </div>
      `;
    } else {
      let itemsHTML = this.items.map(item => `
        <div class="cart-page-item" data-product-id="${item.id}">
          <div class="item-image">
            <img src="${item.immagine || '/assets/images/placeholder.jpg'}" alt="${item.nome}">
          </div>
          <div class="item-details">
            <h3>${item.nome}</h3>
            <p class="item-type">${item.tipo === 'digitale' ? 'Prodotto Digitale' : 'Prodotto Fisico'}</p>
            <div class="item-price">€${parseFloat(item.prezzo).toFixed(2)}</div>
          </div>
          <div class="item-quantity">
            <button class="quantity-btn minus" data-action="decrease">-</button>
            <input type="number" class="quantity-input" value="${item.quantity}" min="1" max="99">
            <button class="quantity-btn plus" data-action="increase">+</button>
          </div>
          <div class="item-total">
            €${(parseFloat(item.prezzo) * item.quantity).toFixed(2)}
          </div>
          <div class="item-actions">
            <button class="btn btn-outline btn-small" data-action="remove">Rimuovi</button>
          </div>
        </div>
      `).join('');
      
      cartPage.innerHTML = `
        <div class="cart-page-items">
          ${itemsHTML}
        </div>
        <div class="cart-page-summary">
          <div class="summary-row">
            <span>Subtotale:</span>
            <span>€${this.total.toFixed(2)}</span>
          </div>
          <div class="summary-row">
            <span>Spese di spedizione:</span>
            <span>${this.needsShipping() ? '€5.00' : 'Gratuita'}</span>
          </div>
          <div class="summary-row total">
            <span><strong>Totale:</strong></span>
            <span><strong>€${(this.total + (this.needsShipping() ? 5 : 0)).toFixed(2)}</strong></span>
          </div>
          <div class="cart-page-actions">
            <button class="btn btn-outline" onclick="ShoppingCart.clearCart()">Svuota Carrello</button>
            <a href="/checkout.php" class="btn btn-primary btn-large">Procedi al Checkout</a>
          </div>
        </div>
      `;
    }
  },
  
  // Controlla se servono spese di spedizione
  needsShipping: function() {
    return this.items.some(item => item.tipo === 'fisico');
  },
  
  // Mostra notifica prodotto aggiunto
  showAddedNotification: function(product) {
    window.AgenziaPlinio.showToast(
      `${product.nome} aggiunto al carrello`,
      'success',
      3000
    );
  },
  
  // Event listeners
  bindEvents: function() {
    // Event delegation per i controlli del carrello
    document.addEventListener('click', (e) => {
      const target = e.target.closest('[data-action]');
      if (!target) return;
      
      const action = target.dataset.action;
      const productId = target.closest('[data-product-id]')?.dataset.productId;
      
      switch (action) {
        case 'add-to-cart':
          e.preventDefault();
          this.handleAddToCart(target);
          break;
          
        case 'remove':
          if (productId) {
            this.removeItem(parseInt(productId));
          }
          break;
          
        case 'increase':
          if (productId) {
            const item = this.items.find(item => item.id === parseInt(productId));
            if (item) {
              this.updateQuantity(parseInt(productId), item.quantity + 1);
            }
          }
          break;
          
        case 'decrease':
          if (productId) {
            const item = this.items.find(item => item.id === parseInt(productId));
            if (item && item.quantity > 1) {
              this.updateQuantity(parseInt(productId), item.quantity - 1);
            }
          }
          break;
      }
    });
    
    // Input quantity change
    document.addEventListener('input', (e) => {
      if (e.target.classList.contains('quantity-input')) {
        const productId = e.target.closest('[data-product-id]')?.dataset.productId;
        if (productId) {
          const newQuantity = parseInt(e.target.value);
          if (newQuantity > 0) {
            this.updateQuantity(parseInt(productId), newQuantity);
          }
        }
      }
    });
  },
  
  // Gestisce aggiunta al carrello da form prodotto
  handleAddToCart: function(button) {
    const productCard = button.closest('.product-card') || button.closest('.service-card');
    if (!productCard) return;
    
    const product = {
      id: parseInt(productCard.dataset.productId || productCard.dataset.serviceId),
      nome: productCard.querySelector('.product-title, .service-title')?.textContent || 'Prodotto',
      prezzo: this.extractPrice(productCard),
      immagine: productCard.querySelector('img')?.src || '',
      tipo: productCard.dataset.productType || 'digitale',
      quantity: this.extractQuantity(button) || 1
    };
    
    if (product.id && product.prezzo) {
      this.addItem(product);
    } else {
      window.AgenziaPlinio.showToast('Errore nell\'aggiungere il prodotto', 'error');
    }
  },
  
  // Estrae prezzo dal DOM
  extractPrice: function(element) {
    const priceEl = element.querySelector('.price, .service-price, [data-price]');
    if (!priceEl) return 0;
    
    if (priceEl.dataset.price) {
      return parseFloat(priceEl.dataset.price);
    }
    
    const priceText = priceEl.textContent.replace(/[€\s,]/g, '').replace('.', '');
    return parseFloat(priceText) / 100 || 0;
  },
  
  // Estrae quantità dal form
  extractQuantity: function(button) {
    const form = button.closest('form');
    if (form) {
      const quantityInput = form.querySelector('input[name="quantity"]');
      return quantityInput ? parseInt(quantityInput.value) : 1;
    }
    return 1;
  },
  
  // Sistema eventi personalizzati
  triggerEvent: function(eventName, data) {
    const event = new CustomEvent(`cart.${eventName}`, {
      detail: data,
      bubbles: true
    });
    document.dispatchEvent(event);
  },
  
  // API per altre parti dell'applicazione
  getItemCount: function() {
    return this.items.reduce((sum, item) => sum + item.quantity, 0);
  },
  
  getTotal: function() {
    return this.total;
  },
  
  getItems: function() {
    return [...this.items];
  },
  
  hasItems: function() {
    return this.items.length > 0;
  },
  
  findItem: function(productId) {
    return this.items.find(item => item.id === productId);
  }
};

// Inizializzazione automatica
document.addEventListener('DOMContentLoaded', () => {
  window.ShoppingCart.init();
});

// Export per uso in altri moduli
window.Cart = window.ShoppingCart;