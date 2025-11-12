<x-navbar :isAdminProfile="true">
    <div class="max-w-6xl mx-auto px-6">
        @if (session('success'))
            <div class="mb-4 p-4 text-sm text-green-800 rounded-lg bg-green-50" role="alert">
                <span class="font-medium">Success!</span> {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="mb-4 p-4 text-sm text-red-800 rounded-lg bg-red-50" role="alert">
                <span class="font-medium">Please correct the following errors:</span>
                <ul class="mt-1.5 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        <!-- Profile Section -->
        <div class="mt-8 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="flex flex-wrap gap-6 items-center">
                
                <!-- Profile Picture -->
                <div class="relative shrink-0 h-40 w-40 rounded-full overflow-hidden border-2 border-gray-300 cursor-pointer group">
                   
                        <div class="h-full w-full flex items-center justify-center bg-blue-600 text-white text-5xl font-bold">
                            {{ strtoupper(substr(Auth::user()->firstname ?? Auth::user()->name ?? 'A', 0, 1)) }}
                        </div>
                    
                </div>

                <!-- Profile Information -->
                <div x-data="{ view: 'information' }" class="flex-1 flex justify-between items-start flex-wrap gap-4">

                    <!-- Information Display -->
                    <div x-show="view === 'information'" class="flex-1">
                        <h1 class="text-4xl font-semibold">{{ Auth::user()->firstname }} {{ Auth::user()->lastname }}</h1>
                        <h1 class="text-2xl text-gray-500">{{ Auth::user()->email }}</h1>

                        <div class="mt-5">
                            <h1 class="text-gray-500">Member Since</h1>
                            <h1 class="text-xl">{{ Auth::user()->created_at->format('F Y') }}</h1>
                        </div>
                        
                        <div class="mt-3">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-purple-100 text-purple-800">
                                <svg class="w-4 h-4 mr-1.5" fill="currentColor" viewBox="0 0 20 20">
                                    <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"/>
                                </svg>
                                Administrator
                            </span>
                        </div>
                    </div>

                    <!-- Edit Information Form -->
                    <div x-show="view === 'EditInformation'" class="flex-1">
                        <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            
                            <!-- Avatar Upload -->
                            <div class="mb-4">
                               
                            </div>
                            
                            <div class="grid gap-6 mb-6 md:grid-cols-2">
                                <div>
                                    <label for="firstname" class="block mb-2 text-sm font-medium text-gray-900">First Name</label>
                                    <input type="text" id="firstname" name="firstname" value="{{ Auth::user()->firstname }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" 
                                        required maxlength="35" />
                                </div>

                                <div>
                                    <label for="lastname" class="block mb-2 text-sm font-medium text-gray-900">Last Name</label>
                                    <input type="text" id="lastname" name="lastname" value="{{ Auth::user()->lastname }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" 
                                        required maxlength="35" />
                                </div>

                                <div>
                                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900">Email</label>
                                    <input type="email" id="email" name="email" value="{{ Auth::user()->email }}"
                                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 w-full p-2.5" 
                                        required />
                                </div>
                            </div>

                            <div class="flex gap-2">
                                <button type="submit"
                                    class="text-white bg-gray-800 hover:bg-gray-900 rounded-lg text-sm px-5 py-2.5">Save</button>
                                <button type="button" @click="view = 'information'"
                                    class="text-gray-900 bg-white border border-gray-300 hover:bg-gray-100 rounded-lg text-sm px-5 py-2.5">Cancel</button>
                            </div>
                        </form>
                    </div>

                    <!-- Edit Button -->
                    <div class="flex flex-col gap-2">
                        <button x-show="view === 'information'" @click="view = 'EditInformation'" type="button"
                            class="text-gray-900 flex items-center gap-2 bg-white border border-gray-300 hover:bg-gray-100 font-medium rounded-lg text-sm px-5 py-2.5">
                            <x-icons.editicon /> Edit
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Admin Statistics Cards -->
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-6 mt-8">
            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Total Campaigns</h5>
                <div class="flex gap-4 items-center">
                    <svg class="w-10 h-10 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
                    </svg>
                    <h1 class="text-4xl font-bold">{{ $totalCampaigns }}</h1>
                </div>
            </div>

            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Pending Reviews</h5>
                <div class="flex gap-4 items-center">
                    <svg class="w-10 h-10 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h1 class="text-4xl font-bold">{{ $pendingCampaigns }}</h1>
                </div>
            </div>

            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Active Campaigns</h5>
                <div class="flex gap-4 items-center">
                    <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    <h1 class="text-4xl font-bold">{{ $activeCampaigns }}</h1>
                </div>
            </div>

            <div class="p-5 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-lg">Total Users</h5>
                <div class="flex gap-4 items-center">
                    <svg class="w-10 h-10 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <h1 class="text-4xl font-bold">{{ $totalUsers }}</h1>
                </div>
            </div>
        </div>

        <!-- Recent Admin Actions -->
        <div class="mt-8">
            <h1 class="text-2xl font-semibold">Recent Actions</h1>
        </div>

        <div class="mt-5 p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
            <div class="mb-4">
                <h1 class="font-semibold text-lg">Your Recent Activity</h1>
                <h1 class="text-gray-500">Campaign approvals, rejections, and other admin actions</h1>
            </div>

            @if($recentActions->isEmpty())
                <div class="text-center py-8 text-gray-500">
                    <p>No recent actions to display.</p>
                </div>
            @else
                <div class="space-y-4">
                    @foreach($recentActions as $action)
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-lg flex justify-between items-center">
                            <!-- Action Details -->
                            <div class="flex-1">
                                <div class="flex items-center gap-2">
                                    @if($action->action === 'approved')
                                        <span class="px-2 py-1 bg-green-100 text-green-800 rounded text-sm font-medium">Approved</span>
                                    @elseif($action->action === 'rejected')
                                        <span class="px-2 py-1 bg-red-100 text-red-800 rounded text-sm font-medium">Rejected</span>
                                    @else
                                        <span class="px-2 py-1 bg-blue-100 text-blue-800 rounded text-sm font-medium">{{ ucfirst($action->action) }}</span>
                                    @endif
                                    
                                    <span class="text-gray-700 font-medium">
                                        Campaign: {{ $action->campaign->title ?? 'Unknown' }}
                                    </span>
                                </div>
                                
                                <p class="text-sm text-gray-500 mt-1">
                                    {{ $action->created_at->diffForHumans() }}
                                </p>

                                @if($action->notes)
                                    <p class="text-gray-600 mt-2 text-sm italic">
                                        Note: "{{ $action->notes }}"
                                    </p>
                                @endif
                            </div>

                            <!-- Action Link -->
                            @if($action->campaign)
                                <a href="{{ route('campaigns.show', $action->campaign) }}" 
                                   class="ml-4 text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    View Campaign →
                                </a>
                            @endif
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

    </div>
</x-navbar>

<!-- Alpine.js -->
<script src="//unpkg.com/alpinejs" defer></script>

<script>
    function previewAvatar(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById('avatar-preview');
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }
</script>