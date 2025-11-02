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

            <!-- Login Form -->
            <form action="{{ route('login.submit') }}" method="POST" class="w-full max-w-xs" x-show="view === 'login'">
                @csrf
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
                    <input type="email" id="email-address-icon" name="email"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                        placeholder="name@flowbite.com">

                    @error('email')
                        <p class="my-2 text-red-500  text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="mt-5">
                    <label for="password-icon" class="mb-2 text-sm font-medium text-gray-900">Enter Password</label>
                </div>
                <div class="relative">
                    <div class="absolute inset-y-0 start-0 flex items-center ps-3.5 pointer-events-none">
                        <x-icons.lock />
                    </div>
                    <input type="password" id="password-icon" name="password"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5"
                        placeholder="Password">

                    @error('password')
                        <p class="my-2 text-red-500 text-xs">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Signup Redirect -->
                <div class="mt-5 text-center">
                    <p>Don't have an account yet?
                        <a onclick="window.location='{{ route('signuppage') }}'"
                            class="text-blue-600 cursor-pointer">Sign up here</a>
                    </p>
                </div>

                <!-- Login Button -->
                <div class="flex justify-center mt-5">
                    <button type="submit"
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

        </div>

        <!-- Right Section -->
        <div class="bg-blue-500 w-1/2 flex justify-center items-center">
            <h1 class="text-white text-center text-3xl font-bold">

            </h1>
        </div>


    </div>
</body>

</html>