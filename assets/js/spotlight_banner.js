(() => {
    const container = document.querySelector('.spotlight_banner .carousel-container');
    const carousel = container?.querySelector('.carousel');
    const slides = carousel ? [...carousel.querySelectorAll('.slide')] : [];
    if (!container || !carousel || slides.length === 0) return;

    const prev = container.querySelector('.prev-btn');
    const next = container.querySelector('.next-btn');
    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)');
    let index = 0;
    let timer = null;

    const showSlide = newIndex => {
        index = (newIndex + slides.length) % slides.length;
        carousel.style.transform = `translateX(-${index * 100}%)`;
        slides.forEach((slide, i) => {
            const active = i === index;
            slide.setAttribute('aria-hidden', String(!active));
            slide.setAttribute('aria-label', `${i + 1} de ${slides.length}`);
            slide.querySelectorAll('a,button').forEach(el => { el.tabIndex = active ? 0 : -1; });
        });
    };
    const stop = () => { if (timer !== null) { clearInterval(timer); timer = null; } };
    const canAutoPlay = () => slides.length > 1 && !reducedMotion.matches &&
        !document.hidden && !container.matches(':hover') && !container.contains(document.activeElement);
    const start = () => {
        stop();
        if (canAutoPlay()) timer = setInterval(() => showSlide(index + 1), 5000);
    };
    const move = by => { showSlide(index + by); start(); };

    prev?.addEventListener('click', () => move(-1));
    next?.addEventListener('click', () => move(1));
    if (slides.length < 2) {
        prev?.setAttribute('hidden', '');
        next?.setAttribute('hidden', '');
    }
    container.addEventListener('mouseenter', stop);
    container.addEventListener('mouseleave', start);
    container.addEventListener('focusin', stop);
    container.addEventListener('focusout', () => { window.requestAnimationFrame(start); });
    document.addEventListener('visibilitychange', start);
    reducedMotion.addEventListener('change', start);
    showSlide(0);
    start();
})();
