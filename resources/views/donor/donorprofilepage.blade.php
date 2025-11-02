<x-navbar :isDonorProfile="true">
    <div class="max-w-6xl mx-auto px-6"> <!-- Centered container with padding -->

        <!-- Profile Section -->
        <div class="mt-8 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex flex-wrap gap-6 items-center">

                <!-- Profile Picture -->
                <div class="flex-shrink-0 h-40 w-40 rounded-full overflow-hidden">
                    <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-1/564573792_122143664882803655_3207956134899640240_n.jpg?stp=c0.51.960.960a_dst-jpg_s200x200_tt6&_nc_cat=108&ccb=1-7&_nc_sid=1d2534&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=kZfLxW4IwXIQ7kNvwGYw6pP&_nc_oc=AdndWVkrw_v0U0SKn58m5NusYdKz11ZnwMuFh9ewSV4EiQIi5XqrwIJwN4zBxyvSibg&_nc_zt=24&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=1C05czytHCQERrXTl72m_w&oh=00_Afic0vEtQX3GOvHrE4596A7sWOHXMAqM8Tpa6G5qJ2ITvQ&oe=690D6184"
                        alt="Profile Picture" class="h-full w-full object-cover object-center">
                </div>

                <!-- Profile Information Section -->
                <div x-data="{ view: 'information' }" class="flex-1 flex justify-between items-start flex-wrap gap-4">

                    <!-- Info Display -->
                    <div x-show="view === 'information'" class="flex-1">
                        <div>
                            <h1 class="text-4xl font-semibold">I love you</h1>
                            <h1 class="text-2xl text-gray-500">admin@university.edu.com</h1>
                        </div>

                        <div class="mt-5">
                            <h1 class="text-gray-500">Member Since</h1>
                            <h1 class="text-xl">October 2023</h1>
                        </div>
                    </div>

                    <!-- Edit Form -->
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

                    <!-- Buttons -->
                    <div class="flex flex-col gap-2">
                        <button x-show="view === 'information'" @click="view = 'EditInformation'" type="button"
                            class="text-gray-900 flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                            <x-icons.editicon /> Edit
                        </button>

                        <div class="flex gap-2" x-show="view === 'EditInformation'">
                            <button @click="view = 'information'" type="button"
                                class="text-white bg-gray-800 hover:bg-gray-900 rounded-lg text-sm px-5 py-2.5">Save</button>
                            <button @click="view = 'information'" type="button"
                                class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Cancel</button>
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
                    <x-icons.calendarsecond/>
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