<x-navbar :isUserProfile="true">
    <div class="mx-65">

        <!-- Profile Section -->
        <div class="w-full ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="gap-5 m-auto flex">
                <!-- Profile Picture -->
                <div class="flex shrink-0 h-50 w-50 rounded-full overflow-hidden">
                    <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-1/564573792_122143664882803655_3207956134899640240_n.jpg?stp=c0.51.960.960a_dst-jpg_s200x200_tt6&_nc_cat=108&ccb=1-7&_nc_sid=1d2534&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=kZfLxW4IwXIQ7kNvwGYw6pP&_nc_oc=AdndWVkrw_v0U0SKn58m5NusYdKz11ZnwMuFh9ewSV4EiQIi5XqrwIJwN4zBxyvSibg&_nc_zt=24&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=EVeFU3sAZf9CWOtV4soXqQ&oh=00_AfdwkYPylTSb_J8Z1EhWfkH4XrwXrpcMBJHheVPxcYH2hg&oe=690C4844"
                        alt="Profile Picture" class="h-full w-full object-cover object-center">
                </div>

                <!-- Profile Information Section -->
                <div x-data="{ view: 'information' }" class="w-full ml-5 flex justify-between">

                    <!-- Information Display -->
                    <div x-show="view === 'information'" class="w-full">
                        <div>
                            <h1 class="text-4xl font-semibold">I love you</h1>
                            <h1 class="text-2xl text-gray-500">sample@university.edu.com</h1>
                        </div>

                        <div class="w-full mt-5">
                            <div class="flex">
                                <div class="w-1/2">
                                    <div>
                                        <h1 class="text-gray-500">Student Number</h1>
                                        <h1 class="text-xl">STU2023sample-N</h1>
                                    </div>

                                    <div>
                                        <h1 class="text-gray-500 mt-5">Member Since</h1>
                                        <h1 class="text-xl">October 2023</h1>
                                    </div>
                                </div>

                                <div class="w-1/2">
                                    <h1 class="text-gray-500">Department</h1>
                                    <h1 class="text-xl">Department of Health</h1>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Edit Information Form -->
                    <div x-show="view === 'EditInformation'" class="w-200">
                        <form>
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="first_name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">First
                                        name</label>
                                    <input type="text" id="first_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                        placeholder="John" required />
                                </div>

                                <div>
                                    <label for="last_name"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Last
                                        name</label>
                                    <input type="text" id="last_name"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                        placeholder="Doe" required />
                                </div>

                                <div>
                                    <label for="student_id"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Student
                                        ID</label>
                                    <input type="text" id="student_id"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                        placeholder="STU2023-N" required />
                                </div>

                                <div>
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Email</label>
                                    <input type="tel" id="email"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                        placeholder="sample@student.edu.com" required />
                                </div>

                                <div>
                                    <label for="department"
                                        class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Department</label>
                                    <input type="tel" id="department"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white"
                                        placeholder="Department" required />
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Edit / Save Buttons -->
                    <div class="mt-5">
                        <!-- Edit Button -->
                        <button x-show="view === 'information'" @click="view = 'EditInformation'" type="button"
                            class="text-gray-900 flex items-center gap-5 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600">
                            <x-icons.editicon /> Edit
                        </button>

                        <div class="flex">
                            <!-- Save Button -->
                            <button x-show="view === 'EditInformation'" @click="view = 'information'" type="button"
                                class="text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">Save</button>

                            <!-- Cancel Button -->
                            <button x-show="view === 'EditInformation'" @click="view = 'information'" type="button"
                                class="text-gray-900 bg-white border border-gray-300 focus:outline-none hover:bg-gray-100 focus:ring-4 focus:ring-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700">
                                Cancel
                            </button>
                        </div>
                    </div>

                </div>

            </div>
        </div>

        <!-- Statistic Cards -->
        <div class="flex justify-between ml-5">
            <div class="w-80 ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Total Campaigns</h5>
                <div class="flex gap-5 items-center">
                    <x-icons.foldericon />
                    <h1 class="text-4xl">6</h1>
                </div>
            </div>

            <div class="w-80 ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Active Campaigns</h5>
                <div class="flex gap-5 items-center">
                    <x-icons.arrowtradeicon />
                    <h1 class="text-4xl">6</h1>
                </div>
            </div>

            <div class="w-80 ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Total Raised</h5>
                <div class="flex gap-5 items-center">
                    <x-icons.hearticon />
                    <h1 class="text-4xl">$6,666</h1>
                </div>
            </div>

            <div class="w-80 ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Total Backers</h5>
                <div class="flex gap-5 items-center">
                    <x-icons.singleusericon />
                    <h1 class="text-4xl">6</h1>
                </div>
            </div>
        </div>

        <!-- Button Group + Sections -->
        <div x-data="{ view: 'mycampaign' }" class="ml-5 mt-5">
            <!-- Button Group -->
            <div class="inline-flex rounded-md shadow-xs" role="group">
                <button @click="view = 'mycampaign'" :class="view === 'mycampaign' 
                        ? 'bg-gray-900 text-white' 
                        : 'bg-transparent text-gray-900 hover:bg-gray-900 hover:text-white'"
                    class="px-4 py-2 text-sm font-medium border border-gray-900 rounded-s-lg focus:z-10 focus:ring-2 focus:ring-gray-500">
                    All
                </button>

                <button @click="view = 'completed'" :class="view === 'completed' 
                        ? 'bg-gray-900 text-white' 
                        : 'bg-transparent text-gray-900 hover:bg-gray-900 hover:text-white'"
                    class="px-4 py-2 text-sm font-medium border border-gray-900 border-l-0 -ml-px rounded-e-lg focus:z-10 focus:ring-2 focus:ring-gray-500">
                    Completed
                </button>
            </div>

            <!-- My Campaigns -->
            <div x-show="view === 'mycampaign'"
                class="w-full mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div>
                    <h1 class="text-2xl">Your Campaigns</h1>
                    <h1 class="text-gray-500 mt-2">Manage and track all your campaigns</h1>
                </div>

                <!-- Campaign Tab -->
                <div class="w-full mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex justify-between">
                        <h1>Title</h1>
                        <h1>Raised</h1>
                    </div>

                    <div class="mb-2 mt-2 flex justify-between">
                        <div>
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border border-blue-400">Status</span>
                            <span
                                class="bg-gray-100 text-gray-800 text-xs font-medium me-2 px-2.5 py-0.5 rounded-sm border border-gray-500">Category</span>
                        </div>

                        <div class="flex gap-2 text-green-700">
                            <h1>$3,850</h1>
                            <h1>/</h1>
                            <h1>$5,000</h1>
                        </div>
                    </div>

                    <div>
                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Completed -->
            <div x-show="view === 'completed'"
                class="w-full mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <div>
                    <h1 class="text-2xl">Your Backers</h1>
                    <h1 class="text-gray-500 mt-2">People who have supported your campaigns</h1>
                </div>

                <!-- Backer Tab -->
                <div class="w-full mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <div class="flex justify-between">
                        <div>
                            <h1 class="text-xl">Dr. Emily Rodriguez</h1>
                            <h1 class="text-gray-500">Supported: AI-Powered Campus Navigation App for Visually Impaired
                                Students</h1>
                            <h1 class="text-gray-500">10/5/2024</h1>
                            <h1 class="text-gray-500 italic">"This is exactly the kind of innovation we need. Keep up
                                the great work!"</h1>
                        </div>
                        <div>
                            <h1 class="text-green-600">$1,000</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-navbar>

<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>