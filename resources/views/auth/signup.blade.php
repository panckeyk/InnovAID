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
        <div class="bg-white w-1/2 flex justify-center items-center">

            <!-- Signup Form -->
            <form method="POST" action="{{ route('signup.submit') }}" class="w-full mx-56" x-data="{ view: 'signup', open: false, selectedRole: 'Who\'s account are you creating this for' }">
                @csrf
                <div class="w-full ml-5 mt-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <!-- Header -->
                    <div class="flex items-center gap-5 mb-4">
                        <button type="button" onclick="window.location='{{ route('login') }}'"
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

                        <button @click="open = !open" type="button"
                            class="w-full bg-gray-50 border border-gray-300 text-gray-700 text-sm rounded-lg 
                                focus:ring-blue-500 focus:border-blue-500 flex justify-between items-center 
                                px-4 py-2.5">
                            <span x-text="selectedRole"></span>
                            <svg class="w-2.5 h-2.5 ms-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                                fill="none" viewBox="0 0 10 6">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                    stroke-width="2" d="m1 1 4 4 4-4" />
                            </svg>
                        </button>

                        <div x-show="open" @click.outside="open = false" x-transition
                            class="z-10 w-full bg-gray-50 divide-y divide-gray-100 rounded-lg shadow-sm 
                                border border-gray-300 absolute mt-1">
                            <ul class="py-2 text-sm text-gray-700">
                                <li><a href="#" @click.prevent="selectedRole = 'Student'; open = false"
                                        class="block px-4 py-2 hover:bg-gray-100">Student</a></li>
                                <li><a href="#" @click.prevent="selectedRole = 'Donor'; open = false"
                                        class="block px-4 py-2 hover:bg-gray-100">Donor</a></li>
                                <!-- <li><a href="#" @click.prevent="selectedRole = 'Admin'; open = false"
                    class="block px-4 py-2 hover:bg-gray-100">Admin</a></li> -->
                            </ul>
                        </div>

                        <input type="hidden" name="role" :value="selectedRole" required>

                        <div class="ml-1 mt-2">
                            <template x-if="selectedRole === 'Student'">
                                <h5 class="text-sm text-gray-500">Students can create campaigns but cannot donate</h5>
                            </template>
                            <template x-if="selectedRole === 'Donor'">
                                <h5 class="text-sm text-gray-500">Donors can donate to campaigns but cannot create one
                                </h5>
                            </template>
                            <template x-if="selectedRole === 'Who\'s account are you creating this for'">
                                <h5 class="text-sm text-red-500">Please select an account type</h5>
                            </template>
                        </div>
                        @error('role')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Signup Fields -->
                    <div class="grid gap-6 mb-6 md:grid-cols-2">
                        <div>
                            <label for="first_name" class="block mb-2 text-sm font-medium text-gray-900">First
                                name</label>
                            <input type="text" id="first_name" name="firstname" value="{{ old('firstname') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('firstname') border-red-500 @enderror"
                                placeholder="John" required maxlength="35" pattern="[A-Za-z\s]+"
                                title="First name should only contain letters and spaces" />
                            @error('firstname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                        <div>
                            <label for="last_name" class="block mb-2 text-sm font-medium text-gray-900">Last
                                name</label>
                            <input type="text" id="last_name" name="lastname" value="{{ old('lastname') }}"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('lastname') border-red-500 @enderror"
                                placeholder="Doe" required maxlength="35" pattern="[A-Za-z\s]+"
                                title="Last name should only contain letters and spaces" />
                            @error('lastname')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Email & Password -->
                    <div class="mb-5">
                        <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email') }}"
                            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') border-red-500 @enderror"
                            placeholder="sample@student.edu.com" required maxlength="255" autocomplete="email" />
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="mb-5" x-data="{ showPassword: false }">
                        <label for="password" class="block mb-2 text-sm font-medium text-gray-900">Password</label>
                        <div class="relative">
                            <input :type="showPassword ? 'text' : 'password'" id="password" name="password"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 @error('password') border-red-500 @enderror"
                                placeholder="Enter password" required minlength="8" autocomplete="new-password" />

                            <button type="button" @click="showPassword = !showPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                <!-- Eye Icon (show password) -->
                                <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <!-- Eye Slash Icon (hide password) -->
                                <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                        <p class="mt-1 text-xs text-gray-500">Password must be at least 8 characters long</p>
                    </div>

                    <div class="mb-5" x-data="{ showConfirmPassword: false }">
                        <label for="confirm-password" class="block mb-2 text-sm font-medium text-gray-900">Confirm
                            Password</label>
                        <div class="relative">
                            <input :type="showConfirmPassword ? 'text' : 'password'" id="confirm-password"
                                name="password_confirmation"
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10"
                                placeholder="Confirm password" required minlength="8" autocomplete="new-password" />

                            <button type="button" @click="showConfirmPassword = !showConfirmPassword"
                                class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
                                <!-- Eye Icon (show password) -->
                                <svg x-show="!showConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                <!-- Eye Slash Icon (hide password) -->
                                <svg x-show="showConfirmPassword" xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>
                    </div>

                    <!-- Create Account Button -->
                    <div>
                        <button type="submit"
                            class="text-white w-full bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Create Account
                        </button>

                    </div>

                    <!-- Already have account -->
                    <div class="border-t mt-4 border-gray-300">
                        <div class="flex justify-between p-2">
                            <h1>Already have an account?</h1>
                            <h1 class="text-blue-600 cursor-pointer" @click="window.location='{{ route('login') }}'">
                                Sign in</h1>
                        </div>
                    </div>
                </div>


            </form>
        </div>

        <!-- Right Section -->
        <div class="bg-blue-500 w-1/2 flex justify-center items-center">
            <div>
                <h1 class="text-white font-light text-center text-3xl mb-5">
                    Help fund innovative projects with <div class="mt-3">
                        <h1 class="text-5xl font-semibold"> InnovAid </h1>
                    </div>
                </h1>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('Images/s3d.svg') }}" />

                </div>

            </div>




        </div>

    </div>
</body>

</html>
