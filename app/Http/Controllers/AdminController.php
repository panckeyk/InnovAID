<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\User;
use App\Models\AdminAction; // Assuming this model exists
use App\Models\Donation;   // CRITICAL: New model import for total funds
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth; // CRITICAL: New import for approve/reject actions
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display admin layout page
     */
    public function layout()
    {
        $approvedCampaigns = Campaign::with('creator')
            ->whereIn('status', ['approved', 'active'])
            // ->withCount(['donations' => function ($query) {
            //     $query->where('payment_status', 'completed');
            // }])
            ->orderBy('created_at', 'desc')
            ->get();

        // Return a view (you might name this file 'admin.approved_campaigns.blade.php')
        return view('admin.adminlayoutpage', [
            'campaigns' => $approvedCampaigns,
            'role' => 'admin',
        ]);
    }

    public function showCampaignDetails($id)
    {
        // $campaign = Campaign::with(['creator', 'donations' => function ($query) {
        //     $query->where('payment_status', 'completed');
        // }])->findOrFail($id);

        $campaign = Campaign::with('creator')->findOrFail($id);

        $backRoute = route('approved.index'); // go back to layout page

        return view('components.campaigndetails', [
            'campaign' => $campaign,
            'role' => 'admin',
            'backRoute' => $backRoute,
        ]);
    }

    public function dashboard(Request $request)
    {
        // 1. Get Filter
        $statusFilter = $request->query('status', 'pending');

        // 2. Calculate Statistics
        $stats = [
            'total_campaigns' => Campaign::count(),
            // Maps to the card in admindashboard.blade.php
            'pending_reviews' => Campaign::where('status', 'pending')->count(),
            'approved_campaigns' => Campaign::where('status', 'approved')->count(),
            'rejected_campaigns' => Campaign::where('status', 'rejected')->count(),
            'total_users' => User::where('role', 'student')->count(),
            'total_donors' => User::where('role', 'donor')->count(),

            // CRITICAL: Total funds raised
            //'total_funds' => Donation::where('payment_status', 'completed')->sum('net_amount'),
        ];

        // 3. Fetch Filtered Campaigns for the main table
        $campaignsQuery = Campaign::query();

        if ($statusFilter !== 'all') {
            $campaignsQuery->where('status', $statusFilter);
        }

        // Eager load the creator relationship for the table
        $campaigns = $campaignsQuery
            ->with('creator') // Selects only id and name from the related user
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        // Get recent admin actions (optional - remove if not needed)
        // Ensure AdminAction model exists for this to work
        $recentActions = AdminAction::with('admin')
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        return view('admin.admindashboard', [
            'stats' => $stats,
            'campaigns' => $campaigns,
            'filter' => ['status' => $statusFilter], // Current active filter for the dropdown
            'role' => 'admin', // Pass role for navbar/layout context
            'recentActions' => $recentActions,
            // 'recentPending' is no longer needed as the full list of $campaigns is filtered by 'pending' by default.
        ]);
    }

    /**
     * Approve the specified campaign and set status to 'active'.
     */
    public function approve(Campaign $campaign)
    {
        // Security check: Only allow approval if the campaign is pending
        if ($campaign->status !== 'pending') {
            return back()->with('error', 'Campaign cannot be approved as it is not pending review.');
        }

        $campaign->update([
            'status' => 'active',
            'approved_by' => Auth::id(),
            'approved_at' => now(),
        ]);

        // Log admin action here if needed (e.g., AdminAction::create([...])); 

        return redirect()->route('admin.admindashboard', ['status' => 'active'])
            ->with('success', "Campaign '{$campaign->title}' has been successfully approved.");
    }

    /**
     * Reject the specified campaign and store the reason.
     */
    public function reject(Request $request, Campaign $campaign)
    {
        $request->validate([
            'rejection_reason' => 'required|string|min:10',
        ]);

        // Security check: Only allow rejection if the campaign is pending
        if ($campaign->status !== 'pending') {
            return back()->with('error', 'Campaign cannot be rejected as it is not pending review.');
        }

        $campaign->update([
            'status' => 'rejected',
            'rejected_by' => Auth::id(),
            'rejected_at' => now(),
            'rejection_reason' => $request->rejection_reason,
        ]);

        // Log admin action here if needed (e.g., AdminAction::create([...])); 

        return redirect()->route('admin.admindashboard', ['status' => 'rejected'])
            ->with('success', "Campaign '{$campaign->title}' has been rejected.");
    }

    // The rest of your existing methods...
    public function profile()
    {
        $admin = Auth::user();

        // Get campaign statistics
        $totalCampaigns = Campaign::count();
        $pendingCampaigns = Campaign::where('status', 'pending')->count();
        $activeCampaigns = Campaign::whereIn('status', ['active', 'approved'])->count();
        $totalUsers = \App\Models\User::count();

        // Get recent admin actions (assuming you have an AdminAction model)
        // If you don't have this model yet, just use an empty collection
        $recentActions = collect([]); // Empty for now

        // If you have an AdminAction model:
        // $recentActions = \App\Models\AdminAction::where('admin_id', $admin->id)
        //     ->with('campaign')
        //     ->orderBy('created_at', 'desc')
        //     ->take(10)
        //     ->get();

        return view('admin.adminprofilepage', compact(
            'totalCampaigns',
            'pendingCampaigns',
            'activeCampaigns',
            'totalUsers',
            'recentActions'
        ));
    }

    public function updateProfile(Request $request)
    {
        $validated = $request->validate([
            'firstname' => 'required|string|max:35|regex:/^[A-Za-z\s]+$/',
            'lastname' => 'required|string|max:35|regex:/^[A-Za-z\s]+$/',
            'email' => 'required|email|unique:users,email,' . Auth::id(),
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif,webp|max:5120',
        ], [
            'firstname.regex' => 'First name should only contain letters and spaces.',
            'lastname.regex' => 'Last name should only contain letters and spaces.',
        ]);

        // Handle avatar upload
        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if (Auth::user()->avatar && Storage::disk('public')->exists(Auth::user()->avatar)) {
                Storage::disk('public')->delete(Auth::user()->avatar);
            }
            $validated['avatar'] = $request->file('avatar')->store('avatars', 'public');
        }

        Auth::user()->update($validated);

        return redirect()->route('admin.profile')
            ->with('success', 'Profile updated successfully!');
    }

    public function index()
    {
        return $this->layout();
    }
}
