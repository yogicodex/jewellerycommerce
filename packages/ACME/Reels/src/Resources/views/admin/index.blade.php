<x-admin::layouts>
    <x-slot:title>
        Reels
    </x-slot:title>

    <div class="flex justify-between items-center">
        <p class="text-xl text-gray-800 dark:text-white font-bold">
            Reels
        </p>

        <div class="flex gap-x-2.5 items-center">
            <a href="{{ route('admin.reels.create') }}" class="primary-button">
                Add Reel
            </a>
        </div>
    </div>

    <!-- This is our new manual table -->
    <div class="p-4 mt-5 bg-white dark:bg-gray-900 rounded box-shadow">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead class="text-sm text-gray-600 dark:text-gray-300 bg-gray-50 dark:bg-gray-900 border-b dark:border-gray-800">
                    <tr>
                        <th class="p-3 text-left">ID</th>
                        <th class="p-3 text-left">Title</th>
                        <th class="p-3 text-left">Sort Order</th>
                        <th class="p-3 text-left">Status</th>
                        <th class="p-3 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($reels as $reel)
                        <tr class="border-b dark:border-gray-800">
                            <td class="p-3">{{ $reel->id }}</td>
                            <td class="p-3">{{ $reel->title }}</td>
                            <td class="p-3">{{ $reel->sort_order }}</td>
                            <td class="p-3">{{ $reel->status ? 'Active' : 'Inactive' }}</td>
                            <td class="p-3 flex gap-2">
                                <a href="{{ route('admin.reels.edit', $reel->id) }}" class="text-blue-600 hover:underline">Edit</a>
                                <form action="{{ route('admin.reels.destroy', $reel->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this reel?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:underline">Delete</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-3 text-center">No reels have been added yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-admin::layouts>