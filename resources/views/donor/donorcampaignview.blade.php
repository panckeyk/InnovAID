<x-navbar :isCampaignDetails="true" :role="$role">
    <script src="//unpkg.com/alpinejs" defer></script>

    <div>
        <div>
            {{-- Assuming $backRoute is passed from the controller (should be route('donor.page')) --}}
            <button type="button"
                class="text-gray-900 flex gap-2 text-center justify-center focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2 dark:bg-gray-800 dark:text-white dark:border-gray-600 dark:hover:bg-gray-700 dark:hover:border-gray-600 dark:focus:ring-gray-700"
                onclick="window.location.href='{{ $backRoute }}'">
                <x-icons.arrowlefticon /> Back to Discover
            </button>
        </div>

        <div class="flex gap-8">
            <div class="w-2/3">
                <div class="bg-white border border-gray-200 shadow-sm h-[400px] rounded-lg overflow-hidden">
                    <img class="w-full h-full object-cover"
                        src="{{ $campaign->image ? asset('storage/' . $campaign->image) : asset('Images/LogoInnovAid.png') }}"
                        alt="Campaign Image">
                </div>

                <div class="flex justify-between items-start mt-5">
                    <div>
                        <div class="mb-3">
                            <span class="bg-blue-100 text-blue-800 text-md font-medium px-2.5 py-0.5 rounded-sm">
                                {{ $campaign->category ?? 'Uncategorized' }}
                            </span>
                        </div>

                        <div>
                            <h5 class="text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $campaign->title }}
                            </h5>
                        </div>

                        <div class="mt-5">
                            <div class="flex items-center gap-3">
                                @if($campaign->creator->avatar)
                                    <img src="{{ asset('storage/' . $campaign->creator->avatar) }}"
                                        alt="Creator Avatar" class="w-14 h-14 rounded-full object-cover">
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

                <div class="mt-10" x-data="{ view: 'description' }">

                    <div class="inline-flex rounded-md shadow-sm" role="group">
                        <button @click="view = 'description'"
                            :class="view === 'description'
                                ?
                                'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-s-lg' :
                                'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white'">
                            Description
                        </button>

                        <button @click="view = 'updates'"
                            :class="view === 'updates'
                                ?
                                'px-4 py-2 text-sm font-medium text-white bg-gray-900 border-t border-b border-gray-900' :
                                'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border-t border-b border-gray-900 hover:bg-gray-900 hover:text-white'">
                            Updates
                        </button>

                        <button @click="view = 'comments'"
                            :class="view === 'comments'
                                ?
                                'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-e-lg' :
                                'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white'">
                            Comments
                        </button>
                    </div>

                    <div x-show="view === 'description'"
                        class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <p class="font-normal text-gray-700 dark:text-gray-400">
                            {{ $campaign->description ?? 'No description available.' }}
                        </p>
                    </div>

                    <div x-show="view === 'updates'" class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <p class="font-normal text-gray-700 dark:text-gray-400 text-center">
                            No updates yet — come back later!
                        </p>
                    </div>

                    <div x-show="view === 'comments'" class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <form>
                            <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="px-4 py-2 bg-white rounded-t-lg">
                                    <label for="comment" class="sr-only">Your comment</label>
                                    <textarea id="comment" rows="4"
                                        class="w-full px-0 text-sm text-gray-900 bg-white border-0 focus:ring-0 dark:text-white"
                                        placeholder="Write a comment..." required></textarea>
                                </div>
                                <div class="flex items-center justify-between px-3 py-2 border-t border-gray-200">
                                    <button type="submit"
                                        class="inline-flex items-center py-2.5 px-4 font-medium text-center text-white bg-blue-700 rounded-lg focus:ring-4 focus:ring-blue-200 hover:bg-blue-800">
                                        Post comment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>

            <div class="w-1/3 pt-10">
                <div class="flex-col justify-center sticky top-10">
                    <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md">
                        @php
                            $raisedAmount = $campaign->donations_sum_amount ?? 0;
                            $goalAmount = $campaign->goal_amount ?? 0;
                            $backersCount = $campaign->donations_count ?? 0;
                            $percentage = $goalAmount > 0 ? round(($raisedAmount / $goalAmount) * 100) : 0;
                            $deadlineDate = \Carbon\Carbon::parse($campaign->deadline);
                            $now = \Carbon\Carbon::now();
                            $daysLeft = (int) $now->diffInDays($deadlineDate, false);
                            $isExpired = $deadlineDate->isPast();
                            $canDonate = !$isExpired && $campaign->status === 'active' && $campaign->current_amount < $campaign->goal_amount;
                        @endphp

                        <h5 class="mb-4 text-2xl font-bold tracking-tight text-gray-900">
                            ${{ number_format($raisedAmount, 2) }}
                            <span class="ml-2 opacity-60 text-lg"> of ${{ number_format($goalAmount, 2) }}</span>
                        </h5>

                        <div class="mt-4">
                            <div class="w-full bg-gray-200 rounded-full h-2.5">
                                <div class="bg-blue-600 h-2.5 rounded-full"
                                    style="width: {{ min($percentage, 100) }}%"></div>
                            </div>

                            <div class="mt-5 flex justify-between text-center">
                                <div class="w-1/3">
                                    <div class="mb-1 text-sm font-medium text-gray-500">Funded</div>
                                    <span class="text-lg font-bold">{{ $percentage }}%</span>
                                </div>

                                <div class="w-1/3">
                                    <div class="mb-1 text-sm font-medium text-gray-500">Backers</div>
                                    <span class="text-lg font-bold">{{ $backersCount }}</span>
                                </div>

                                <div class="w-1/3">
                                    <div class="mb-1 text-sm font-medium text-gray-500">Days Left</div>
                                    <span class="text-lg font-bold">
                                        @if ($isExpired || $daysLeft < 0)
                                            Expired
                                        @elseif ($daysLeft == 0)
                                            Last Day
                                        @else
                                            {{ $daysLeft }}
                                        @endif
                                    </span>
                                </div>
                            </div>
                        </div>

                        <div class="mt-5 pt-5 border-t border-gray-200">
                            @if ($isExpired || !$canDonate)
                                {{-- Campaign expired or cannot accept donations --}}
                                <button type="button" disabled
                                    class="flex justify-center items-center gap-2 w-full text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-lg px-5 py-3">
                                    <span><x-icons.haticon /></span>
                                    @if ($isExpired)
                                        Campaign Has Expired
                                    @elseif ($campaign->current_amount >= $campaign->goal_amount)
                                        Funding Goal Reached
                                    @else
                                        Donations Not Available
                                    @endif
                                </button>
                            @elseif (Auth::check() && Auth::user()->role === 'donor')
                                {{-- Donor route for donation form --}}
                                <a href="{{ route('donor.create', $campaign) }}"
                                    class="flex justify-center items-center gap-2 w-full text-white bg-blue-700 hover:bg-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-lg px-5 py-3 transition duration-150 ease-in-out">
                                    <span><x-icons.haticon /></span>
                                    Back this Project
                                </a>
                            @else
                                {{-- Non-donor/Admin view placeholder --}}
                                <button type="button" disabled
                                    class="flex justify-center items-center gap-2 w-full text-white bg-gray-400 cursor-not-allowed font-medium rounded-lg text-lg px-5 py-3">
                                    <span><x-icons.haticon /></span>
                                    Log in as Donor to Back This Project
                                </button>
                            @endif
                        </div>
                    </div>

    <div class="w-full mt-5">
                        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <div class="mb-5 text-xl font-semibold text-gray-900">
                                <h1>Recent Backers</h1>
                            </div>

                            {{-- Make sure your campaign model loads the 'donations.user' relation in the controller --}}
                            @if ($campaign->donations->isEmpty())
                                <p class="text-gray-500 text-center">No backers yet.</p>
                            @else
                                @foreach ($campaign->donations->sortByDesc('created_at')->take(5) as $donation)
                                    <div
                                        class="flex items-center gap-3 border-b border-gray-200 pb-3 mb-3 last:border-b-0 last:mb-0 last:pb-0">
                                        <img src="{{ $donation->donor?->avatar
                                            ? asset('storage/' . $donation->donor->avatar)
                                            : asset('Images/default-avatar.png') }}"
                                            alt="Backer Avatar" class="w-10 h-10 rounded-full object-cover">

                                        <div class="flex flex-col leading-tight">
                                            <span class="text-md font-semibold text-gray-900">
                                                {{ $donation->anonymous ? 'Anonymous Donor' : ($donation->donor?->firstname . ' ' . $donation->donor?->lastname) ?? 'Deleted User' }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                Donated ${{ number_format($donation->amount, 2) }}
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

    {{-- Comments Section --}}
    <div class="w-full mt-5">
        <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="mb-5 text-xl font-semibold text-gray-900">
                <h1>Comments</h1>
            </div>

            @auth
                <form method="POST" action="{{ route('campaigns.comments.store', $campaign) }}" class="mb-6">
                    @csrf
                    <textarea name="content" rows="3" maxlength="1000" required
                              class="w-full border border-gray-300 rounded-lg p-3 focus:ring-blue-500 focus:border-blue-500"
                              placeholder="Write a comment..."></textarea>
                    @error('content')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <div class="mt-2 flex justify-end">
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900">Post Comment</button>
                    </div>
                </form>
            @else
                <p class="text-gray-500 mb-4">Please log in to post a comment.</p>
            @endauth

            <div class="space-y-4">
                @forelse ($campaign->comments as $comment)
                    <div class="p-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <div class="flex items-center gap-3">
                            @if($comment->user?->avatar)
                                <img src="{{ asset('storage/' . $comment->user->avatar) }}" class="w-10 h-10 rounded-full object-cover" alt="User Avatar">
                            @else
                                <div class="w-10 h-10 rounded-full bg-blue-600 flex items-center justify-center text-white font-semibold">
                                    {{ strtoupper(substr($comment->user?->firstname ?? 'U', 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <div class="text-sm font-semibold">{{ $comment->user?->firstname }} {{ $comment->user?->lastname }}</div>
                                <div class="text-xs text-gray-500">{{ $comment->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <div class="mt-3 text-gray-800">{{ $comment->content }}</div>
                    </div>
                @empty
                    <p class="text-gray-500">No comments yet.</p>
                @endforelse
            </div>
        </div>
    </div>
</x-navbar>
