const storageKey = 'theme';
const themeToggle = document.querySelector('.theme-toggle');
const themeIcon = themeToggle?.querySelector('.theme-toggle__icon') ?? null;
const colorSchemeQuery = window.matchMedia('(prefers-color-scheme: dark)');

function getCurrentTheme() {
    return document.documentElement.dataset.theme === 'dark'
        ? 'dark'
        : 'light';
}

function getSavedTheme() {
    try {
        const theme = localStorage.getItem(storageKey);
        return ['system', 'light', 'dark'].includes(theme) ? theme : null;
    } catch (error) {
        return null;
    }
}

if (!['light', 'dark'].includes(document.documentElement.dataset.theme)) {
    const savedTheme = getSavedTheme();
    document.documentElement.dataset.theme = savedTheme === 'light' || savedTheme === 'dark'
        ? savedTheme
        : (colorSchemeQuery.matches ? 'dark' : 'light');
}

function saveTheme(theme) {
    try {
        localStorage.setItem(storageKey, theme);
    } catch (error) {
        // Motyw nadal działa w bieżącym dokumencie.
    }
}

function syncThemeToggle() {
    if (!themeToggle) {
        return;
    }

    const isDark = getCurrentTheme() === 'dark';
    const currentMode = getSavedTheme() ?? 'system';
    const nextMode = {
        system: 'light',
        light: 'dark',
        dark: 'system',
    }[currentMode];
    themeToggle.setAttribute('aria-pressed', String(isDark));
    themeToggle.setAttribute(
        'aria-label',
        `Ustaw ${nextMode === 'system' ? 'motyw systemowy' : `motyw ${nextMode}`}`
    );
    themeToggle.dataset.mode = currentMode;

    if (themeIcon) {
        themeIcon.textContent = currentMode === 'system' ? '◐' : (isDark ? '☀' : '☾');
    }
}

function setTheme(theme, remember = true) {
    const effectiveTheme = theme === 'system'
        ? (colorSchemeQuery.matches ? 'dark' : 'light')
        : theme;
    document.documentElement.dataset.theme = effectiveTheme;

    if (remember) {
        saveTheme(theme);
    }

    syncThemeToggle();
}

themeToggle?.addEventListener('click', () => {
    const currentMode = getSavedTheme() ?? 'system';
    const nextMode = { system: 'light', light: 'dark', dark: 'system' }[currentMode];
    setTheme(nextMode);
});

colorSchemeQuery.addEventListener('change', (event) => {
    if (getSavedTheme() !== null && getSavedTheme() !== 'system') {
        return;
    }

    document.documentElement.dataset.theme = event.matches ? 'dark' : 'light';
    syncThemeToggle();
});

syncThemeToggle();
