{!! view_render_event('bagisto.shop.layout.footer.before') !!}

@inject('themeCustomizationRepository', 'Webkul\Theme\Repositories\ThemeCustomizationRepository')

@php
    $channel = core()->getCurrentChannel();
    $customization = $themeCustomizationRepository->findOneWhere([
        'type' => 'footer_links',
        'status' => 1,
        'theme_code' => $channel->theme,
        'channel_id' => $channel->id,
    ]);
@endphp

<!--
    We keep v-pre as a safeguard, but the critical changes are inside.
-->
<footer v-pre class="mt-3 bg-[#141275] text-white pt-6 pb-6 px-4 w-full font-serif">
    <div class="px-6 mx-auto lg:container">
        <div class="flex justify-center mb-6 md:justify-start">
            <a href="{{ route('shop.home.index') }}" class="max-w-[150px]">
                @if ($logo = $channel->logo_url)
                    <img src="{{ asset('vendor/webkul/shop/assets/images/logo png.png') }}" alt="{{ $channel->name }}">
                @else
                    <img src="{{ bagisto_asset('#') }}" alt="{{ config('app.name') }}">
                @endif
            </a>
        </div>

        <div class="grid grid-cols-1 gap-10 pb-10 md:grid-cols-2 lg:grid-cols-4 lg:gap-8 !w-full">
            @if ($customization?->options)
                @php
                    $footerSections = array_values($customization->options ?? []);
                @endphp

                @foreach ($footerSections as $i => $footerLinkSection)
                    @php
                        usort($footerLinkSection, fn($a, $b) => $a['sort_order'] - $b['sort_order']);

                        $title = match ($i) {
                            0 => 'Quick Buy',
                            1 => 'Quick Links',
                            default => 'Links',
                        };
                    @endphp

                    <div x-data="{ open: window.innerWidth >= 768 }" class="footer-section">
                        <button type="button" x-on:click="open = !open"
                            class="flex items-center justify-between w-full mb-5 text-base font-semibold tracking-wider text-left uppercase border-b border-gray-700 md:border-b-0 pb-2.5 md:pb-0 md:cursor-default md:pointer-events-none">
                            <span>{{ $title }}</span>
                            <svg class="w-5 h-5 transition-transform duration-300 md:hidden"
                                x-bind:class="{ 'rotate-180': open }" fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        <ul x-show="open" x-cloak class="grid gap-3 font-sans text-sm text-gray-300">
                            @foreach ($footerLinkSection as $link)
                                <li>
                                    <a href="{{ $link['url'] }}"
                                        class="transition-colors duration-200 hover:text-white">
                                        {{ $link['title'] }}
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @endif

            <div>
                <h3 class="mb-5 text-base font-semibold tracking-wider uppercase">Get In Touch</h3>
                <div class="grid gap-3 font-sans text-sm text-gray-300">
                    <p>2656 Bank Street, Karol Bagh, New Delhi - 110005</p>
                    <p>Email: rajjewellerz.narang@gmail.com</p>
                    <p>Whatsapp: +91-9899393962</p>
                    <p>Timings: 11:00AM - 8:00PM, Tuesday - Sunday (Monday Off)</p>
                    <p>Phone: 011-41544717</p>
                </div>
            </div>

            <div>
                <h3 class="mb-5 text-base font-semibold tracking-wider uppercase">Newsletter</h3>
                <p class="mb-4 font-sans text-sm text-gray-300">Sign up to our newsletter to receive exclusive offers.
                </p>
                @if (core()->getConfigData('customer.settings.newsletter.subscription'))
                    <form action="{{ route('shop.subscription.store') }}" method="POST">
                        @csrf
                        <div class="relative w-full">
                            <input type="email" name="email"
                                class="!w-full !rounded-md !border !border-white !bg-[#141275] !p-3 !text-white font-sans"
                                aria-label="@lang('shop::app.components.layouts.footer.email')" placeholder="Email..." required>

                            {{-- You may still want to use the error component if you have custom validation feedback --}}
                            <x-shop::form.control-group.error control-name="email" />
                        </div>
                        <button type="submit"
                            class="mt-4 w-full rounded-md bg-gray-200 px-7 py-2.5 text-black font-sans font-medium hover:bg-gray-300 transition-colors duration-200">
                            @lang('shop::app.components.layouts.footer.subscribe')
                        </button>
                    </form>
                @endif
            </div>
        </div>

        <div class="pt-8 text-center border-t border-gray-700">
            <p class="font-sans text-sm text-gray-400">
                @lang('shop::app.components.layouts.footer.footer-text', ['current_year' => date('Y')])
                &nbsp;|&nbsp; Crafted by
                <a href="https://www.craftiveweb.com/" target="_blank" class="text-blue-500 hover:underline">
                    CraftiveWeb
                </a>
            </p>
        </div>
    </div>
</footer>

{!! view_render_event('bagisto.shop.layout.footer.after') !!}
