<x-navbar :is-admin-dashboard="true">
    <div class="mt-7 text-center">
        <h1 class="text-3xl font-bold">Admin Dashboard </h1>
        <h1 class="text-xl text-gray-600 mt-2">
            Manage campaigns and monitor platform activity
        </h1>
    </div>

    <div class="mx-65">
        <div class="flex justify-center gap-10">

            <!-- Total Campaigns -->
            <div
                class="max-w-sm mt-10 p-6 bg0 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex  items-center justify-between">
                    <h5 class="mb-2 text-2xl text-center font-normal text-gray-500 dark:text-gray-400"> Total
                        Campaigns </h5>
                    <x-icons.charticon />
                </div>
                <div class="w-[250px] mt-5 mb-5">
                    <h1 class="text-4xl"> 4 </h1>
                </div>
                <p class=" font-normal text-gray-500 dark:text-gray-400"> [Number] pending review </p>
            </div>

            <!-- Total Funds -->
            <div
                class="max-w-sm mt-10 p-6 bg0 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex  items-center justify-between">
                    <h5 class="mb-2 text-2xl text-center font-normal text-gray-500 dark:text-gray-400"> Total Funds
                        Raised </h5>
                    <x-icons.cashicon />
                </div>
                <div class="w-[250px] mt-5 mb-5">
                    <h1 class="text-4xl"> 4 </h1>
                </div>
                <p class=" font-normal text-gray-500 dark:text-gray-400"> Accross all campaigns </p>
            </div>

            <!-- Donations -->
            <div
                class="max-w-sm mt-10 p-6 bg0 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex  items-center justify-between">
                    <h5 class="mb-2 text-2xl text-center font-normal text-gray-500 dark:text-gray-400"> Total Donations
                    </h5>
                    <x-icons.arrowtradeicon />
                </div>
                <div class="w-[250px] mt-5 mb-5">
                    <h1 class="text-4xl"> 4 </h1>
                </div>
                <p class=" font-normal text-gray-500 dark:text-gray-400"> From generous supporters </p>
            </div>

            <!-- Active Users -->
            <div
                class="max-w-sm mt-10 p-6 bg0 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex  items-center justify-between">
                    <h5 class="mb-2 text-2xl text-center font-normal text-gray-500 dark:text-gray-400"> Active Users
                    </h5>
                    <x-icons.usersicon />
                </div>
                <div class="w-[250px] mt-5 mb-5">
                    <h1 class="text-4xl"> 4 </h1>
                </div>
                <p class=" font-normal text-gray-500 dark:text-gray-400"> Students and donors </p>
            </div>

        </div>

        <!-- Button Group + Dynamic Section -->
        <div x-data="{ view: 'pending' }" class="mt-10">
            <!-- Button Group -->
            <div>
                <div class="inline-flex rounded-md shadow-xs" role="group">
                    <button type="button" @click="view = 'pending'"
                        class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                        Pending Review
                    </button>

                    <button type="button" @click="view = 'all'"
                        class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                        All Campaigns
                    </button>

                    <button type="button" @click="view = 'analytics'"
                        class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                        Analytics
                    </button>
                </div>
            </div>

            <!-- Pending Approval -->
            <div x-show="view === 'pending'"
                class="mt-10 p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-start">
                    <h5 class="mb-2 text-lg text-center font-normal"> Campaigns Pending Approval </h5>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400"> Review and approve student project submissions </p>
                </div>
                <div>
                    <x-pendingcardtable />
                </div>
            </div>

            <!-- Analytics -->
            <div x-show="view === 'analytics'"
                class="mt-10 p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-start">
                    <h5 class="mb-2 text-lg text-center font-normal"> Top donors </h5>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400"> </p>
                </div>
                <div>
                    <x-topdonor />
                </div>



            </div>

            <div x-show="view === 'analytics'" class="mt-10 p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="text-center">
                    <h1 class="text-2xl mb-10"> Category Distribution </h1>
                </div>

                <div class="flex justify-center gap-10 ">
                    <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"> <h1> Technology </h1></div>
                    <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"> <h1> Social Impact </h1></div>
                    <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"> <h1> Research </h1></div>
                    <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"> <h1> Art and Design  </h1></div>
                    <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"> <h1> Environment </h1></div>
                    <div class="block max-w-sm p-6 bg-white border border-gray-200 rounded-lg shadow-sm hover:bg-gray-100 dark:bg-gray-800 dark:border-gray-700 dark:hover:bg-gray-700"> <h1> Health </h1></div>

                </div>

            </div>


            <!-- All Campaigns (optional placeholder for now) -->
            <div x-show="view === 'all'"
                class="mt-10 p-6 bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
                <div class="flex justify-start">
                    <h5 class="mb-2 text-lg text-center font-normal"> All Campaign </h5>
                </div>
                <div>
                    <p class="text-gray-500 dark:text-gray-400"> Overview of all campaigns on the platform
                    </p>
                </div>
                <div>
                    <x-allcampaign />
                </div>
            </div>
        </div>





    </div>

</x-navbar>