<x-navbar :isUserCampaign="true">
    <div class="mt-7 text-center">
        <h1 class="text-3xl font-bold">My Campaigns </h1>
        <h1 class="text-xl text-gray-600 mt-2">
            Manage and track your fundraising projects
        </h1>
    </div>

    <div class="flex justify-center mt-5">

        <div class="inline-flex rounded-md shadow-xs" role="group">
            <button type="button"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                All
            </button>

            <button type="button"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                Active
            </button>

            <button type="button"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-l border-gray-900 hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                Pending
            </button>

            <button type="button"
                class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white focus:z-10 focus:ring-2 focus:ring-gray-500 focus:bg-gray-900 focus:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700 dark:focus:bg-gray-700">
                Completed
            </button>
        </div>
    </div>

    <div class="flex justify-center mx-65">
        <div class="flex gap-20 flex-wrap mt-5">
            <x-campaigncard />
            <x-campaigncard />
            <x-campaigncard />
            <x-campaigncard />
            <x-campaigncard />
        </div>
    </div>
</x-navbar>