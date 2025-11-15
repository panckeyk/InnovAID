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
            <form action="/login" method="POST" class="w-full max-w-xs" x-show="view === 'login'">
                @csrf
                <div class="mb-10">
                    <h1 class="text-3xl font-bold text-center">Login to your Account</h1>
                </div>

                <!-- Email -->
                <div class="flex flex-col gap-2">
                    <label for="email-address-icon" class="text-sm font-medium text-gray-900">
                        Email Address
                    </label>

                    <input type="email" id="email-address-icon" name="email" 
                        value="{{ old('email') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('email') border-red-500 @enderror" 
                        placeholder="Email@example.com" 
                        required 
                        autocomplete="email"
                        maxlength="255">

                    @error('email')
                        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="flex flex-col gap-2 mt-5" x-data="{ showPassword: false }">
    <label for="password-icon" class="text-sm font-medium text-gray-900">
        Enter Password
    </label>

    <div class="relative">
        <input :type="showPassword ? 'text' : 'password'" 
            id="password-icon" 
            name="password" 
            class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 pr-10 @error('password') border-red-500 @enderror" 
            placeholder="Password" 
            required 
            minlength="8"
            autocomplete="current-password">

        <button type="button" 
            @click="showPassword = !showPassword"
            class="absolute inset-y-0 right-0 flex items-center pr-3 text-gray-500 hover:text-gray-700">
            <!-- Eye Icon (show password) -->
            <svg x-show="!showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            
            <!-- Eye Slash Icon (hide password) -->
            <svg x-show="showPassword" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5 mr-2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 001.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0112 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 01-4.293 5.774M6.228 6.228L3 3m3.228 3.228l3.65 3.65m7.894 7.894L21 21m-3.228-3.228l-3.65-3.65m0 0a3 3 0 10-4.243-4.243m4.242 4.242L9.88 9.88" />
            </svg>
        </button>
    </div>

    @error('password')
        <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
    @enderror
</div>

                <!-- General Error Messages -->
                @if ($errors->any())
                    <div class="mt-4 p-3 text-sm text-red-800 rounded-lg bg-red-50">
                        @foreach ($errors->all() as $error)
                            <p>{{ $error }}</p>
                        @endforeach
                    </div>
                @endif


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
                        class="text-white w-full justify-center bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm p-2.5 text-center inline-flex items-center me-2">
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
            <div >
                <h1 class="text-white font-light text-center text-3xl mb-5">
                    Help fund innovative projects with <div class="mt-3"> <h1 class="text-5xl font-semibold"> InnovAid </h1>   </div>
                </h1>
                <div class="flex items-center justify-center">
                    <img src="{{ asset('Images/s3d.svg') }}" />

                </div>

            </div>




        </div>


    </div>
</body>

</html>