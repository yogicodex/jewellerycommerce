<x-admin::layouts>
    {{-- Changed title from Reel to Video --}}
    <x-slot:title>Edit Video</x-slot:title>

    <x-admin::form :action="route('admin.reels.update', $reel->id)" enctype="multipart/form-data" method="PUT">
        <div class="flex items-center justify-between">
            {{-- Changed title from Reel to Video --}}
            <p class="text-[20px] text-gray-800 font-bold">Edit Video</p>
            <div class="flex gap-x-[10px] items-center">
                <a href="{{ route('admin.reels.index') }}" class="transparent-button hover:bg-gray-200">Cancel</a>
                {{-- Changed title from Reel to Video --}}
                <button type="submit" class="primary-button">Save Video</button>
            </div>
        </div>

        <div class="p-4 mt-5 bg-white rounded shadow">
            {{-- Title Field --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>Title</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="text" name="title" required :value="old('title') ?? $reel->title" />
                <x-admin::form.control-group.error control-name="title" />
            </x-admin::form.control-group>

            {{-- Placement Key Field --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>Placement Key</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="text" name="placement_key" :value="old('placement_key') ?? $reel->placement_key"
                    placeholder="e.g., homepage-featured" />
                <x-admin::form.control-group.error control-name="placement_key" />
            </x-admin::form.control-group>

            {{-- Video Field --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>Video File (Leave blank to keep
                    existing)</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="file" name="video" accept="video/*" />

                {{-- START: Added help text --}}
                <x-admin::form.control-group.label class="!mt-2 text-gray-500">
                    Recommended dimensions: 1280x700px. Max duration: 55 seconds.
                </x-admin::form.control-group.label>
                {{-- END: Added help text --}}

                <x-admin::form.control-group.error control-name="video" />

                @if ($reel->video_path)
                    {{-- START: Made video preview larger --}}
                    <video src="{{ Storage::url($reel->video_path) }}" width="320" class="mt-2 rounded"></video>
                    {{-- END: Made video preview larger --}}
                @endif
            </x-admin::form.control-group>

            {{-- Sort Order Field --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label class="required">Sort Order</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="number" name="sort_order" required :value="old('sort_order') ?? $reel->sort_order" />
                <x-admin::form.control-group.error control-name="sort_order" />
            </x-admin::form.control-group>

            {{-- Status Field --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label class="required">Status</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="select" name="status" required :value="old('status') ?? $reel->status">
                    <option value="1" {{ $reel->status ? 'selected' : '' }}>Active</option>
                    <option value="0" {{ !$reel->status ? 'selected' : '' }}>Inactive</option>
                </x-admin::form.control-group.control>
                <x-admin::form.control-group.error control-name="status" />
            </x-admin::form.control-group>
        </div>
    </x-admin::form>
</x-admin::layouts>
