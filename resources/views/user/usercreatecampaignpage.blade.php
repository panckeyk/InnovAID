<x-navbar :isCreatePage="true">

    <div class="mx-65">
        <div>
            <button type="button"
                class="text-gray-900 flex gap-2 text-center justify-center focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                onclick="window.location.href='{{ route('user.campaign') }}'">
                <x-icons.arrowlefticon /> Back to your Campaigns
            </button>
        </div>

        <div class="ml-5">
            <h1 class="text-3xl font-semibold">Create New Campaign</h1>
            <h5 class="mt-2 text-gray-500">Share your innovative project idea and start raising funds</h5>
        </div>

        <!-- Basic Information -->
        <div class="w-full ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div>
                <h1 class="text-xl font-semibold">Basic Information</h1>
                <h1 class="mt-2 text-gray-500">Tell us about your project</h1>
            </div>

            <!-- Project Title -->
            <div class="mb-6 mt-5">
                <label for="default-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Project Title
                </label>
                <input type="text" id="default-input" placeholder="Input Title"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
            </div>

            <!-- Dropdown -->
            <div class="mb-6 mt-5 relative">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Category</label>

                <button id="dropdownDefaultButton" data-dropdown-toggle="dropdown"
                    class="w-full bg-gray-50 border border-gray-300 text-gray-500 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 flex justify-between items-center px-4 py-2.5 dark:bg-gray-700 dark:border-gray-600 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    type="button">
                    Select a category
                    <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>

                <!-- Dropdown menu -->
                <div id="dropdown"
                    class="z-10 hidden w-full bg-gray-50 divide-y divide-gray-100 rounded-lg shadow-sm border border-gray-300 dark:bg-gray-700 dark:border-gray-600 absolute mt-1">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200" aria-labelledby="dropdownDefaultButton">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Technology
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Social Impact
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Research
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Art & Design
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Environment
                            </a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">
                                Health
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- Description -->
            <div class="mb-6 mt-5">
                <label for="message" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                    Description
                </label>
                <textarea id="message" rows="4"
                    class="block p-2.5 w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                    placeholder="Write your thoughts here..."></textarea>
            </div>

        </div>

        <!-- Project Media  -->
        <div class="w-full ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div>
                <h1 class="text-xl font-semibold">Project Media </h1>
                <h1 class="mt-2 text-gray-500">Add images to showcase your project </h1>
            </div>

            <div class="mt-5">
                <div class="flex items-center justify-center w-full">
                    <label for="dropzone-file"
                        class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-gray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center pt-5 pb-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2" />
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click
                                    to upload</span> or drag and drop</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">SVG, PNG, JPG or GIF (MAX. 800x400px)
                            </p>
                        </div>
                        <input id="dropzone-file" type="file" class="hidden" />
                    </label>
                </div>
            </div>
        </div>



        <!-- Submit / Cancel -->
        <div class="flex m-5">
            <div>
                <button type="button" onclick="window.location.href='{{ route('user.campaign') }}'"
                    class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">Cancel
                </button>

            </div>

            <div>
                <button type="button"
                    class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                    Submit </button>

            </div>
        </div>
    </div>

</x-navbar>