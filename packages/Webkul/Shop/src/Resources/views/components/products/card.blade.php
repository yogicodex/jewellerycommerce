<v-product-card {{ $attributes }} :product="product">
</v-product-card>

{{-- This new style block contains all the logic for the desktop hover animations --}}
@pushOnce('styles')
    <style>
        /* Media query to ensure these styles ONLY apply to large desktop screens (1024px and wider) */
        @media (min-width: 1024px) {
            /* --- Wishlist & Compare Icons --- */

            /* Initial State (Hidden): Set opacity to 0 and shift them slightly to the right */
            .custom-desktop-hover-icons {
                opacity: 0;
                visibility: hidden;
                transform: translateX(16px); /* Start 16px to the right */
                transition: opacity 0.3s ease, transform 0.3s ease, visibility 0.3s;
            }

            /* Hover State (Visible): On parent hover, fade them in and slide them into place */
            .group:hover .custom-desktop-hover-icons {
                opacity: 1;
                visibility: visible;
                transform: translateX(0);
            }

            /* --- Add to Cart Icon --- */

            /* Initial State (Hidden): Set opacity to 0 and push it completely below the card */
            .custom-cart-hover-icon {
                opacity: 0;
                transform: translate(-50%, 100%); /* Keeps it centered horizontally, pushes it down */
                transition: opacity 0.3s ease-in-out, transform 0.3s ease-in-out;
            }

            /* Hover State (Visible): On parent hover, fade it in and slide it up nicely */
            .group:hover .custom-cart-hover-icon {
                opacity: 1;
                transform: translate(-50%, -16px); /* Keeps it centered, moves it up 16px */
            }
        }
    </style>
@endPushOnce

@pushOnce('scripts')
    <script
        type="text/x-template"
        id="v-product-card-template"
    >
        <!-- Grid Card -->
        <div
            class="max-w-sm overflow-hidden"
            v-if="mode != 'list'"
        >
            <div class="relative w-full overflow-hidden transition-all duration-300 ease-in-out group h-80 max-md:h-60 max-sm:h-52 lg:hover:shadow-xl">
                {!! view_render_event('bagisto.shop.components.products.card.image.before') !!}

                <a
                    :href="`{{ route('shop.product_or_category.index', '') }}/${product.url_key}`"
                    :aria-label="product.name + ' '"
                >
                   <x-shop::media.images.lazy
                        class="object-cover w-full h-full transition-transform duration-300 bg-zinc-100 group-hover:scale-105"
                        ::src="product.base_image.original_image_url"
                        ::srcset="product.base_image.srcset"
                        ::key="product.id"
                        ::index="product.id"
                        width="291"
                        height="300"
                        ::alt="product.name"
                    />
                </a>

                {!! view_render_event('bagisto.shop.components.products.card.image.after') !!}

                <!-- Badges -->
                <div class="absolute top-4 action-items ltr:left-4 rtl:right-4">
                    <p
                        class="inline-block rounded-full bg-red-600 px-2.5 text-sm text-white"
                        v-if="product.on_sale"
                    >
                        @lang('shop::app.components.products.card.sale')
                    </p>
                    <p
                        class="inline-block rounded-full bg-navyBlue px-2.5 text-sm text-white"
                        v-else-if="product.is_new"
                    >
                        @lang('shop::app.components.products.card.new')
                    </p>
                </div>

                <!-- 
                    MODIFICATION 1: 
                    - Removed Tailwind animation classes (like lg:invisible, lg:opacity-0, etc.).
                    - Added the new `custom-desktop-hover-icons` class for our CSS to target.
                -->
                <div class="absolute flex-col top-4 gap-y-2 ltr:right-4 rtl:left-4 custom-desktop-hover-icons">
                    @if (core()->getConfigData('customer.settings.wishlist.wishlist_option'))
                        <span
                            class="flex items-center justify-center w-8 h-8 text-lg rounded-full cursor-pointer bg-white/30 backdrop-blur-sm"
                            role="button"
                            aria-label="@lang('shop::app.components.products.card.add-to-wishlist')"
                            :class="product.is_wishlist ? 'icon-heart-fill text-red-500' : 'icon-heart'"
                            @click="addToWishlist()"
                        >
                        </span>
                    @endif

                    @if (core()->getConfigData('catalog.products.settings.compare_option'))
                        <span
                            class="flex items-center justify-center w-8 h-8 text-lg rounded-full cursor-pointer icon-compare bg-white/30 backdrop-blur-sm"
                            role="button"
                            aria-label="@lang('shop::app.components.products.card.add-to-compare')"
                            @click="addToCompare(product.id)"
                        >
                        </span>
                    @endif
                </div>

                <!-- 
                    MODIFICATION 2:
                    - Removed Tailwind animation classes.
                    - Added the new `custom-cart-hover-icon` class.
                    - Kept essential positioning classes (`absolute`, `bottom-4`, etc.).
                -->
                @if (core()->getConfigData('sales.checkout.shopping_cart.cart_page'))
                    <div class="absolute -translate-x-1/2 bottom-4 left-1/2 custom-cart-hover-icon">
                        {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.before') !!}

                        <button
                            class="flex items-center justify-center w-10 h-10 rounded-full cursor-pointer bg-white/80 backdrop-blur-sm hover:bg-white"
                            :disabled="! product.is_saleable || isAddingToCart"
                            aria-label="@lang('shop::app.components.products.card.add-to-cart')"
                            @click="addToCart()"
                        >
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-shopping-cart-icon lucide-shopping-cart"><circle cx="8" cy="21" r="1"/><circle cx="19" cy="21" r="1"/><path d="M2.05 2.05h2l2.66 12.42a2 2 0 0 0 2 1.58h9.78a2 2 0 0 0 1.95-1.57l1.65-7.43H5.12"/></svg>
                        </button>

                        {!! view_render_event('bagisto.shop.components.products.card.add_to_cart.after') !!}
                    </div>
                @endif
            </div>

            <!-- Details Section -->
            <div class="p-4 text-center">
                {!! view_render_event('bagisto.shop.components.products.card.name.before') !!}

                <p class="w-full text-sm font-medium truncate text-zinc-900">
                    @{{ product.name }}
                </p>

                {!! view_render_event('bagisto.shop.components.products.card.name.after') !!}

                <!-- Pricing -->
                {!! view_render_event('bagisto.shop.components.products.card.price.before') !!}

                <div
                    class="flex flex-wrap items-center justify-center min-w-0 gap-x-2.5 gap-y-1 mt-1.5 text-base font-semibold"
                    v-html="product.price_html"
                >
                </div>

                {!! view_render_event('bagisto.shop.components.products.card.price.after') !!}
            </div>
        </div>

        <!-- List Card (Unchanged) -->
        <div
            class="relative flex grid-cols-2 gap-4 overflow-hidden rounded max-w-max max-sm:flex-wrap"
            v-else
        >
          {{-- Your existing list view code remains unchanged --}}
        </div>
    </script>

    <script type="module">
        app.component('v-product-card', {
            template: '#v-product-card-template',
            props: ['mode', 'product'],
            data() {
                return {
                    isCustomer: '{{ auth()->guard('customer')->check() }}',
                    isAddingToCart: false,
                }
            },
            methods: {
                addToWishlist() {
                    if (this.isCustomer) {
                        this.$axios.post(`{{ route('shop.api.customers.account.wishlist.store') }}`, {
                                product_id: this.product.id
                            })
                            .then(response => {
                                this.product.is_wishlist = !this.product.is_wishlist;
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                            })
                            .catch(error => {});
                    } else {
                        window.location.href = "{{ route('shop.customer.session.index') }}";
                    }
                },
                addToCompare(productId) {
                    if (this.isCustomer) {
                        this.$axios.post('{{ route('shop.api.compare.store') }}', { 'product_id': productId })
                            .then(response => {
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.data.message });
                            })
                            .catch(error => {
                                if ([400, 422].includes(error.response.status)) {
                                    this.$emitter.emit('add-flash', { type: 'warning', message: error.response.data.data.message });
                                    return;
                                }
                                this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            });
                        return;
                    }
                    let items = this.getStorageValue() ?? [];
                    if (items.length) {
                        if (!items.includes(productId)) {
                            items.push(productId);
                            localStorage.setItem('compare_items', JSON.stringify(items));
                            this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.components.products.card.add-to-compare-success')" });
                        } else {
                            this.$emitter.emit('add-flash', { type: 'warning', message: "@lang('shop::app.components.products.card.already-in-compare')" });
                        }
                    } else {
                        localStorage.setItem('compare_items', JSON.stringify([productId]));
                        this.$emitter.emit('add-flash', { type: 'success', message: "@lang('shop::app.components.products.card.add-to-compare-success')" });
                    }
                },
                getStorageValue(key) {
                    let value = localStorage.getItem('compare_items');
                    if (!value) {
                        return [];
                    }
                    return JSON.parse(value);
                },
                addToCart() {
                    this.isAddingToCart = true;
                    this.$axios.post('{{ route('shop.api.checkout.cart.store') }}', { 'quantity': 1, 'product_id': this.product.id })
                        .then(response => {
                            if (response.data.message) {
                                this.$emitter.emit('update-mini-cart', response.data.data);
                                this.$emitter.emit('add-flash', { type: 'success', message: response.data.message });
                            } else {
                                this.$emitter.emit('add-flash', { type: 'warning', message: response.data.data.message });
                            }
                            this.isAddingToCart = false;
                        })
                        .catch(error => {
                            this.$emitter.emit('add-flash', { type: 'error', message: error.response.data.message });
                            if (error.response.data.redirect_uri) {
                                window.location.href = error.response.data.redirect_uri;
                            }
                            this.isAddingToCart = false;
                        });
                },
            },
        });
    </script>
@endpushOnce