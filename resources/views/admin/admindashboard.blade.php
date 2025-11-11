@php
    // Required Variables:
    // $stats: ['total_campaigns' => int, 'pending_reviews' => int, 'total_funds' => float]
    // $campaigns: Collection of Campaign models (filtered by controller)
    // $filter: ['status' => string] (current filter applied)
    // $role: 'admin'
    
    // Fallback data if variables aren't passed (for quick testing)
    $stats = $stats ?? ['total_campaigns' => 0, 'pending_reviews' => 0, 'total_funds' => 0];
    $campaigns = $campaigns ?? [];
    $filter = $filter ?? ['status' => 'pending'];
@endphp

<x-navbar :role="$role" :isAdminDashboard="true">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 mt-20 lg:px-8 py-10">
        <h1 class="text-3xl text-center font-bold text-gray-900 mb-8">Admin Dashboard</h1>

        {{-- Quick Actions --}}
        <div class="mb-6 flex gap-4">
            <a href="{{ route('admin.users.index') }}"
                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-4 focus:ring-blue-300 font-medium">
                Manage Admins
            </a>
        </div>

        {{-- 1. Stats Overview --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-10">
            
            {{-- Total Campaigns Card --}}
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-blue-500">
                <p class="text-sm font-medium text-gray-500">Total Campaigns</p>
                <p class="text-3xl font-bold text-gray-900 mt-1">{{ number_format($stats['total_campaigns']) }}</p>
            </div>
            
            {{-- Pending Review Card (Prioritized) --}}
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-red-500">
                <p class="text-sm font-medium text-gray-500">Pending Reviews</p>
                <p class="text-3xl font-bold text-red-600 mt-1">{{ number_format($stats['pending_reviews']) }}</p>
            </div>

            {{-- Total Funds Raised Card --}}
            <div class="bg-white p-6 rounded-lg shadow-md border-l-4 border-green-500">
                <p class="text-sm font-medium text-gray-500">Total Funds Raised</p>
                {{-- <p class="text-3xl font-bold text-gray-900 mt-1">${{ number_format($stats['total_funds'], 2) }}</p> --}}
            </div>
        </div>
        
        {{-- 2. Campaign Management Table --}}
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="p-6">
                <h2 class="text-2xl font-semibold text-gray-900 mb-4">Campaign Management</h2>
                
                {{-- Filter/Search/Add Section --}}
                <div class="flex flex-col md:flex-row justify-between items-center mb-6 space-y-4 md:space-y-0">
                    
                    {{-- Status Filter Form --}}
                    <form method="GET" action="{{ route('admin.admindashboard') }}" class="w-full md:w-auto flex space-x-2">
                        <select name="status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50">
                            <option value="pending" {{ $filter['status'] === 'pending' ? 'selected' : '' }}>Pending Review</option>
                            <option value="active" {{ $filter['status'] === 'active' ? 'selected' : '' }}>Active Campaigns</option>
                            <option value="approved" {{ $filter['status'] === 'approved' ? 'selected' : '' }}>Approved Campaigns</option>
                            <option value="rejected" {{ $filter['status'] === 'rejected' ? 'selected' : '' }}>Rejected Campaigns</option>
                            <option value="all" {{ $filter['status'] === 'all' ? 'selected' : '' }}>All Campaigns</option>
                        </select>
                        <button type="submit" class="px-4 py-2 bg-gray-800 text-white rounded-md hover:bg-gray-900">Filter</button>
                    </form>
                    
                
                </div>
            </div>

            {{-- Table --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title / Creator</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Goal / Raised</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse ($campaigns as $campaign)
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                                    {{ Str::limit($campaign->title, 40) }}
                                    <div class="text-xs text-gray-500">by {{ $campaign->creator->name ?? 'N/A' }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ $campaign->category }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        // Dynamic badge color based on campaign status
                                        $badgeColor = [
                                            'pending' => 'bg-yellow-100 text-yellow-800',
                                            'approved' => 'bg-green-100 text-green-800',
                                            'rejected' => 'bg-red-100 text-red-800',
                                            'active' => 'bg-blue-100 text-blue-800',
                                            'draft' => 'bg-gray-100 text-gray-800',
                                        ][$campaign->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $badgeColor }}">
                                        {{ ucfirst($campaign->status) }}
                                    </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    ${{ number_format($campaign->current_amount, 0) }} / ${{ number_format($campaign->goal_amount, 0) }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    {{-- Link to the campaign page for review/details --}}
                                    <a href="{{ route('campaigns.show', $campaign->id) }}" 
                                        class="font-semibold {{ $campaign->status === 'pending' ? 'text-red-600 hover:text-red-900' : 'text-indigo-600 hover:text-indigo-900' }}">
                                        {{ $campaign->status === 'pending' ? 'Review Campaign' : 'View Details' }}
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-4 text-center text-gray-500">No campaigns found with status **'{{ $filter['status'] }}'**.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            {{-- Pagination (Placeholder) --}}
            <div class="p-4 border-t border-gray-200">
                <!-- <p class="text-sm text-gray-500 text-center">Pagination Placeholder</p> -->
            </div>
        </div>
    </div>
</x-navbar>