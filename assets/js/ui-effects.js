// UI reveal, navbar morphing and stagger animations.
(function () {
    const observerOptions = {
        threshold: 0.15,
    };

    const revealElements = document.querySelectorAll('[data-animate]');
    const staggerContainers = document.querySelectorAll('[data-stagger]');

    const observer = new IntersectionObserver(entries => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            }
        });
    }, observerOptions);

    revealElements.forEach(el => observer.observe(el));
    staggerContainers.forEach(el => observer.observe(el));

    // Navbar morphing
    const nav = document.querySelector('[data-nav]');
    if (nav) {
        const morphNav = () => {
            nav.dataset.scrolled = window.scrollY > 30;
        };
        window.addEventListener('scroll', morphNav, { passive: true });
        morphNav();
    }

    // Scroll top button
    const scrollTopButton = document.querySelector('[data-scroll-top]');
    if (scrollTopButton) {
        const toggleScrollTop = () => {
            if (window.scrollY > 300) {
                scrollTopButton.classList.add('is-visible');
            } else {
                scrollTopButton.classList.remove('is-visible');
            }
        };
        window.addEventListener('scroll', toggleScrollTop, { passive: true });
        scrollTopButton.addEventListener('click', () => {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });
        toggleScrollTop();
    }

    // Auto-dismiss flash messages
    document.querySelectorAll('[data-auto-dismiss]').forEach(notification => {
        setTimeout(() => notification.classList.add('fade-out'), 3500);
        notification.addEventListener('transitionend', event => {
            if (notification.classList.contains('fade-out') && event.propertyName === 'opacity') {
                notification.remove();
            }
        });
    });
})();
