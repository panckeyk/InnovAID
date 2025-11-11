<x-navbar :isUserCampaign="true">

    @if (session('success'))
        <div class="mx-65 mt-5 p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
            <span class="font-medium">Success!</span> {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mx-65 mt-5 p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
            <span class="font-medium">Error!</span> {{ session('error') }}
        </div>
    @endif

    <!-- <div class="flex justify-center mt-5">
        <button type="button"
            class="text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800"
            onclick="window.location.href='{{ route('user.createcampaign') }}'">
            <span class="text-white p-2.5 flex justify-between gap-4">
                <x-icons.plusicon />
                <h1>Create Campaign</h1>
            </span>
        </button>
    </div> -->

    <div class="text-center mt-27">
            <h1 class="text-3xl font-bold">My Campaigns </h1>
            <h1 class="text-xl text-gray-600 mt-2">
                View All of your created campaigns
            </h1>
    </div>



    <div class="flex justify-center mt-5">
        {{-- Filter Buttons: Uses URL query params for filtering --}}
        @php
            // Function to generate the necessary classes for the active state
            $statusClass = function ($status, $currentStatus) {
                if ($status === $currentStatus) {
                    return 'bg-gray-900 text-white focus:bg-gray-900 focus:text-white dark:bg-gray-700 dark:text-white';
                }
                return 'bg-transparent text-gray-900 hover:bg-gray-900 hover:text-white dark:border-white dark:text-white dark:hover:text-white dark:hover:bg-gray-700';
            };
        @endphp

        <div class="inline-flex rounded-md shadow-xs" role="group">

            {{-- ALL Button --}}
            <a href="{{ route('user.campaign', ['status' => 'all']) }}"
                class="px-4 py-2 text-sm font-medium border border-gray-900 rounded-s-lg focus:z-10 focus:ring-2 focus:ring-gray-500 {{ $statusClass('all', $filterStatus ?? 'all') }}">
                All ({{ Auth::user()->campaigns->count() }})
            </a>

            {{-- ACTIVE Button (Maps to 'active' or 'approved') --}}
            <a href="{{ route('user.campaign', ['status' => 'active']) }}"
                class="px-4 py-2 text-sm font-medium border-t border-b border-gray-900 focus:z-10 focus:ring-2 focus:ring-gray-500 {{ $statusClass('active', $filterStatus ?? 'all') }}">
                Active ({{ Auth::user()->campaigns->whereIn('status', ['active', 'approved'])->count() }})
            </a>

            {{-- PENDING Button (Maps to 'pending') --}}
            <a href="{{ route('user.campaign', ['status' => 'pending']) }}"
                class="px-4 py-2 text-sm font-medium border-t border-b border-l border-gray-900 focus:z-10 focus:ring-2 focus:ring-gray-500 {{ $statusClass('pending', $filterStatus ?? 'all') }}">
                Pending ({{ Auth::user()->campaigns->where('status', 'pending')->count() }})
            </a>

            {{-- DRAFT Button --}}
            <!-- <a href="{{ route('user.campaign', ['status' => 'draft']) }}"
                class="px-4 py-2 text-sm font-medium border-t border-b border-gray-900 focus:z-10 focus:ring-2 focus:ring-gray-500 {{ $statusClass('draft', $filterStatus ?? 'all') }}">
                Draft ({{ Auth::user()->campaigns->where('status', 'draft')->count() }})
            </a> -->

            {{-- COMPLETED Button (Maps to 'completed' or 'canceled') --}}
            <a href="{{ route('user.campaign', ['status' => 'completed']) }}"
                class="px-4 py-2 text-sm font-medium border border-gray-900 rounded-e-lg focus:z-10 focus:ring-2 focus:ring-gray-500 {{ $statusClass('completed', $filterStatus ?? 'all') }}">
                Completed ({{ Auth::user()->campaigns->whereIn('status', ['completed', 'canceled'])->count() }})
            </a>
        </div>
    </div>

    {{-- Campaign Cards Section --}}
    <div class="flex justify-center mx-65">
        <div class="flex gap-10 flex-wrap mt-8 justify-center">

            @forelse ($campaigns as $campaign)
                @php
                    // Link to view if campaign is active/approved/completed, otherwise link to edit
                    $campaignUrl = in_array($campaign->status, ['active', 'approved', 'completed']) 
                        ? route('campaigns.show', $campaign) 
                        : route('campaigns.edit', $campaign);
                @endphp
                <a href="{{ $campaignUrl }}"
                    class="block hover:opacity-90 transition-opacity">
                    <x-campaigncard :campaign="$campaign" />
                </a>
            @empty
                <div class="w-full p-10 text-center bg-white border border-gray-200 rounded-lg shadow-sm">
                    <p class="text-gray-500 text-lg">No <strong>{{ $filterStatus ?? 'all' }}</strong> campaigns found.
                    </p>
                    @if (($filterStatus ?? 'all') === 'all')
                        <p class="text-gray-400 mt-2">Create your first campaign to get started!</p>
                        <a href="{{ route('campaigns.create') }}"
                            class="inline-block mt-4 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg text-sm px-5 py-2.5">
                            Create Campaign
                        </a>
                    @endif
                </div>
            @endforelse

        </div>
    </div>

    {{-- Pagination Links --}}
    @if ($campaigns->hasPages())
        <div class="flex justify-center mx-65 mt-8 mb-10">
            {{ $campaigns->links() }}
        </div>
    @endif
</x-navbar>
