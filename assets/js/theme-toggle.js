document.addEventListener('DOMContentLoaded', () => {
    const themeToggle = document.getElementById('themeToggle');
    const body = document.body;

    if (!themeToggle) return;

    // Respeita a preferência manual se o usuário tiver clicado no botão durante a sessão
    const temaManual = localStorage.getItem('asbc_theme_manual');

    if (temaManual === 'light') {
        body.classList.add('light-mode');
        themeToggle.innerHTML = '🌙 Noite';
    } else if (temaManual === 'dark') {
        body.classList.remove('light-mode');
        themeToggle.innerHTML = '☀️ Dia';
    }

    // Clique no botão manual
    themeToggle.addEventListener('click', () => {
        if (body.classList.contains('light-mode')) {
            body.classList.remove('light-mode');
            themeToggle.innerHTML = '☀️ Dia';
            localStorage.setItem('asbc_theme_manual', 'dark');
        } else {
            body.classList.add('light-mode');
            themeToggle.innerHTML = '🌙 Noite';
            localStorage.setItem('asbc_theme_manual', 'light');
        }
    });
});