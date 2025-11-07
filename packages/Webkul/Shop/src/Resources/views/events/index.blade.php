<x-shop::layouts>
    <x-slot:title>
        Events & Exhibitions
    </x-slot>

    <div class="container px-4 py-8 mx-auto sm:px-6 lg:py-12 lg:px-8">

        <h1 class="mb-12 text-[16px] font-normal text-center text-gray-800 md:text-[26px]">
            Events & Exhibitions
        </h1>

        @foreach ($banners as $banner)
            {{-- 
                BANNER CONTAINER
                - We use Blade's `$loop->even` to check if this is the 2nd, 4th, 6th, etc., item.
                - The default `flex-col` ensures that on mobile, the image appears above the text.
                - On medium screens (`md:`), we switch to a row layout.
                - If it's EVEN, `md:flex-row-reverse` puts the image on the left.
                - If it's ODD, `md:flex-row` puts the text on the left.
            --}}
            <div
                class="flex flex-col mb-12 overflow-hidden bg-white rounded-lg shadow-lg @if ($loop->even) md:flex-row-reverse @else md:flex-row @endif">

                {{-- RIGHT COLUMN (Image) - MOVED FIRST FOR MOBILE VIEW --}}
                <div class="md:w-2/3">
                    <img class="object-cover w-full h-full"
                        src="{{ \Illuminate\Support\Facades\Storage::url($banner->path) }}"
                        alt="{{ $banner->title ?? 'Event Banner' }}">
                </div>

                {{-- LEFT COLUMN (Text Content) - MOVED SECOND FOR MOBILE VIEW --}}
                <div class="flex flex-col items-center justify-center p-8 text-center md:w-1/3">
                    @if ($banner->title)
                        <h2 class="mb-6 font-serif text-2xl tracking-wide text-gray-700 md:text-3xl">
                            {!! nl2br(e($banner->title)) !!}
                        </h2>
                    @endif

                    @if ($banner->link)
                        <a href="{{ $banner->link }}" target="_blank" rel="noopener noreferrer"
                            class="px-8 py-3 mt-4 font-semibold tracking-widest text-gray-700 uppercase transition-colors duration-300 border border-gray-400 rounded-sm hover:bg-gray-800 hover:text-white">
                            Book Now
                        </a>
                    @endif
                </div>

            </div>
        @endforeach

        {{-- Message for when no banners exist --}}
        @if ($banners->isEmpty())
            <p class="mt-8 text-center text-gray-500">There are currently no events to display. Please check back later.
            </p>
        @endif
    </div>
</x-shop::layouts>