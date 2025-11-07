@php
    $reels = \ACME\Reels\Models\Reel::where('status', 1)->orderBy('sort_order', 'asc')->take(4)->get();
@endphp

{{-- This style block injects the CSS directly into the page --}}
@push('styles')
    <style>
        .reel-h1 {
            font-size: 36px;
            font-weight: 400;
            color: #060c3b;
            font-family: DM Serif Display;
            margin: 0;
            text-align: center;
            margin-top: 38px;
        }

        .reels-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 24px;
            margin: 24px auto;
        }

        .reel-card {
            transition: transform 0.3s ease;
            /* MODIFIED: Scaled down the card by 10% for desktop */

            transform: scale(0.9);
        }

        .reel-card:hover {
            /* MODIFIED: Adjusted hover scale to be relative to the new smaller size */
            transform: scale(0.95);
        }

        .reel-item {
            position: relative;
            width: 100%;
            padding-top: 177.77%;
            /* This maintains the aspect ratio, so we don't touch it */
            border-radius: 8px;
            overflow: hidden;
            cursor: pointer;
            background-color: #f0f0f0;
        }

        .reel-item video {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .reel-title-below {
            margin-top: 8px;
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            text-align: center;
            background-color: #060c3b;
            padding-top: 10px;
            padding-bottom: 10px;
            border-radius: 12px;
        }

        .reel-item-link {
            display: block;
            text-decoration: none;
        }


        /* --- NEW RESPONSIVE STYLES FOR SCROLLING --- */
        @media (max-width: 992px) {

            .reels-grid {
                display: flex;
                overflow-x: auto;
                gap: 16px;
                padding-bottom: 16px;
                scroll-snap-type: x mandatory;
                scrollbar-width: none;
                -ms-overflow-style: none;
            }

            .reels-grid::-webkit-scrollbar {
                display: none;
            }

            .reel-card {
                flex-shrink: 0;
                /* MODIFIED: Reduced width from 60% to 54% (~10% smaller) */
                width: 54%;
                scroll-snap-align: start;
                /* MODIFIED: Reset transform for mobile scrolling view */
                transform: none;
            }

            .reel-card:hover {
                /* MODIFIED: Use scale for hover effect on mobile as well */
                transform: scale(1.05);
            }
        }

        @media (max-width: 576px) {

            .reel-card {
                /* MODIFIED: Reduced width from 75% to 67.5% (~10% smaller) */
                width: 67.5%;
            }
        }
    </style>
@endpush


@if ($reels->isNotEmpty())
    <div class="container mt-20 max-w-6xl mx-auto max-lg:px-8 max-md:mt-8 max-sm:mt-7 max-sm:!px-4">
        <h1 class="reel-h1">
            Watch and Buy
        </h1>
        <div class="reels-grid">
            @foreach ($reels as $reel)
                {{-- MODIFIED: Added a .reel-card wrapper --}}
                <div class="reel-card">
                    {{-- This checks for and applies the product link --}}
                    @if (!empty($reel->product_link))
                        <a href="{{ url($reel->product_link) }}" class="reel-item-link">
                            <div class="reel-item">
                                <video src="{{ Illuminate\Support\Facades\Storage::url($reel->video_path) }}" autoplay
                                    loop muted playsinline preload="metadata"></video>
                            </div>
                        </a>
                    @else
                        <div class="reel-item">
                            <video src="{{ Illuminate\Support\Facades\Storage::url($reel->video_path) }}" autoplay loop
                                muted playsinline preload="metadata"></video>
                        </div>
                    @endif

                    {{-- MODIFIED: The title is now outside the video item --}}
                    <div class="reel-title-below">
                        {{ $reel->title }}
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endif
