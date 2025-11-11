<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Campaign;
use App\Models\AdminAction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CampaignReviewController extends Controller
{

    /**
     * Display all campaigns for admin review
     */
    public function index(Request $request)
    {
        $status = $request->get('status', 'pending');

        $campaigns = Campaign::with('creator')
            ->when($status !== 'all', function ($query) use ($status) {
                return $query->where('status', $status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        $totalCampaignsCount = Campaign::count();
        $pendingCampaignsCount = Campaign::where('status', 'pending')->count();

        return view('admin.admindashboard', [
            'campaigns' => $campaigns, 
            'status' => $status,
            'totalCampaignsCount' => $totalCampaignsCount,
            'pendingCampaignsCount' => $pendingCampaignsCount,
        ]);
    }

    /**
     * Show detailed campaign for review
     */
    public function show(Campaign $campaign)
    {
        $campaign->load(['creator', 'donations']);

        return view('components.campaignpage', compact('campaign'));
    }

    /**
     * Approve a pending campaign
     */
    public function approve(Campaign $campaign)
    {
        $user = Auth::user();

        // 1. Security Check: Only allow pending campaigns to be approved
        if ($campaign->status !== 'pending') {
            return back()->with('error', 'Campaign status is not pending for review.');
        }

        // 2. Update the Campaign status and audit fields
        $campaign->update([
            'status' => 'approved',
            'approved_by' => $user->id,
            'approved_at' => now(),
            // Clear rejection fields if necessary
            'rejected_by' => null,
            'rejected_at' => null,
            'rejection_reason' => null,
        ]);

        // 3. Record the Admin Action (Audit Trail)
        AdminAction::create([
            'admin_id' => $user->id,
            'action_type' => 'approve_campaign',
            'target_type' => 'campaign',
            'target_id' => $campaign->id,
            'reason' => 'Campaign approved by ' . $user->name,
        ]);

        return back()->with('success', 'Campaign "' . $campaign->title . '" has been approved.');
    }

    /**
     * Reject a pending campaign with reason
     */
    public function reject(Request $request, Campaign $campaign)
    {
        // 1. Validation: Ensure a reason is provided
        $request->validate([
            'rejection_reason' => 'required|string|min:10|max:500',
        ]);

        $user = Auth::user();

        // 2. Security Check: Only allow pending campaigns to be rejected
        if ($campaign->status !== 'pending') {
            return back()->with('error', 'Campaign status is not pending for review.');
        }

        // 3. Update the Campaign status and audit fields
        $campaign->update([
            'status' => 'rejected',
            'rejected_by' => $user->id,
            'rejected_at' => now(),
            'rejection_reason' => $request->rejection_reason,
            // Clear approval fields if necessary
            'approved_by' => null,
            'approved_at' => null,
        ]);

        // 4. Record the Admin Action (Audit Trail)
        AdminAction::create([
            'admin_id' => $user->id,
            'action_type' => 'reject_campaign',
            'target_type' => 'campaign',
            'target_id' => $campaign->id,
            'reason' => $request->rejection_reason,
        ]);

        return back()->with('success', 'Campaign "' . $campaign->title . '" has been rejected.');
    }
}
