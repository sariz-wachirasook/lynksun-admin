const init = () => {
    const imageUploadInputs = $(".js-image-upload-input");
    imageUploadInputs.each((index, element) => {
        const imageUploadInput = $(element);

        // drag and drop
        imageUploadInput
            .parent()
            .on(
                "drag dragstart dragend dragover dragenter dragleave drop",
                (event) => {
                    event.preventDefault();
                    event.stopPropagation();

                    if (
                        event.type === "dragover" ||
                        event.type === "dragenter"
                    ) {
                        imageUploadInput
                            .parent()
                            .addClass("border-blue-500 dark:border-blue-500");
                    }

                    if (event.type === "dragleave" || event.type === "drop") {
                        imageUploadInput
                            .parent()
                            .removeClass(
                                "border-blue-500 dark:border-blue-500"
                            );
                    }

                    if (event.type === "drop") {
                        const file = event.originalEvent.dataTransfer.files[0];

                        if (!file) {
                            return;
                        }

                        const reader = new FileReader();

                        reader.onload = (event) => {
                            imageUploadInput
                                .parent()
                                .find(".js-image-upload-preview")
                                .remove();

                            imageUploadInput.parent().append(
                                `<img src="${event.target.result}" alt=""
                                    class="js-image-upload-preview absolute inset-0 w-full h-full object-cover" />`
                            );

                            imageUploadInput
                                .parent()
                                .find(".js-image-upload-text")
                                .addClass("hidden");
                        };

                        reader.readAsDataURL(file);

                        imageUploadInput.prop(
                            "files",
                            event.originalEvent.dataTransfer.files
                        );
                    }

                    return false;
                }
            );

        imageUploadInput.on("change", (event) => {
            const file = event.target.files[0];

            if (!file) {
                return;
            }

            const reader = new FileReader();

            reader.onload = (event) => {
                imageUploadInput
                    .parent()
                    .find(".js-image-upload-preview")
                    .remove();

                imageUploadInput.parent().append(
                    `<img src="${event.target.result}" alt=""
                        class="js-image-upload-preview absolute inset-0 w-full h-full object-cover" />`
                );

                imageUploadInput
                    .parent()
                    .find(".js-image-upload-text")
                    .addClass("hidden");
            };

            reader.readAsDataURL(file);
        });
    });
};

export default { init };
