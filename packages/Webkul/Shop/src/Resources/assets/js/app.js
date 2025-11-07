
/**
 * This will track all the images and fonts for publishing.
 */
import.meta.glob(["../images/**", "../fonts/**"]);

/**
 * Main vue bundler.
 */
import { createApp } from "vue/dist/vue.esm-bundler";

/**
 * Main root application registry.
 */
window.app = createApp({
    data() {
        return {};
    },

    mounted() {
        this.lazyImages();
    },

    methods: {
        onSubmit() { },

        onInvalidSubmit() { },

        lazyImages() {
            var lazyImages = [].slice.call(document.querySelectorAll('img.lazy'));

            let lazyImageObserver = new IntersectionObserver(function (entries, observer) {
                entries.forEach(function (entry) {
                    if (entry.isIntersecting) {
                        let lazyImage = entry.target;

                        lazyImage.src = lazyImage.dataset.src;

                        lazyImage.classList.remove('lazy');

                        lazyImageObserver.unobserve(lazyImage);
                    }
                });
            });

            lazyImages.forEach(function (lazyImage) {
                lazyImageObserver.observe(lazyImage);
            });
        },
    },
});

/**
 * Global plugins registration.
 */
import Axios from "./plugins/axios";
import Emitter from "./plugins/emitter";
import Shop from "./plugins/shop";
import VeeValidate from "./plugins/vee-validate";
import Flatpickr from "./plugins/flatpickr";

[
    Axios,
    Emitter,
    Shop,
    VeeValidate,
    Flatpickr,
].forEach((plugin) => app.use(plugin));

/**
 * Global directives.
 */
import Debounce from "./directives/debounce";

app.directive("debounce", Debounce);

export default app;



/**
 * Custom Search Overlay Logic (Final Version with Module Import)
 */
import $ from 'jquery';

$(document).ready(function () {
    // Function to open the search overlay
    function openSearch() {
        $('#search-overlay').addClass('open');
        setTimeout(function () {
            $('#search-overlay .form-control').focus();
        }, 400);
    }

    // Function to close the search overlay
    function closeSearch() {
        $('#search-overlay').removeClass('open');
    }

    // Use event delegation to listen for clicks on the search icon
    $(document).on('click', '#search-icon-trigger', function (e) {
        e.preventDefault();
        openSearch();
    });

    // Listen for clicks on the close icon
    $(document).on('click', '#search-close-icon', function (e) {
        e.preventDefault();
        closeSearch();
    });

    // Listen for the 'Escape' key to close the overlay
    $(document).on('keydown', function (e) {
        if (e.key === "Escape" && $('#search-overlay').hasClass('open')) {
            closeSearch();
        }
    });
});
