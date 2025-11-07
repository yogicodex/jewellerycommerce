@php
    /**
     * This component receives a single '$reel' object and renders it as a card.
     */
@endphp

@pushOnce('styles')
    <style>
    
        .bg-reel {
            background-color: #f5f4f1;
        }
        
        .reel-card {
            transition: transform 0.3s ease;
            margin-top: 60px;
            padding: 10px;
            margin-left: 0;
            margin-right: 0;
        }

        .reel-item {
            position: relative;
            width: 100%;
            /*
                                                                                                                 * START: Aspect Ratio Change
                                                                                                                 * This value was changed from 177.77% (for vertical reels)
                                                                                                                 * to 54.6875% to create a widescreen (1280x700) aspect ratio.
                                                                                                                 * Calculation: (700 / 1280) * 100%
                                                                                                                */
            padding-top: 54.6875%;
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

        .reel-item-link {
            display: block;
            text-decoration: none;
        }

        /* Overlay styling */
        .reel-overlay {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            z-index: 2;
            width: 100%;
            padding: 20px;
            box-sizing: border-box;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            user-select: none;
        }

        .reel-overlay-title {
            color: white;
            font-size: 28px;
            font-weight: normal;
            text-align: center;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.7);
        }

        .shop-now-btn {
            align-items: center;
            appearance: none;
            background-clip: padding-box;
            background-color: initial;
            background-image: none;
            border-style: none;
            box-sizing: border-box;
            color: #fff;
            cursor: pointer;
            display: inline-flex;
            flex-direction: row;
            flex-shrink: 0;
            font-family: Eina01, sans-serif;
            font-size: 16px;
            font-weight: normal;
            justify-content: center;
            line-height: 24px;
            margin-top: 6px;
            min-height: 56px;
            outline: none;
            overflow: visible;
            padding: 16px 26px;
            pointer-events: auto;
            position: relative;
            text-align: center;
            text-decoration: none;
            border-radius: 80px;
            z-index: 0;
            transition: color 100ms ease-out;
        }

        .shop-now-btn::before,
        .shop-now-btn::after {
            border-radius: 80px;
        }

        .shop-now-btn::before {
            background-color: rgba(203, 131, 225, 0.32);
            content: "";
            display: block;
            height: 100%;
            left: 0;
            position: absolute;
            top: 0;
            width: 100%;
            z-index: -2;
        }

        .shop-now-btn::after {
            background-image: linear-gradient(92.83deg, #6F487B 0%, #CB83E1 100%);
            bottom: 4px;
            content: "";
            display: block;
            left: 4px;
            position: absolute;
            right: 4px;
            top: 4px;
            transition: all 100ms ease-out;
            z-index: -1;
        }

        .shop-now-btn:hover:not(:disabled)::after {
            bottom: 0;
            left: 0;
            right: 0;
            top: 0;
            transition-timing-function: ease-in;
        }

        .shop-now-btn:active:not(:disabled) {
            color: #ccc;
        }

        .shop-now-btn:active:not(:disabled)::after {
            background-image: linear-gradient(0deg,
                    rgba(0, 0, 0, 0.2),
                    rgba(0, 0, 0, 0.2)),
                linear-gradient(92.83deg, #6F487B 0%, #CB83E1 100%);
        }

        .shop-now-btn:disabled {
            cursor: default;
            opacity: 0.24;
        }

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .mobile-view {
                padding-left: 5px !important;
                padding-right: 5px !important;
            }

            .reel-card {
                margin-top: 30px;
            }

            .reel-overlay-title {
                font-size: 18px;
            }

            .shop-now-btn {
                font-size: 12px;
                padding: 10px 18px;
                min-height: 40px;
            }
        }
    </style>
@endPushOnce

@if (!empty($reel))
<div class="bg-reel">
    <div class="container max-w-xl py-6 mx-auto my-24 bg-gray-400 mobile-view"
        style="padding-left: 48px; padding-right: 48px;">
        <div class="mx-auto reel-card">
            <a href="{{ url('#') }}" class="reel-item-link"
                aria-label="Link to product for reel titled {{ $reel->title }}">
                <div class="reel-item">
                    <video src="{{ Illuminate\Support\Facades\Storage::url($reel->video_path) }}" autoplay loop muted
                        playsinline preload="metadata"></video>

                    @if (!empty($reel->title))
                        <div class="reel-overlay">
                            <h2 class="reel-overlay-title">{{ $reel->title }}</h2>
                            <span class="shop-now-btn">Shop Now</span>
                        </div>
                    @endif
                </div>
            </a>
        </div>
    </div>
    </div>
@endif
