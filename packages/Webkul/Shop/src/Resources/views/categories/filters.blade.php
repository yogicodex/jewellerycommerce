{!! view_render_event('bagisto.shop.categories.view.filters.before') !!}

<!-- 
    STRUCTURE:
    1. Desktop Filter Button
    2. Mobile Filter + Sort bar
    3. Two separate drawers (Desktop sidebar, Mobile fullscreen)
-->

<!-- 🖥️ Desktop Filter Button -->
<div class="max-md:hidden">
    <button
        type="button"
        class="flex w-full items-center justify-center gap-x-1 rounded-lg  px-3 py-1.5 text-xs transition-all hover:bg-gray-100 uppercase"
        @click="isDrawerActive.filter = true"
    >
        <span class="icon-filter-1 text-sm"></span>
        <span>
        @lang('shop::app.categories.filters.filter')
        </span>
    </button>
</div>

<!-- 📱 Mobile Filter + Sort Bar -->
<div
    class="fixed bottom-0 z-10 grid w-full max-w-full grid-cols-[1fr_auto_1fr] items-center justify-items-center border-t border-zinc-200 bg-white px-5 ltr:left-0 rtl:right-0 md:hidden"
>
    <!-- Mobile Filter Toggle -->
    <div
        class="flex cursor-pointer items-center gap-x-2.5 px-2.5 py-3.5 text-base font-medium uppercase"
        @click="isDrawerActive.filter = true"
    >
        <span class="icon-filter-1 text-2xl"></span>
        @lang('shop::app.categories.filters.filter')
    </div>

    <span class="h-5 w-0.5 bg-zinc-200"></span>

    <!-- Mobile Sort Drawer -->
    <x-shop::drawer
        position="bottom"
        width="100%"
        ::is-active="isDrawerActive.toolbar"
    >
        <x-slot:toggle>
            <div
                class="flex cursor-pointer items-center gap-x-2.5 px-2.5 py-3.5 text-base font-medium uppercase"
                @click="isDrawerActive.toolbar = true"
            >
                <span class="icon-sort-1 text-2xl"></span>
                @lang('shop::app.categories.filters.sort')
            </div>
        </x-slot:toggle>

        <x-slot:header>
            <p class="text-lg font-semibold">@lang('shop::app.categories.filters.sort')</p>
        </x-slot:header>

        <x-slot:content class="!px-0">
            @include('shop::categories.toolbar')
        </x-slot:content>
    </x-shop::drawer>
</div>

<!-- 🖥️ Desktop Filter Drawer -->
<x-shop::drawer
    position="left"
    width="420px"
    ::is-active="isDrawerActive.filter"
    @close="isDrawerActive.filter = false"
    class="hidden md:block"
>
    <x-slot:header>
        <!-- <div class="flex items-center justify-between bg-red-500">
            <p class="text-lg font-semibold">
                @lang('shop::app.categories.filters.filters')
            </p>

            <p
                class="cursor-pointer text-sm font-medium"
                @click="clearFilters('filter', '')"
            >
                @lang('shop::app.categories.filters.clear-all')
            </p>
        </div> -->
    </x-slot:header>

    <x-slot:content>
        <v-filters
            @filter-applied="setFilters('filter', $event)"
            @filter-clear="clearFilters('filter', $event)"
        >
            <x-shop::shimmer.categories.filters />
        </v-filters>
    </x-slot:content>
</x-shop::drawer>

<!-- 📱 Mobile Filter Drawer -->
<x-shop::drawer
    position="bottom"
    width="100%"
    ::is-active="isDrawerActive.filter"
    @close="isDrawerActive.filter = false"
    class="block md:hidden"
>
    <x-slot:header>
        <div class="flex items-center justify-between">
            <p class="text-lg font-semibold">
                @lang('shop::app.categories.filters.filters')
            </p>

            <p
                class="cursor-pointer text-sm font-medium"
                @click="clearFilters('filter', '')"
            >
                @lang('shop::app.categories.filters.clear-all')
            </p>
        </div>
    </x-slot:header>

    <x-slot:content>
        <v-filters
            @filter-applied="setFilters('filter', $event)"
            @filter-clear="clearFilters('filter', $event)"
        >
            <x-shop::shimmer.categories.filters />
        </v-filters>
    </x-slot:content>
</x-shop::drawer>

{!! view_render_event('bagisto.shop.categories.view.filters.after') !!}

@pushOnce('scripts')
    <!-- Filters Vue template -->
    <script type="text/x-template" id="v-filters-template">
        <template v-if="isLoading">
            <x-shop::shimmer.categories.filters />
        </template>

        <template v-else>
            <div class="panel-side journal-scroll grid max-h-[1320px] min-w-[342px] grid-cols-[1fr] overflow-y-auto overflow-x-hidden max-xl:min-w-[270px] md:max-w-[342px] md:ltr:pr-7 md:rtl:pl-7">
                <!-- Header -->
                <div class="flex h-[50px] items-center justify-between border-b border-zinc-200 pb-2.5 max-md:hidden">
                    <p class="text-lg font-semibold max-sm:font-medium">
                        @lang('shop::app.categories.filters.filters')
                    </p>
                    <p
                        class="cursor-pointer text-xs font-medium"
                        tabindex="0"
                        @click="clear()"
                    >
                        @lang('shop::app.categories.filters.clear-all')
                    </p>
                </div>

                <!-- Filter Items -->
                <v-filter-item
                    ref="filterItemComponent"
                    :key="filterIndex"
                    :filter="filter"
                    v-for="(filter, filterIndex) in filters.available"
                    @values-applied="applyFilter(filter, $event)"
                ></v-filter-item>
            </div>
        </template>
    </script>

    <!-- Filter Item Template -->
    <script type="text/x-template" id="v-filter-item-template">
        <x-shop::accordion class="last:border-b-0">
            <x-slot:header class="px-0 py-2.5 max-sm:!pb-1.5">
                <div class="flex items-center justify-between">
                    <p class="text-lg font-semibold max-sm:text-base max-sm:font-medium">@{{ filter.name }}</p>
                </div>
            </x-slot>

            <x-slot:content class="!p-0">
                <ul v-if="filter.type === 'price'">
                    <li>
                        <v-price-filter
                            :key="refreshKey"
                            :default-price-range="appliedValues"
                            @set-price-range="applyValue($event)"
                        ></v-price-filter>
                    </li>
                </ul>

                <template v-else>
                    <!-- Search Box -->
                    <div v-if="filter.type !== 'boolean'">
                        <div class="relative">
                            <div class="icon-search pointer-events-none absolute top-3 flex items-center text-2xl max-md:text-xl max-sm:top-2.5 ltr:left-3 rtl:right-3"></div>

                            <input
                                type="text"
                                class="block w-full rounded-xl border border-zinc-200 px-11 py-3.5 text-sm font-medium text-gray-900"
                                placeholder="@lang('shop::app.categories.filters.search.title')"
                                v-model="searchQuery"
                                v-debounce:500="searchOptions"
                            />
                        </div>
                    </div>

                    <!-- Options -->
                    <ul class="pb-3 text-base text-gray-700">
                        <template v-if="options.length">
                            <li
                                v-for="(option, optionIndex) in options"
                                :key="`${filter.id}_${option.id}`"
                            >
                                <div class="flex items-center gap-x-4 rounded hover:bg-gray-100 ltr:pl-2 rtl:pr-2">
                                    <input
                                        type="checkbox"
                                        :id="`filter_${filter.id}_option_${option.id}`"
                                        class="peer hidden"
                                        :value="option.id"
                                        v-model="appliedValues"
                                        @change="applyValue"
                                    />

                                    <label
                                        class="icon-uncheck peer-checked:icon-check-box cursor-pointer text-2xl text-navyBlue peer-checked:text-navyBlue"
                                        :for="`filter_${filter.id}_option_${option.id}`"
                                    ></label>

                                    <label
                                        class="w-full cursor-pointer p-2 text-base text-gray-900"
                                        :for="`filter_${filter.id}_option_${option.id}`"
                                    >
                                        @{{ option.name }}
                                    </label>
                                </div>
                            </li>
                        </template>

                        <template v-else>
                            <li class="py-2 text-center text-sm text-gray-500">
                                @lang('shop::app.categories.filters.search.no-options-available')
                            </li>
                        </template>
                    </ul>
                </template>
            </x-slot>
        </x-shop::accordion>
    </script>

    <!-- Price Filter Template -->
    <script type="text/x-template" id="v-price-filter-template">
        <div>
            <template v-if="isLoading">
                <x-shop::shimmer.range-slider />
            </template>
            <template v-else>
                <x-shop::range-slider
                    ::key="refreshKey"
                    default-type="price"
                    ::default-allowed-max-range="allowedMaxPrice"
                    ::default-min-range="minRange"
                    ::default-max-range="maxRange"
                    @change-range="setPriceRange($event)"
                />
            </template>
        </div>
    </script>

    <!-- Vue Components -->
    <script type="module">
        app.component('v-filters', {
            template: '#v-filters-template',
            data() {
                return {
                    isLoading: true,
                    filters: { available: {}, applied: {} },
                };
            },
            mounted() {
                this.getFilters();
                this.setFilters();
            },
            methods: {
                getFilters() {
                    this.$axios.get('{{ route("shop.api.categories.attributes") }}', {
                        params: { category_id: "{{ isset($category) ? $category->id : '' }}" },
                    })
                    .then((response) => {
                        this.isLoading = false;
                        this.filters.available = response.data.data;
                    })
                    .catch((error) => console.log(error));
                },
                setFilters() {
                    let queryParams = new URLSearchParams(window.location.search);
                    queryParams.forEach((value, filter) => {
                        if (!['sort', 'limit', 'mode'].includes(filter)) {
                            this.filters.applied[filter] = value.split(',');
                        }
                    });
                    this.$emit('filter-applied', this.filters.applied);
                },
                applyFilter(filter, values) {
                    if (values.length) this.filters.applied[filter.code] = values;
                    else delete this.filters.applied[filter.code];
                    this.$emit('filter-applied', this.filters.applied);
                },
                clear() {
                    this.filters.applied = {};
                    this.$refs.filterItemComponent.forEach((c) => {
                        c.$data.appliedValues = c.filter.code === 'price' ? null : [];
                    });
                    this.$emit('filter-applied', this.filters.applied);
                },
            },
        });

        app.component('v-filter-item', {
            template: '#v-filter-item-template',
            props: ['filter'],
            data() {
                return {
                    options: [],
                    meta: null,
                    appliedValues: null,
                    currentPage: 1,
                    searchQuery: '',
                    isLoadingMore: true,
                    refreshKey: 0,
                };
            },
            mounted() {
                this.fetchFilterOptions();
                if (this.filter.code === 'price') {
                    this.appliedValues = this.$parent.$data.filters.applied[this.filter.code]?.join(',');
                    ++this.refreshKey;
                } else {
                    this.appliedValues = this.$parent.$data.filters.applied[this.filter.code] ?? [];
                }
            },
            methods: {
                applyValue($event) {
                    if (this.filter.code === 'price') this.appliedValues = $event;
                    this.$emit('values-applied', this.appliedValues);
                },
                searchOptions() {
                    this.currentPage = 1;
                    this.fetchFilterOptions(true);
                },
                fetchFilterOptions(replace = true) {
                    this.isLoadingMore = true;
                    const url = `{{ route("shop.api.categories.attribute_options", 'attribute_id') }}`.replace('attribute_id', this.filter.id);
                    this.$axios.get(url, {
                        params: { page: this.currentPage, search: this.searchQuery },
                    })
                    .then((response) => {
                        this.isLoadingMore = false;
                        this.options = replace ? response.data.data : [...this.options, ...response.data.data];
                        this.meta = response.data.meta;
                    })
                    .catch(() => { this.isLoadingMore = false; });
                },
            },
        });

        app.component('v-price-filter', {
            template: '#v-price-filter-template',
            props: ['defaultPriceRange'],
            data() {
                return {
                    refreshKey: 0,
                    isLoading: true,
                    allowedMaxPrice: 100,
                    priceRange: this.defaultPriceRange ?? [0, 100].join(','),
                };
            },
            computed: {
                minRange() { return this.priceRange.split(',')[0]; },
                maxRange() { return this.priceRange.split(',')[1]; },
            },
            mounted() {
                this.getMaxPrice();
            },
            methods: {
                getMaxPrice() {
                    this.$axios.get('{{ route("shop.api.categories.max_price", $category->id ?? '') }}')
                        .then((response) => {
                            this.isLoading = false;
                            if (response.data.data.max_price)
                                this.allowedMaxPrice = response.data.data.max_price;
                            if (!this.defaultPriceRange)
                                this.priceRange = [0, this.allowedMaxPrice].join(',');
                            ++this.refreshKey;
                        });
                },
                setPriceRange($event) {
                    this.priceRange = [$event.minRange, $event.maxRange].join(',');
                    this.$emit('set-price-range', this.priceRange);
                },
            },
        });
    </script>
@endPushOnce
