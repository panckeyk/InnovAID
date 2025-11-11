<x-navbar :isCampaignDetails="true" :role="$role"> 
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
            <!-- Left Side -->
            <div class="w-1/2">
                <!-- Campaign Image -->
                <div class="bg-white border border-gray-200 shadow-sm h-100 rounded-lg">
                    <img class="w-full h-full object-cover" 
                        src="{{ $campaign->image ? asset('storage/' . $campaign->image) : asset('Images/LogoInnovAid.png') }}" 
                        alt="Campaign Image">
                </div>

                <div class="flex justify-between">
                    <div>
                        <!-- Category -->
                        <div class="mt-5">
                            <span class="bg-blue-100 text-blue-800 text-md font-medium px-2.5 py-0.5 rounded-sm">
                                {{ $campaign->category ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <div>
                            <h5 class="my-5 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $campaign->title }}
                            </h5>
                        </div>

                        <!-- Creator -->
                        <div>
                            <div class="flex items-center gap-3">
                                @if($campaign->creator->avatar)
                                    <img src="{{ asset('storage/' . $campaign->creator->avatar) }}" 
                                        alt="Creator Avatar" 
                                        class="w-14 h-14 rounded-full object-cover">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-xl">
                                        {{ strtoupper(substr($campaign->creator->firstname ?? 'U', 0, 1)) }}
                                    </div>
                                @endif

                                <div class="flex flex-col leading-tight">
                                    <span class="text-lg font-semibold text-gray-900">
                                        {{ $campaign->creator->firstname }} {{ $campaign->creator->lastname }}
                                    </span>
                                    <span class="text-md text-gray-500">
                                        {{ $campaign->creator->department ?? ucfirst($campaign->creator->role ?? 'Creator') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description / Updates / Comments -->
                <div class="mt-5" x-data="{view: 'description'}">

                    <!-- Tabs -->
                    <div class="inline-flex rounded-md shadow-xs" role="group">
                        <button @click="view = 'description'"
                            :class="view === 'description'
                                ? 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-s-lg'
                                : 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white'">
                            Description
                        </button>

                        <button @click="view = 'comments'"
                            :class="view === 'comments'
                                ? 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-e-lg'
                                : 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white'">
                            Comments
                        </button>
                    </div>

                    <!-- Description Tab -->
                    <div x-show="view === 'description'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <p class="font-normal text-gray-700 dark:text-gray-400">
                            {{ $campaign->description ?? 'No description available.' }}
                        </p>
                    </div>

                    <!-- Updates Tab -->
                    <div x-show="view === 'updates'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <p class="font-normal text-gray-700 dark:text-gray-400 text-center">
                            No updates yet — come back later!
                        </p>
                    </div>

                    <!-- Comments Tab -->
                    <div x-show="view === 'comments'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">

                        {{-- Comments List (always visible) --}}
                        <div class="space-y-4 mb-6">
                            @forelse(($campaign->comments ?? collect()) as $comment)
                                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="flex items-center gap-3">
                                        @if($comment->user?->avatar)
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="w-9 h-9 rounded-full object-cover" alt="User Avatar">
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold">
                                                {{ strtoupper(substr($comment->user?->firstname ?? 'U', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-semibold">{{ $comment->user?->firstname }} {{ $comment->user?->lastname }}</div>
                                            <div class="text-xs text-gray-500">{{ $comment->created_at?->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-gray-800 text-sm">{{ $comment->content }}</div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No comments yet.</p>
                            @endforelse
                        </div>

                        {{-- Post form (hidden for admin) --}}
                        @if ($role !== 'admin')
                            <form method="POST" action="{{ route('campaigns.comments.store', $campaign) }}">
                                @csrf
                                <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50">
                                    <div class="px-4 py-2 bg-white rounded-t-lg">
                                        <label for="comment" class="sr-only">Your comment</label>
                                        <textarea id="comment" name="content" rows="3" maxlength="1000" required
                                            class="w-full px-0 text-sm text-gray-900 bg-white border-0 focus:ring-0"
                                            placeholder="Write a comment..."></textarea>
                                    </div>
                                    <div class="flex items-center justify-end px-3 py-2 border-t border-gray-200">
                                        <button type="submit"
                                            class="inline-flex items-center py-2.5 px-4 font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-800">
                                            Post comment
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                            <p class="text-xs text-gray-500">Admins can view comments but cannot post.</p>
                        @endif
                    </div>

                </div>

                
            </div>

            <!-- Right Side -->
            <div class="w-1/2">
                <div class="flex-col justify-center">
                    <!-- Funding Card -->
                    <div class="w-full ml-5 p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h5 class="mb-2 text-2xl flex font-bold tracking-tight text-gray-900 dark:text-white">
                            ${{ number_format($campaign->donations_sum_amount ?? 0, 2) }}
                            <span class="ml-2 opacity-60">
                                <h5 class="text-[16px] mt-2"> of ${{ number_format($campaign->goal_amount ?? 0, 2) }}</h5>
                            </span>
                        </h5>

                        <!-- Progress Bar -->
                        @php
                            $percentage = ($campaign->goal_amount > 0)
                                ? round(($campaign->donations_sum_amount ?? 0) / $campaign->goal_amount * 100)
                                : 0;
                        @endphp
                        <div class="mt-5">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>

                            <div class="mt-5 flex">
                                <div class="w-1/2">
                                    <div class="mb-1">
                                        <span class="text-sm font-medium text-gray-500">Funded</span>
                                    </div>
                                    <span class="text-lg font-medium">{{ $percentage }}%</span>
                                </div>

                                <div class="w-1/2">
                                    <div class="mb-1">
                                        <span class="text-sm font-medium text-gray-500">Backers</span>
                                    </div>
                                    <span class="text-lg font-medium">{{ $campaign->donations_count ?? 0 }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Duration -->
                        @php
                            $deadlineDate = $campaign->deadline instanceof \Carbon\Carbon
                                ? $campaign->deadline
                                : \Carbon\Carbon::parse($campaign->deadline);
                            $daysLeft = (int) now()->diffInDays($deadlineDate, false);
                        @endphp
                        <div class="border-t mt-5 border-gray-300">
                            <div class="flex items-center gap-2 mt-3">
                                <div><x-icons.clockicon /></div>
                                <div>
                                    <h1 class="text-xl">
                                        @if ($daysLeft < 0)
                                            Expired
                                        @elseif ($daysLeft === 0)
                                            Last Day
                                        @else
                                            {{ $daysLeft }} {{ $daysLeft === 1 ? 'Day' : 'Days' }} Left
                                        @endif
                                    </h1>
                                    <h1 class="text-gray-500">
                                        Deadline {{ $deadlineDate->format('M d, Y') }}
                                    </h1>
                                </div>
                            </div>
                        </div>

                        <!-- Back this project -->
                        <div class="mt-5">
                            <button type="button"
                                class="flex justify-center items-center gap-2 w-full text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-4 focus:ring-gray-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                <span><x-icons.haticon /></span>
                                Back this Project
                            </button>
                        </div>
                    </div>

                    <!-- Recent Backers -->
                    <div class="w-full ml-5 mt-5">
                        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="mb-5 text-xl">
                                <h1>Recent Backers</h1>
                            </div>

                            @if ($campaign->donations->isEmpty())
                                <p class="text-gray-500 text-center">No backers yet.</p>
                            @else
                                @foreach ($campaign->donations->take(5) as $donation)
                                    <div class="flex items-center gap-3 border-b border-gray-300 pb-3 mb-3">
                                        <img src="{{ $donation->donor?->avatar 
                                                    ? asset('storage/' . $donation->donor->avatar)
                                                    : asset('Images/default-avatar.png') }}" 
                                            alt="Backer Avatar" 
                                            class="w-10 h-10 rounded-full object-cover">

                                        <div class="flex flex-col leading-tight">
                                            <span class="text-md font-semibold text-gray-900">
                                                {{ $donation->anonymous ? 'Anonymous Donor' : ($donation->donor?->firstname . ' ' . $donation->donor?->lastname) ?? 'Anonymous' }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                ${{ number_format($donation->amount, 2) }}
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-navbar>



{{-- <x-navbar :isCampaignDetails="true" :role="$role"> 
    <script src="//unpkg.com/alpinejs" defer></script> --}}

{{--
    <div>
        <div>
            <button type="button"
                class="text-gray-900 flex gap-2 text-center justify-center focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                onclick="window.location.href='{{ $backRoute }}'">
                <x-icons.arrowlefticon /> Back to Discover
            </button>
        </div>

        <div class="flex">
            <!-- Left Side -->
            <div class="w-1/2">
                <!-- Campaign Image -->
                <div class="bg-white border border-gray-200 shadow-sm h-100 rounded-lg">
                    <img class="w-full h-full object-cover" 
                        src="{{ $campaign->image ? asset('storage/' . $campaign->image) : asset('Images/LogoInnovAid.png') }}" 
                        alt="Campaign Image">
                </div>

                <div class="flex justify-between">
                    <div>
                        <!-- Category -->
                        <div class="mt-5">
                            <span class="bg-blue-100 text-blue-800 text-md font-medium px-2.5 py-0.5 rounded-sm">
                                {{ $campaign->category ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <!-- Title -->
                        <div>
                            <h5 class="my-5 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $campaign->title }}
                            </h5>
                        </div>

                        <!-- Creator -->
                        <div>
                            <div class="flex items-center gap-3">
                                @if($campaign->creator->avatar)
                                    <img src="{{ asset('storage/' . $campaign->creator->avatar) }}" 
                                        alt="Creator Avatar" 
                                        class="w-14 h-14 rounded-full object-cover">
                                @else
                                    <div class="w-14 h-14 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold text-xl">
                                        {{ strtoupper(substr($campaign->creator->firstname ?? 'U', 0, 1)) }}
                                    </div>
                                @endif

                                <div class="flex flex-col leading-tight">
                                    <span class="text-lg font-semibold text-gray-900">
                                        {{ $campaign->creator->firstname }} {{ $campaign->creator->lastname }}
                                    </span>
                                    <span class="text-md text-gray-500">
                                        {{ $campaign->creator->department ?? ucfirst($campaign->creator->role ?? 'Creator') }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Description / Updates / Comments -->
                <div class="mt-5" x-data="{view: 'description'}">

                    <!-- Tabs -->
                    <div class="inline-flex rounded-md shadow-xs" role="group">
                        <button @click="view = 'description'"
                            :class="view === 'description'
                                ? 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-s-lg'
                                : 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white'">
                            Description
                        </button>

                        <button @click="view = 'comments'"
                            :class="view === 'comments'
                                ? 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-e-lg'
                                : 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white'">
                            Comments
                        </button>
                    </div>

                    <!-- Description Tab -->
                    <div x-show="view === 'description'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <p class="font-normal text-gray-700 dark:text-gray-400">
                            {{ $campaign->description ?? 'No description available.' }}
                        </p>
                    </div>

                    <!-- Updates Tab -->
                    <div x-show="view === 'updates'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <p class="font-normal text-gray-700 dark:text-gray-400 text-center">
                            No updates yet — come back later!
                        </p>
                    </div>

                    <!-- Comments Tab -->
                    <div x-show="view === 'comments'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">

                        {{-- Comments List (always visible) --}}
                        <div class="space-y-4 mb-6">
                            @forelse(($campaign->comments ?? collect()) as $comment)
                                <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                                    <div class="flex items-center gap-3">
                                        @if($comment->user?->avatar)
                                            <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="w-9 h-9 rounded-full object-cover" alt="User Avatar">
                                        @else
                                            <div class="w-9 h-9 rounded-full bg-blue-600 flex items-center justify-center text-white text-sm font-semibold">
                                                {{ strtoupper(substr($comment->user?->firstname ?? 'U', 0, 1)) }}
                                            </div>
                                        @endif
                                        <div>
                                            <div class="text-sm font-semibold">{{ $comment->user?->firstname }} {{ $comment->user?->lastname }}</div>
                                            <div class="text-xs text-gray-500">{{ $comment->created_at?->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                    <div class="mt-2 text-gray-800 text-sm">{{ $comment->content }}</div>
                                </div>
                            @empty
                                <p class="text-gray-500 text-sm">No comments yet.</p>
                            @endforelse
                        </div>

                        {{-- Post form (hidden for admin) --}}
                        @if ($role !== 'admin')
                            <form method="POST" action="{{ route('campaigns.comments.store', $campaign) }}">
                                @csrf
                                <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50">
                                    <div class="px-4 py-2 bg-white rounded-t-lg">
                                        <label for="comment2" class="sr-only">Your comment</label>
                                        <textarea id="comment2" name="content" rows="3" maxlength="1000" required
                                            class="w-full px-0 text-sm text-gray-900 bg-white border-0 focus:ring-0"
                                            placeholder="Write a comment..."></textarea>
                                    </div>
                                    <div class="flex items-center justify-end px-3 py-2 border-t border-gray-200">
                                        <button type="submit"
                                            class="inline-flex items-center py-2.5 px-4 font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-800">
                                            Post comment
                                        </button>
                                    </div>
                                </div>
                            </form>
                        @else
                        @endif
                    </div>

                </div>
            </div>



                    <!-- Removed: Recent Backers section -->
                </div>
            </div>
        </div>
    </div>

