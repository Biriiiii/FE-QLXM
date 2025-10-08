// theme-toggle.js
function setTheme(mode) {
    var style = document.getElementById('theme-style');
    var icon = document.getElementById('theme-toggle-icon');
    if (!style || !icon) return;
    if (mode === 'light') {
        style.innerHTML = `
        :root {
            --bg-main: #f4f6fa !important;
            --bg-sidebar: #fff !important;
            --text-main: #23262f !important;
            --sidebar-active: linear-gradient(90deg,#2563eb 60%,#60a5fa 100%) !important;
            --sidebar-header: #2563eb !important;
            --card-bg: #fff !important;
            --table-bg: #fff !important;
            --table-border: #e5e7eb !important;
            --table-shadow: 0 4px 24px 0 rgba(0,0,0,0.08), 0 1.5px 4px 0 rgba(0,0,0,0.04) !important;
            --btn-primary: #2563eb !important;
            --btn-success: #059669 !important;
            --btn-warning: #f59e42 !important;
            --btn-danger: #ef4444 !important;
            --footer-bg: #fff !important;
            --brand: #2563eb !important;
        }
        body { background: var(--bg-main) !important; color: var(--text-main) !important; }
        `;
        icon.className = 'bi bi-moon-fill';
    } else {
        style.innerHTML = `
        :root {
            --bg-main: #181a20 !important;
            --bg-sidebar: #23262f !important;
            --text-main: #eaeaea !important;
            --sidebar-active: linear-gradient(90deg,#2563eb 60%,#60a5fa 100%) !important;
            --sidebar-header: #a3a3a3 !important;
            --card-bg: #23262f !important;
            --table-bg: #23262f !important;
            --table-border: #23262f !important;
            --table-shadow: 0 4px 24px 0 rgba(0,0,0,0.18), 0 1.5px 4px 0 rgba(0,0,0,0.12) !important;
            --btn-primary: #2563eb !important;
            --btn-success: #059669 !important;
            --btn-warning: #f59e42 !important;
            --btn-danger: #ef4444 !important;
            --footer-bg: #23262f !important;
            --brand: #fff !important;
        }
        body { background: var(--bg-main) !important; color: var(--text-main) !important; }
        `;
        icon.className = 'bi bi-sun-fill';
    }
    localStorage.setItem('theme', mode);
}
window.addEventListener('DOMContentLoaded', function () {
    var toggleBtn = document.getElementById('theme-toggle');
    var icon = document.getElementById('theme-toggle-icon');
    if (!toggleBtn || !icon) return;
    const saved = localStorage.getItem('theme') || 'dark';
    setTheme(saved);
    toggleBtn.addEventListener('click', function () {
        const current = localStorage.getItem('theme') || 'dark';
        const next = current === 'dark' ? 'light' : 'dark';
        setTheme(next);
    });
});
// theme-toggle.js
function setTheme(mode) {
    console.log('setTheme called with mode:', mode);
    var style = document.getElementById('theme-style');
    var icon = document.getElementById('theme-toggle-icon');
    if (!style || !icon) return;
    if (mode === 'light') {
        style.innerHTML = `
        :root {
            --bg-main: #f4f6fa !important;
            --bg-sidebar: #fff !important;
            --text-main: #23262f !important;
            --sidebar-active: linear-gradient(90deg,#2563eb 60%,#60a5fa 100%) !important;
            --sidebar-header: #2563eb !important;
            --card-bg: #fff !important;
            --table-bg: #fff !important;
            --table-border: #e5e7eb !important;
            --table-shadow: 0 4px 24px 0 rgba(0,0,0,0.08), 0 1.5px 4px 0 rgba(0,0,0,0.04) !important;
            --btn-primary: #2563eb !important;
            --btn-success: #059669 !important;
            --btn-warning: #f59e42 !important;
            --btn-danger: #ef4444 !important;
            --footer-bg: #fff !important;
            --brand: #2563eb !important;
        }
        body { background: var(--bg-main) !important; color: var(--text-main) !important; }
        `;
        icon.className = 'bi bi-moon-fill';
    } else {
        style.innerHTML = `
        :root {
            --bg-main: #181a20 !important;
            --bg-sidebar: #23262f !important;
            --text-main: #eaeaea !important;
            --sidebar-active: linear-gradient(90deg,#2563eb 60%,#60a5fa 100%) !important;
            --sidebar-header: #a3a3a3 !important;
            --card-bg: #23262f !important;
            --table-bg: #23262f !important;
            --table-border: #23262f !important;
            --table-shadow: 0 4px 24px 0 rgba(0,0,0,0.18), 0 1.5px 4px 0 rgba(0,0,0,0.12) !important;
            --btn-primary: #2563eb !important;
            --btn-success: #059669 !important;
            --btn-warning: #f59e42 !important;
            --btn-danger: #ef4444 !important;
            --footer-bg: #23262f !important;
            --brand: #fff !important;
        }
        body { background: var(--bg-main) !important; color: var(--text-main) !important; }
        `;
        icon.className = 'bi bi-sun-fill';
    }
    localStorage.setItem('theme', mode);
}
window.addEventListener('DOMContentLoaded', function () {
    var toggleBtn = document.getElementById('theme-toggle');
    var icon = document.getElementById('theme-toggle-icon');
    if (!toggleBtn || !icon) return;
    const saved = localStorage.getItem('theme') || 'dark';
    setTheme(saved);
    toggleBtn.addEventListener('click', function () {
        const current = localStorage.getItem('theme') || 'dark';
        const next = current === 'dark' ? 'light' : 'dark';
        console.log('Theme toggle clicked. Current:', current, 'Next:', next);
        setTheme(next);
    });
});
