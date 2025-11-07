<!-- SEO Meta Content -->
@push('meta')
    <meta name="description"
        content="{{ trim($category->meta_description) != '' ? $category->meta_description : \Illuminate\Support\Str::limit(strip_tags($category->description), 120, '') }}" />

    <meta name="keywords" content="{{ $category->meta_keywords }}" />

    @if (core()->getConfigData('catalog.rich_snippets.categories.enable'))
        <script type="application/ld+json">
            {!! app('Webkul\Product\Helpers\SEO')->getCategoryJsonLd($category) !!}
        </script>
    @endif
@endPush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ trim($category->meta_title) != '' ? $category->meta_title : $category->name }}
    </x-slot>

    {!! view_render_event('bagisto.shop.categories.view.banner_path.before') !!}

    <!-- Hero Image -->
    @if ($category->banner_path)
        <div>
            <x-shop::media.images.lazy class="max-h-[300px] max-w-full" src="{{ $category->banner_url }}"
                alt="{{ $category->name }}" width="1472" height="300" />
        </div>
    @endif

    {!! view_render_event('bagisto.shop.categories.view.banner_path.after') !!}

    {!! view_render_event('bagisto.shop.categories.view.description.before') !!}
    {!! view_render_event('bagisto.shop.categories.view.description.after') !!}

    @if (in_array($category->display_mode, [null, 'products_only', 'products_and_description']))
        <!-- Category Vue Component -->
        <v-category>
            <!-- Category Shimmer Effect -->
            <x-shop::shimmer.categories.view />
        </v-category>
    @endif

    @pushOnce('scripts')
        <script
            type="text/x-template"
            id="v-category-template"
        >
            <div class="flex items-center justify-between p-4 mt-10 sm:border">
                <div>
                @include('shop::categories.filters')
                </div>
                <div class="max-md:hidden">
                        @include('shop::categories.toolbar')
                    </div>
            </div>
            <div class="container px-[60px] max-lg:px-8 max-md:px-4">
                <div class="flex items-start gap-10 max-lg:gap-5 md:mt-10 ">
                   
                    <!-- Product Listing Container -->
                    <div class="flex-1">
                        <!-- Product List Card Container (for 'list' view) -->
                        <div
                            class="grid grid-cols-1 gap-6 mt-8"
                            v-if="(filters.toolbar.applied.mode ?? filters.toolbar.default.mode) === 'list'"
                        >
                            <!-- ... list view code remains unchanged ... -->
                        </div>

                        <!-- Product Grid Card Container -->
                        <div v-else class="mt-8 max-md:mt-5">
                            <!-- Product Card Shimmer Effect -->
                            <template v-if="isLoading">
                                <!-- 
                                    MODIFICATION 1: 
                                    - Changed max-1060:grid-cols-1 to max-1060:grid-cols-2 to match the actual grid.
                                -->
                                <div class="grid grid-cols-4 gap-8 max-1060:grid-cols-2 max-md:justify-items-center max-md:gap-x-4">
                                    <x-shop::shimmer.products.cards.grid count="12" />
                                </div>
                            </template>

                            {!! view_render_event('bagisto.shop.categories.view.grid.product_card.before') !!}

                            <!-- Product Card Listing -->
                            <template v-else>
                                <template v-if="products.length">
                                    <div class="grid grid-cols-4 gap-8 max-1060:grid-cols-2 max-md:justify-items-center max-md:gap-x-4">
                                        <!-- 
                                            MODIFICATION 2 (THE MAIN FIX):
                                            - Added class="w-full" to force the card to obey the grid column width.
                                        -->
                                        <x-shop::products.card
                                            class="w-full"
                                            ::mode="'grid'"
                                            v-for="product in products"
                                        />
                                    </div>
                                </template>

                                <!-- Empty Products Container -->
                                <template v-else>
                                    <div class="grid items-center w-full py-32 m-auto text-center place-content-center justify-items-center">
                                        <img
                                            class="max-md:h-[100px] max-md:w-[100px]"
                                            src="{{ bagisto_asset('src/Resources/assets/images/thank-you.png') }}"
                                            alt="@lang('shop::app.categories.view.empty')"
                                        />

                                        <p
                                            class="text-xl max-md:text-sm"
                                            role="heading"
                                        >
                                            @lang('shop::app.categories.view.empty')
                                        </p>
                                    </div>
                                </template>
                            </template>

                            {!! view_render_event('bagisto.shop.categories.view.grid.product_card.after') !!}
                        </div>

                        {!! view_render_event('bagisto.shop.categories.view.load_more_button.before') !!}

                        <!-- Load More Button -->
                        <button
                            class="secondary-button mx-auto mt-14 block w-max rounded-2xl px-11 py-3 text-center text-base max-md:rounded-lg max-sm:mt-6 max-sm:px-6 max-sm:py-1.5 max-sm:text-sm"
                            @click="loadMoreProducts"
                            v-if="links.next && ! loader"
                        >
                            @lang('shop::app.categories.view.load-more')
                        </button>

                        <button
                            v-else-if="links.next"
                            class="secondary-button mx-auto mt-14 block w-max rounded-2xl px-[74.5px] py-3.5 text-center text-base max-md:rounded-lg max-md:py-3 max-sm:mt-6 max-sm:px-[50.8px] max-sm:py-1.5"
                        >
                            <!-- Spinner -->
                            <img
                                class="w-5 h-5 animate-spin text-navyBlue"
                                src="{{ bagisto_asset('src/Resources/assets/images/spinner.svg') }}"
                                alt="Loading"
                            />
                        </button>

                        {!! view_render_event('bagisto.shop.categories.view.grid.load_more_button.after') !!}
                    </div>
                </div>
            </div>
        </script>

        <script type="module">
            // ... your script remains unchanged ...
            app.component('v-category', {
                template: '#v-category-template',

                data() {
                    return {
                        isMobile: window.innerWidth <= 767,
                        isLoading: true,
                        isDrawerActive: {
                            toolbar: false,
                            filter: false,
                        },
                        filters: {
                            toolbar: {
                                default: {},
                                applied: {},
                            },
                            filter: {},
                        },
                        products: [],
                        links: {},
                        loader: false,
                    }
                },
                computed: {
                    queryParams() {
                        let queryParams = Object.assign({}, this.filters.filter, this.filters.toolbar.applied);
                        return this.removeJsonEmptyValues(queryParams);
                    },
                    queryString() {
                        return this.jsonToQueryString(this.queryParams);
                    },
                },
                watch: {
                    queryParams() {
                        this.getProducts();
                    },
                    queryString() {
                        window.history.pushState({}, '', '?' + this.queryString);
                    },
                },
                methods: {
                    setFilters(type, filters) {
                        this.filters[type] = filters;
                    },
                    clearFilters(type, filters) {
                        this.filters[type] = {};
                    },
                    getProducts() {
                        document.body.style.overflow = 'scroll';
                        this.$axios.get("{{ route('shop.api.products.index', ['category_id' => $category->id]) }}", {
                                params: this.queryParams
                            })
                            .then(response => {
                                this.isLoading = false;
                                this.products = response.data.data;
                                this.links = response.data.links;
                            }).catch(error => {
                                console.log(error);
                            });
                    },
                    loadMoreProducts() {
                        if (!this.links.next) {
                            return;
                        }
                        this.loader = true;
                        this.$axios.get(this.links.next)
                            .then(response => {
                                this.loader = false;
                                this.products = [...this.products, ...response.data.data];
                                this.links = response.data.links;
                            }).catch(error => {
                                console.log(error);
                            });
                    },
                    removeJsonEmptyValues(params) {
                        Object.keys(params).forEach(function(key) {
                            if ((!params[key] && params[key] !== undefined)) {
                                delete params[key];
                            }
                            if (Array.isArray(params[key])) {
                                params[key] = params[key].join(',');
                            }
                        });
                        return params;
                    },
                    jsonToQueryString(params) {
                        let parameters = new URLSearchParams();
                        for (const key in params) {
                            parameters.append(key, params[key]);
                        }
                        return parameters.toString();
                    }
                },
            });
        </script>
    @endPushOnce
</x-shop::layouts>