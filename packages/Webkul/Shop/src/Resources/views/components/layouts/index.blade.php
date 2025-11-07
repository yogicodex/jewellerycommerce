@props([
    'hasHeader' => true,
    'hasFeature' => true,
    'hasFooter' => true,
])

<!DOCTYPE html>

<html lang="{{ app()->getLocale() }}" dir="{{ core()->getCurrentLocale()->direction }}">

<head>

    {!! view_render_event('bagisto.shop.layout.head.before') !!}

    <title>{{ $title ?? '' }}</title>

    <meta charset="UTF-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta http-equiv="content-language" content="{{ app()->getLocale() }}">

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="base-url" content="{{ url()->to('/') }}">
    <meta name="currency" content="{{ core()->getCurrentCurrency()->toJson() }}">

    @stack('meta')

    <link rel="icon" sizes="16x16"
        href="{{ core()->getCurrentChannel()->favicon_url ?? asset('images/favicon.ico') }}" />

    @bagistoVite(['src/Resources/assets/css/app.css', 'src/Resources/assets/js/app.js'])

    <link rel="preload" href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap"
        as="style">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700;800&display=swap">

    <link rel="preload" href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap" as="style">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Serif+Display&display=swap">

    @stack('styles')

    <style>
        {!! core()->getConfigData('general.content.custom_scripts.custom_css') !!}
        /* --- Styles moved from inline locations to fix Vue warning --- */

        /* Floating WhatsApp Button Styles */
        .floating-whatsapp-button {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 1000;
            display: flex;
            align-items: center;
            text-decoration: none;
            transition: transform 0.3s ease;
        }

        .floating-whatsapp-button:hover {
            transform: scale(1.03);
        }

        .chat-bubble {
            background-color: white;
            color: #333;
            padding: 5px 10px;
            border-radius: 20px;
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin-right: 10px;
            white-space: nowrap;
            z-index: 1;
        }

        .floating-whatsapp-button svg {
            width: 40px;
            height: 50px;
            margin-bottom: 5px;
            filter: drop-shadow(0 4px 8px rgba(0, 0, 0, 0.2));
        }

        /* SVG Icon Styles */
        .cls-1,
        .cls-2 {
            fill: #fff;
        }

        .cls-1 {
            fill-rule: evenodd;
        }

        .st0 {
            fill: #fff !important;
            fill-rule: evenodd;
            clip-rule: evenodd;
        }
    </style>

    @if (core()->getConfigData('general.content.speculation_rules.enabled'))
        <script type="speculationrules">
                @json(core()->getSpeculationRules(), JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)
            </script>
    @endif

    {!! view_render_event('bagisto.shop.layout.head.after') !!}

</head>

<body>
    {!! view_render_event('bagisto.shop.layout.body.before') !!}

    <a href="#main" class="skip-to-main-content-link">
        Skip to main content
    </a>

    <div id="app">
        {{-- Flash Message Blade Component --}}
        <x-shop::flash-group />

        {{-- Confirm Modal Blade Component --}}
        <x-shop::modal.confirm />

        {{-- Header Offer Banner --}}
        @if (core()->getConfigData('general.content.shop.header_offer_title'))
            <div class="top-offer">
                {!! core()->getConfigData('general.content.shop.header_offer_title') !!}

                @if (core()->getConfigData('general.content.shop.header_offer_redirection_title') &&
                        core()->getConfigData('general.content.shop.header_offer_redirection_link'))
                    <a href="{{ core()->getConfigData('general.content.shop.header_offer_redirection_link') }}"
                        class="offer-link">
                        {{ core()->getConfigData('general.content.shop.header_offer_redirection_title') }}
                    </a>
                @endif
            </div>
        @endif

        {{-- Page Header Blade Component --}}
        @if ($hasHeader)
            <x-shop::layouts.header />
        @endif


        @if (core()->getConfigData('general.gdpr.settings.enabled') && core()->getConfigData('general.gdpr.cookie.enabled'))
            <x-shop::layouts.cookie />
        @endif

        {!! view_render_event('bagisto.shop.layout.content.before') !!}

        {{-- Page Content Blade Component --}}
        <main id="main" class="bg-white">
            {{ $slot }}
        </main>

        {!! view_render_event('bagisto.shop.layout.content.after') !!}

        {{-- Page Footer Blade Component --}}
        @if ($hasFooter)
            <x-shop::layouts.footer />
        @endif
    </div>

    {!! view_render_event('bagisto.shop.layout.body.after') !!}

    @stack('scripts')

    {!! view_render_event('bagisto.shop.layout.vue-app-mount.before') !!}
    <script>
        /**
         * Load event, the purpose of using the event is to mount the application
         * after all of our `Vue` components which is present in blade file have
         * been registered in the app. No matter what `app.mount()` should be
         * called in the last.
         */
        window.addEventListener("load", function(event) {
            app.mount("#app");
        });
    </script>
    {!! view_render_event('bagisto.shop.layout.vue-app-mount.after') !!}

    <script type="text/javascript">
        {!! core()->getConfigData('general.content.custom_scripts.custom_javascript') !!}
    </script>

    {{-- =================================================================== --}}
    {{-- Custom Floating WhatsApp Icon --}}
    {{-- =================================================================== --}}

    <!-- Floating WhatsApp Button -->
    <!-- !! REPLACE the href value with your actual WhatsApp link !! -->
    <a href="https://wa.me/9899393962" class="floating-whatsapp-button" target="_blank"
        aria-label="Chat with us on WhatsApp">

        <!-- The text bubble -->
        <div class="chat-bubble">
            Need Help? Chat with us
        </div>

        <!-- The WhatsApp SVG Icon -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1219.547 1225.016">
            <path fill="#E0E0E0"
                d="M1041.858 178.02C927.206 63.289 774.753.07 612.325 0 277.617 0 5.232 272.298 5.098 606.991c-.039 106.986 27.915 211.42 81.048 303.476L0 1225.016l321.898-84.406c88.689 48.368 188.547 73.855 290.166 73.896h.258.003c334.654 0 607.08-272.346 607.222-607.023.056-162.208-63.052-314.724-177.689-429.463zm-429.533 933.963h-.197c-90.578-.048-179.402-24.366-256.878-70.339l-18.438-10.93-191.021 50.083 51-186.176-12.013-19.087c-50.525-80.336-77.198-173.175-77.16-268.504.111-278.186 226.507-504.503 504.898-504.503 134.812.056 261.519 52.604 356.814 147.965 95.289 95.36 147.728 222.128 147.688 356.948-.118 278.195-226.522 504.543-504.693 504.543z">
            </path>
            <linearGradient id="a" x1="609.77" x2="609.77" y1="1190.114" y2="21.084"
                gradientUnits="userSpaceOnUse">
                <stop offset="0" stop-color="#20b038"></stop>
                <stop offset="1" stop-color="#60d66a"></stop>
            </linearGradient>
            <path fill="url(#a)"
                d="M27.875 1190.114l82.211-300.18c-50.719-87.852-77.391-187.523-77.359-289.602.133-319.398 260.078-579.25 579.469-579.25 155.016.07 300.508 60.398 409.898 169.891 109.414 109.492 169.633 255.031 169.57 409.812-.133 319.406-260.094 579.281-579.445 579.281-.023 0 .016 0 0 0h-.258c-96.977-.031-192.266-24.375-276.898-70.5l-307.188 80.548z">
            </path>
            <path fill="#FFF" fill-rule="evenodd"
                d="M462.273 349.294c-11.234-24.977-23.062-25.477-33.75-25.914-8.742-.375-18.75-.352-28.742-.352-10 0-26.25 3.758-39.992 18.766-13.75 15.008-52.5 51.289-52.5 125.078 0 73.797 53.75 145.102 61.242 155.117 7.5 10 103.758 166.266 256.203 226.383 126.695 49.961 152.477 40.023 179.977 37.523s88.734-36.273 101.234-71.297c12.5-35.016 12.5-65.031 8.75-71.305-3.75-6.25-13.75-10-28.75-17.5s-88.734-43.789-102.484-48.789-23.75-7.5-33.75 7.516c-10 15-38.727 48.773-47.477 58.773-8.75 10.023-17.5 11.273-32.5 3.773-15-7.523-63.305-23.344-120.609-74.438-44.586-39.75-74.688-88.844-83.438-103.859-8.75-15-.938-23.125 6.586-30.602 6.734-6.719 15-17.508 22.5-26.266 7.484-8.758 9.984-15.008 14.984-25.008 5-10.016 2.5-18.773-1.25-26.273s-32.898-81.67-46.234-111.326z"
                clip-rule="evenodd"></path>
            <path fill="#FFF"
                d="M1036.898 176.091C923.562 62.677 772.859.185 612.297.114 281.43.114 12.172 269.286 12.039 600.137 12 705.896 39.633 809.13 92.156 900.13L7 1211.067l318.203-83.438c87.672 47.812 186.383 73.008 286.836 73.047h.255.003c330.812 0 600.109-269.219 600.25-600.055.055-160.343-62.328-311.108-175.649-424.53zm-424.601 923.242h-.195c-89.539-.047-177.344-24.086-253.93-69.531l-18.227-10.805-188.828 49.508 50.414-184.039-11.875-18.867c-49.945-79.414-76.312-171.188-76.273-265.422.109-274.992 223.906-498.711 499.102-498.711 133.266.055 258.516 52 352.719 146.266 94.195 94.266 146.031 219.578 145.992 352.852-.118 274.999-223.923 498.749-498.899 498.749z">
            </path>
        </svg>

    </a>

    {{-- =================================================================== --}}

    {{-- Custom Full Screen Search Overlay --}}
    <div id="search-overlay" class="search-overlay">
        <!-- Close Icon -->
        <a href="#" id="search-close-icon" class="search-close-icon">&times;</a>

        <!-- Search Form Container -->
        <div class="search-overlay-content">
            <form role="search" action="{{ route('shop.search.index') }}" class="flex items-center w-full">
                <div class="relative w-full form-group">
                    <input type="search" name="query"
                        class="block w-full text-center bg-transparent outline-none form-control search-txt"
                        placeholder="@lang('shop::app.components.layouts.header.desktop.bottom.search-text')" required>
                    <button class="btn" type="submit" hidden></button>
                </div>
            </form>
        </div>
    </div>
    {{-- End Custom Search --}}

    <script src="//unpkg.com/alpinejs" defer></script>

</body>

</html>
