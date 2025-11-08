<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display the main user layout page.
     */
    public function layout()
    {
        // NOTE: The CampaignsController handles data fetching for specific lists.
        // This method should handle the main dashboard view.
        $role = Auth::check() ? Auth::user()->role : null;
        $backRoute = $this->getBackRoute($role);

        $campaigns = Campaign::with('creator')
            ->where('status', 'active') // Only show active campaigns on the main dashboard
            ->latest()
            ->take(10)
            ->get();

        return view('user.userlayoutpage', compact('role', 'backRoute', 'campaigns'));
    }

    /**
     * Display the user's campaign list page (My Campaigns Page).
     * This method now contains the campaign filtering and data fetching logic.
     */
    public function campaigns(Request $request)
    {
        $creatorId = Auth::id();

        // 1. Get the current filter status from the URL query
        $filterStatus = $request->query('status', 'all');

        // 2. Start building the query
        $campaignsQuery = Campaign::with('creator')
            ->where('creator_id', $creatorId);

        // 3. Apply status filtering logic
        if ($filterStatus !== 'all') {
            $statusesMap = [
                'active' => ['active', 'approved'],
                'pending' => ['pending'],
                'draft' => ['draft'],
                'rejected' => ['rejected'],
                'completed' => ['completed', 'canceled'],
            ];

            if (isset($statusesMap[$filterStatus])) {
                $campaignsQuery->whereIn('status', $statusesMap[$filterStatus]);
            }
        }

        // 4. Finalize the query (Pagination)
        $campaigns = $campaignsQuery
            ->latest() // Order by created_at DESC
            ->paginate(10)
            ->appends(['status' => $filterStatus]);

        // 5. Return the view with the campaign data and the active filter status
        return view('user.usermycampaignpage', compact('campaigns', 'filterStatus'));
    }

    /**
     * Display the campaign creation form.
     */
    public function createCampaign()
    {
        $role = Auth::check() ? Auth::user()->role : null;
        $backRoute = $this->getBackRoute($role);

        return view('user.usercreatecampaignpage', compact('role', 'backRoute'));
    }

    /**
     * Display the user's profile page.
     */
    public function profile()
    {
        $role = Auth::check() ? Auth::user()->role : null;
        $backRoute = $this->getBackRoute($role);

        return view('user.userprofilepage', compact('role', 'backRoute'));
    }

    /**
     * Determine the correct back route based on user role.
     */
    private function getBackRoute(?string $role): string
    {
        return match ($role) {
            'admin' => route('admin.page'),
            'donor' => route('donor.page'),
            'student', 'user' => route('user.page'),
            default => route('login'),
        };
    }
}
