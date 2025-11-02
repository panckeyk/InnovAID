<x-navbar :isCampaignPage="true" :role="$role">
    <script src="//unpkg.com/alpinejs" defer></script>


    <div class="">
        <div>
            <button type="button"
                class="text-gray-900 flex gap-2 text-center justify-center focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                onclick="window.location.href='{{ $backRoute }}'">
                <x-icons.arrowlefticon /> Back to Discover
            </button>
        </div>


        <div class="flex">
            <div class="w-1/2 ">
                <div>
                    <div class="bg-white border border-gray-200 shadow-sm h-100 rounded-lg ">
                        <img class="w-full h-full object-cover" src="{{ asset('Images/LogoInnovAid.png') }}"
                            alt="Campaign Image">
                    </div>
                </div>


                <div class="flex justify-between">
                    <div>
                        <!-- Category -->
                        <div class="mt-5">
                            <span
                                class="bg-blue-100 text-blue-800 text-md font-medium px-2.5 py-0.5 rounded-sm dark:bg-blue-900 dark:text-blue-300">
                                Category
                            </span>
                        </div>

                        <!-- Title -->
                        <div>
                            <h5 class="my-5 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                Noteworthy technology acquisitions 2021
                            </h5>
                        </div>

                        <div>
                            <div class="flex items-center gap-3">
                                <!-- Profile Image -->
                                <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-6/564573792_122143664882803655_3207956134899640240_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=We6aogr25N0Q7kNvwHRIULk&_nc_oc=AdnqYzDxVLoYdYAzlU7W0L4xZSlWwgq8ohkBeQy9kRFpWK4is8NQIVsU_VJ8-LYSE-Y&_nc_zt=23&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=VTyKMO_QvonwhWwQ2SVYlw&oh=00_AffyP-oXzI2197pWXR8yL0BgH9jaUgq1PjpDPOibF1M--Q&oe=690B00E7"
                                    alt="Creator Avatar" class="w-14 h-14 rounded-full object-cover">

                                <!-- Name and Role -->
                                <div class="flex flex-col leading-tight">
                                    <span class="text-lg font-semibold text-gray-900">Alex Kumar</span>
                                    <span class="text-md text-gray-500">Social Work</span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Dynamic Selection -->
                <div class="mt-5" x-data="{view: 'description'}">

                    <!-- Button Group -->
                    <div class="inline-flex rounded-md shadow-xs" role="group">
                        <!-- Description -->
                        <button @click="view = 'description'"
                            :class="view === 'description'
        ? 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-s-lg'
        : 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white'">
                            Description
                        </button>

                        <!-- Updates -->
                        <button @click="view = 'updates'"
                            :class="view === 'updates'
        ? 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border-t border-b border-gray-900'
        : 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white'">
                            Updates
                        </button>

                        <!-- Comments -->
                        <button @click="view = 'comments'"
                            :class="view === 'comments'
        ? 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-e-lg'
        : 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white'">
                            Comments
                        </button>
                    </div>

                    <!-- Description -->
                    <div x-show="view === 'description'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5 ">
                        <p class="font-normal text-gray-700 dark:text-gray-400">Lorem ipsum dolor sit amet consectetur
                            adipiscing elit. Quisque faucibus ex sapien vitae pellentesque sem placerat. In id cursus mi
                            pretium
                            tellus duis convallis. Tempus leo eu aenean sed diam urna tempor. Pulvinar vivamus fringilla
                            lacus
                            nec metus bibendum egestas. Iaculis massa nisl malesuada lacinia integer nunc posuere. Ut
                            hendrerit
                            semper vel class aptent taciti sociosqu. Ad litora torquent per conubia nostra inceptos
                            himenaeos..
                        </p>
                    </div>

                    <!-- Updates -->
                    <div x-show="view === 'updates'" class="block p-6 bg-white border border-gray-200 rounded-lg mt-5 ">
                        <p class="font-normal text-gray-700 dark:text-gray-400 text-center"> No updates yet come back
                            later!
                        </p>
                    </div>

                    <!-- Comments -->
                    <div x-show="view === 'comments'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5 ">

                        <form>
                            <div
                                class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                                <div class="px-4 py-2 bg-white rounded-t-lg dark:bg-gray-800">
                                    <label for="comment" class="sr-only">Your comment</label>
                                    <textarea id="comment" rows="4"
                                        class="w-full px-0 text-sm text-gray-900 bg-white border-0 dark:bg-gray-800 focus:ring-0 dark:text-white dark:placeholder-gray-400"
                                        placeholder="Write a comment..." required></textarea>
                                </div>
                                <div
                                    class="flex items-center justify-between px-3 py-2 border-t dark:border-gray-600 border-gray-200">
                                    <button type="submit"
                                        class="inline-flex items-center py-2.5 px-4 font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 dark:focus:ring-blue-900 hover:bg-blue-800">
                                        Post comment
                                    </button>
                                </div>
                            </div>
                        </form>

                    </div>


                </div>




            </div>




            <div class="w-1/2">
                <!-- Back this shit card -->
                <div class="flex-col justify-center">

                    <div class="w-full ml-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">

                        <h5 class="mb-2 text-2xl flex font-bold tracking-tight text-gray-900 dark:text-white"> $3,850
                            <span class="ml-2 opacity-60">
                                <h5 class="text-[16px] mt-2"> of $30,500 </h5>
                            </span>
                        </h5>

                        <!-- Progress Bar  -->
                        <div>
                            <div class="mt-5">

                                <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                    <div class="bg-blue-600 h-2.5 rounded-full" style="width: 45%"></div>
                                </div>

                                <div class="mt-5">
                                    <div class="flex">
                                        <div class="w-1/2">
                                            <div class="mb-1">
                                                <span class="text-sm font-medium text-gray-500">Funded</span>
                                            </div>
                                            <div>
                                                <span class="text-lg font-medium  dark:text-white">45%</span>
                                            </div>
                                        </div>

                                        <div class="w-1/2">
                                            <div class=" mb-1">
                                                <span class="text-sm font-medium text-gray-500">Backers</span>
                                            </div>
                                            <div>
                                                <span class="text-lg font-medium  dark:text-white">1</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- Duration -->
                        <div class="border-t mt-5 border-gray-300">
                            <div class="flex items-center gap-2 mt-3">
                                <div>
                                    <x-icons.clockicon />
                                </div>

                                <div>
                                    <h1 class="text-xl"> Days Left </h1>
                                    <h1 class="text-gray-500"> Days Duration </h1>
                                </div>
                            </div>
                        </div>

                        <!-- Back this project button -->
                        <div class="mt-5">

                            <button type="button"
                                class="flex justify-center items-center gap-2 w-full text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700 dark:border-gray-700">
                                <span> <x-icons.haticon /> </span>
                                Back this Project

                            </button>

                        </div>

                    </div>

                    <!-- Recent Backers  -->
                    <div class="w-full ml-5 mt-5">
                        <div>
                            <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <div class="mb-5 text-xl">
                                    <h1> Recent Backers </h1>
                                </div>
                                <div>
                                    <!-- Backer Info -->
                                    <div class="flex items-center gap-3 border-b border-gray-300 pb-3 mb-3">
                                        <!-- Profile Image -->
                                        <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-6/564573792_122143664882803655_3207956134899640240_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=We6aogr25N0Q7kNvwHRIULk&_nc_oc=AdnqYzDxVLoYdYAzlU7W0L4xZSlWwgq8ohkBeQy9kRFpWK4is8NQIVsU_VJ8-LYSE-Y&_nc_zt=23&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=VTyKMO_QvonwhWwQ2SVYlw&oh=00_AffyP-oXzI2197pWXR8yL0BgH9jaUgq1PjpDPOibF1M--Q&oe=690B00E7"
                                            alt="Creator Avatar" class="w-10 h-10 rounded-full object-cover">

                                        <!-- Name and Role -->
                                        <div class="flex flex-col leading-tight">
                                            <span class="text-md font-semibold text-gray-900">Alex Kumar</span>
                                            <span class="text-sm text-gray-500">$11</span>
                                        </div>
                                    </div>

                                    <div class="flex items-center gap-3 border-b border-gray-300 pb-3 mb-3">
                                        <!-- Profile Image -->
                                        <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-6/564573792_122143664882803655_3207956134899640240_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=We6aogr25N0Q7kNvwHRIULk&_nc_oc=AdnqYzDxVLoYdYAzlU7W0L4xZSlWwgq8ohkBeQy9kRFpWK4is8NQIVsU_VJ8-LYSE-Y&_nc_zt=23&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=VTyKMO_QvonwhWwQ2SVYlw&oh=00_AffyP-oXzI2197pWXR8yL0BgH9jaUgq1PjpDPOibF1M--Q&oe=690B00E7"
                                            alt="Creator Avatar" class="w-10 h-10 rounded-full object-cover">

                                        <!-- Name and Role -->
                                        <div class="flex flex-col leading-tight">
                                            <span class="text-md font-semibold text-gray-900">Alex Kumar</span>
                                            <span class="text-sm text-gray-500">$11</span>
                                        </div>
                                    </div>
                                    
                                    <div class="flex items-center gap-3 border-b border-gray-300 pb-3 mb-3">
                                        <!-- Profile Image -->
                                        <img src="https://scontent.fmnl17-7.fna.fbcdn.net/v/t39.30808-6/564573792_122143664882803655_3207956134899640240_n.jpg?_nc_cat=108&ccb=1-7&_nc_sid=6ee11a&_nc_eui2=AeGzWJhcmSJ6gPup8gsVMdXsoWT97wJ5HCehZP3vAnkcJxmx1HtL88dkk7OUruufssUjQn9KQ8cE2N01JDpK7cGu&_nc_ohc=We6aogr25N0Q7kNvwHRIULk&_nc_oc=AdnqYzDxVLoYdYAzlU7W0L4xZSlWwgq8ohkBeQy9kRFpWK4is8NQIVsU_VJ8-LYSE-Y&_nc_zt=23&_nc_ht=scontent.fmnl17-7.fna&_nc_gid=VTyKMO_QvonwhWwQ2SVYlw&oh=00_AffyP-oXzI2197pWXR8yL0BgH9jaUgq1PjpDPOibF1M--Q&oe=690B00E7"
                                            alt="Creator Avatar" class="w-10 h-10 rounded-full object-cover">

                                        <!-- Name and Role -->
                                        <div class="flex flex-col leading-tight">
                                            <span class="text-md font-semibold text-gray-900">Alex Kumar</span>
                                            <span class="text-sm text-gray-500">$11</span>
                                        </div>
                                    </div>


                                </div>



                            </div>

                        </div>

                    </div>

                </div>

            </div>




        </div>







    </div>
</x-navbar>