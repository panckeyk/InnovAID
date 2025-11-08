<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;

class CampaignsController extends Controller
{
    /**
     * Display a listing of the resource (My Campaigns Page).
     * This method is secured by Auth, showing only the current user's campaigns.
     */
    public function index(Request $request)
    {
        $creatorId = Auth::id();

        $filterStatus = $request->query('status', 'all');

        // Start building the query
        $campaignsQuery = Campaign::with('creator')
            ->where('creator_id', $creatorId);

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

        // 3. Finalize the query
        $campaigns = $campaignsQuery
            ->latest() // Order by created_at DESC
            ->paginate(10)
            ->appends(['status' => $filterStatus]); // <-- Keep the filter in pagination links

        // 4. Pass the campaigns and the active filter status to the view
        return view('user.usermycampaignpage', compact('campaigns', 'filterStatus'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // View for the campaign creation form
        return view('user.usercreatecampaignpage');
    }

    /**
     * @param \Illuminate\Http\StoreCampaignRequest $request
     */
    public function store(StoreCampaignRequest $request)
    {
        // 1. Validation
        $validatedData = $request->validated();

        // 2. File Handling
        $imagePath = $request->file('image')->store('campaign_images', 'public');
        $pdfPath = $request->hasFile('proposal_pdf')
            ? $request->file('proposal_pdf')->store('campaign_proposals', 'public')
            : null;

        // 3. Database Insertion
        $campaign = Campaign::create([
           // 'id' => Str::uuid(), // Assuming you use UUIDs as per your migration
            'creator_id' => Auth::id(),
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'category' => $validatedData['category'],
            'goal_amount' => $validatedData['goal_amount'],
            'deadline' => $validatedData['deadline'],
            'status' => 'pending', // Start as draft until the student submits it for approval
            'image' => $imagePath,
        ]);

        return redirect()->route('user.campaign')->with('success', 'Campaign draft created successfully! 🎉');
    }

    /**
     * Display the specified resource (READ).
     */
    /**
     * Display the specified resource (READ).
     */
    public function show(Campaign $campaign)
    {
        $user = Auth::user();
        $role = $user ? $user->role : 'donor'; // Default role for guests
        $isCreator = $user && $campaign->creator_id === $user->id;
        $isAdmin = ($role === 'admin');
        $isAuthorized = $isCreator || $isAdmin; 

        // 1. UNAUTHORIZED ACCESS CHECK
        // If status is not public ('active', 'completed', 'approved') and user is neither
        // the creator nor an admin, then abort.
        if (in_array($campaign->status, ['draft', 'pending', 'rejected']) && !$isAuthorized) {
            abort(404, 'Campaign Not Found.');
        }

        // 2. CREATOR REDIRECT LOGIC (Keeping your original intent)
        // If the user is the creator AND the campaign is in a non-public state (draft/pending/rejected), 
        // redirect them to the edit page to work on it.
        if ($isCreator && in_array($campaign->status, ['draft', 'pending', 'rejected'])) {
            // Note: This maintains your original redirect logic.
            return redirect()->route('campaigns.edit', $campaign); 
        }

        // 3. EAGER LOADING DATA & SETTING DYNAMIC VARIABLES
        
        // Load the creator's details (name, avatar) and count completed donations
        $campaign->load('creator'); 
        // $campaign->loadCount(['donations' => function ($query) {
        //     $query->where('payment_status', 'completed');
        // }]);

        // Determine the back button route
       // $backRoute = $isAdmin ? route('admin.admindashboard') : route('discover');

        // 4. INCREMENT VIEWS (Only for public view access)
        // Increment views only if campaign is public AND the current user is NOT an authorized user (creator/admin)
        if (in_array($campaign->status, ['active', 'approved']) && !$isAuthorized) {
            $campaign->increment('views');
        }

        // 5. RETURN THE DYNAMIC VIEW
        // The view receives the necessary variables to render the correct UI (Admin panel or Donor panel).
        return view('components.campaignpage', [ // CRITICAL: Changed view to 'campaignpage'
            'campaign' => $campaign,
            'role' => $role, 
            // 'backRoute' => $backRoute,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Campaign $campaign)
    {
        // Authorization: Only the creator can edit (and only if the status allows it)
        if ($campaign->creator_id !== Auth::id() || !in_array($campaign->status, ['draft', 'rejected'])) {
            // You may want to use a Laravel Policy for this: Gate::authorize('update', $campaign);
            abort(403, 'Unauthorized. Campaign can only be edited when in draft or rejected status.');
        }

        return view('user.usercreatecampaignpage', compact('campaign'));
    }

    /**
     * Update the specified resource in storage (UPDATE).
     */
    public function update(Request $request, Campaign $campaign)
    {
        // 1. Authorization Check (Crucial): Only creator can update, and only if status is 'draft' or 'rejected'.
        if ($campaign->creator_id !== Auth::id() || !in_array($campaign->status, ['draft', 'rejected'])) {
            abort(403, 'Unauthorized. Campaign updates are restricted in the current status.');
        }

        // Use a dedicated UpdateCampaignRequest for validation if rules differ from Store
        $data = $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'category' => 'sometimes|required|in:Technology,Education,Social Impact,Environment,Arts',
            'goal_amount' => 'sometimes|required|numeric|min:100',
            'deadline' => 'sometimes|required|date|after:today',
            'image' => 'nullable|image|max:2048', // Validation for file update
        ]);

        // 2. Handle File Upload (Image)
        if ($request->hasFile('image')) {
            if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
                Storage::disk('public')->delete($campaign->image);
            }
            // Store new image
            $data['image'] = $request->file('image')->store('campaign_images', 'public');
        }

        // If the user modified the content, it should go back to pending for approval.
        if ($campaign->status === 'rejected' || ($campaign->status === 'draft' && $request->has('submit_for_review'))) {
            $data['status'] = 'pending';
            $data['rejection_reason'] = null; // Clear previous rejection reason
            $message = 'Campaign updated and resubmitted for approval!';
        } else {
            $message = 'Campaign saved as draft.';
        }

        // 4. Update Record
        $campaign->update($data);

        return back()->with('success', $message);
    }

    /**
     * Remove the specified resource from storage (DELETE).
     */
    public function destroy(Campaign $campaign)
    {
        // 1. Authorization Check (Crucial): Only the creator can delete, and only if no donations have been made, or if it's a draft.
        if ($campaign->creator_id !== Auth::id() && Auth::user()->role !== 'admin') {
            abort(403, 'Unauthorized to delete this campaign.');
        }

        // 2. Business Rule: Prevent deletion if active/approved and has donations (optional, but recommended)
        if ($campaign->current_amount > 0 && $campaign->status !== 'draft') {
            return back()->with('error', 'Cannot delete an active campaign that has received donations. Consider setting status to "canceled".');
        }

        // 3. Delete Associated File (Image)
        if ($campaign->image && Storage::disk('public')->exists($campaign->image)) {
            Storage::disk('public')->delete($campaign->image);
        }

        // 4. Delete Record
        $campaign->delete();

        return redirect()->route('user.campaign')->with('success', 'Campaign deleted successfully!');
    }

    /**
     * Helper function to determine the redirect route based on user role.
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
