{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.before') !!}

<!-- Header Offer (Blade, always visible and admin-manageable) -->
@if (core()->getConfigData('general.content.header_offer.title'))
    <div class="w-full py-2 text-sm font-medium text-center text-white bg-navyBlue">
        {!! core()->getConfigData('general.content.header_offer.title') !!}
        <a href="{{ core()->getConfigData('general.content.header_offer.redirection_link') }}"
            class="ml-2 font-semibold underline">
            {{ core()->getConfigData('general.content.header_offer.redirection_title') }}
        </a>
    </div>
@endif

<!-- Vue Topbar (Currency & Locale)
<v-topbar>
    <div class="flex items-center justify-between px-16 border-b bg-gray-50">
        Currency Switcher
        <x-shop::dropdown position="bottom-left">
             <x-slot:toggle>
<div class="flex cursor-pointer gap-2.5 py-3" @click="currencyToggler = ! currencyToggler">
    <span>{{ core()->getCurrentCurrency()->symbol . ' ' . core()->getCurrentCurrencyCode() }}</span>
    <span :class="{ 'icon-arrow-up': currencyToggler, 'icon-arrow-down': !currencyToggler }" class="text-2xl"></span>
</div>
</x-slot>

<x-slot:content class="journal-scroll max-h-[500px] !p-0">
    <v-currency-switcher></v-currency-switcher>
</x-slot>
</x-shop::dropdown>

Empty center space (optional)
<div class="flex-1"></div>

<!-- Locale Switcher
        <x-shop::dropdown position="bottom-right">
            <!-- <x-slot:toggle>
<div class="flex cursor-pointer items-center gap-2.5 py-3" @click="localeToggler = ! localeToggler">
    <img src="{{ !empty(core()->getCurrentLocale()->logo_url) ? core()->getCurrentLocale()->logo_url : bagisto_asset('images/default-language.svg') }}"
        width="24" height="16" />
    <span>{{ core()->getCurrentChannel()->locales()->where('code', app()->getLocale())->value('name') }}</span>
    <span :class="{ 'icon-arrow-up': localeToggler, 'icon-arrow-down': !localeToggler }" class="text-2xl"></span>
</div>
</x-slot>

<x-slot:content class="journal-scroll max-h-[500px] !p-0">
    <v-locale-switcher></v-locale-switcher>
</x-slot>
</x-shop::dropdown>
</div>
</v-topbar>
-->
{!! view_render_event('bagisto.shop.components.layouts.header.desktop.top.after') !!}

@pushOnce('scripts')
    <!-- Currency Switcher Template -->
    <script type="text/x-template" id="v-currency-switcher-template">
                <div class="my-2.5 grid gap-1 overflow-auto max-md:my-0 sm:max-h-[500px]">
                    <span
                        class="px-5 py-2 text-base cursor-pointer hover:bg-gray-100"
                        v-for="currency in currencies"
                        :class="{'bg-gray-100': currency.code == '{{ core()->getCurrentCurrencyCode() }}'}"
                        @click="change(currency)"
                    >
                        @{{ currency.symbol + ' ' + currency.code }}
                    </span>
                </div>
            </script>

    <!-- Locale Switcher Template -->
    <script type="text/x-template" id="v-locale-switcher-template">
                <div class="my-2.5 grid gap-1 overflow-auto max-md:my-0 sm:max-h-[500px]">
                    <span
                        class="flex cursor-pointer items-center gap-2.5 px-5 py-2 text-base hover:bg-gray-100"
                        :class="{'bg-gray-100': locale.code == '{{ app()->getLocale() }}'}"
                        v-for="locale in locales"
                        @click="change(locale)"
                    >
                        <img :src="locale.logo_url || '{{ asset('images/default-language.svg') }}'" width="24" height="16"/>
                        @{{ locale.name }}
                    </span>
                </div>
            </script>

    <script type="module">
        app.component('v-topbar', {
            template: '#v-topbar-template',
            data() {
                return {
                    localeToggler: '',
                    currencyToggler: ''
                };
            }
        });

        app.component('v-currency-switcher', {
            template: '#v-currency-switcher-template',
            data() {
                return {
                    currencies: @json(core()->getCurrentChannel()->currencies)
                };
            },
            methods: {
                change(currency) {
                    let url = new URL(window.location.href);
                    url.searchParams.set('currency', currency.code);
                    window.location.href = url.href;
                }
            }
        });

        app.component('v-locale-switcher', {
            template: '#v-locale-switcher-template',
            data() {
                return {
                    locales: @json(core()->getCurrentChannel()->locales()->orderBy('name')->get())
                };
            },
            methods: {
                change(locale) {
                    let url = new URL(window.location.href);
                    url.searchParams.set('locale', locale.code);
                    window.location.href = url.href;
                }
            }
        });
    </script>
@endPushOnce
