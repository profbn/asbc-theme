document.addEventListener('DOMContentLoaded', function () {
    'use strict';

    const button = document.getElementById('themeToggle');
    if (!button) return;

    // O visitante tem prioridade sobre o horário definido pelo site.
    let preference = null;
    try {
        preference = window.localStorage.getItem('asbc_theme_manual');
    } catch (_error) {
        // O navegador pode desabilitar o armazenamento; a troca continua funcionando.
    }

    function applyTheme(light) {
        document.body.classList.toggle('light-mode', light);
        button.textContent = light ? '🌙 Noite' : '☀️ Dia';
        button.setAttribute('aria-pressed', light ? 'true' : 'false');
    }

    // Sem escolha manual, usa o horário LOCAL do visitante.
    const localHour = new Date().getHours();
    const automaticLight = localHour >= 6 && localHour < 18;
    applyTheme(preference === 'light' ? true : preference === 'dark' ? false : automaticLight);

    button.addEventListener('click', function () {
        const light = !document.body.classList.contains('light-mode');
        applyTheme(light);
        try {
            window.localStorage.setItem('asbc_theme_manual', light ? 'light' : 'dark');
        } catch (_error) {
            // Mantém o visual ativo, mesmo sem poder salvar a preferência.
        }
    });

    // Menu recolhível em telas pequenas e expansão dos submenus por toque/teclado.
    const menuToggle = document.getElementById('asbc-menu-toggle');
    const navigation = document.getElementById('asbc-primary-navigation');
    if (menuToggle && navigation) {
        document.documentElement.classList.add('js');
        menuToggle.addEventListener('click', function () {
            const open = !navigation.classList.contains('is-open');
            navigation.classList.toggle('is-open', open);
            menuToggle.setAttribute('aria-expanded', open ? 'true' : 'false');
        });

        navigation.querySelectorAll('li').forEach(function (item, index) {
            const submenu = item.querySelector(':scope > ul');
            if (!submenu) return;

            const id = submenu.id || 'asbc-submenu-' + index;
            submenu.id = id;
            const toggle = document.createElement('button');
            toggle.type = 'button';
            toggle.className = 'submenu-toggle';
            toggle.setAttribute('aria-controls', id);
            toggle.setAttribute('aria-expanded', 'false');
            toggle.setAttribute('aria-label', 'Abrir ou fechar submenu');
            toggle.textContent = '▾';
            const link = item.querySelector(':scope > a');
            if (link) link.insertAdjacentElement('afterend', toggle);
            else item.insertBefore(toggle, submenu);

            toggle.addEventListener('click', function () {
                const open = !item.classList.contains('submenu-open');
                item.classList.toggle('submenu-open', open);
                toggle.setAttribute('aria-expanded', open ? 'true' : 'false');
            });
        });
    }

});
