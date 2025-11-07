<v-categories-carousel src="{{ $src }}" title="{{ $title }}" navigation-link="{{ $navigationLink ?? '' }}">
    <x-shop::shimmer.categories.carousel :count="4" :navigation-link="$navigationLink ?? false" />
</v-categories-carousel>

@pushOnce('scripts')
    <script type="text/x-template" id="v-categories-carousel-template">
        <div
            class="container mt-14 max-lg:px-8 max-md:mt-7 max-sm:mt-5 max-sm:px-4"
            v-if="!isLoading && categories?.length"
        >
            <!-- Portrait-style categories grid -->
            <div class="grid justify-center grid-cols-4 gap-20 max-lg:grid-cols-2 max-sm:grid-cols-2 max-sm:gap-2">
                <div
                    v-for="category in categories.slice(0, 4)"
                    :key="category.id"
                    class="flex flex-col items-center text-center group"
                >
                    <a
                        :href="category.slug"
                        :aria-label="category.name"
                        class="block overflow-hidden  w-[320px] h-[400px] max-md:w-[240px] max-md:h-[300px] max-sm:w-full max-sm:h-full"
                    >
                        <img
                            class="object-cover w-full h-full transition-transform duration-300 ease-in-out group-hover:scale-105"
                            :src="category.logo?.large_image_url || '{{ bagisto_asset('src/Resources/assets/images/large-product-placeholder.webp') }}'"
                            :alt="category.name"
                            :title="category.name"
                        >
                    </a>

                    <!-- Category name below image -->
                    <a
                        :href="category.slug"
                        class="mt-4"
                    >
                        <p
                            class="text-sm tracking-wide text-gray-900 uppercase max-md:text-xs max-sm:text-[10px]"
                            v-text="category.name"
                        ></p>
                    </a>
                </div>
            </div>
        </div>

        <!-- Loading shimmer -->
        <template v-if="isLoading">
            <x-shop::shimmer.categories.carousel :count="4" :navigation-link="$navigationLink ?? false" />
        </template>
    </script>

    <script type="module">
        app.component('v-categories-carousel', {
            template: '#v-categories-carousel-template',

            props: ['src', 'title', 'navigationLink'],

            data() {
                return {
                    isLoading: true,
                    categories: [],
                };
            },

            mounted() {
                this.getCategories();
            },

            methods: {
                getCategories() {
                    this.$axios.get(this.src)
                        .then(response => {
                            this.isLoading = false;
                            this.categories = response.data.data;
                        })
                        .catch(error => console.error(error));
                },
            },
        });
    </script>
@endPushOnce
