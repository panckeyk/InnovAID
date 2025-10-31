<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/png" href="{{ asset('Images/LogoInnovAid.png') }}">
    <script src="//unpkg.com/alpinejs" defer></script>

</head>

<body>

    <div class="mt-5">
        <div class="flow-root  border-b border-b-gray-200">
            <ul role="list" class="divide-y divide-gray-200 dark:divide-gray-700">
                <li class="py-3 sm:py-4">
                    <div class="flex items-center">
                        <div class="shrink-0">
                            <img class="w-8 h-8 rounded-full" src="https://scontent.fmnl17-2.fna.fbcdn.net/v/t39.30808-1/561632276_1498917951390072_3649692673996152857_n.jpg?stp=dst-jpg_s200x200_tt6&_nc_cat=107&ccb=1-7&_nc_sid=e99d92&_nc_eui2=AeGe84dBe1vXYScvDx7mZC73lPb9QD56ImWU9v1APnoiZTk5GXr6ewG8Ad-GZIS7NfOa38xcLJd1ipSdEolZeoV_&_nc_ohc=Krj6qCS5E9AQ7kNvwHAAB5D&_nc_oc=AdncNR1KkVivYzj4LiVE4bAW2ntxJwdLUXjrI1Gs_aViYfapw2d94Om97VCz9bk28eY&_nc_zt=24&_nc_ht=scontent.fmnl17-2.fna&_nc_gid=rovolT20QhzQcgV8VdTC5w&oh=00_AfdY_Eh8XnfyjEASA38fCa0KNg-7d8Tr4qvgGUcpVsc0fQ&oe=690B178C"
                                alt="Neil image">
                        </div>
                        <div class="flex-1 min-w-0 ms-4">
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-white">
                                Neil Sims
                            </p>
                            <p class="text-sm text-gray-500 truncate dark:text-gray-400">
                                email@windster.com
                            </p>
                        </div>
                        <div class="inline-flex items-center text-base font-semibold text-gray-900 dark:text-white">
                            $320
                        </div>
                    </div>
                </li>

            </ul>
        </div>
    </div>

</body>

</html>