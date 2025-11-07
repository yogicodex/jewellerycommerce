<v-products-carousel src="{{ $src }}" title="{{ $title }}" navigation-link="{{ $navigationLink ?? '' }}"
    short-text="{{ $shortText ?? '' }}">
    <x-shop::shimmer.products.carousel :navigation-link="$navigationLink ?? false" />
</v-products-carousel>

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-products-carousel-template"
    >
        <div
            class="container lg:!px-[53px] mt-20 max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4"
            v-if="! isLoading && products.length"
        >
           <!-- The main header container. 'relative' is needed for the arrows. -->
<div class="relative">
    <!-- This container is now centered and takes the full width -->
    <div class="text-center">
        <h2 class="text-3xl font-dmserif max-md:text-2xl max-sm:text-xl">
            @{{ title }}
        </h2>

        <p
            class="mt-1 text-sm text-gray-500"
            v-if="shortText"
        >
            @{{ shortText }}
        </p>
    </div>

    <!-- This container for arrows is now positioned absolutely to the right -->
    <div class="absolute top-0 right-0 flex items-center justify-between gap-8">
        <a
            :href="navigationLink"
            class="hidden max-lg:flex"
            v-if="navigationLink"
        >
            <p class="items-center text-xl max-md:text-base max-sm:text-sm">
                @lang('shop::app.components.products.carousel.view-all')

                <span class="text-2xl icon-arrow-right max-md:text-lg max-sm:text-sm"></span>
            </p>
        </a>

        <template v-if="products.length > 3">
            <span
                v-if="products.length > 4 || (products.length > 3 && isScreenMax2xl)"
                class="inline-block text-2xl cursor-pointer icon-arrow-left-stylish rtl:icon-arrow-right-stylish max-lg:hidden"
                role="button"
                aria-label="@lang('shop::app.components.products.carousel.previous')"
                tabindex="0"
                @click="swipeLeft"
            >
            </span>

            <span
                v-if="products.length > 4 || (products.length > 3 && isScreenMax2xl)"
                class="inline-block text-2xl cursor-pointer icon-arrow-right-stylish rtl:icon-arrow-left-stylish max-lg:hidden"
                role="button"
                aria-label="@lang('shop::app.components.products.carousel.next')"
                tabindex="0"
                @click="swipeRight"
            >
            </span>
        </template>
    </div>
</div>

 <div
    ref="swiperContainer"
    class="flex gap-8 pb-2.5 mt-10 overflow-auto scroll-smooth scrollbar-hide max-md:gap-7 max-md:mt-5 max-sm:gap-4 max-md:pb-0 max-md:whitespace-nowrap"
>
    <x-shop::products.card
        class="w-[291px] flex-shrink-0 max-md:h-fit max-md:min-w-56 max-sm:min-w-[192px]"
        v-for="product in products"
    />
</div>

            <a
                :href="navigationLink"
                class="secondary-button rounded-none mx-auto mt-5 block w-max px-11 py-3 text-center text-base max-lg:mt-0 max-lg:hidden max-lg:py-3.5 bg-[#121375] hover:bg-white hover:text-black text-white"
                :aria-label="title"
                v-if="navigationLink"
            >
                @lang('shop::app.components.products.carousel.view-all')
            </a>
        </div>

        <!-- Product Card Listing -->
        <template v-if="isLoading">
            <x-shop::shimmer.products.carousel :navigation-link="$navigationLink ?? false" />
        </template>
    </script>

    <script type="module">
        app.component('v-products-carousel', {
            template: '#v-products-carousel-template',

            props: [
                'src',
                'title',
                'navigationLink',
                'shortText',
            ],

            data() {
                return {
                    isLoading: true,

                    products: [],

                    offset: 323,

                    isScreenMax2xl: window.innerWidth <= 1440,
                };
            },

            mounted() {
                this.getProducts();
            },

            created() {
                window.addEventListener('resize', this.updateScreenSize);
            },

            beforeDestroy() {
                window.removeEventListener('resize', this.updateScreenSize);
            },

            methods: {
                getProducts() {
                    this.$axios.get(this.src)
                        .then(response => {
                            this.isLoading = false;

                            this.products = response.data.data;
                        }).catch(error => {
                            console.log(error);
                        });
                },

                updateScreenSize() {
                    this.isScreenMax2xl = window.innerWidth <= 1440;
                },

                swipeLeft() {
                    const container = this.$refs.swiperContainer;

                    container.scrollLeft -= this.offset;
                },

                swipeRight() {
                    const container = this.$refs.swiperContainer;

                    // Check if scroll reaches the end
                    if (container.scrollLeft + container.clientWidth >= container.scrollWidth) {
                        // Reset scroll to the beginning
                        container.scrollLeft = 0;
                    } else {
                        // Scroll to the right
                        container.scrollLeft += this.offset;
                    }
                },
            },
        });
    </script>
@endPushOnce