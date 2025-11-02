<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('Images/LogoInnovAid.png') }}">
    <script src="//unpkg.com/alpinejs" defer></script>


</head>

<body class="">
    <div class="flex w-full h-full">

        <!-- Left Section -->
        <div x-data="{ view: 'login' }" class="bg-white w-1/2 flex justify-center items-center">

            <!-- Login Form -->
            <form class="w-full max-w-xs" x-show="view === 'login'">
                <div class="mb-10">
                    <h1 class="text-3xl font-bold text-center">WELCOME BACK</h1>
                </div>

            
                <!-- Email -->
                <div class="relative">
                    <label for="email-address-icon" class="mb-2 text-sm font-medium text-gray-900">Email Address</label>
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <svg class="w-4 h-4 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 16">
                            <path
                                d="m10.036 8.278 9.258-7.79A1.979 1.979 0 0 0 18 0H2A1.987 1.987 0 0 0 .641.541l9.395 7.737Z" />
                            <path
                                d="M11.241 9.817c-.36.275-.801.425-1.255.427-.428 0-.845-.138-1.187-.395L0 2.6V14a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V2.5l-8.759 7.317Z" />
                        </svg>
                    </div>
                    <input type="text" id="email-address-icon"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                        placeholder="name@flowbite.com">
                </div>

                <!-- Password -->
                <div class="mt-5">
                    <label for="password-icon" class="mb-2 text-sm font-medium text-gray-900">Enter Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <x-icons.lock />
                    </div>
                    <input type="password" id="password-icon"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                        placeholder="Password">
                </div>

                <!-- Signup Redirect -->
                <div class="mt-5 text-center">
                    <p>Don't have an account yet?
                        <a @click="view = 'signup'" class="text-blue-600 cursor-pointer">Sign up here</a>
                    </p>
                </div>

                <!-- Login Button -->
                <div class="flex justify-center mt-5">
                    <button type="button" onclick="window.location='{{ route('user.page') }}'"
                        class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
                        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 14 10">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M1 5h12m0 0L9 1m4 4L9 9" />
                        </svg>
                        <span class="ml-4">Login</span>
                    </button>
                </div>
            </form>

            <!-- Signup Form -->
            <form class="w-full mx-56" x-show="view === 'signup'"
                x-data="{ open: false, selectedRole: 'Who\'s account are you creating this for' }">
                <div class="w-full ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <!-- Header -->
                    <div class="flex items-center gap-5 mb-4">
                        <button @click="view = 'login'"
                            class="text-gray-900 focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm p-2">
                            <x-icons.arrowlefticon />
                        </button>
                        <div>
                            <h1 class="text-xl font-semibold">Create Account</h1>
                            <h1 class="text-gray-500">Join InnovAid and start making a difference</h1>
                        </div>
                    </div>

                    <!-- Account Type -->
                    <div class="mb-6 relative">
                        <label class="block mb-2 text-sm font-medium text-gray-900">I am</label>

                        <!-- Dropdown button -->
                        <button @click="open = !open" type="button" class="w-full bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg 
               focus:ring-blue-500 focus:border-blue-500 flex justify-between items-center 
               px-4 py-2.5">
                            <span x-text="selectedRole"></span>
                            <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <!-- Dropdown menu -->
                        <div x-show="open" @click.outside="open = false" x-transition class="z-10 w-full bg-gray-50 divide-y divide-gray-100 rounded-lg shadow-sm 
               border border-gray-300 absolute mt-1">
                            <ul class="py-2 text-sm text-gray-700">
                                <li>
                                    <a href="#" @click.prevent="selectedRole = 'Student'; open = false"
                                        class="block px-4 py-2 hover:bg-gray-100">
                                        Student
                                    </a>
                                </li>
                                <li>
                                    <a href="#" @click.prevent="selectedRole = 'Donor'; open = false"
                                        class="block px-4 py-2 hover:bg-gray-100">
                                        Donor
                                    </a>
                                </li>
                                <li>
                                    <a href="#" @click.prevent="selectedRole = 'Admin'; open = false"
                                        class="block px-4 py-2 hover:bg-gray-100">
                                        Admin
                                    </a>
                                </li>
                            </ul>
                        </div>

                        <div class="ml-1 mt-2">
                            <template x-if="selectedRole === 'Student'">
                                <h5 class="text-sm text-gray-500">Students can create campaigns but cannot donate</h5>
                            </template>
                            <template x-if="selectedRole === 'Donor'">
                                <h5 class="text-sm text-gray-500">Donors can donate to campaigns but cannot create one
                                </h5>
                            </template>
                            <template x-if="selectedRole === 'Admin'">
                                <h5 class="text-sm text-gray-500">Admins manage both students and donors</h5>
                            </template>
                        </div>
                    </div>

                    <!-- Signup Fields -->
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First
                                name</label>
                            <input type="text" id="first_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="John" required />
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last
                                name</label>
                            <input type="text" id="last_name"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                placeholder="Doe" required />
                        </div>  
                        <template x-if="selectedRole === 'Student'">
                            <div>
                                <label for="student_id" class="block mb-2 text-sm font-medium text-gray-900">Student
                                    ID</label>
                                <input type="text" id="student_id"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="STU2023-N" required />
                            </div>
                        </template>

                        <template x-if="selectedRole === 'Student'">
                            <div>
                                <label for="department"
                                    class="block mb-2 text-sm font-medium text-gray-900">Department</label>
                                <input type="text" id="department"
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                                    placeholder="Department" required />
                            </div>
                        </template>

                    </div>

                    <!-- Email & Password -->
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" id="email"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="sample@student.edu.com" required />
                    </div>
                    <div class="mb-5">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <input type="password" id="password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Enter password" required />
                    </div>
                    <div class="mb-5">
                        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                            Password</label>
                        <input type="password" id="confirm-password"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5"
                            placeholder="Confirm password" required />
                    </div>

                    <!-- Create Account Button -->
                    <div>
                        <button type="button"
                            class="text-white w-full bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Create Account
                        </button>
                    </div>

                    <!-- Already have account -->
                    <div class="border-t mt-4 border-gray-300">
                        <div class="flex justify-between p-2">
                            <h1>Already have an account?</h1>
                            <h1 class="text-blue-600 cursor-pointer" @click="view = 'login'">Sign in</h1>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <!-- Right Section -->
        <div class="bg-blue-500 w-1/2 flex justify-center items-center">
            <h1 class="text-white text-center text-3xl font-bold">

            </h1>
        </div>


    </div>
</body>

</html>