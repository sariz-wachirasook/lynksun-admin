const init = () => {
    const darkModeSwitcher = document.getElementById("dark-mode-switcher");

    darkModeSwitcher.addEventListener("click", () => {
        toggle();
    });
};

const toggle = () => {
    if (localStorage.getItem("color-theme") === "dark") {
        document.documentElement.classList.remove("dark");
        localStorage.setItem("color-theme", "light");
        const darkModeSwitcher = document.getElementById("dark-mode-switcher");
        if (darkModeSwitcher) {
            darkModeSwitcher.innerHTML = `<i class="fa-solid fa-moon"></i>`;
        }
    } else {
        document.documentElement.classList.add("dark");
        localStorage.setItem("color-theme", "dark");
        const darkModeSwitcher = document.getElementById("dark-mode-switcher");
        if (darkModeSwitcher) {
            darkModeSwitcher.innerHTML = `<i class="fa-solid fa-sun"></i>`;
        }
    }
};

export default {
    init,
};
