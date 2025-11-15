@php
    $fundedAmount = $campaign->current_amount ?? 0;
    $goalAmount = $campaign->goal_amount ?? 1;
    $progressPercent = $goalAmount > 0 ? round(($fundedAmount / $goalAmount) * 100) : 0;
    $backersCount = 0;
    $daysLeft = (int) now()->diffInDays($campaign->deadline, false);
    $categoryClass = 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300';
@endphp

<x-navbar :isCampaignPage="true" :role="$role">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        {{-- Success/Error Messages --}}
        @if(session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <span class="font-medium">Error!</span> {{ session('error') }}
            </div>
        @endif

        <div>
            <button type="button"
                class="text-gray-900 flex gap-2 text-center justify-center focus:outline-none hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5 me-2 mb-2"
                onclick="window.location.href='{{ $role === 'admin' ? route('admin.admindashboard') : $backRoute }}'">
                ← Back to {{ $role === 'admin' ? 'Admin Dashboard' : 'Discover' }}
            </button>
        </div>

        <div class="flex flex-wrap lg:flex-nowrap gap-8 mt-5">
            {{-- Left Column --}}
            <div class="w-full lg:w-2/3">
                <div>
                    <div class="bg-white border border-gray-200 shadow-sm h-full rounded-lg aspect-video overflow-hidden">
                        <x-cloudinary::image public-id="{{ $campaign->image_public_id }}" width="80" height="40"
                        class="w-full h-full object-cover" />
                    </div>
                </div>

                <div class="flex justify-between">
                    <div>
                        <div class="mt-5">
                            @if ($role === 'admin' && $campaign->status === 'pending')
                                <span class="text-md font-medium px-2.5 py-0.5 rounded-sm bg-red-100 text-red-800">
                                    PENDING REVIEW
                                </span>
                            @else
                                <span class="text-md font-medium px-2.5 py-0.5 rounded-sm {{ $categoryClass }}">
                                    {{ $campaign->category }}
                                </span>
                            @endif
                        </div>

                        <div>
                            <h5 class="my-5 text-3xl font-bold tracking-tight text-gray-900 dark:text-white">
                                {{ $campaign->title }}
                            </h5>
                        </div>

                        <div>
                            <div class="flex items-center gap-3">
                                <img src="{{ $campaign->creator->avatar ? asset('storage/' . $campaign->creator->avatar) : 'https://flowbite.com/docs/images/people/profile-picture-5.jpg' }}"
                                    alt="Creator Avatar" class="w-14 h-14 rounded-full object-cover">
                                <div class="flex flex-col leading-tight">
                                    <span class="text-lg font-semibold text-gray-900">{{ $campaign->creator->full_name }}</span>
                                    <span class="text-md text-gray-500">{{ $campaign->creator->department ?? 'Student' }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-5">
                    <div class="inline-flex rounded-md shadow-xs" role="group">
                        <button onclick="showTab('description')" id="desc-btn"
                            class="px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-s-lg">
                            Description
                        </button>
                        <button onclick="showTab('comments')" id="comments-btn"
                            class="px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white">
                            Comments
                        </button>
                    </div>

                    <div id="description-tab" class="block p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <h2 class="text-xl font-semibold mb-4">Project Details</h2>
                        <p class="font-normal text-gray-700 dark:text-gray-400 whitespace-pre-wrap">{{ $campaign->description }}</p>
                        
                        @if ($campaign->proposal_pdf && $role === 'admin')
                            <div class="mt-5 pt-4 border-t border-gray-200">
                                <a href="{{ asset('storage/' . $campaign->proposal_pdf) }}" target="_blank"
                                   class="inline-flex items-center text-blue-600 hover:underline font-semibold">
                                    📄 View Detailed Proposal Document
                                </a>
                            </div>
                        @endif
                    </div>

                    <div id="updates-tab" class="hidden p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <p class="font-normal text-gray-700 dark:text-gray-400 text-center">No updates yet. Come back later!</p>
                    </div>

                    <div id="comments-tab" class="hidden p-6 bg-white border border-gray-200 rounded-lg mt-5">
                        <form>
                            <div class="w-full mb-4 border border-gray-200 rounded-lg bg-gray-50">
                                <div class="px-4 py-2 bg-white rounded-t-lg">
                                    <label for="comment" class="sr-only">Your comment</label>
                                    <textarea id="comment" rows="4" class="w-full px-0 text-sm text-gray-900 bg-white border-0 focus:ring-0" placeholder="Write a comment..." required></textarea>
                                </div>
                                <div class="flex items-center justify-between px-3 py-2 border-t border-gray-200">
                                    <button type="submit" class="inline-flex items-center py-2.5 px-4 font-medium text-center text-white bg-blue-700 rounded-lg hover:bg-blue-800">
                                        Post comment
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            {{-- Right Column --}}
            <div class="w-full lg:w-1/3">
                <div class="flex-col justify-center sticky top-5">
                    @if ($role === 'admin')
                        {{-- ADMIN REVIEW ACTION CARD --}}
                        <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-xl border-t-4">
                            <h3 class="mb-4 text-2xl font-bold">Review Actions</h3>

                            <form method="POST" action="{{ route('admin.campaigns.approve', $campaign->id) }}" class="mb-3">
                                @csrf
                                <button type="submit" class="flex justify-center items-center gap-2 w-full text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                    ✓ Approve Campaign
                                </button>
                            </form>

                            <button type="button" onclick="openRejectModal()" class="flex justify-center items-center gap-2 w-full text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 font-medium rounded-lg text-sm px-5 py-2.5">
                                ✕ Reject Campaign
                            </button>
                        </div>

                        <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-md mt-5">
                            <h3 class="mb-4 text-xl font-bold">Goal Details</h3>
                            <p class="text-lg font-normal text-gray-500">Goal: <span class="text-gray-900 font-semibold">${{ number_format($goalAmount, 2) }}</span></p>
                            <p class="text-lg font-normal text-gray-500 mt-2">Deadline: <span class="text-gray-900 font-semibold">{{ $campaign->deadline->format('M d, Y') }}</span></p>
                        </div>
                    @else
                        {{-- PUBLIC/STUDENT VIEW --}}
                        <div class="w-full p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                            <h5 class="mb-2 text-2xl flex font-bold tracking-tight text-gray-900">
                                ${{ number_format($fundedAmount, 0) }}
                                <span class="ml-2 opacity-60">
                                    <h5 class="text-[16px] mt-2">of ${{ number_format($goalAmount, 0) }}</h5>
                                </span>
                            </h5>

                            <div>
                                <div class="mt-5">
                                    <div class="w-full bg-gray-200 rounded-full h-2.5">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ min(100, $progressPercent) }}%"></div>
                                    </div>

                                    <div class="mt-5">
                                        <div class="flex">
                                            <div class="w-1/2">
                                                <div class="mb-1">
                                                    <span class="text-sm font-medium text-gray-500">Funded</span>
                                                </div>
                                                <div>
                                                    <span class="text-lg font-medium">{{ $progressPercent }}%</span>
                                                </div>
                                            </div>

                                            <div class="w-1/2">
                                                <div class="mb-1">
                                                    <span class="text-sm font-medium text-gray-500">Backers</span>
                                                </div>
                                                <div>
                                                    <span class="text-lg font-medium">{{ $backersCount }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="border-t mt-5 border-gray-300">
                                <div class="flex items-center gap-2 mt-3">
                                    <div>🕒</div>
                                    <div>
                                        <h1 class="text-xl">{{ $daysLeft > 0 ? $daysLeft : '0' }} Days Left</h1>
                                        <h1 class="text-gray-500">Deadline: {{ $campaign->deadline->format('M d, Y') }}</h1>
                                    </div>
                                </div>
                            </div>

                            {{-- Comments Section --}}
                            <div class="mt-8 border-t border-gray-200 pt-6">
                                <h2 class="text-2xl font-semibold mb-4">Comments</h2>

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

                        <div class="w-full mt-5">
                            <div class="block p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                                <div class="mb-5 text-xl">
                                    <h1>Recent Backers</h1>
                                </div>
                                <div>
                                    <div class="flex items-center gap-3 border-b border-gray-300 pb-3 mb-3">
                                        <img src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="Backer Avatar" class="w-10 h-10 rounded-full object-cover">
                                        <div class="flex flex-col leading-tight">
                                            <span class="text-md font-semibold text-gray-900">Alex Kumar</span>
                                            <span class="text-sm text-gray-500">$11</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Reject Modal --}}
    @if ($role === 'admin')
        <div id="rejectModal" class="hidden fixed inset-0 z-50 overflow-y-auto bg-gray-900 bg-opacity-50">
            <div class="flex items-center justify-center min-h-screen pt-4 px-4 pb-20">
                <div class="relative bg-white rounded-lg shadow-xl max-w-lg w-full">
                    <form method="POST" action="{{ route('admin.campaigns.reject', $campaign->id) }}">
                        @csrf
                        <div class="bg-white px-6 pt-6 pb-4">
                            <div class="flex justify-between items-start mb-4">
                                <h3 class="text-xl font-semibold text-gray-900">
                                    Reject Campaign
                                </h3>
                                <button type="button" onclick="closeRejectModal()" class="text-gray-400 hover:text-gray-600">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                            
                            <p class="text-sm text-gray-600 mb-4">{{ $campaign->title }}</p>
                            
                            <div>
                                <label for="rejection_reason" class="block text-sm font-medium text-gray-700 mb-2">
                                    Reason for Rejection <span class="text-red-600">*</span>
                                </label>
                                <textarea 
                                    id="rejection_reason" 
                                    name="rejection_reason" 
                                    rows="4" 
                                    required
                                    class="w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-red-500 focus:border-red-500" 
                                    placeholder="Please provide a clear reason for rejecting this campaign..."></textarea>
                            </div>
                        </div>
                        <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                            <button type="submit"
                                class="px-4 py-2 bg-red-600 text-white font-medium rounded-lg hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                                Confirm Reject
                            </button>
                            <button type="button" 
                                onclick="closeRejectModal()"
                                class="px-4 py-2 bg-white border border-gray-300 text-gray-700 font-medium rounded-lg hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-gray-500">
                                Cancel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <script>
            function openRejectModal() {
                document.getElementById('rejectModal').classList.remove('hidden');
                document.body.style.overflow = 'hidden'; // Prevent background scrolling
            }
            
            function closeRejectModal() {
                document.getElementById('rejectModal').classList.add('hidden');
                document.body.style.overflow = 'auto'; // Re-enable scrolling
            }

            // Close modal when clicking outside
            document.getElementById('rejectModal').addEventListener('click', function(e) {
                if (e.target === this) {
                    closeRejectModal();
                }
            });

            // Tab switching
            function showTab(tabName) {
                // Hide all tabs
                document.getElementById('description-tab').classList.add('hidden');
                const updatesTab = document.getElementById('updates-tab');
                if (updatesTab) updatesTab.classList.add('hidden');
                document.getElementById('comments-tab').classList.add('hidden');
                
                // Reset all buttons
                document.getElementById('desc-btn').className = 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-s-lg hover:bg-gray-900 hover:text-white';
                const updatesBtn = document.getElementById('updates-btn');
                if (updatesBtn) updatesBtn.className = 'hidden';
                document.getElementById('comments-btn').className = 'px-4 py-2 text-sm font-medium text-gray-900 bg-transparent border border-gray-900 rounded-e-lg hover:bg-gray-900 hover:text-white';
                
                // Show selected tab and highlight button
                if (tabName === 'description') {
                    document.getElementById('description-tab').classList.remove('hidden');
                    document.getElementById('desc-btn').className = 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-s-lg';
                } else if (tabName === 'comments') {
                    document.getElementById('comments-tab').classList.remove('hidden');
                    document.getElementById('comments-btn').className = 'px-4 py-2 text-sm font-medium text-white bg-gray-900 border border-gray-900 rounded-e-lg';
                }
            }
        </script>
    @endif
</x-navbar>