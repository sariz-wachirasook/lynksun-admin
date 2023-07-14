import "flowbite";

import tinymce from "./components/tinymce";
import mobileResize from "./components/utils/mobileResize";
import darkModeSwitcher from "./components/utils/darkModeSwitcher";
import modal from "./components/modal";
import imageUpload from "./components/imageUpload";
import lazy from "./components/utils/lazy";
import barChart from "./components/barChart";

$(() => {
    tinymce.init();
    mobileResize.init();
    darkModeSwitcher.init();
    imageUpload.init();
    modal.initDeleteModal();
    lazy.init();
    barChart.init();
});
