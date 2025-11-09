<x-navbar :isDonorProfile="true">
    <div class="max-w-6xl mt-30 mx-auto px-6"> <!-- Centered container with padding -->

        <!-- Profile Section -->
        <div class="mt-8 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex flex-wrap gap-6 items-center">

                <!-- Profile Picture -->
                <div class="relative flex-shrink-0 h-40 w-40 rounded-full overflow-hidden border cursor-pointer group">
                    @if(Auth::user()->photo)
                        <!-- Uploaded profile picture -->
                        <img src="{{ asset('storage/' . Auth::user()->photo) }}" alt="Profile Picture"
                            class="h-full w-full object-cover object-center transition-transform duration-300 group-hover:scale-105">
                    @else
                        <!-- First letter fallback -->
                        <div
                            class="h-full w-full flex items-center justify-center bg-green-200 font-semibold text-green-800 text-4xl transition-transform duration-300 group-hover:scale-105">
                            {{ strtoupper(substr(Auth::user()->firstname ?? '', 0, 1)) }}
                        </div>
                    @endif

                    <!-- Hover Overlay -->
                    <div
                        class="absolute inset-0 bg-black bg-opacity-10 opacity-0 group-hover:opacity-20 flex items-center justify-center text-white font-semibold text-sm transition-opacity duration-300">
                        Change
                    </div>


                </div>

                <!-- Profile Information -->
                <div x-data="{ view: 'information' }" class="flex-1 flex justify-between items-start flex-wrap gap-4">

                    <!-- Information Display -->
                    <div x-show="view === 'information'" class="flex-1">
                        <h1 class="text-4xl font-semibold">{{ Auth::user()->firstname}} {{ Auth::user()->lastname}}</h1>
                        <h1 class="text-2xl text-gray-500">{{ Auth::user()->email }}</h1>

                        <div class="mt-5 grid md:grid-cols-2 gap-4">
                            <div>
                                <h1 class="text-gray-500">Member Since </h1>
                                <h1 class="text-xl">October 25, 2025</h1>

                            </div>

                        </div>
                    </div>


                    <!-- Edit Information Form -->
                    <div x-show="view === 'EditInformation'" class="flex-1">
                        <form>
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First
                                        name</label>
                                    <input type="text" id="first_name" placeholder="John"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" />
                                </div>

                                <div>
                                    <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last
                                        name</label>
                                    <input type="text" id="last_name" placeholder="Doe"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" />
                                </div>

                                <div>
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                    <input type="email" id="email" placeholder="sample@student.edu.com"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" />
                                </div>

                            </div>
                        </form>
                    </div>

                    <!-- Edit Information Form -->
                    <div class="flex flex-col gap-2">
                        <button x-show="view === 'information'" @click="view = 'EditInformation'" type="button"
                            class="text-gray-900 flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                            <x-icons.editicon /> Edit
                        </button>

                        <div class="flex flex-col justify-between h-full gap-2" x-show="view === 'EditInformation'">

                            <!-- TOP -->
                            <div>
                                <button @click="view = 'information'" type="button"
                                    class="text-white bg-gray-800 hover:bg-gray-900 rounded-lg text-sm px-5 py-2.5">
                                    Save
                                </button>
                                <button @click="view = 'information'" type="button"
                                    class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">
                                    Cancel
                                </button>
                            </div>

                            <!-- BOTTOM -->
                            <!-- Change Password Button -->
                            <div class="mt-5">
                                <button type="button" data-modal-target="password-modal"
                                    data-modal-toggle="password-modal"
                                    class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">
                                    Change Password
                                </button>
                            </div>

                            <!-- Change Password Modal -->
                            <div id="password-modal" tabindex="-1" aria-hidden="true"
                                class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

                                <div class="relative p-4 w-full max-w-md max-h-full">
                                    <div class="relative bg-white rounded-lg shadow-sm dark:bg-gray-700">

                                        <!-- Header -->
                                        <div
                                            class="flex justify-between p-4 gap-10 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                                            <div>
                                                <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Change
                                                    Password</h3>
                                                <h2 class="text-sm text-gray-600 dark:text-gray-300">
                                                    Make sure your new password is strong and secure.
                                                </h2>
                                            </div>
                                            <div>
                                                <button type="button" data-modal-toggle="password-modal"
                                                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                                                    <svg class="w-3 h-3" aria-hidden="true" fill="none"
                                                        viewBox="0 0 14 14">
                                                        <path stroke="currentColor" stroke-linecap="round"
                                                            stroke-linejoin="round" stroke-width="2"
                                                            d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6" />
                                                    </svg>
                                                </button>
                                            </div>
                                        </div>

                                        <!-- Body -->
                                        <form class="p-5">
                                            <div class="space-y-4">
                                                <!-- Old Password -->
                                                <div>
                                                    <label for="old_password"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        Old Password
                                                    </label>
                                                    <input type="password" id="old_password"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required />
                                                </div>

                                                <!-- New Password -->
                                                <div>
                                                    <label for="new_password"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        New Password
                                                    </label>
                                                    <input type="password" id="new_password"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required />
                                                </div>

                                                <!-- Re-enter New Password -->
                                                <div>
                                                    <label for="confirm_password"
                                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                                        Re-enter New Password
                                                    </label>
                                                    <input type="password" id="confirm_password"
                                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                                                        required />
                                                </div>

                                                <!-- Buttons -->
                                                <div class="flex justify-end mt-5 gap-2">
                                                    <button type="button" data-modal-toggle="password-modal"
                                                        class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                                        Cancel
                                                    </button>

                                                    <button type="submit"
                                                        class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                                        Save Password
                                                    </button>
                                                </div>
                                            </div>
                                        </form>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>



            </div>
        </div>

        <!-- Cards Section -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg"> Total Donated </h5>
                <div class="flex gap-4 items-center">
                    <x-icons.hearticon />
                    <h1 class="text-4xl">6</h1>
                </div>
            </div>

            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Campaigns Supported </h5>
                <div class="flex gap-4 items-center">
                    <x-icons.foldericon />
                    <h1 class="text-4xl">6</h1>
                </div>
            </div>

            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Total Donations</h5>
                <div class="flex gap-4 items-center">
                    <x-icons.arrowtradeicon />
                    <h1 class="text-4xl">$6,666</h1>
                </div>
            </div>

            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg"> Member Since </h5>
                <div class="flex gap-4 items-center">
                    <x-icons.calendarsecond />
                    <h1 class="text-4xl">6</h1>
                </div>
            </div>
        </div>

        <div class="mt-5">
            <h1 class="text-2xl"> Donation History </h1>
        </div>

        <div class="mt-5 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div>
                <h1 class="font-semibold"> Donation History </h1>
                <h1 class="text-gray-500"> All your contributions to campaigns </h1>
            </div>

            <div class="mt-5 p-6 bg-white border border-gray-200 rounded-lg shadow-sm flex justify-between">
                <!-- Campaign tab -->
                <div>
                    <h1> Title </h1>
                    <h1 class="text-gray-500"> Date and Time </h1>
                    <h1 class="text-gray-500"> Donor Comment </h1>
                </div>

                <div>
                    <h1 class="text-green-600"> $500</h1>
                </div>
            </div>
        </div>

    </div>
</x-navbar>

<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>