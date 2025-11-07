<x-admin::layouts>
    <x-slot:title>Add New Video</x-slot:title>

    {{-- We removed all x-data and other Alpine attributes from this section --}}
    <div>
        {{-- We give the form an ID so our script can find it easily --}}
        <x-admin::form :action="route('admin.reels.store')" enctype="multipart/form-data" method="POST" id="videoUploadForm">
            <div class="flex items-center justify-between">
                <p class="text-[20px] text-gray-800 font-bold">Add New Video</p>
                <div class="flex gap-x-[10px] items-center">
                    <a href="{{ route('admin.reels.index') }}" class="transparent-button hover:bg-gray-200">Cancel</a>

                    {{-- We give the button an ID to control its text and state --}}
                    <button type="submit" class="primary-button" id="saveButton">
                        <span>Save Video</span>
                    </button>
                </div>
            </div>



            <div class="p-4 mt-5 bg-white rounded shadow">
                {{-- Form fields are unchanged --}}
                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>Title</x-admin::form.control-group.label>
                    <x-admin::form.control-group.control type="text" name="title" :value="old('title')"
                        placeholder="Video Title" />
                    <x-admin::form.control-group.error control-name="title" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label>Placement Key</x-admin::form.control-group.label>
                    <x-admin::form.control-group.control type="text" name="placement_key" :value="old('placement_key')"
                        placeholder="e.g., homepage-featured" />
                    <x-admin::form.control-group.error control-name="placement_key" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">Video File</x-admin::form.control-group.label>
                    <x-admin::form.control-group.control type="file" name="video" required accept="video/*" />
                    <x-admin::form.control-group.label class="!mt-2 text-gray-500">
                        Recommended dimensions: 1280x700px. Max duration: 55 seconds.
                    </x-admin::form.control-group.label>
                    <x-admin::form.control-group.error control-name="video" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">Sort Order</x-admin::form.control-group.label>
                    <x-admin::form.control-group.control type="number" name="sort_order" required :value="old('sort_order', 0)" />
                    <x-admin::form.control-group.error control-name="sort_order" />
                </x-admin::form.control-group>

                <x-admin::form.control-group>
                    <x-admin::form.control-group.label class="required">Status</x-admin::form.control-group.label>
                    <x-admin::form.control-group.control type="select" name="status" required>
                        <option value="1">Active</option>
                        <option value="0">Inactive</option>
                    </x-admin::form.control-group.control>
                    <x-admin::form.control-group.error control-name="status" />
                </x-admin::form.control-group>
            </div>
        </x-admin::form>
    </div>

    {{-- This is now plain JavaScript, with NO Alpine.js --}}
    <script>
        // Find all the elements we need to work with
        const form = document.getElementById('videoUploadForm');
        const saveButton = document.getElementById('saveButton');
        const progressBarContainer = document.getElementById('progressBarContainer');
        const progressBar = document.getElementById('progressBar');

        // Listen for the form's submit event
        form.addEventListener('submit', function(event) {
            // Prevent the default form submission
            event.preventDefault();

            // Show the progress bar and disable the button
            progressBarContainer.style.display = 'block';
            saveButton.disabled = true;
            saveButton.firstElementChild.textContent = 'Uploading...';

            const formData = new FormData(form);
            const xhr = new XMLHttpRequest();

            // Listen for progress events
            xhr.upload.addEventListener('progress', (e) => {
                if (e.lengthComputable) {
                    const progress = Math.round((e.loaded / e.total) * 100);
                    progressBar.style.width = progress + '%';
                    progressBar.textContent = progress + '%';
                }
            });

            // Handle success
            xhr.onload = () => {
                if (xhr.status >= 200 && xhr.status < 300) {
                    // It worked! Redirect to the index page.
                    window.location.href = "{{ route('admin.reels.index') }}";
                } else {
                    // It failed. Re-enable the form.
                    saveButton.disabled = false;
                    saveButton.firstElementChild.textContent = 'Save Video';
                    progressBarContainer.style.display = 'none';
                    alert(`Upload failed: ${xhr.statusText}`);
                }
            };

            // Handle network errors
            xhr.onerror = () => {
                saveButton.disabled = false;
                saveButton.firstElementChild.textContent = 'Save Video';
                progressBarContainer.style.display = 'none';
                alert('An error occurred during the upload. Please check your network connection.');
            };

            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            xhr.open('POST', form.action);
            xhr.setRequestHeader('X-CSRF-TOKEN', csrfToken);
            xhr.send(formData);
        });
    </script>
</x-admin::layouts>
