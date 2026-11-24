// Menu mobile. Não altera a navegação horizontal do desktop.
(() => {
    const nav = document.querySelector('.site-nav');
    const toggle = nav?.querySelector('.nav-toggle');
    const menu = nav?.querySelector('#primary-navigation');
    if (!nav || !toggle || !menu) return;

    const closeMenu = () => {
        toggle.setAttribute('aria-expanded', 'false');
        toggle.setAttribute('aria-label', 'Abrir menu de navegação');
        menu.dataset.open = 'false';
    };
    toggle.addEventListener('click', () => {
        const open = toggle.getAttribute('aria-expanded') !== 'true';
        toggle.setAttribute('aria-expanded', String(open));
        toggle.setAttribute('aria-label', open ? 'Fechar menu de navegação' : 'Abrir menu de navegação');
        menu.dataset.open = String(open);
    });
    menu.querySelectorAll('a').forEach(link => link.addEventListener('click', closeMenu));
    document.addEventListener('keydown', event => {
        if (event.key === 'Escape' && toggle.getAttribute('aria-expanded') === 'true') {
            closeMenu(); toggle.focus();
        }
    });
    document.addEventListener('click', event => {
        if (!nav.contains(event.target)) closeMenu();
    });
    window.matchMedia('(min-width: 701px)').addEventListener('change', event => {
        if (event.matches) closeMenu();
    });
})();
