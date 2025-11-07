<!--
    This code has been refactored to reduce PHP in the Blade template
    and to change the mobile category display to a smooth, dropdown style
    with plus/minus icons and hierarchical text styling.
-->

<div class="flex flex-wrap gap-4 px-4 pt-6 pb-4 shadow-sm lg:hidden">
    <div class="flex items-center justify-between w-full">
        <!-- Left Navigation -->
        <div class="flex items-center gap-x-1.5">
            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.before') !!}

            <!-- Drawer -->
            <v-mobile-drawer></v-mobile-drawer>

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.after') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.logo.before') !!}

            {!! view_render_event('bagisto.shop.components.layouts.header.mobile.logo.after') !!}
        </div>
        <div class="ml-8 -mt-3">
            <a href="{{ route('shop.home.index') }}" class="max-h-[30px] " aria-label="@lang('shop::app.components.layouts.header.mobile.bagisto')">
                <img src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}" width="80" height="24" class="">
            </a>
        </div>

        <!-- Right Navigation -->
        <div>
            <div class="flex items-center gap-x-5 max-md:gap-x-4">
                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.compare.before') !!}

                @if (core()->getConfigData('catalog.products.settings.compare_option'))
                    <a href="{{ route('shop.compare.index') }}" aria-label="@lang('shop::app.components.layouts.header.mobile.compare')">
                        <span class="text-2xl cursor-pointer icon-compare"></span>
                    </a>
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.compare.after') !!}

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.mini_cart.before') !!}

                @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    @include('shop::checkout.cart.mini-cart')
                @endif

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.mini_cart.after') !!}

                <!-- For Large screens -->
                <div class="max-md:hidden">
                    <x-shop::dropdown
                        position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                        <x-slot:toggle>
                            <span class="text-2xl cursor-pointer icon-users"></span>
                        </x-slot>

                        <!-- Guest Dropdown -->
                        @guest('customer')
                            <x-slot:content>
                                <div class="grid gap-2.5">
                                    <p class="text-xl font-dmserif">
                                        @lang('shop::app.components.layouts.header.mobile.welcome-guest')
                                    </p>

                                    <p class="text-sm">
                                        @lang('shop::app.components.layouts.header.mobile.dropdown-text')
                                    </p>
                                </div>

                                <p class="w-full mt-3 border border-zinc-200"></p>

                                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.customers_action.before') !!}

                                <div class="flex gap-4 mt-6">
                                    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.sign_in_button.before') !!}

                                    <a href="{{ route('shop.customer.session.create') }}"
                                        class="block py-4 m-0 mx-auto text-base font-medium text-center text-white cursor-pointer w-max rounded-2xl bg-navyBlue px-7 ltr:ml-0 rtl:mr-0">
                                        @lang('shop::app.components.layouts.header.mobile.sign-in')
                                    </a>

                                    <a href="{{ route('shop.customers.register.index') }}"
                                        class="m-0 mx-auto block w-max cursor-pointer rounded-2xl border-2 border-navyBlue bg-white px-7 py-3.5 text-center text-base font-medium text-navyBlue ltr:ml-0 rtl:mr-0">
                                        @lang('shop::app.components.layouts.header.mobile.sign-up')
                                    </a>

                                    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.sign_in_button.after') !!}
                                </div>

                                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.customers_action.after') !!}
                            </x-slot>
                        @endguest

                        <!-- Customers Dropdown -->
                        @auth('customer')
                            <x-slot:content class="!p-0">
                                <div class="grid gap-2.5 p-5 pb-0">
                                    <p class="text-xl font-dmserif">
                                        @lang('shop::app.components.layouts.header.mobile.welcome')’
                                        {{ auth()->guard('customer')->user()->first_name }}
                                    </p>

                                    <p class="text-sm">
                                        @lang('shop::app.components.layouts.header.mobile.dropdown-text')
                                    </p>
                                </div>

                                <p class="w-full mt-3 border border-zinc-200"></p>

                                <div class="mt-2.5 grid gap-1 pb-2.5">
                                    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.profile_dropdown.links.before') !!}

                                    <a class="px-5 py-2 text-base cursor-pointer"
                                        href="{{ route('shop.customers.account.profile.index') }}">
                                        @lang('shop::app.components.layouts.header.mobile.profile')
                                    </a>

                                    <a class="px-5 py-2 text-base cursor-pointer"
                                        href="{{ route('shop.customers.account.orders.index') }}">
                                        @lang('shop::app.components.layouts.header.mobile.orders')
                                    </a>

                                    @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                                        <a class="px-5 py-2 text-base cursor-pointer"
                                            href="{{ route('shop.customers.account.wishlist.index') }}">
                                            @lang('shop::app.components.layouts.header.mobile.wishlist')
                                        </a>
                                    @endif

                                    <!--Customers logout-->
                                    @auth('customer')
                                        <x-shop::form method="DELETE" action="{{ route('shop.customer.session.destroy') }}"
                                            id="customerLogout" />

                                        <a class="px-5 py-2 text-base cursor-pointer"
                                            href="{{ route('shop.customer.session.destroy') }}"
                                            onclick="event.preventDefault(); document.getElementById('customerLogout').submit();">
                                            @lang('shop::app.components.layouts.header.mobile.logout')
                                        </a>
                                    @endauth

                                    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.index.profile_dropdown.links.after') !!}
                                </div>
                            </x-slot>
                        @endauth
                    </x-shop::dropdown>
                </div>

                <!-- For Medium and small screen -->
                <div class="md:hidden">
                    @guest('customer')
                        <a href="{{ route('shop.customer.session.create') }}" aria-label="@lang('shop::app.components.layouts.header.mobile.account')">
                            <span class="text-2xl cursor-pointer icon-users"></span>
                        </a>
                    @endguest

                    <!-- Customers Dropdown -->
                    @auth('customer')
                        <a href="{{ route('shop.customers.account.index') }}" aria-label="@lang('shop::app.components.layouts.header.mobile.account')">
                            <span class="text-2xl cursor-pointer icon-users"></span>
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </div>

    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.search.before') !!}

    <!-- Serach Catalog Form -->
    <form action="{{ route('shop.search.index') }}" class="flex items-center w-full">
        <label for="organic-search" class="sr-only">
            @lang('shop::app.components.layouts.header.mobile.search')
        </label>

        <div class="relative w-full">
            <div
                class="icon-search pointer-events-none absolute top-3 flex items-center text-2xl max-md:text-xl max-sm:top-2.5 ltr:left-3 rtl:right-3">
            </div>

            <input type="text"
                class="block w-full rounded-xl border border-['#E3E3E3'] px-11 py-3.5 text-sm font-medium text-gray-900 max-md:rounded-lg max-md:px-10 max-md:py-3 max-md:font-normal max-sm:text-xs"
                name="query" value="{{ request('query') }}" placeholder="@lang('shop::app.components.layouts.header.mobile.search-text')" required>

            @if (core()->getConfigData('catalog.products.settings.image_search'))
                @include('shop::search.images.index')
            @endif
        </div>
    </form>

    {!! view_render_event('bagisto.shop.components.layouts.header.mobile.search.after') !!}
</div>

@pushOnce('scripts')
    <style>
        .category-sub-menu {
            max-height: 0;
            overflow: hidden;
            transition: max-height 0.3s ease-in-out;
        }

        .category-sub-menu.open {
            max-height: 1000px; /* Adjust this value if you have very long sub-menus */
        }
    </style>

    <script type="text/x-template" id="v-mobile-drawer-template">
        <x-shop::drawer
            position="left"
            width="100%"
            @close="onDrawerClose"
        >
            <x-slot:toggle>
                <span class="text-2xl cursor-pointer icon-hamburger"></span>
            </x-slot>

            <x-slot:header>
                <div class="flex items-center justify-between">
                    <a href="{{ route('shop.home.index') }}">
                        <img
                            src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                            alt="{{ config('app.name') }}"
                            width="131"
                            height="29"
                        >
                    </a>
                </div>
            </x-slot>

            <x-slot:content class="!p-0">
                <!-- Account Profile Hero Section -->
                <div class="p-4 border-b border-zinc-200">
                    <div class="grid grid-cols-[auto_1fr] items-center gap-4 rounded-xl border border-zinc-200 p-2.5">
                        <div>
                            <img
                                src="{{ auth()->user()?->image_url ??  bagisto_asset('src/Resources/assets/images/user-placeholder.png') }}"
                                class="h-[60px] w-[60px] rounded-full max-md:rounded-full"
                            >
                        </div>

                        @guest('customer')
                            <a
                                href="{{ route('shop.customer.session.create') }}"
                                class="flex text-base font-medium"
                            >
                                @lang('shop::app.components.layouts.header.mobile.login')

                                <i class="icon-double-arrow text-2xl ltr:ml-2.5 rtl:mr-2.5"></i>
                            </a>
                        @endguest

                        @auth('customer')
                            <div class="flex flex-col justify-between gap-2.5 max-md:gap-0">
                                <p class="text-2xl break-all font-mediums max-md:text-xl">Hello! {{ auth()->user()?->first_name }}</p>

                                <p class="no-underline text-zinc-500 max-md:text-sm">{{ auth()->user()?->email }}</p>
                            </div>
                        @endauth
                    </div>
                </div>

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.categories.before') !!}

                <!-- Mobile category view -->
                <v-mobile-category ref="mobileCategory"></v-mobile-category>

                {!! view_render_event('bagisto.shop.components.layouts.header.mobile.drawer.categories.after') !!}
            </x-slot>

            <x-slot:footer>
                <!-- Localization & Currency Section -->
                @if(core()->getCurrentChannel()->locales()->count() > 1 || core()->getCurrentChannel()->currencies()->count() > 1 )
                    <div class="fixed bottom-0 z-10 grid w-full max-w-full grid-cols-[1fr_auto_1fr] items-center justify-items-center border-t border-zinc-200 bg-white px-5 ltr:left-0 rtl:right-0">
                        <!-- Filter Drawer -->
                        <x-shop::drawer
                            position="bottom"
                            width="100%"
                        >
                            <!-- Drawer Toggler -->
                            <x-slot:toggle>
                                <div
                                    class="flex cursor-pointer items-center gap-x-2.5 px-2.5 py-3.5 text-lg font-medium uppercase max-md:py-3 max-sm:text-base"
                                    role="button"
                                >
                                    {{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}
                                </div>
                            </x-slot>

                            <!-- Drawer Header -->
                            <x-slot:header>
                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-semibold">
                                        @lang('shop::app.components.layouts.header.mobile.currencies')
                                    </p>
                                </div>
                            </x-slot>

                            <!-- Drawer Content -->
                            <x-slot:content class="!px-0">
                                <div
                                    class="overflow-auto"
                                    :style="{ height: getCurrentScreenHeight }"
                                >
                                    <v-currency-switcher></v-currency-switcher>
                                </div>
                            </x-slot>
                        </x-shop::drawer>

                        <!-- Seperator -->
                        <span class="h-5 w-0.5 bg-zinc-200"></span>

                        <!-- Sort Drawer -->
                        <x-shop::drawer
                            position="bottom"
                            width="100%"
                        >
                            <!-- Drawer Toggler -->
                            <x-slot:toggle>
                                <div
                                    class="flex cursor-pointer items-center gap-x-2.5 px-2.5 py-3.5 text-lg font-medium uppercase max-md:py-3 max-sm:text-base"
                                    role="button"
                                >
                                    <img
                                        src="{{ ! empty(core()->getCurrentLocale()->logo_url)
                                                ? core()->getCurrentLocale()->logo_url
                                                : bagisto_asset('images/default-language.svg')
                                            }}"
                                        class="h-full"
                                        alt="Default locale"
                                        width="24"
                                        height="16"
                                    />

                                    {{ core()->getCurrentChannel()->locales()->orderBy('name')->where('code', app()->getLocale())->value('name') }}
                                </div>
                            </x-slot>

                            <!-- Drawer Header -->
                            <x-slot:header>
                                <div class="flex items-center justify-between">
                                    <p class="text-lg font-semibold">
                                        @lang('shop::app.components.layouts.header.mobile.locales')
                                    </p>
                                </div>
                            </x-slot>

                            <!-- Drawer Content -->
                            <x-slot:content class="!px-0">
                                <div
                                    class="overflow-auto"
                                    :style="{ height: getCurrentScreenHeight }"
                                >
                                    <v-locale-switcher></v-locale-switcher>
                                </div>
                            </x-slot>
                        </x-shop::drawer>
                    </div>
                @endif
            </x-slot>
        </x-shop::drawer>
    </script>

    <script
        type="text/x-template"
        id="v-mobile-category-template"
    >
        <div class="h-full px-6 overflow-auto">
            <div class="py-4">
                <!-- Dynamic Categories -->
                <div
                    v-for="category in categories"
                    :key="category.id"
                    class="border-b border-zinc-200"
                >
                    <div
                        class="flex items-center justify-between py-4 transition-colors duration-200 cursor-pointer"
                        @click="toggleCategory(category.id)"
                    >
                        <a :href="category.url" class="text-base font-medium text-black uppercase">
                            @{{ category.name }}
                        </a>

                        <span
                            v-if="category.children && category.children.length"
                            class="text-2xl"
                            :class="isOpen(category.id) ? 'icon-minus' : 'icon-plus'"
                        ></span>
                    </div>

                    <!-- Second Level Categories -->
                    <div
                        v-if="category.children && category.children.length"
                        class="category-sub-menu ltr:pl-4 rtl:pr-4"
                        :class="{ 'open': isOpen(category.id) }"
                    >
                        <div
                            v-for="secondLevelCategory in category.children"
                            :key="secondLevelCategory.id"
                        >
                            <div
                                class="flex items-center justify-between py-3 transition-colors duration-200 cursor-pointer"
                                @click.stop="toggleCategory(secondLevelCategory.id)"
                            >
                                <a :href="secondLevelCategory.url" class="text-sm font-normal uppercase">
                                    @{{ secondLevelCategory.name }}
                                </a>

                                <span
                                    v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                    class="text-xl"
                                    :class="isOpen(secondLevelCategory.id) ? 'icon-minus' : 'icon-plus'"
                                ></span>
                            </div>

                            <!-- Third Level Categories -->
                            <div
                                v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                class="category-sub-menu ltr:pl-5 rtl:pr-5"
                                :class="{ 'open': isOpen(secondLevelCategory.id) }"
                            >
                                <a
                                    v-for="thirdLevelCategory in secondLevelCategory.children"
                                    :key="thirdLevelCategory.id"
                                    :href="thirdLevelCategory.url"
                                    class="block py-2 text-xs uppercase transition-colors duration-200"
                                >
                                    @{{ thirdLevelCategory.name }}
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!--!! START: CUSTOM STATIC LINKS FOR MOBILE !! -->
                <div class="pt-4 mt-4 mb-2">
                    <!-- Legacy Link -->
                    <div class="flex items-center justify-between py-2 transition-colors duration-200 cursor-pointer">
                        <a href="{{ route('shop.static.legacy') }}" class="text-base font-medium text-black">
                            LEGACY
                        </a>
                    </div>

                    <!-- Events Link -->
                    <div class="flex items-center justify-between py-2 transition-colors duration-200 cursor-pointer">
                        <a href="{{ route('shop.events.index') }}" class="text-base font-medium text-black">
                            EVENTS
                        </a>
                    </div>

                    <!-- Contact Us Link -->
                    <div class="flex items-center justify-between py-2 transition-colors duration-200 cursor-pointer">
                        <a href="{{ route('shop.home.contact_us') }}" class="text-base font-medium text-black">
                            CONTACT US
                        </a>
                    </div>
                </div>
                <!--!! END: CUSTOM STATIC LINKS FOR MOBILE !! -->
            </div>
        </div>
    </script>

    <script type="module">
        app.component('v-mobile-category', {
            template: '#v-mobile-category-template',

            data() {
                return {
                    categories: [],
                    openCategories: {},
                }
            },

            mounted() {
                this.getCategories();
            },

            methods: {
                getCategories() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.categories = response.data.data;
                            this.initializeOpenState(this.categories);
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },

                initializeOpenState(categories) {
                    for (const category of categories) {
                        this.openCategories[category.id] = false;
                        if (category.children && category.children.length) {
                            this.initializeOpenState(category.children);
                        }
                    }
                },

                toggleCategory(categoryId) {
                    this.openCategories[categoryId] = !this.openCategories[categoryId];
                },

                isOpen(categoryId) {
                    return this.openCategories[categoryId];
                },

                resetState() {
                    for (const key in this.openCategories) {
                        this.openCategories[key] = false;
                    }
                }
            },
        });

        app.component('v-mobile-drawer', {
            template: '#v-mobile-drawer-template',

            computed: {
                getCurrentScreenHeight() {
                    return window.innerHeight - (window.innerWidth < 920 ? 61 : 0) + 'px';
                },
            },

            methods: {
                onDrawerClose() {
                    this.$refs.mobileCategory.resetState();
                }
            },
        });
    </script>
@endPushOnce