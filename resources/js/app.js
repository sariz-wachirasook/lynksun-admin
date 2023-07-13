import "flowbite/dist/flowbite.min.js";

import tinymce from "./components/tinymce";
import mobileResize from "./utils/mobileResize";
import darkModeSwitcher from "./utils/darkModeSwitcher";
import modal from "./components/modal";
import imageUpload from "./components/imageUpload";
import lazy from "./utils/lazy";

$(() => {
    tinymce.init();
    mobileResize.init();
    darkModeSwitcher.init();
    imageUpload.init();
    modal.initDeleteModal();
    lazy.init();
});
