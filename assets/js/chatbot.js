/**
 * Chatbot System - AG Servizi Via Plinio 72
 */

class ChatbotManager {
    constructor() {
        this.isOpen = false;
        this.messages = [];
        this.isTyping = false;
        this.init();
    }
    
    init() {
        this.setupChatWidget();
        this.setupEventListeners();
        this.loadInitialData();
    }
    
    setupChatWidget() {
        const floatingChat = document.getElementById('floating-chat');
        if (!floatingChat) return;
        
        const chatWidget = document.getElementById('chat-widget');
        if (!chatWidget) return;
        
        // Build chat interface
        chatWidget.innerHTML = `
            <div class="chat-header">
                <div class="chat-header-info">
                    <div class="chat-avatar">
                        <img src="/assets/images/chat-avatar.jpg" alt="Assistente" onerror="this.style.display='none'">
                        <div class="avatar-fallback">AG</div>
                    </div>
                    <div>
                        <h4>Assistente Virtuale</h4>
                        <p>AG Servizi Via Plinio 72</p>
                    </div>
                </div>
                <div class="chat-status">
                    <span class="status-indicator online"></span>
                    Online
                </div>
            </div>
            
            <div class="chat-messages" id="chat-messages">
                <div class="welcome-message">
                    <div class="message bot-message">
                        <div class="message-content">
                            👋 Ciao! Sono l'assistente virtuale di AG Servizi.<br>
                            Come posso aiutarti oggi?
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="quick-actions" id="quick-actions">
                <button class="quick-action" data-action="services">
                    📋 I nostri servizi
                </button>
                <button class="quick-action" data-action="hours">
                    🕐 Orari di apertura
                </button>
                <button class="quick-action" data-action="contact">
                    📞 Come contattarci
                </button>
                <button class="quick-action" data-action="spid">
                    🆔 Info SPID
                </button>
            </div>
            
            <div class="chat-input-container">
                <div class="typing-indicator" id="typing-indicator" style="display: none;">
                    <div class="typing-dots">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                    L'assistente sta scrivendo...
                </div>
                <div class="chat-input">
                    <input type="text" id="chat-input-field" placeholder="Scrivi un messaggio..." maxlength="500">
                    <button id="chat-send-btn" aria-label="Invia messaggio">
                        <svg viewBox="0 0 24 24">
                            <path d="M2,21L23,12L2,3V10L17,12L2,14V21Z"/>
                        </svg>
                    </button>
                </div>
            </div>
        `;
    }
    
    setupEventListeners() {
        const chatToggle = document.querySelector('.chat-toggle');
        const chatInput = document.getElementById('chat-input-field');
        const sendBtn = document.getElementById('chat-send-btn');
        
        if (chatToggle) {
            chatToggle.addEventListener('click', () => {
                this.toggle();
            });
        }
        
        if (chatInput) {
            chatInput.addEventListener('keydown', (e) => {
                if (e.key === 'Enter' && !e.shiftKey) {
                    e.preventDefault();
                    this.sendMessage();
                }
            });
            
            chatInput.addEventListener('input', () => {
                this.updateSendButton();
            });
        }
        
        if (sendBtn) {
            sendBtn.addEventListener('click', () => {
                this.sendMessage();
            });
        }
        
        // Quick actions
        document.addEventListener('click', (e) => {
            if (e.target.classList.contains('quick-action')) {
                const action = e.target.dataset.action;
                this.handleQuickAction(action);
            }
        });
        
        // Close chat when clicking outside
        document.addEventListener('click', (e) => {
            const floatingChat = document.getElementById('floating-chat');
            if (this.isOpen && floatingChat && !floatingChat.contains(e.target)) {
                this.close();
            }
        });
        
        // Escape key to close
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && this.isOpen) {
                this.close();
            }
        });
    }
    
    loadInitialData() {
        // Load FAQ data and common responses
        this.faqData = {
            services: {
                question: "Quali servizi offrite?",
                answer: `Offriamo una vasta gamma di servizi:
                
📋 **Servizi Digitali:**
• SPID - Identità Digitale
• PEC - Posta Certificata  
• Firma Digitale
• CNS - Carta Nazionale Servizi

💳 **Pagamenti:**
• Ricariche telefoniche
• Bollettini postali
• F24 e Tasse
• Bollo Auto

📦 **Altri Servizi:**
• Spedizioni e pacchi
• Pratiche automobilistiche
• Contratti telefonici
• Assicurazioni

Vuoi informazioni su un servizio specifico?`
            },
            hours: {
                question: "Quali sono gli orari di apertura?",
                answer: `🕐 **Orari di apertura:**

**Lunedì - Venerdì:** 9:00 - 18:00
**Sabato:** 9:00 - 13:00
**Domenica:** Chiuso

📍 Siamo in Via Plinio 72, Monza (MB)

Per urgenze fuori orario, puoi scriverci tramite il sito web o WhatsApp.`
            },
            contact: {
                question: "Come posso contattarvi?",
                answer: `📞 **Contatti:**

**Telefono:** +39 039 123 4567
**Email:** info@agenziaplinio.it
**WhatsApp:** +39 335 123 4567

📍 **Indirizzo:**
Via Plinio 72, 20900 Monza (MB)

🌐 **Online:**
• Sito web: modulo contatti
• Social media: Facebook, Instagram
• Chat: qui con me! 😊`
            },
            spid: {
                question: "Come posso attivare SPID?",
                answer: `🆔 **Attivazione SPID:**

Per attivare SPID hai bisogno di:
• Documento d'identità valido
• Codice fiscale
• Numero di cellulare
• Indirizzo email

📋 **Procedura:**
1. Vieni in agenzia con i documenti
2. Compiliamo insieme la richiesta
3. Verifica dell'identità
4. Attivazione immediata

💰 **Costo:** €25 (attivazione completa)
⏱️ **Tempo:** 15-20 minuti

Vuoi prenotare un appuntamento?`
            }
        };
        
        // Common keywords for auto-response
        this.keywords = {
            'orari|apertura|chiuso|aperto': 'hours',
            'servizi|cosa|fate|offrite': 'services', 
            'spid|identità|digitale': 'spid',
            'contatto|telefono|email|indirizzo': 'contact',
            'costo|prezzo|quanto|costa': 'pricing',
            'pec|posta|certificata': 'pec',
            'ricarica|telefonica|cellulare': 'ricariche'
        };
    }
    
    toggle() {
        if (this.isOpen) {
            this.close();
        } else {
            this.open();
        }
    }
    
    open() {
        const floatingChat = document.getElementById('floating-chat');
        const chatToggle = document.querySelector('.chat-toggle');
        
        floatingChat.classList.add('active');
        chatToggle.classList.add('active');
        this.isOpen = true;
        
        // Focus input
        setTimeout(() => {
            const chatInput = document.getElementById('chat-input-field');
            if (chatInput) chatInput.focus();
        }, 300);
        
        // Mark as read in localStorage
        localStorage.setItem('chatOpened', 'true');
    }
    
    close() {
        const floatingChat = document.getElementById('floating-chat');
        const chatToggle = document.querySelector('.chat-toggle');
        
        floatingChat.classList.remove('active');
        chatToggle.classList.remove('active');
        this.isOpen = false;
    }
    
    sendMessage() {
        const input = document.getElementById('chat-input-field');
        const message = input.value.trim();
        
        if (!message) return;
        
        // Add user message
        this.addMessage(message, 'user');
        input.value = '';
        this.updateSendButton();
        
        // Hide quick actions after first message
        const quickActions = document.getElementById('quick-actions');
        if (quickActions && this.messages.length === 1) {
            quickActions.style.display = 'none';
        }
        
        // Process message and generate response
        this.processMessage(message);
    }
    
    processMessage(message) {
        // Show typing indicator
        this.showTyping();
        
        // Simulate processing delay
        setTimeout(() => {
            const response = this.generateResponse(message);
            this.hideTyping();
            this.addMessage(response, 'bot');
        }, 1000 + Math.random() * 1000);
    }
    
    generateResponse(message) {
        const lowerMessage = message.toLowerCase();
        
        // Check for keywords
        for (const [keywords, action] of Object.entries(this.keywords)) {
            const regex = new RegExp(keywords, 'i');
            if (regex.test(lowerMessage)) {
                return this.faqData[action]?.answer || this.getDefaultResponse();
            }
        }
        
        // Check for specific questions
        if (lowerMessage.includes('appuntamento') || lowerMessage.includes('prenotare')) {
            return `📅 **Prenotazione Appuntamento:**

Perfetto! Per prenotare un appuntamento puoi:

1. **Chiamarci:** +39 039 123 4567
2. **Compilare il modulo** sul sito web
3. **Venire direttamente** in agenzia

🕐 Siamo aperti:
• Lun-Ven: 9:00-18:00
• Sabato: 9:00-13:00

Per quale servizio vorresti prenotare?`;
        }
        
        if (lowerMessage.includes('prezzo') || lowerMessage.includes('costo')) {
            return `💰 **Listino Prezzi Principali:**

🆔 **SPID:** €25
📧 **PEC:** €30/anno
✍️ **Firma Digitale:** €35
📱 **Ricariche:** Senza commissioni

📋 **Altri servizi:** Prezzi variabili
📞 **Consulenza gratuita** per preventivi personalizzati

Vuoi un preventivo per un servizio specifico?`;
        }
        
        // Greeting responses
        if (lowerMessage.match(/^(ciao|salve|buongiorno|buonasera|hey)/)) {
            return `👋 Ciao! Benvenuto in AG Servizi Via Plinio 72!

Sono qui per aiutarti con informazioni sui nostri servizi, orari, prezzi e molto altro.

Come posso assisterti oggi? 😊`;
        }
        
        // Gratitude responses
        if (lowerMessage.match(/(grazie|thanks|merci)/)) {
            return `😊 Prego, è stato un piacere aiutarti!

Se hai altre domande sono sempre qui.
Per assistenza diretta, ricorda che puoi anche:

📞 Chiamarci: +39 039 123 4567
📧 Scriverci: info@agenziaplinio.it

Buona giornata! 🌟`;
        }
        
        return this.getDefaultResponse();
    }
    
    getDefaultResponse() {
        const responses = [
            `Mi dispiace, non sono sicuro di aver capito bene la tua richiesta. 🤔

Puoi essere più specifico? Oppure scegli uno di questi argomenti:
• 📋 I nostri servizi
• 🕐 Orari e contatti  
• 🆔 SPID e servizi digitali
• 💰 Prezzi e preventivi`,
            
            `Non ho trovato informazioni specifiche su questo argomento. 

Per assistenza personalizzata, ti consiglio di:
📞 **Chiamarci:** +39 039 123 4567
📧 **Scriverci:** info@agenziaplinio.it

Il nostro staff sarà felice di aiutarti! 😊`,
            
            `Hmm, non sono sicuro di come rispondere a questa domanda. 

Prova a chiedere di:
• Servizi disponibili
• Orari di apertura
• Come contattarci
• Informazioni su SPID/PEC

O contattaci direttamente! 📞`
        ];
        
        return responses[Math.floor(Math.random() * responses.length)];
    }
    
    handleQuickAction(action) {
        const faqItem = this.faqData[action];
        if (faqItem) {
            this.addMessage(faqItem.question, 'user');
            
            setTimeout(() => {
                this.addMessage(faqItem.answer, 'bot');
            }, 500);
            
            // Hide quick actions
            const quickActions = document.getElementById('quick-actions');
            if (quickActions) {
                quickActions.style.display = 'none';
            }
        }
    }
    
    addMessage(content, sender) {
        const messagesContainer = document.getElementById('chat-messages');
        if (!messagesContainer) return;
        
        const messageDiv = document.createElement('div');
        messageDiv.className = `message ${sender}-message`;
        
        // Format message content
        const formattedContent = this.formatMessage(content);
        
        messageDiv.innerHTML = `
            <div class="message-content">${formattedContent}</div>
            <div class="message-time">${this.formatTime(new Date())}</div>
        `;
        
        messagesContainer.appendChild(messageDiv);
        
        // Store message
        this.messages.push({
            content,
            sender,
            timestamp: Date.now()
        });
        
        // Scroll to bottom
        messagesContainer.scrollTop = messagesContainer.scrollHeight;
        
        // Add animation
        messageDiv.style.opacity = '0';
        messageDiv.style.transform = 'translateY(10px)';
        
        requestAnimationFrame(() => {
            messageDiv.style.transition = 'opacity 0.3s, transform 0.3s';
            messageDiv.style.opacity = '1';
            messageDiv.style.transform = 'translateY(0)';
        });
    }
    
    formatMessage(content) {
        // Convert markdown-style formatting
        return content
            .replace(/\*\*(.*?)\*\*/g, '<strong>$1</strong>')
            .replace(/\*(.*?)\*/g, '<em>$1</em>')
            .replace(/`(.*?)`/g, '<code>$1</code>')
            .replace(/\n/g, '<br>');
    }
    
    formatTime(date) {
        return date.toLocaleTimeString('it-IT', {
            hour: '2-digit',
            minute: '2-digit'
        });
    }
    
    showTyping() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.style.display = 'flex';
            this.isTyping = true;
            
            // Scroll to show typing indicator
            const messagesContainer = document.getElementById('chat-messages');
            messagesContainer.scrollTop = messagesContainer.scrollHeight;
        }
    }
    
    hideTyping() {
        const typingIndicator = document.getElementById('typing-indicator');
        if (typingIndicator) {
            typingIndicator.style.display = 'none';
            this.isTyping = false;
        }
    }
    
    updateSendButton() {
        const input = document.getElementById('chat-input-field');
        const sendBtn = document.getElementById('chat-send-btn');
        
        if (input && sendBtn) {
            const hasText = input.value.trim().length > 0;
            sendBtn.classList.toggle('active', hasText);
        }
    }
}

// Initialize when DOM is ready
document.addEventListener('DOMContentLoaded', () => {
    window.chatbotManager = new ChatbotManager();
});

// Export for module systems
if (typeof module !== 'undefined' && module.exports) {
    module.exports = ChatbotManager;
}