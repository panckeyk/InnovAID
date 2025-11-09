<x-navbar :isDonor="true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- 2. Changed the header for a public/donor audience --}}
        <h1 class="text-3xl font-bold mb-8 text-gray-900">Explore Active Student Campaigns 🚀</h1>

        @if ($campaigns->isEmpty())
            <p class="text-gray-600">There are no active campaigns open for donations at this time.</p>
        @else
            <div class="flex justify-center">
                <div class="flex gap-8 flex-wrap">
                    @foreach ($campaigns as $campaign)
                        <a 
                            {{-- 3. CRITICAL: Changed route to the public campaign detail page --}}
                            href="{{ route('campaigns.show', $campaign) }}" 
                            class="block transition-transform transform hover:scale-105 hover:shadow-xl rounded-lg overflow-hidden"
                        >
                            <x-campaigncard 
                                :campaign="$campaign" 
                                {{-- 4. Removed :show-admin-details="true" --}}
                            />
                        </a>
                    @endforeach
                </div>
            </div>
        @endif
    </div>
</x-navbar>