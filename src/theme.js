// Funciones para manejar el tema (modo claro/oscuro)

// Función para establecer una cookie
function setCookie(name, value, days) {
    const d = new Date();
    d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
    const expires = "expires=" + d.toUTCString();
    document.cookie = name + "=" + value + ";" + expires + ";path=/";
}

// Función para obtener una cookie
function getCookie(name) {
    const nameEQ = name + "=";
    const ca = document.cookie.split(';');
    for (let i = 0; i < ca.length; i++) {
        let c = ca[i];
        while (c.charAt(0) == ' ') c = c.substring(1, c.length);
        if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length, c.length);
    }
    return null;
}

// Función para aplicar el tema
function applyTheme(theme) {
    if (theme === 'dark') {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }
    updateThemeIcon(theme);
}

// Función para actualizar el icono del botón
function updateThemeIcon(theme) {
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        if (theme === 'dark') {
            themeToggle.innerHTML = '☀️';
            themeToggle.title = 'Cambiar a modo claro';
        } else {
            themeToggle.innerHTML = '🌙';
            themeToggle.title = 'Cambiar a modo oscuro';
        }
    }
}

// Función para cambiar el tema
function toggleTheme() {
    const currentTheme = getCookie('theme') || 'light';
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    setCookie('theme', newTheme, 365); // Cookie válida por 1 año
    applyTheme(newTheme);
}

// Cargar el tema al cargar la página
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = getCookie('theme') || 'light';
    applyTheme(savedTheme);
    
    // Agregar evento al botón de cambio de tema
    const themeToggle = document.getElementById('theme-toggle');
    if (themeToggle) {
        themeToggle.addEventListener('click', toggleTheme);
    }
});
