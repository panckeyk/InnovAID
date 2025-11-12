@php
    use Illuminate\Support\Facades\Auth;
    $role = Auth::check() ? Auth::user()->role : null;
@endphp

@props([
    'isAdmin' => false,
    'isAdminDashboard' => false,
    'isDonor' => false,
    'isCampaignDetails' => false,
    'isUserCampaign' => false,
    'isCampaignPage' => false,
    'isCreatePage' => false,
    'isUserProfile' => false,
    'isAdminProfile' => false,
    'isDonorProfile' => false,
    'isUserPage' => false,
    'role' => null,
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
        <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-xl">
            <div class="max-w-7xl flex items-center justify-between mx-auto p-4">
                <!-- 🔹 Left Section: Logo + Nav Links -->
                <div class="flex items-center space-x-8">
                    <a class="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="{{ asset('Images/LogoInnovAid.png') }}"
                            src="{{ asset('Images/LogoInnovAid.png') }}" loading="lazy" class="h-8"
                            alt="Logo" />
                        <span
                            class="self-center text-2xl text-[#1848a0] font-semibold whitespace-nowrap dark:text-white">
                            Innovaid
                        </span>
                    </a>

                    <!-- 🔹 Navigation -->
                    <ul class="flex space-x-8 font-medium p-0 border-0 bg-transparent dark:bg-transparent">
                        @if ($role === 'admin')
                            <li>
                                <a href="{{ route('approved.index') }}"
                                    class="py-2 px-3 rounded-sm {{ request()->routeIs('admin.page') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">
                                    Discover
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.admindashboard') }}"
                                    class="py-2 px-3 rounded-sm {{ request()->routeIs('admin.dashboard') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">
                                    Admin Dashboard
                                </a>
                            </li>
                        @elseif ($role === 'donor')
                            <li>
                                <a href="{{ route('donor.page') }}"
                                    class="py-2 px-3 rounded-sm {{ request()->routeIs('donor.page') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">
                                    Discover
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('donor.profile') }}"
                                    class="py-2 px-3 rounded-sm {{ request()->routeIs('donor.profile') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">
                                    Profile
                                </a>
                            </li>
                        @elseif ($role === 'student')
                            <li>
                                <a href="{{ route('user.page') }}"
                                    class="py-2 px-3 rounded-sm {{ request()->routeIs('user.page') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">
                                    Discover
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('user.campaign') }}"
                                    class="py-2 px-3 rounded-sm {{ request()->routeIs('user.campaign') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500' }}">
                                    My Campaigns
                                </a>
                            </li>
                        @else
                            <!-- Default (guest) links -->
                            <li>
                                <a href="{{ route('donor.page') }}"
                                    class="py-2 px-3 rounded-sm {{ request()->routeIs('campaign.page') ? 'text-blue-700 dark:text-blue-500' : 'text-gray-900 hover:text-blue-700 dark:text-white' }}">
                                    Discover
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('login') }}"
                                    class="py-2 px-3 rounded-sm text-gray-900 hover:text-blue-700 dark:text-white">
                                    Login
                                </a>
                            </li>
                        @endif
                    </ul>
                </div>

                <!-- 🔹 Right Section -->
                <div class="flex items-center space-x-3">

                    <!-- 🔸 Create Campaign (only visible to non-admins) -->
                    @if ($role === 'student' or $isUserPage or $isUserCampaign)
                        <div>
                            <button type="button"
                                class="text-white bg-gray-900 rounded-2xl px-2 hover:bg-white hover:text-gray-900"
                                onclick="window.location.href='{{ route('user.createcampaign') }}'">
                                <span class="p-2.5 flex justify-between gap-4">
                                    <x-icons.plusicon />
                                    <h1>Create Campaign</h1>
                                </span>
                            </button>
                        </div>
                    @endif

                    <!-- 🔹 Profile Dropdown -->
                    @auth
                        <button type="button"
                            class="flex items-center p-3 text-sm rounded-xl hover:bg-gray-100 dark:focus:ring-gray-600"
                            id="user-menu-button" data-dropdown-toggle="user-dropdown" data-dropdown-placement="bottom">
                            <div class="rounded-full w-8 h-8 bg-blue-600 flex justify-center items-center font-semibold text-white">
                                <div>
                                     {{ strtoupper(substr(Auth::user()->firstname, 0, 1)) }}
                                </div>    
                            </div>

                            <!-- <img class="w-8 h-8 rounded-full object-cover"
                                src="{{ Auth::user()->avatar ? asset('storage/' . Auth::user()->avatar) : asset('Images/default-avatar.png') }}"
                                alt="user photo"> -->
                            <span class="ml-5">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</span>
                        </button>

                        <div id="user-dropdown"
                            class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600">
                            <div class="px-4 py-3">
                                <span class="block text-sm text-gray-900 dark:text-white">
                                    {{ Auth::user()->firstname }} {{ Auth::user()->lastname }}
                                </span>
                                <span class="block text-sm text-gray-500 truncate dark:text-gray-400">
                                    {{ Auth::user()->email }}
                                </span>
                            </div>
                            <ul aria-labelledby="user-menu-button">
                                <li>
                                    @php
                                        try {
                                            switch ($role) {
                                                case 'admin':
                                                    $profileRoute = route('admin.adminprofilepage');
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
                                        class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                        Profile
                                    </a>
                                </li>
                                <li>
                                    <form action="{{ route('logout') }}" method="POST">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200">
                                            Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    @endauth
                </div>
            </div>
        </nav>
    </header>

    <!-- 🔹 "Discover Projects" Section (hidden on dashboard/profile pages) -->
    @unless (
        $isAdminDashboard ||
            $isUserCampaign ||
            $isCampaignPage ||
            $isCreatePage ||
            $isUserProfile ||
            $isAdminProfile ||
            $isDonorProfile ||
            $isCampaignDetails)
        <div class="text-center mt-15">
            <h1 class="text-3xl font-bold">Discover Projects</h1>
            <h1 class="text-xl text-gray-600 mt-2">
                Support innovative student projects and make an impact
            </h1>
        </div>


        <!-- Group Button  -->
        {{-- <div class="flex justify-center mt-5">

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

        </div> --}}
    @endunless

    <main class="p-8">
        {{ $slot }}
    </main>
</body>

</html>
