
function initTheme() {
    const btn   = document.getElementById("themeBtn");
    const saved = localStorage.getItem("theme");
    if (saved === "dark") {
        document.documentElement.setAttribute("data-theme", "dark");
        if (btn) btn.innerHTML = '<i class="fa-solid fa-moon"></i>';
    }
    if (btn) btn.onclick = toggleTheme;
}
function toggleTheme() {
    const root = document.documentElement;
    const btn  = document.getElementById("themeBtn");
    if (root.getAttribute("data-theme") === "dark") {
        root.removeAttribute("data-theme");
        localStorage.setItem("theme", "light");
        if (btn) btn.innerHTML = '<i class="fa-regular fa-moon"></i>';
    } else {
        root.setAttribute("data-theme", "dark");
        localStorage.setItem("theme", "dark");
        if (btn) btn.innerHTML = '<i class="fa-solid fa-moon"></i>';
    }
}
initTheme();
