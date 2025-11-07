@php
    $channel = core()->getCurrentChannel();

    /**
     * Fetching Specific Reels by their unique keys.
     * This is the "hard-coded" method, which is very reliable.
     */
    $heroReel = \ACME\Reels\Models\Reel::where('placement_key', 'homepage-after-categories')
        ->where('status', 1)
        ->first();

    $heroReel2 = \ACME\Reels\Models\Reel::where('placement_key', 'homepage-store-video')->where('status', 1)->first();

@endphp

<!-- SEO Meta Content -->
@push('meta')
    <meta name="title" content="{{ $channel->home_seo['meta_title'] ?? '' }}" />
    <meta name="description" content="{{ $channel->home_seo['meta_description'] ?? '' }}" />
    <meta name="keywords" content="{{ $channel->home_seo['meta_keywords'] ?? '' }}" />
@endpush

<x-shop::layouts>
    <!-- Page Title -->
    <x-slot:title>
        {{ $channel->home_seo['meta_title'] ?? '' }}
    </x-slot>

    <!-- Loop over the theme customization sections from the database -->
    @foreach ($customizations as $customization)
        <!-- Render the theme components -->
        @switch ($customization->type)
            @case ($customization::IMAGE_CAROUSEL)
                @php($data = $customization->options ?? [])
                <!-- Image Carousel -->
                <x-shop::carousel :options="$data" aria-label="{{ trans('shop::app.home.index.image-carousel') }}" />

                {{-- Inject the first reel right after the hero carousel --}}
            @break

            @case ($customization::STATIC_CONTENT)
                @php($data = $customization->options ?? [])

                {{-- @dd($customization) --}}



                @if ($heroReel2 && $customization->id === 20)
                    @include('reels::components.single-reel-card', ['reel' => $heroReel2])
                @endif
                @if ($customization->id === 20)
                    {{-- Render the services section here --}}
                    <x-shop::layouts.services />
                @endif


                @if (!empty($data['css']))
                    @push('styles')
                        <style>
                            {{ $data['css'] }}
                        </style>
                    @endpush
                @endif

                {{-- ✅ Check for specific static section title --}}



                @if (!empty($data['html']))
                    {!! $data['html'] !!}
                @endif
            @break

            @case ($customization::CATEGORY_CAROUSEL)
                @php($data = $customization->options ?? [])
                <!-- Categories carousel -->
                <x-shop::categories.carousel :title="$data['title'] ?? ''" :src="route('shop.api.categories.index', $data['filters'] ?? [])" :navigation-link="route('shop.home.index')"
                    aria-label="{{ trans('shop::app.home.index.categories-carousel') }}" />

                {{-- Inject the second reel right after the category carousel --}}
                @if ($heroReel)
                    @include('reels::components.single-reel-card', ['reel' => $heroReel])
                @endif
            @break

            @case ($customization::PRODUCT_CAROUSEL)
                @php($data = $customization->options ?? [])
                <!-- Product Carousel -->
                <x-shop::products.carousel :title="$data['title'] ?? ''" :src="route('shop.api.products.index', $data['filters'] ?? [])" :navigation-link="route('shop.search.index', $data['filters'] ?? [])" :short-text="$customization->short_text ?? ''"
                    aria-label="{{ trans('shop::app.home.index.product-carousel') }}" />
            @break
        @endswitch
    @endforeach
</x-shop::layouts>
