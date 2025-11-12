/**
 * Effetto particelle per hero - AG Servizi Via Plinio 72
 */

(function() {
    function createParticle(container) {
        const particle = document.createElement('span');
        particle.className = 'hero-particle';
        particle.style.position = 'absolute';
        particle.style.borderRadius = '50%';
        particle.style.background = 'rgba(255, 191, 0, 0.35)';
        particle.style.boxShadow = '0 0 12px rgba(255, 191, 0, 0.45)';
        particle.style.willChange = 'transform';
        particle.style.pointerEvents = 'none';
        particle.style.mixBlendMode = 'screen';
        
        const size = Math.random() * 6 + 4;
        particle.style.width = `${size}px`;
        particle.style.height = `${size}px`;
        
        container.appendChild(particle);
        const bounds = container.getBoundingClientRect();
        const width = bounds.width || window.innerWidth || 1;
        const height = bounds.height || window.innerHeight || 1;

        return {
            element: particle,
            x: Math.random() * width,
            y: Math.random() * height,
            angle: Math.random() * Math.PI * 2,
            speed: Math.random() * 0.4 + 0.15,
            scale: Math.random() * 0.4 + 0.8
        };
    }
    
    function initHeroParticles() {
        const container = document.getElementById('hero-particles');
        if (!container) {
            return;
        }
        
        container.innerHTML = '';
        container.style.position = 'absolute';
        container.style.top = '0';
        container.style.left = '0';
        container.style.right = '0';
        container.style.bottom = '0';
        container.style.pointerEvents = 'none';
        container.style.overflow = 'hidden';
        container.style.zIndex = '0';
        
        const particleCount = parseInt(container.dataset.particles, 10) || 28;
        const particles = [];
        
        for (let i = 0; i < particleCount; i += 1) {
            particles.push(createParticle(container));
        }

        window.addEventListener('resize', () => {
            const rect = container.getBoundingClientRect();
            particles.forEach(p => {
                p.x = Math.min(p.x, rect.width);
                p.y = Math.min(p.y, rect.height);
            });
        });
        
        const animate = () => {
            const rect = container.getBoundingClientRect();
            if (!rect.width || !rect.height) {
                requestAnimationFrame(animate);
                return;
            }
            
            particles.forEach(particle => {
                particle.x += Math.cos(particle.angle) * particle.speed;
                particle.y += Math.sin(particle.angle) * particle.speed;
                
                if (particle.x < 0) particle.x = rect.width;
                if (particle.x > rect.width) particle.x = 0;
                if (particle.y < 0) particle.y = rect.height;
                if (particle.y > rect.height) particle.y = 0;
                
                particle.element.style.transform = `translate(${particle.x}px, ${particle.y}px) scale(${particle.scale})`;
                particle.angle += (Math.random() - 0.5) * 0.02;
            });
            
            requestAnimationFrame(animate);
        };
        
        animate();
    }
    
    window.initHeroParticles = initHeroParticles;
})();
