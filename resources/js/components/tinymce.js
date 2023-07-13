const init = () => {
    const tinymceClass = document.getElementsByClassName("tinymce");

    if (tinymceClass.length > 0) {
        import(
            "https://cdn.tiny.cloud/1/8p9v7axwmgov274fbixlh2imupntb2v6c5qn6smlbmefkati/tinymce/6/tinymce.min.js"
        ).then(() => {
            let mode = localStorage.getItem("color-theme");

            if (!mode) {
                mode = window.matchMedia("(prefers-color-scheme: dark)").matches
                    ? "dark"
                    : "light";
            }

            let style_formats = [
                {
                    title: "Headers",
                    items: [
                        {
                            title: "Header 2",
                            format: "h2",
                        },
                        {
                            title: "Header 3",
                            format: "h3",
                        },
                        {
                            title: "Header 4",
                            format: "h4",
                        },
                        {
                            title: "Header 5",
                            format: "h5",
                        },
                        {
                            title: "Header 6",
                            format: "h6",
                        },
                    ],
                },
                {
                    title: "Inline",
                    items: [
                        {
                            title: "Bold",
                            icon: "bold",
                            format: "bold",
                        },
                        {
                            title: "Italic",
                            icon: "italic",
                            format: "italic",
                        },
                        {
                            title: "Underline",
                            icon: "underline",
                            format: "underline",
                        },
                        {
                            title: "Strikethrough",
                            icon: "strikethrough",
                            format: "strikethrough",
                        },
                        {
                            title: "Superscript",
                            icon: "superscript",
                            format: "superscript",
                        },
                        {
                            title: "Subscript",
                            icon: "subscript",
                            format: "subscript",
                        },
                        {
                            title: "Code",
                            icon: "code",
                            format: "code",
                        },
                    ],
                },
                {
                    title: "Blocks",
                    items: [
                        {
                            title: "Paragraph",
                            format: "p",
                        },
                        {
                            title: "Blockquote",
                            format: "blockquote",
                        },
                        {
                            title: "Div",
                            format: "div",
                        },
                        {
                            title: "Pre",

                            format: "pre",
                        },
                    ],
                },
                {
                    title: "Alignment",
                    items: [
                        {
                            title: "Left",
                            icon: "alignleft",
                            format: "alignleft",
                        },
                        {
                            title: "Center",
                            icon: "aligncenter",
                            format: "aligncenter",
                        },

                        {
                            title: "Right",
                            icon: "alignright",
                            format: "alignright",
                        },
                        {
                            title: "Justify",
                            icon: "alignjustify",
                            format: "alignjustify",
                        },
                    ],
                },
            ];

            tinymce.init({
                selector: ".tinymce",
                toolbar_mode: "floating",
                placeholder: "Type here...",
                skin: mode === "dark" ? "oxide-dark" : "oxide",
                content_css: mode,
                setup: function (editor) {
                    editor.on("change", function () {
                        tinymce.triggerSave();
                    });

                    editor.on("init", function () {
                        $(".tox-tinymce").css("opacity", "1");
                    });
                },
                style_formats,
            });

            const darkModeSwitcher =
                document.getElementById("dark-mode-switcher");
            darkModeSwitcher.addEventListener("click", () => {
                setTimeout(() => {
                    let mode = localStorage.getItem("color-theme");
               
                    tinymce.remove();
                    tinymce.init({
                        selector: ".tinymce",
                        toolbar_mode: "floating",
                        placeholder: "Type here...",
                        skin: mode === "dark" ? "oxide-dark" : "oxide",
                        content_css: mode,
                        setup: function (editor) {
                            editor.on("change", function () {
                                tinymce.triggerSave();
                            });

                            editor.on("init", function () {
                                $(".tox-tinymce").css("opacity", "1");
                            });
                        },
                        style_formats,
                    });
                }, 24);
            });
        });
    }
};

export default {
    init,
};
