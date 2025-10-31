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
        <div class="overflow-x-auto bg-white rounded-lg">
            <table class="w-full text-sm text-left text-gray-600">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50">
                    <tr>
                        <th scope="col" id="campaign-title" class="px-6 py-3 w-[35%]">Campaign</th>
                        <th scope="col" id="creator" class="px-6 py-3 w-[20%]">Creator</th>
                        <th scope="col" id="status" class="px-6 py-3 text-center w-[10%]">Status</th>
                        <th scope="col" id="progress" class="px-6 py-3 text-center w-[10%]">Progress</th>
                        <th scope="col" id="views" class="px-6 py-3 text-center w-[15%]">Views</th>
                        <th scope="col" id="actions" class="px-6 py-3 text-center w-[10%]">Actions</th>
                    </tr>
                </thead>

                <tbody>
                    <tr class="bg-white border-b border-b-gray-200 hover:bg-gray-100">
                        <!-- Campaign -->
                        <td headers="campaign-title" class="px-6 py-3">
                            <div class="flex items-center gap-3">
                                <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-6/564573792_122143664882803655_3207956134899640240_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=We6aogr25N0Q7kNvwHRIULk&_nc_oc=AdnqYzDxVLoYdYAzlU7W0L4xZSlWwgq8ohkBeQy9kRFpWK4is8NQIVsU_VJ8-LYSE-Y&_nc_zt=23&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=VTyKMO_QvonwhWwQ2SVYlw&oh=00_AffyP-oXzI2197pWXR8yL0BgH9jaUgq1PjpDPOibF1M--Q&oe=690B00E7"
                                    alt="Campaign Thumbnail" class="w-10 h-10 rounded-md object-cover flex-shrink-0">
                                <span class="font-medium text-gray-900 truncate max-w-[220px]"
                                    title="Student Coding Bootcamp for Underserved High Schools">
                                    Student Coding Bootcamp for Underserved High Schools
                                </span>
                            </div>
                        </td>

                        <!-- Creator -->
                        <td headers="creator" class="px-6 py-3">
                            <div class="flex items-center gap-2">
                                <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-6/564573792_122143664882803655_3207956134899640240_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=We6aogr25N0Q7kNvwHRIULk&_nc_oc=AdnqYzDxVLoYdYAzlU7W0L4xZSlWwgq8ohkBeQy9kRFpWK4is8NQIVsU_VJ8-LYSE-Y&_nc_zt=23&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=VTyKMO_QvonwhWwQ2SVYlw&oh=00_AffyP-oXzI2197pWXR8yL0BgH9jaUgq1PjpDPOibF1M--Q&oe=690B00E7"
                                    alt="Creator Avatar" class="w-8 h-8 rounded-full object-cover">
                                <span class="font-medium text-gray-900">Alex Kumar</span>
                            </div>
                        </td>

                        <!-- Category -->
                        <td headers="category" class="px-6 py-3 text-center">
                            <span class="bg-gray-100 text-gray-800 text-xs font-medium px-2.5 py-0.5 rounded">
                                Tech
                            </span>
                        </td>

                        <!-- Goal -->
                        <td headers="goal" class="px-6 py-3 text-center font-medium text-gray-900">$3,500</td>

                        <!-- Submitted -->
                        <td headers="submitted" class="px-6 py-3 text-center text-gray-500">20</td>

                        <!-- Actions -->
                        <td headers="actions" class="px-6 py-3 text-center">
                            <div class="flex justify-center items-center gap-2">
                                <!-- Eye (View) -->
                                <button class="p-1 text-blue-600 hover:bg-blue-100 rounded-full transition"
                                    title="View">
                                    <x-icons.eyeicon/>
                                </button>

                              
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

</body>

</html>