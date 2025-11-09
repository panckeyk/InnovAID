<x-navbar :isCreatePage="true">

    {{-- Main Form element starts here --}}
    <form method="POST" action="{{ isset($campaign) ? route('campaigns.update', $campaign) : route('campaigns.store') }}"
        enctype="multipart/form-data">
        @csrf
        @if (isset($campaign))
            @method('PUT')
        @endif

        <div class="mx-65 mt-25">
            <div>
                {{-- Back button --}}
                <button type="button"
                    class="text-gray-900 flex gap-2 text-center justify-center focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                    onclick="window.location.href='{{ route('user.campaign') }}'">
                    <x-icons.arrowlefticon /> Back to your Campaigns
                </button>
            </div>

            <div class="ml-5">
                <h1 class="text-3xl font-semibold">{{ isset($campaign) ? 'Edit Campaign' : 'Create New Campaign' }}</h1>
                <h5 class="mt-2 text-gray-500">
                    {{ isset($campaign) ? 'Update your campaign details' : 'Share your innovative project idea and start raising funds' }}
                </h5>
            </div>

            {{-- Validation Error Display --}}
            @if ($errors->any())
                <div class="ml-5 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400"
                    role="alert">
                    <span class="font-medium">Please correct the following errors:</span>
                    <ul class="mt-1.5 list-disc list-inside">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="w-full ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div>
                    <h1 class="text-xl font-semibold">Basic Information</h1>
                    <h1 class="mt-2 text-gray-500">Tell us about your project</h1>
                </div>

                <div class="mb-6 mt-5">
                    <label for="title" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Project Title
                    </label>
                    <input type="text" id="title" name="title" placeholder="Input Title"
                        value="{{ old('title', $campaign->title ?? '') }}" required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('title')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 mt-5">
                    <label for="category"
                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>
                    <select id="category" name="category" required
                        class="w-full bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block px-4 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option value="" disabled
                            {{ old('category', $campaign->category ?? '') == '' ? 'selected' : '' }}>Select a category
                        </option>
                        @foreach (['Technology', 'Social Impact', 'Research', 'Art & Design', 'Environment', 'Health'] as $cat)
                            <option value="{{ $cat }}"
                                {{ old('category', $campaign->category ?? '') == $cat ? 'selected' : '' }}>
                                {{ $cat }}
                            </option>
                        @endforeach
                    </select>
                    @error('category')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 mt-5">
                    <label for="goal_amount" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Funding Goal ($)
                    </label>
                    <input type="number" id="goal_amount" name="goal_amount" placeholder="e.g., 500.00"
                        value="{{ old('goal_amount', $campaign->goal_amount ?? '') }}" required min="100"
                        step="0.01"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('goal_amount')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 mt-5">
                    <label for="deadline" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Campaign Deadline
                    </label>
                    <input type="date" id="deadline" name="deadline"
                        value="{{ old('deadline', isset($campaign) ? \Carbon\Carbon::parse($campaign->deadline)->format('Y-m-d') : '') }}"
                        required
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @error('deadline')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6 mt-5">
                    <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                        Description
                    </label>
                    <textarea id="description" name="description" rows="4" required
                        class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        placeholder="Write your thoughts here...">{{ old('description', $campaign->description ?? '') }}</textarea>
                    @error('description')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>

            </div>

            <div class="w-full ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div>
                    <h1 class="text-xl font-semibold">Project Media</h1>
                    <h1 class="mt-2 text-gray-500">Add an image to showcase your project</h1>
                </div>

                {{-- Show current image if editing --}}
                @if (isset($campaign) && $campaign->image)
                    <div class="mt-5 mb-3">
                        <p class="text-sm text-gray-700 mb-2">Current Image:</p>
                        <img src="{{ asset('storage/' . $campaign->image) }}" alt="Campaign Image"
                            class="rounded-lg max-w-xs">
                        <p class="text-xs text-gray-500 mt-2">Upload a new image to replace this one</p>
                    </div>
                @endif

                <div class="mt-5">
                    <div class="flex items-center justify-center w-full">
                        <label for="image_upload"
                            class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400">
                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">JPG, PNG, GIF (Max 5MB)</p>
                            </div>
                            <input id="image_upload" type="file" name="image"
                                {{ isset($campaign) ? '' : 'required' }} class="hidden" accept="image/*" />
                        </label>
                    </div>
                    @error('image')
                        <p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <div class="flex gap-2 m-5">
                <button type="button" onclick="window.location.href='{{ route('user.campaign') }}'"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                    Cancel
                </button>

                <button type="submit"
                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    {{ isset($campaign) ? 'Update Campaign' : 'Submit for Approval' }}
                </button>

                {{-- Delete Button (Only show when editing) --}}
                @if (isset($campaign))
                    <button type="button" onclick="confirmDelete('{{ $campaign->id }}')"
                        class="text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                        Delete Campaign
                    </button>
                @endif
            </div>
        </div>
    </form>
    {{-- Main Form element ends here --}}

    {{-- Delete Form (Separate, Outside Main Form) --}}
    @if (isset($campaign))
        <form id="delete-form-{{ $campaign->id }}" action="{{ route('campaigns.destroy', $campaign) }}"
            method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    @endif

    {{-- Delete Confirmation Script --}}
    @if (isset($campaign))
        <script>
            function confirmDelete(campaignId) {
                if (confirm('Are you sure you want to delete this campaign? This action cannot be undone.')) {
                    document.getElementById('delete-form-' + campaignId).submit();
                }
            }
        </script>
    @endif

</x-navbar>