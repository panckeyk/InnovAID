<x-navbar :is-admin="true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <h1 class="text-3xl font-bold mb-8">All Approved & Active Campaigns</h1>

        @if ($campaigns->isEmpty())
            <p class="text-gray-600">There are no active or approved campaigns at this time.</p>
        @else
            <div class="flex justify-center">
                <div class="flex gap-8 flex-wrap">
                    @foreach ($campaigns as $campaign)
                        <a 
                            href="{{ route('admin.campaign.details', ['id' => $campaign->id]) }}" 
                            class="transition-transform transform hover:scale-105 hover:shadow-lg"
                        >
                            <x-campaigncard 
                                :campaign="$campaign" 
                                :show-admin-details="true" 
                            />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-navbar>
