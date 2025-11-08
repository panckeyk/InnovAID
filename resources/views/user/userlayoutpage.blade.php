<x-navbar :isUserPage="true">
    <div class="flex justify-center mx-65">
        <div class="flex gap-20 flex-wrap">
            
            {{-- FIX: Loop through the $campaigns collection and pass each item --}}
            @forelse ($campaigns as $campaign)
                <x-campaigncard :campaign="$campaign" />
            @empty
                <p class="text-gray-500 p-10">No active campaigns to show yet.</p>
            @endforelse

            
        </div>

        </div>
</x-navbar>
