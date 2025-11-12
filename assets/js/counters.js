/**
 * Gestione contatori animati - AG Servizi Via Plinio 72
 */

(function() {
    function animateValue(element) {
        const target = parseInt(element.dataset.count || element.dataset.target || element.textContent, 10);
        if (Number.isNaN(target)) {
            return;
        }
        const duration = parseInt(element.dataset.duration, 10) || 2000;
        const startValue = parseInt(element.dataset.start || '0', 10);
        const startTime = performance.now();
        
        const update = (currentTime) => {
            const elapsed = currentTime - startTime;
            const progress = Math.min(elapsed / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 4);
            const value = Math.floor(startValue + (target - startValue) * eased);
            element.textContent = value.toLocaleString('it-IT');
            
            if (progress < 1) {
                requestAnimationFrame(update);
            } else if (element.dataset.suffix) {
                element.textContent += element.dataset.suffix;
            }
        };
        
        requestAnimationFrame(update);
    }
    
    function initCounters() {
        const counters = document.querySelectorAll('[data-count], [data-target], .counter, .stat-number');
        if (!counters.length) {
            return;
        }
        
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries, obs) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        animateValue(entry.target);
                        obs.unobserve(entry.target);
                    }
                });
            }, { threshold: 0.25 });
            
            counters.forEach(counter => observer.observe(counter));
        } else {
            counters.forEach(counter => animateValue(counter));
        }
    }
    
    window.initCounters = initCounters;
})();
