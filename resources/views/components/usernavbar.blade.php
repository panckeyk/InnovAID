<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <header>

        <nav class="bg-white border-gray-200 dark:bg-gray-900 shadow-xl">
            <div class="max-w-screen-xl flex items-center justify-between mx-auto p-4">

                <!-- 🔹 Left Section: Logo + Links -->
                <div class="flex items-center space-x-8">
                    <!-- Logo -->
                    <a href="#" class="flex items-center space-x-3 rtl:space-x-reverse">
                        <img src="https://flowbite.com/docs/images/logo.svg" class="h-8" alt="Flowbite Logo" />
                        <span
                            class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white">Innovaid</span>
                    </a>

                    <!-- Nav Links -->
                    <ul class="flex space-x-8 font-medium p-0 border-0 bg-transparent dark:bg-transparent">
                        <li>
                            <a href="#" class="py-2 px-3 text-blue-700 rounded-sm dark:text-blue-500"
                                aria-current="page">Discover</a>
                        </li>
                        <li>
                            <a href="#"
                                class="py-2 px-3 text-gray-900 hover:text-blue-700 dark:text-white md:dark:hover:text-blue-500">
                                My Campaigns
                            </a>
                        </li>
                    </ul>
                </div>

                <!-- 🔹 Right Section: Profile Button -->
                <div class="flex items-center space-x-3">
                    <div>
                        <button type="button"
                        class="bg-blue-950 rounded-xl"
                        >
                            
                            <span class="text-white p-3 flex justify-between gap-4"> <x-icons.plusicon/> <h1> Create Campaign </h1> </span>
                        </button>
                    </div>

                    <div>
                        <button type="button"
                        class="p-3 rounded-xl"
                        >
                            <span> <x-icons.bellicon/> </span>
                        </button>
                    </div>

                    <button type="button"
                        class="flex items-center p-3 text-sm rounded-xl hover:bg-gray-100 dark:focus:ring-gray-600"
                        id="user-menu-button" aria-expanded="false" data-dropdown-toggle="user-dropdown"
                        data-dropdown-placement="bottom">

                        <img class="w-8 h-8 rounded-full"
                            src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-1/564573792_122143664882803655_3207956134899640240_n.jpg?stp=c0.51.960.960a_dst-jpg_s160x160_tt6&_nc_cat=108&ccb=1-7&_nc_sid=1d2534&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=We6aogr25N0Q7kNvwHRIULk&_nc_oc=AdnqYzDxVLoYdYAzlU7W0L4xZSlWwgq8ohkBeQy9kRFpWK4is8NQIVsU_VJ8-LYSE-Y&_nc_zt=24&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=a3gMmjy7ykKyiWCOV1TdOw&oh=00_AffBWSHxyRYpPE63cXVrDFf2woFxXXPhlqCOAh4uOPxlsw&oe=6907E344"
                            alt="user photo">
                        <span class="ml-5">Sample Name </span>
                    </button>

                    <!-- Dropdown menu (optional) -->
                    <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded-lg shadow-sm dark:bg-gray-700 dark:divide-gray-600"
                        id="user-dropdown">
                        <div class="px-4 py-3">
                            <span class="block text-sm text-gray-900 dark:text-white">Sample Username</span>
                            <span
                                class="block text-sm text-gray-500 truncate dark:text-gray-400">name@flowbite.com</span>
                        </div>
                        <ul aria-labelledby="user-menu-button">
                            <li><a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Profile</a>
                            </li>
                            <li><a href="#"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Settings</a>
                            </li>
                            <li><a href="{{ route('loginpage') }}"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:hover:bg-gray-600 dark:text-gray-200 dark:hover:text-white">Logout</a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </nav>


    </header>
</body>

</html>