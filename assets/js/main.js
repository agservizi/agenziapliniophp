// Core interactive behaviors for Agenzia Plinio portal.
(function () {
    document.addEventListener('DOMContentLoaded', () => {
        initPreloader();
        initNavbarBurger();
        initMagneticCards();
        init3DButtons();
        initCounters();
        initCartAnimations();
    });

    function initPreloader() {
        const preloader = document.getElementById('preloader');
        if (!preloader) {
            return;
        }
        window.addEventListener('load', () => {
            setTimeout(() => preloader.classList.add('hidden'), 400);
            preloader.addEventListener('transitionend', () => preloader.remove(), { once: true });
        });
    }

    function initNavbarBurger() {
        const burgers = Array.from(document.querySelectorAll('.navbar-burger'));
        burgers.forEach(burger => {
            const targetId = burger.dataset.target;
            const target = document.getElementById(targetId);
            burger.addEventListener('click', () => {
                burger.classList.toggle('is-active');
                target?.classList.toggle('is-active');
            });
        });
    }

    function initMagneticCards() {
        if (!window.matchMedia('(pointer: fine)').matches) {
            return;
        }
        const cards = Array.from(document.querySelectorAll('.service-card'));
        cards.forEach(card => {
            card.addEventListener('mousemove', event => {
                const rect = card.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                const centerX = rect.width / 2;
                const centerY = rect.height / 2;
                const rotateX = ((y - centerY) / centerY) * 6;
                const rotateY = ((x - centerX) / centerX) * -6;
                card.style.transform = `rotateX(${rotateX}deg) rotateY(${rotateY}deg)`;
            });
            card.addEventListener('mouseleave', () => {
                card.style.transform = 'rotateX(0) rotateY(0)';
            });
        });
    }

    function init3DButtons() {
        if (!window.matchMedia('(pointer: fine)').matches) {
            return;
        }
        document.querySelectorAll('.button-liquid').forEach(button => {
            button.addEventListener('pointermove', event => {
                const rect = button.getBoundingClientRect();
                const x = event.clientX - rect.left;
                const y = event.clientY - rect.top;
                button.style.setProperty('--hover-x', `${x}px`);
                button.style.setProperty('--hover-y', `${y}px`);
            });
        });
    }

    function initCounters() {
        const counters = document.querySelectorAll('[data-counter]');
        if (!counters.length) {
            return;
        }
        const observer = new IntersectionObserver(entries => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    animateCounter(entry.target);
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.4 });
        counters.forEach(counter => observer.observe(counter));
    }

    function animateCounter(counter) {
        const target = Number(counter.dataset.counter || 0);
        const duration = 1600;
        let start = null;

        function step(timestamp) {
            if (!start) {
                start = timestamp;
            }
            const progress = Math.min((timestamp - start) / duration, 1);
            counter.textContent = Math.round(progress * target).toLocaleString('it-IT');
            if (progress < 1) {
                window.requestAnimationFrame(step);
            }
        }
        window.requestAnimationFrame(step);
    }

    function initCartAnimations() {
        const cartButtons = document.querySelectorAll('[data-add-cart]');
        cartButtons.forEach(button => {
            button.addEventListener('click', () => {
                button.classList.add('is-loading');
                const originalText = button.textContent;
                button.textContent = 'Aggiunto!';
                setTimeout(() => {
                    button.classList.remove('is-loading');
                    button.textContent = originalText;
                }, 1200);
            });
        });
    }
})();
