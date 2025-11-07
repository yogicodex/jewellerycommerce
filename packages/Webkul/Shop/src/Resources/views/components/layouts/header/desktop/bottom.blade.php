{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.before') !!}

<!-- Main container that will hold our two new rows -->
<div class="w-full">
    <!-- ROW 1: Social Icons, Logo, and User Actions -->
    <div class="flex items-center justify-between border-b px-11">

        <!-- Left Section: Social Icons -->
        <div class="flex items-center justify-start flex-1 gap-x-2">
            <div>
                <a href="https://www.instagram.com/rajjewellerz_narang?igsh=NTc4MTIwNjQ2YQ==" aria-label="Instagram">
                    <div class="p-2 rounded-full hover:bg-gray-100">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                            stroke-linejoin="round" class="lucide lucide-instagram-icon lucide-instagram">
                            <rect width="20" height="20" x="2" y="2" rx="5" ry="5" />
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z" />
                            <line x1="17.5" x2="17.51" y1="6.5" y2="6.5" />
                        </svg>
                    </div>
                </a>
            </div>
            <a href="#" aria-label="Facebook">
                <div class="p-2 rounded-full hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg"width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="1" stroke-linecap="round" stroke-linejoin="round"
                        class="lucide lucide-facebook-icon lucide-facebook">
                        <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z" />
                    </svg>
                </div>
            </a>
            <a href="#" aria-label="YouTube">
                <div class="p-2 rounded-full hover:bg-gray-100">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                        stroke-linejoin="round" class="lucide lucide-youtube-icon lucide-youtube">
                        <path
                            d="M2.5 17a24.12 24.12 0 0 1 0-10 2 2 0 0 1 1.4-1.4 49.56 49.56 0 0 1 16.2 0A2 2 0 0 1 21.5 7a24.12 24.12 0 0 1 0 10 2 2 0 0 1-1.4 1.4 49.55 49.55 0 0 1-16.2 0A2 2 0 0 1 2.5 17" />
                        <path d="m10 15 5-3-5-3z" />
                    </svg>
                </div>
            </a>
        </div>

        <!-- Center Section: Logo -->
        <div class="flex items-center justify-center flex-1">
            <a href="{{ route('shop.home.index') }}" aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.bagisto')">
                <img class="max-h-[80px]"
                    src="{{ core()->getCurrentChannel()->logo_url ?? bagisto_asset('images/logo.svg') }}"
                    alt="{{ config('app.name') }}">
            </a>
        </div>

        <!-- Right Section: User Actions -->
        <div class="flex flex-1 items-center justify-end gap-x-9 max-[1100px]:gap-x-6 max-lg:gap-x-8">
             {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.before') !!}

            <!-- Compare -->
            @if(core()->getConfigData('catalog.products.settings.compare_option'))
                <a
                    href="{{ route('shop.compare.index') }}"
                    aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.compare')"
                >
                    <span
                        class="icon-compare inline-block cursor-pointer text-2xl"
                        role="presentation"
                    ></span>
                </a>
            @endif

            {!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.compare.after') !!}
            <a href="#" id="search-icon-trigger" class="flex items-center">
                <span class="text-2xl cursor-pointer icon-search"></span>
            </a>
            <div class="mt-1.5 flex gap-x-8 max-[1100px]:gap-x-6 max-lg:gap-x-8">
                @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    @include('shop::checkout.cart.mini-cart')
                @endif
                <x-shop::dropdown
                    position="bottom-{{ core()->getCurrentLocale()->direction === 'ltr' ? 'right' : 'left' }}">
                    <x-slot:toggle>
                        <span class="inline-block text-2xl cursor-pointer icon-users" role="button"
                            aria-label="@lang('shop::app.components.layouts.header.desktop.bottom.profile')" tabindex="0"></span>
                    </x-slot:toggle>
                    @guest('customer')
                        <x-slot:content>
                            <div class="grid gap-2.5">
                                <p class="text-xl font-dmserif">
                                    @lang('shop::app.components.layouts.header.desktop.bottom.welcome-guest')</p>
                                <p class="text-sm">@lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                                </p>
                            </div>
                            <p class="w-full mt-3 border border-zinc-200"></p>
                            <div class="flex gap-4 mt-6">
                                <a href="{{ route('shop.customer.session.create') }}"
                                    class="block m-0 mx-auto text-base text-center primary-button w-max rounded-2xl px-7 max-md:rounded-lg ltr:ml-0 rtl:mr-0">@lang('shop::app.components.layouts.header.desktop.bottom.sign-in')</a>
                                <a href="{{ route('shop.customers.register.index') }}"
                                    class="block m-0 mx-auto text-base text-center border-2 secondary-button w-max rounded-2xl px-7 max-md:rounded-lg max-md:py-3 ltr:ml-0 rtl:mr-0">@lang('shop::app.components.layouts.header.desktop.bottom.sign-up')</a>
                            </div>
                        </x-slot:content>
                    @endguest
                    @auth('customer')
                        <x-slot:content class="!p-0">
                            <div class="grid gap-2.5 p-5 pb-0">
                                <p class="text-xl font-dmserif">
                                    @lang('shop::app.components.layouts.header.desktop.bottom.welcome')’
                                    {{ auth()->guard('customer')->user()->first_name }}</p>
                                <p class="text-sm">@lang('shop::app.components.layouts.header.desktop.bottom.dropdown-text')
                                </p>
                            </div>
                            <p class="w-full mt-3 border border-zinc-200"></p>
                            <div class="mt-2.5 grid gap-1 pb-2.5">
                                <a class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                                    href="{{ route('shop.customers.account.profile.index') }}">@lang('shop::app.components.layouts.header.desktop.bottom.profile')</a>
                                <a class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                                    href="{{ route('shop.customers.account.orders.index') }}">@lang('shop::app.components.layouts.header.desktop.bottom.orders')</a>
                                @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                                    <a class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                                        href="{{ route('shop.customers.account.wishlist.index') }}">@lang('shop::app.components.layouts.header.desktop.bottom.wishlist')</a>
                                @endif
                                <x-shop::form method="DELETE" action="{{ route('shop.customer.session.destroy') }}"
                                    id="customerLogout" />
                                <a class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                                    href="{{ route('shop.customer.session.destroy') }}"
                                    onclick="event.preventDefault(); document.getElementById('customerLogout').submit();">@lang('shop::app.components.layouts.header.desktop.bottom.logout')</a>
                            </div>
                        </x-slot:content>
                    @endauth
                </x-shop::dropdown>
            </div>
        </div>
    </div>

    <!-- ROW 2: Category Navigation Menu -->
    <div class="flex items-center justify-center w-full border-b">
        <v-desktop-category>
            <div class="flex items-center gap-5">
                <span class="w-20 h-6 rounded shimmer" role="presentation"></span>
                <span class="w-20 h-6 rounded shimmer" role="presentation"></span>
                <span class="w-20 h-6 rounded shimmer" role="presentation"></span>
            </div>
        </v-desktop-category>
    </div>
</div>

@pushOnce('scripts')
    <script type="text/x-template" id="v-desktop-category-template">
        <!-- Loading State -->
        <div class="flex items-center gap-5" v-if="isLoading">
            <span class="w-20 h-6 rounded shimmer" role="presentation"></span>
            <span class="w-20 h-6 rounded shimmer" role="presentation"></span>
            <span class="w-20 h-6 rounded shimmer" role="presentation"></span>
        </div>

        <!-- Default category layout -->
        <div 
            class="flex items-center"
            v-else-if="'{{ core()->getConfigData('general.design.categories.category_view') }}' !== 'sidebar'"
        >
            <!--!! NEW HOME LINK ADDED HERE !! -->
           
            <div class="relative flex h-[60px] items-center">
                <span class="relative group">
                <span>
                    <a 
                        href="{{ route('shop.home.index') }}" 
                        class="inline-block px-5 text-xs uppercase"
                    >
                      HOME
                    </a>
                </span>
                <span 
                    class="absolute left-0 -bottom-1 h-[1px] w-0 bg-black transition-all duration-300 ease-out group-hover:w-full"
                ></span>
                 </span>
            </div>

            <!-- Dynamic Categories Loop -->
            <div 
                class="group relative flex h-[60px] items-center border-transparent"
                v-for="category in categories.slice(0, 5)"
            >
                <span class="relative group">
                    <a 
                      
                        class="inline-block px-5 text-xs uppercase"
                    >
                        @{{ category.name.toUpperCase() }}
                    </a>
                <span 
                    class="absolute left-0 -bottom-1 h-[1px] w-0 bg-black transition-all duration-300 ease-out group-hover:w-full"
                ></span>
                </span>

                <div 
                    class="absolute top-[60px] z-[1] min-w-[200px] w-max max-h-[580px]
                    overflow-hidden border border-[#F3F3F3] bg-white py-2
                    origin-top scale-y-0 opacity-0 pointer-events-none
                    transition-transform transition-opacity duration-100 ease-out
                    group-hover:scale-y-100 group-hover:opacity-100 group-hover:pointer-events-auto
                    ltr:-left-9 rtl:-right-9"
                    v-if="category.children && category.children.length"
                >
                    <div class="grid grid-cols-1">
                        <template v-for="secondLevelCategory in category.children">
                            <div>
                                <a 
                                    :href="secondLevelCategory.url" 
                                    class="block px-4 py-2 text-xs uppercase text-navyBlue hover:bg-gray-100"
                                >
                                    @{{ secondLevelCategory.name.toUpperCase() }}
                                </a>
                                <ul 
                                    class="mt-1 ltr:pl-8 rtl:pr-8"
                                    v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                >
                                    <li v-for="thirdLevelCategory in secondLevelCategory.children">
                                        <a 
                                            :href="thirdLevelCategory.url"
                                            class="block p-1 text-xs uppercase text-zinc-500 hover:bg-gray-50"
                                        >
                                            @{{ thirdLevelCategory.name.toUpperCase() }}
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </template>
                    </div>
                </div>
            </div>

            <!-- Legacy Link -->
            <div class="relative flex h-[60px] items-center">
                <span class="relative group">
                <span class="relative">
                    <a 
                        href="{{ route('shop.static.legacy') }}" 
                        class="inline-block px-5 text-xs uppercase"
                    >
                      LEGACY
                    </a>
                </span>
                <span 
                    class="absolute left-0 -bottom-1 h-[1px] w-0 bg-black transition-all duration-300 ease-out group-hover:w-full"
                ></span>
                </span>
            </div>

            <!-- Events Link -->
            <div class="relative flex h-[60px] items-center">
                <span class="relative group">
                <span>
                    <a 
                        href="{{ route('shop.events.index') }}" 
                        class="inline-block px-5 text-xs uppercase"
                    >
                      EVENTS
                    </a>
                </span>
                <span 
                    class="absolute left-0 -bottom-1 h-[1px] w-0 bg-black transition-all duration-300 ease-out group-hover:w-full"
                ></span>
                 </span>
            </div>

            <!--!! NEW CONTACT US LINK ADDED HERE !! -->
            <div class="relative flex h-[60px] items-center">
                <span class="relative group">
                <span>
                    <a 
                        href="{{ route('shop.home.contact_us') }}" 
                        class="inline-block px-5 text-xs uppercase"
                    >
                      CONTACT US
                    </a>
                </span>
                <span 
                    class="absolute left-0 -bottom-1 h-[1px] w-0 bg-black transition-all duration-300 ease-out group-hover:w-full"
                ></span>
                 </span>
            </div>
        </div>

        <!-- Sidebar category layout -->
        <div v-else>
            <div class="flex items-center">
                <div class="flex h-[60px] cursor-pointer items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue"
                    @click="toggleCategoryDrawer">
                    <span class="flex items-center gap-1 px-5 uppercase"><span
                            class="text-xl icon-hamburger"></span>@lang('shop::app.components.layouts.header.desktop.bottom.all')</span>
                </div>

                <!--!! NEW HOME LINK FOR SIDEBAR VIEW !! -->
                <div class="group relative flex h-[60px] items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue">
                    <span>
                        <a 
                            href="{{ route('shop.home.index') }}" 
                            class="inline-block px-5 uppercase"
                        >
                          HOME
                        </a>
                    </span>
                </div>

                <div class="group relative flex h-[60px] items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue"
                    v-for="category in categories.slice(0, 5)">
                    <span><a :href="category.url" class="inline-block px-5 uppercase">@{{ category.name.toUpperCase() }}</a></span>
                    
                    <div 
                        class="pointer-events-none absolute top-[60px] z-[1] max-h-[580px] w-max min-w-[200px] origin-top scale-95 -translate-y-4 transform overflow-auto border border-b-0 border-l-0 border-r-0 border-t border-[#F3F3F3] bg-white py-2 opacity-0 shadow-[0_6px_6px_1px_rgba(0,0,0,.3)] transition-all duration-300 ease-in-out group-hover:pointer-events-auto group-hover:scale-100 group-hover:translate-y-0 group-hover:opacity-100 ltr:-left-9 rtl:-right-9"
                        v-if="category.children && category.children.length">
                        <div class="grid grid-cols-1 !uppercase">
                            <template v-for="secondLevelCategory in category.children">
                                <div>
                                    <a 
                                        :href="secondLevelCategory.url" 
                                        class="block px-4 py-2 text-sm font-medium uppercase text-navyBlue hover:bg-gray-100"
                                    >
                                        @{{ secondLevelCategory.name.toUpperCase() }}
                                    </a>
                                    <ul 
                                        class="mt-1 ltr:pl-8 rtl:pr-8"
                                        v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                    >
                                        <li v-for="thirdLevelCategory in secondLevelCategory.children">
                                            <a 
                                                :href="thirdLevelCategory.url"
                                                class="block p-1 text-xs uppercase text-zinc-500 hover:bg-gray-50"
                                            >
                                                @{{ thirdLevelCategory.name.toUpperCase() }}
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </template>
                        </div>
                    </div>
                </div>

                <!-- Legacy Link (for sidebar view) -->
                <div class="group relative flex h-[60px] items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue">
                    <span>
                        <a 
                            href="{{ route('shop.static.legacy') }}" 
                            class="inline-block px-5 uppercase"
                        >
                          LEGACY
                        </a>
                    </span>
                </div>

                <!-- Events Link (for sidebar view) -->
                <div class="group relative flex h-[60px] items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue">
                    <span>
                        <a 
                            href="{{ route('shop.events.index') }}" 
                            class="inline-block px-5 uppercase"
                        >
                          EVENTS
                        </a>
                    </span>
                </div>

                <!--!! NEW CONTACT US LINK FOR SIDEBAR VIEW !! -->
                <div class="group relative flex h-[60px] items-center border-b-4 border-transparent hover:border-b-4 hover:border-navyBlue">
                    <span>
                        <a 
                            href="{{ route('shop.home.contact_us') }}" 
                            class="inline-block px-5 uppercase"
                        >
                          CONTACT US
                        </a>
                    </span>
                </div>
            </div>

            <x-shop::drawer position="left" width="400px" ::is-active="isDrawerActive" @toggle="onDrawerToggle"
                @close="onDrawerClose">
                <x-slot:toggle></x-slot>
                    <x-slot:header class="border-b border-gray-200">
                        <div class="flex items-center justify-between w-full">
                            <p class="text-xl font-medium">
                                @lang('shop::app.components.layouts.header.desktop.bottom.categories')</p>
                        </div>
                    </x-slot:header>
                    <x-slot:content class="!px-0">
                        <div class="relative h-full overflow-hidden">
                            <div class="flex h-full transition-transform duration-300"
                                :class="{'ltr:translate-x-0 rtl:translate-x-0': currentViewLevel !== 'third', 'ltr:-translate-x-full rtl:translate-x-full': currentViewLevel === 'third'}">
                                <div class="h-[calc(100vh-74px)] w-full flex-shrink-0 overflow-auto">
                                    <div class="py-4">
                                        <div v-for="category in categories" :key="category.id"
                                            :class="{'mb-2': category.children && category.children.length}">
                                            <div
                                                class="flex items-center justify-between px-6 py-2 transition-colors duration-200 cursor-pointer hover:bg-gray-100">
                                                <a :href="category.url" class="text-base font-medium text-black uppercase">@{{
                                                    category.name.toUpperCase() }}</a></div>
                                            <div v-if="category.children && category.children.length">
                                                <div v-for="secondLevelCategory in category.children"
                                                    :key="secondLevelCategory.id">
                                                    <div class="flex items-center justify-between px-6 py-2 transition-colors duration-200 cursor-pointer hover:bg-gray-100"
                                                        @click="showThirdLevel(secondLevelCategory, category, $event)">
                                                        <a :href="secondLevelCategory.url" class="text-sm font-normal uppercase">@{{
                                                            secondLevelCategory.name.toUpperCase() }}</a>
                                                        <span
                                                            v-if="secondLevelCategory.children && secondLevelCategory.children.length"
                                                            class="icon-arrow-right rtl:icon-arrow-left"></span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex-shrink-0 w-full h-full" v-if="currentViewLevel === 'third'">
                                    <div class="px-6 py-4 border-b border-gray-200">
                                        <button @click="goBackToMainView"
                                            class="flex items-center justify-center gap-2 focus:outline-none"
                                            aria-label="Go back">
                                            <span class="text-lg icon-arrow-left rtl:icon-arrow-right"></span>
                                            <p class="text-base font-medium text-black uppercase">
                                                @lang('shop::app.components.layouts.header.desktop.bottom.back-button')</p>
                                        </button>
                                    </div>
                                    <div class="py-4">
                                        <div v-for="thirdLevelCategory in currentSecondLevelCategory?.children"
                                            :key="thirdLevelCategory.id" class="mb-2"><a :href="thirdLevelCategory.url"
                                                class="block px-6 py-2 text-sm uppercase transition-colors duration-200 hover:bg-gray-100">@{{
                                                thirdLevelCategory.name.toUpperCase() }}</a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </x-slot:content>
            </x-shop::drawer>
        </div>
    </script>

    <script type="module">
        app.component('v-desktop-category', {
            template: '#v-desktop-category-template',

            data() {
                return {
                    isLoading: true,
                    categories: [],
                    isDrawerActive: false,
                    currentViewLevel: 'main',
                    currentSecondLevelCategory: null,
                    currentParentCategory: null
                }
            },

            mounted() {
                this.getCategories();
            },

            methods: {
                getCategories() {
                    this.$axios.get("{{ route('shop.api.categories.tree') }}")
                        .then(response => {
                            this.isLoading = false;
                            this.categories = response.data.data;
                        })
                        .catch(error => {
                            console.log(error);
                        });
                },

                toggleCategoryDrawer() {
                    this.isDrawerActive = !this.isDrawerActive;

                    if (this.isDrawerActive) {
                        this.currentViewLevel = 'main';
                    }
                },

                onDrawerToggle(event) {
                    this.isDrawerActive = event.isActive;
                },

                onDrawerClose(event) {
                    this.isDrawerActive = false;
                },

                showThirdLevel(secondLevelCategory, parentCategory, event) {
                    if (secondLevelCategory.children && secondLevelCategory.children.length) {
                        this.currentSecondLevelCategory = secondLevelCategory;
                        this.currentParentCategory = parentCategory;
                        this.currentViewLevel = 'third';

                        if (event) {
                            event.preventDefault();
                            event.stopPropagation();
                        }
                    }
                },

                goBackToMainView() {
                    this.currentViewLevel = 'main';
                }
            },
        });
    </script>
@endPushOnce

{!! view_render_event('bagisto.shop.components.layouts.header.desktop.bottom.after') !!}
