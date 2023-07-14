const init = () => {
    optimizeMobile();
    window.addEventListener("resize", () => {
        optimizeMobile();
    });
};

function optimizeMobile() {
    const html = document.getElementsByTagName("html")[0];
    if (window.innerWidth < 475) {
        html.style.fontSize = (window.innerWidth / 475) * 100 + "%";
    } else {
        html.style.fontSize = 100 + "%";
    }
}

export default {
    init,
};
