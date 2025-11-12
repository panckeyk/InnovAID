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
                <div class="flex flex-col gap-2 mt-5">
                    <label for="password-icon" class="text-sm font-medium text-gray-900">
                        Enter Password
                    </label>

                    <input type="password" id="password-icon" name="password" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 @error('password') border-red-500 @enderror" 
                        placeholder="Password" 
                        required 
                        minlength="8"
                        autocomplete="current-password">

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