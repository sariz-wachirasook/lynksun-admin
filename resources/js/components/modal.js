import { Modal } from "flowbite";

const initDeleteModal = () => {
    // set the modal menu element
    const $targetEl = $("#popup-modal")[0];

    // options with default values
    const options = {
        placement: "bottom-right",
        backdrop: "dynamic",
        backdropClasses:
            "bg-gray-900 bg-opacity-50 dark:bg-opacity-80 fixed inset-0 z-40",
        closable: true,
        onHide: () => {
            console.log("modal is hidden");
        },
        onShow: () => {
            console.log("modal is shown");
        },
        onToggle: () => {
            console.log("modal has been toggled");
        },
    };

    const modal = new Modal($targetEl, options);
    let dataToDelete = null;

    $(".js-btn-delete").on("click", function () {
        dataToDelete = $(this).data("to-delete");
        console.log(dataToDelete);
        modal.show();
    });

    $(".js-btn-confirm-delete").on("click", function () {
        console.log(dataToDelete);
        modal.hide();
        $("#form-delete-" + dataToDelete).submit();
    });

    $(".js-btn-cancel-delete").on("click", function () {
        modal.hide();
    });

    $(".js-btn-close-modal").on("click", function () {
        modal.hide();
    });
};

export default {
    initDeleteModal,
};
