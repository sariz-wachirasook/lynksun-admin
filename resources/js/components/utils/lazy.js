const init = () => {
    // detect if element is in viewport
    const isInViewport = (el) => {
        // at least 50% far from viewport
        const rect = el.getBoundingClientRect();

        return (
            rect.top <=
                (window.innerHeight || document.documentElement.clientHeight) *
                    1.5 &&
            rect.left <=
                (window.innerWidth || document.documentElement.clientWidth) *
                    1.5
        );
    };

    const loadSrc = (el) => {
        const src = $(el).attr("data-src");
        $(el).attr("src", src).removeAttr("data-src");
        $(el).show();

        // next to element with .lazy-skeleton
        const skeleton = $(el).next(".lazy-skeleton")[0];
        if (skeleton) {
            skeleton.remove();
        }
    };

    // check if element is in viewport
    const checkViewport = () => {
        const lazySrc = $("[data-src]");
        if (lazySrc.length > 0) {
            lazySrc.each(function () {
                if (isInViewport(this)) {
                    loadSrc(this);
                }
            });
        }
    };

    checkViewport();

    setInterval(() => {
        checkViewport();
    }, 500);
};

export default {
    init,
};
