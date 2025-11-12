/**
 * Animazioni homepage - AG Servizi Via Plinio 72
 */

(function() {
    const fallbackThrottle = (fn, limit = 16) => {
        let waiting = false;
        return function(...args) {
            if (waiting) {
                return;
            }
            waiting = true;
            fn.apply(this, args);
            setTimeout(() => {
                waiting = false;
            }, limit);
        };
    };
    
    const getThrottle = () => {
        const utils = window.AgenziaPlinio && window.AgenziaPlinio.utils;
        return utils && typeof utils.throttle === 'function' ? utils.throttle : fallbackThrottle;
    };
    
    function initParallax() {
        const heroVisual = document.querySelector('.hero-visual');
        const heroBackground = document.querySelector('.hero-background');
        const floatingCards = heroVisual ? heroVisual.querySelectorAll('.hero-floating-card') : [];
        
        if (!heroVisual && !heroBackground) {
            return;
        }
        
        const throttle = getThrottle();
        
        if (heroBackground) {
            const onScroll = throttle(() => {
                const offset = Math.min(window.pageYOffset * 0.15, 120);
                heroBackground.style.transform = `translateY(${offset}px)`;
            }, 16);
            window.addEventListener('scroll', onScroll, { passive: true });
            onScroll();
        }
        
        if (heroVisual && floatingCards.length) {
            const handleMouseMove = throttle((event) => {
                const rect = heroVisual.getBoundingClientRect();
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 2;
                const offsetX = ((event.clientX - centerX) / rect.width) * 2;
                const offsetY = ((event.clientY - centerY) / rect.height) * 2;
                
                floatingCards.forEach((card, index) => {
                    const depth = (index + 1) * 8;
                    card.style.transform = `translate3d(${offsetX * depth}px, ${offsetY * depth}px, 0)`;
                });
            }, 16);
            
            heroVisual.addEventListener('mousemove', handleMouseMove, { passive: true });
            heroVisual.addEventListener('mouseleave', () => {
                floatingCards.forEach(card => {
                    card.style.transform = '';
                });
            });
        }
    }
    
    window.initParallax = initParallax;
})();
