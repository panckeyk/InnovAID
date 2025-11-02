
<div
    class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm 
           dark:bg-gray-800 dark:border-gray-700 overflow-hidden 
           transform transition duration-100 ease-in-out 
           hover:scale-105 hover:shadow-2xl hover:border-blue-300" 
    onclick="window.location.href='{{ route('campaign.page') }}'"

           >

    <a>
        <div class="h-40 w-full">
            <img class="w-full h-full object-cover" src="{{ asset('Images/LogoInnovAid.png') }}" alt="Campaign Image">
        </div>
    </a>

    <div class="p-5">
        <span
            class="bg-blue-100 text-blue-800 text-md font-medium px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">
            Category
        </span>

        <h5 class="my-5 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
            Noteworthy technology acquisitions 2021
        </h5>
        
        <div class="mt-5">
            <div class="flex items-center gap-3">
                <!-- Profile Image -->
                <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-6/564573792_122143664882803655_3207956134899640240_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=We6aogr25N0Q7kNvwHRIULk&_nc_oc=AdnqYzDxVLoYdYAzlU7W0L4xZSlWwgq8ohkBeQy9kRFpWK4is8NQIVsU_VJ8-LYSE-Y&_nc_zt=23&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=VTyKMO_QvonwhWwQ2SVYlw&oh=00_AffyP-oXzI2197pWXR8yL0BgH9jaUgq1PjpDPOibF1M--Q&oe=690B00E7"
                    alt="Creator Avatar" class="w-10 h-10 rounded-full object-cover">

                <!-- Name and Role -->
                <div class="flex flex-col leading-tight">
                    <span class="font-semibold text-gray-900">Alex Kumar</span>
                    <span class="text-sm text-gray-500">Social Work</span>
                </div>
            </div>
        </div>

        <!-- Progress Bar -->
        <div class="mt-5">
            <div class="flex justify-between gap-2 mb-1">
                <span class="text-sm font-medium text-blue-700 dark:text-white">$3,500</span>
                <span class="text-sm font-medium opacity-60 dark:text-white">of $30,500</span>
            </div>

            <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
            </div>

            <div class="flex justify-between">
                <div class="flex gap-2 mb-1">
                    <span class="text-sm font-medium text-blue-700 dark:text-white">45%</span>
                    <span class="text-sm font-medium text-blue-700 dark:text-white">Funded</span>
                </div>

                <div class="flex items-center gap-1">
                    <x-icons.calendaricon class="w-5 h-5 text-blue-700 dark:text-white" />
                    <span class="text-sm font-medium opacity-60 dark:text-white">[number] days left</span>
                </div>
            </div>
        </div>

    </div>
</div>
