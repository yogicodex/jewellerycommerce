<x-admin::layouts>
    {{-- The title is already correct --}}
    <x-slot:title>
        Events & Exhibitions
    </x-slot>

    <div class="flex flex-col gap-4">
        <div class="flex items-center justify-between">
            <p class="text-xl font-bold text-gray-800 dark:text-white">
                Event Banners
            </p>

            <div class="flex items-center gap-x-2.5">
                {{-- The "Add New Banner" button is already correct --}}
                <a href="{{ route('admin.event_banners.create') }}" class="primary-button">
                    Add New Banner
                </a>
            </div>
        </div>

        {{-- ADD THIS DATAGRID COMPONENT TO DISPLAY THE BANNERS --}}
        <x-admin::datagrid :src="route('admin.event_banners.index')">
            {{-- This component will automatically handle the table creation, columns, pagination, and actions. --}}
        </x-admin::datagrid>

    </div>
</x-admin::layouts>
