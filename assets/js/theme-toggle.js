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
});
