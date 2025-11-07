<x-admin::layouts>
    <x-slot:title>Add New Event Banner</x-slot>

    <x-admin::form :action="route('admin.event_banners.store')" method="POST" enctype="multipart/form-data">
        <div class="p-4">
            {{-- TITLE --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>Title (Optional)</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="text" name="title" placeholder="Event Title" />
                <x-admin::form.control-group.error control-name="title" /> {{-- <-- Add this --}}
            </x-admin::form.control-group>

            {{-- IMAGE --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label class="required">Banner Image</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="image" name="image" :is-required="true" />
                <x-admin::form.control-group.error control-name="image" /> {{-- <-- This was already here --}}
            </x-admin::form.control-group>

            {{-- LINK --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>Link (Optional)</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="text" name="link" placeholder="https://example.com" />
                <x-admin::form.control-group.error control-name="link" /> {{-- <-- Add this --}}
            </x-admin::form.control-group>

            {{-- STATUS --}}
            <x-admin::form.control-group>
                <x-admin::form.control-group.label>Status</x-admin::form.control-group.label>
                <x-admin::form.control-group.control type="select" name="status">
                    <option value="1">Enabled</option>
                    <option value="0">Disabled</option>
                </x-admin::form.control-group.control>
                <x-admin::form.control-group.error control-name="status" /> {{-- <-- Add this --}}
            </x-admin::form.control-group>
        </div>

        <div class="flex justify-end gap-x-2.5 p-4">
            <button type="submit" class="primary-button">Save Banner</button>
        </div>
    </x-admin::form>
</x-admin::layouts>
