@php
    use Illuminate\Support\Facades\Auth;
    $role = Auth::check() ? Auth::user()->role : null;
@endphp

@props([
    'isAdmin' => false,
    'isAdminDashboard' => false,
    'isDonor' => false,
    'isUserCampaign' => false,
    'isCampaignPage' => false,
    'isCreatePage' => false,
    'isUserProfile' => false,
    'isAdminProfile' => false,
    'isDonorProfile' => false,
    'isUserPage' => false,
    'role' => null
])


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('Images/LogoInnovAid.png') }}">
</head>

<body>
    <header>
        <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-xl fixed top-0 z-50 w-full">
            <div class="max-w-7xl flex items-center justify-between mx-auto p-4">

                <!-- 🔹 Left Section: Logo + Nav Links -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a class="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="{{ asset('Images/LogoInnovAid.png') }}" class="h-8" alt="Flowbite Logo" />
                        <span
                            class="self-center text-2xl text-[#1848a0] font-semibold whitespace-nowrap dark:text-white">
                            Innovaid
                        </span>
                    </a>

                    <!-- Nav Links -->
                    @if ($isAdmin or $isAdminDashboard or $role === 'admin')
                                    <!-- 🔸 Admin Navigation -->
                                    <ul class="flex space-x-8 font-medium p-0 border-0 bg-transparent">
                                        <li>
                                            <a href="{{ route('approved.index') }}" class="py-2 px-3 rounded-sm
                                                                                                {{ request()->routeIs('admin.page')
                        ? 'text-blue-700 dark:text-blue-500'
                        : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}"
                                                aria-current="page">
                                                Discover
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{ route('admin.admindashboard') }}" class="py-2 px-3 rounded-sm
                                                                                                {{ request()->routeIs('admin.admindashboard')
                        ? 'text-blue-700 dark:text-blue-500'
                        : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">
                                                Admin Dashboard
                                            </a>
                                        </li>

                                    </ul>
                    @else
                        <!-- 🔸 Regular User Navigation -->
                        <ul class="flex space-x-8 font-medium p-0 border-0 bg-transparent dark:bg-transparent">
                            @unless ($isDonor or $isDonorProfile or $role === 'donor')
                                <li>
                                    <a href="{{ route('user.page') }}"
                                        class="py-2 px-3 text-blue-700 rounded-sm dark:text-blue-500 
                                                {{ request()->routeIs('user.page') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500'}} "
                                        aria-current="page"> Discover </a>
                                </li>
                                <li>
                                    <a href="{{ route('user.campaign') }}"
                                        class="py-2 px-3 text-blue-700 rounded-sm dark:text-blue-500 
                                                {{ request()->routeIs('user.campaign') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500'}} "
                                        aria-current="page">
                                        My Campaigns
                                    </a>
                                </li>
                            @endunless
                        </ul>
                    @endif
                </div>

                <!-- 🔹 Right Section -->
                <div class="flex items-center space-x-3">

                    <!-- 🔸 Create Campaign (only visible to non-admins) -->
                    @if ($role === 'student' or $isUserPage or $isUserCampaign)
                        <div>
                            <button type="button"
                                onclick="window.location.href='{{ route('user.createcampaign') }}'">
                                <span class="text-white p-2.5 flex justify-between bg-gray-900 rounded-2xl gap-4 px-5 hover:bg-white hover:text-black font-semibold ">
                                <x-icons.plusicon />
                                <h1>Create Campaign</h1>
                            </span>
                            </button>
                        </div>
                    @endif

                    <!-- 🔹 Profile Menu -->
                     @auth
                    <button type="button"
                        class="flex items-center p-3 text-sm rounded-xl hover:bg-gray-100 dark:focus:ring-gray-600"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">

                        <div
                            class=" bg-green-200 flex items-center justify-center text-sm font-semibold
                            text-green-800 px-5 py-3 rounded-full">
                            <div>
                                 {{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}
                            </div>                           
                        </div>
                        <!-- lagay naten here yung image na papasok sa creation ng user -->

                        <span class="ml-5">{{ Auth::user()->firstname}} {{ Auth::user()->lastname}}</span>
                    </button>

                    <!-- Dropdown menu -->
                     
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                        id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">{{ Auth::user()->firstname}} {{ Auth::user()->lastname}} </span>
                            <span
                                class="block text-sm text-gray-500 truncate dark:text-gray-400">{{ Auth::user()->email }}</span>
                        </div>
                        <ul aria-labelledby="user-menu-button">
                            <li>
                                @php
                                    try {
                                            switch ($role) {
                                                case 'admin':
                                                    $profileRoute = route('admin.profile');
                                                    break;
                                                case 'donor':
                                                    $profileRoute = route('donor.profile');
                                                    break;
                                                default:
                                                    $profileRoute = route('user.profile');
                                                    break;
                                            }
                                        } catch (\Exception $e) {
                                            // Fallback if route doesn't exist
    $profileRoute = '#';
    \Log::error('Profile route error: ' . $e->getMessage());
                                        }
                                @endphp

                            <a href="{{ $profileRoute }}"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">
                                Profile
                            </a>
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST" > 
                                    @csrf
                                    <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</button>
                                </form>
                                
                            </li>
                        </ul>
                    </div>
                    @endauth
                </div>

               
            </div>
        </nav>
    </header>

    @unless ($isAdminDashboard or $isUserCampaign or $isCampaignPage or $isCreatePage or $isUserProfile or $isAdminProfile or $isDonorProfile)
        <div class="text-center mt-35">
            <h1 class="text-3xl font-bold">Discover Projects</h1>
            <h1 class="text-xl text-gray-600 mt-2">
                Support innovative student projects and make an impact
            </h1>
        </div>


        <div class="flex justify-center mt-10 space-x-3">
            <!-- Search bar -->
            <div class="relative w-full max-w-sm">
                <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M21 21l-4.35-4.35M11 19a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                    </svg>
                </div>
                <input type="search" id="search"
                    class="block w-full pl-10 pr-4 py-2 text-sm text-gray-900 border border-gray-200 rounded-lg bg-gray-50 focus:ring-blue-500 focus:border-blue-500"
                    placeholder="Search projects, creators, or keywords..." />
            </div>

            <!-- Dropdown 1 -->
            <div class="relative">
                <button id="categoryDropdownButton" data-dropdown-toggle="categoryDropdown"
                    class="flex items-center justify-between w-40 px-4 py-2 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-blue-500">
                    All Categories
                    <svg class="w-3 h-3 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="categoryDropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-44 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Technology </a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Social Impact</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Research</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Art & Design</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Environment</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Health </a></li>

                    </ul>
                </div>
            </div>

            <!-- Dropdown 2 -->
            <div class="relative">
                <button id="sortDropdownButton" data-dropdown-toggle="sortDropdown"
                    class="flex items-center justify-between w-32 px-4 py-2 text-sm text-gray-700 bg-gray-50 border border-gray-200 rounded-lg hover:bg-gray-100 focus:ring-2 focus:ring-blue-500">
                    Trending
                    <svg class="w-3 h-3 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 10 6">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m1 1 4 4 4-4" />
                    </svg>
                </button>
                <!-- Dropdown menu -->
                <div id="sortDropdown"
                    class="z-10 hidden bg-white divide-y divide-gray-100 rounded-lg shadow-sm w-36 dark:bg-gray-700">
                    <ul class="py-2 text-sm text-gray-700 dark:text-gray-200">
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Trending</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Newest</a></li>
                        <li><a href="#" class="block px-4 py-2 hover:bg-gray-100">Ending Soon </a></li>
                    </ul>
                </div>
            </div>


        </div>

        <!-- Group Button  -->
        <div class="flex justify-center mt-5">

            <div class="inline-flex rounded-md shadow-xs" role="group">
                <button type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                    All Projects
                </button>
                <button type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">

                    Featured
                </button>
                <button type="button"
                    class="inline-flex items-center px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">

                    Almost Funded
                </button>
            </div>

        </div>
    @endunless

    <!-- where the body of page lmao  -->
    <main class="p-8">
        {{ $slot }}
    </main>

   
</body>

</html>