<x-navbar :isUserProfile="true">
    <div class="max-w-6xl mt-5 mx-auto px-6">
        @if (session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <span class="font-medium">Please correct the following errors:</span>
                <ul class="mt-1.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Profile Section -->
        <div class="mt-8 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex flex-wrap gap-6 items-center">


                <!-- Profile Picture -->
                <div class="relative shrink-0 h-40 w-40 rounded-full overflow-hidden border-2 border-gray-300 cursor-pointer group">
                   
                    <!-- First letter fallback -->
                    <div
                        class="h-full w-full flex items-center justify-center bg-blue-600 font-semibold text-white text-5xl transition-transform duration-300 group-hover:scale-105">
                        {{ strtoupper(substr(Auth::user()->firstname ?? 'U', 0, 1)) }}
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
                                <h1 class="text-gray-500">Student Number</h1>
                                <h1 class="text-xl">STU2023sample-N</h1>

                            </div>

                        </div>
                    </div>


                    <!-- Edit Information Form -->
                    <div x-show="view === 'EditInformation'" class="flex-1">
                        <form action="{{ route('user.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Avatar Upload -->
                            <div class="mb-4">
                                <!-- <div class="rounded-full w-8 h-8 bg-blue-600 flex justify-center items-center font-semibold text-white">
                                    <div>
                                        {{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}
                                    </div> 
                                </div> -->
                            </div>
                            
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="firstname" class="block mb-2 text-sm font-medium text-gray-900">First
                                        name</label>
                                    <input type="text" id="firstname" name="firstname" value="{{ Auth::user()->firstname }}"
                                        required maxlength="35" pattern="[A-Za-z\s]+"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 @error('firstname') border-red-500 @enderror" />
                                    @error('firstname')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900">Last
                                        name</label>
                                    <input type="text" id="lastname" name="lastname" value="{{ Auth::user()->lastname }}"
                                        required maxlength="35" pattern="[A-Za-z\s]+"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 @error('lastname') border-red-500 @enderror" />
                                    @error('lastname')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="student_id" class="block mb-2 text-sm font-medium text-gray-900">Student
                                        ID</label>
                                    <input type="text" id="student_id" name="student_id" value="{{ Auth::user()->student_id }}"
                                        maxlength="50"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" />
                                </div>

                                <div>
                                    <label for="email"
                                        class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                        required
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5 @error('email') border-red-500 @enderror" />
                                    @error('email')
                                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label for="department" class="block mb-2 text-sm font-medium text-gray-900">Department</label>
                                    <input type="text" id="department" name="department" value="{{ Auth::user()->department }}"
                                        maxlength="255"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" />
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit"
                                    class="text-white bg-gray-800 hover:bg-gray-900 rounded-lg text-sm px-5 py-2.5">Save</button>
                                <button type="button" @click="view = 'information'"
                                    class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Cancel</button>
                                <!-- <button type="button" data-modal-target="password-modal"
                                    data-modal-toggle="password-modal"
                                    class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">
                                    Change Password
                                </button> -->
                            </div>
                            

                            
                        </form>
                    </div>

                    <!-- Edit Information Form -->
                    <div class="flex flex-col gap-2">
                        <button x-show="view === 'information'" @click="view = 'EditInformation'" type="button"
                            class="text-gray-900 flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                            <x-icons.editicon /> Edit
                        </button>


                            <!-- BOTTOM -->
                            <!-- Change Password Button -->
                            <!-- <div class="mt-5">
                                <button type="button" data-modal-target="password-modal"
                                    data-modal-toggle="password-modal"
                                    class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">
                                    Change Password
                                </button>
                            </div> -->

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

            <!-- Statistic Cards -->
            <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
                <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h5 class="mb-2 text-lg">Total Campaigns</h5>
                    <div class="flex gap-4 items-center">
                        <x-icons.foldericon />
                        <h1 class="text-4xl">6</h1>
                    </div>
                </div>

                <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h5 class="mb-2 text-lg">Active Campaigns</h5>
                    <div class="flex gap-4 items-center">
                        <x-icons.arrowtradeicon />
                        <h1 class="text-4xl">6</h1>
                    </div>
                </div>

                <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h5 class="mb-2 text-lg">Total Raised</h5>
                    <div class="flex gap-4 items-center">
                        <x-icons.hearticon />
                        <h1 class="text-4xl">$6,666</h1>
                    </div>
                </div>

                <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h5 class="mb-2 text-lg">Total Backers</h5>
                    <div class="flex gap-4 items-center">
                        <x-icons.singleusericon />
                        <h1 class="text-4xl">6</h1>
                    </div>
                </div>
            </div>

            <!-- Campaign / Completed Section -->
            <div x-data="{ view: 'mycampaign' }" class="mt-10">
                <!-- Button Group -->
                <div class="inline-flex rounded-md shadow-sm" role="group">
                    <button @click="view = 'mycampaign'"
                        :class="view === 'mycampaign' ? 'bg-gray-900 text-white' : 'bg-transparent text-gray-900 hover:bg-gray-900 hover:text-white'"
                        class="px-4 py-2 text-sm font-medium border border-gray-900 rounded-s-lg focus:z-10 focus:ring-2 focus:ring-gray-500">
                        All
                    </button>
                    <button @click="view = 'completed'"
                        :class="view === 'completed' ? 'bg-gray-900 text-white' : 'bg-transparent text-gray-900 hover:bg-gray-900 hover:text-white'"
                        class="px-4 py-2 text-sm font-medium border border-gray-900 rounded-e-lg focus:z-10 focus:ring-2 focus:ring-gray-500">
                        Completed
                    </button>
                </div>

                <!-- All Campaigns -->
                <div x-show="view === 'mycampaign'"
                    class="mt-6 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h1 class="text-2xl">Your Campaigns</h1>
                    <h1 class="text-gray-500 mt-2">Manage and track all your campaigns</h1>

                    <div class="mt-6 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex justify-between text-sm font-medium text-gray-600">
                            <h1>Title</h1>
                            <h1>Raised</h1>
                        </div>

                        <div class="my-3 flex justify-between">
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

                        <div class="w-full bg-gray-200 rounded-full h-2.5">
                            <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                        </div>
                    </div>
                </div>

                <!-- Completed -->
                <div x-show="view === 'completed'"
                    class="mt-6 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <h1 class="text-2xl">Your Backers</h1>
                    <h1 class="text-gray-500 mt-2">People who have supported your campaigns</h1>

                    <div class="mt-6 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex justify-between">
                            <div>
                                <h1 class="text-xl font-medium">Dr. Emily Rodriguez</h1>
                                <p class="text-gray-500">Supported: AI-Powered Campus Navigation App for Visually
                                    Impaired
                                    Students</p>
                                <p class="text-gray-500">10/5/2024</p>
                                <p class="text-gray-500 italic">"This is exactly the kind of innovation we need. Keep up
                                    the
                                    great work!"</p>
                            </div>
                            <h1 class="text-green-600 font-medium">$1,000</h1>
                        </div>
                    </div>
                </div>
            </div>
        </div>
</x-navbar>

<script src="//unpkg.com/alpinejs" defer></script>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                preview.src = e.target.result;
                preview.classList.remove('hidden');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>