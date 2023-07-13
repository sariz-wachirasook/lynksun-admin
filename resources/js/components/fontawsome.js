const init = () => {
    const fontawesomeSolidClass = document.getElementsByClassName("fa-solid");
    if (fontawesomeSolidClass.length > 0) {
        import("https://kit.fontawesome.com/49d34c1588.js");
    }
};

export default {
    init,
};
