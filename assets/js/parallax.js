// Parallax engine with mouse and motion support.
(function () {
    const scenes = document.querySelectorAll('[data-parallax]');
    if (!scenes.length) {
        return;
    }

    const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const isMobile = window.matchMedia('(max-width: 767px)').matches;
    if (prefersReducedMotion || isMobile) {
        scenes.forEach(scene => {
            scene.querySelectorAll('[data-parallax-layer]').forEach(layer => {
                layer.style.transform = 'none';
            });
        });
        return;
    }

    let ticking = false;
    let mouseX = 0;
    let mouseY = 0;

    function updateScene(scene, intensity, x, y) {
        const layers = scene.querySelectorAll('[data-parallax-layer]');
        layers.forEach(layer => {
            const depth = Number(layer.dataset.depth || 0);
            const translateX = (x * depth * intensity).toFixed(2);
            const translateY = (y * depth * intensity).toFixed(2);
            layer.style.transform = `translate3d(${translateX}px, ${translateY}px, 0)`;
        });
    }

    function onFrame() {
        scenes.forEach(scene => {
            const rect = scene.getBoundingClientRect();
            const intensity = scene.dataset.intensity ? Number(scene.dataset.intensity) : 16;
            const relativeX = mouseX - (rect.left + rect.width / 2);
            const relativeY = mouseY - (rect.top + rect.height / 2);
            updateScene(scene, intensity / 100, relativeX, relativeY);
        });
        ticking = false;
    }

    function requestTick() {
        if (!ticking) {
            ticking = true;
            window.requestAnimationFrame(onFrame);
        }
    }

    document.addEventListener('mousemove', event => {
        mouseX = event.clientX;
        mouseY = event.clientY;
        requestTick();
    }, { passive: true });

    if (window.DeviceMotionEvent) {
        window.addEventListener('deviceorientation', event => {
            const clamp = value => Math.max(Math.min(value, 45), -45);
            mouseX = (clamp(event.gamma || 0) / 45) * window.innerWidth;
            mouseY = (clamp(event.beta || 0) / 45) * window.innerHeight;
            requestTick();
        }, { passive: true });
    }
})();
