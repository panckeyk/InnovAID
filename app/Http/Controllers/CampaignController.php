<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCampaignRequest;
use App\Models\Campaign;
use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function showCampaignPage(Campaign $campaign)
    {
        $campaign = Campaign::where('creator_id', Auth::id())
                              // Order them by the most recently created
                              ->with('creator')
                              ->latest() 
                              ->take(5)
                              ->get();
      
        $role = Auth::check() ? Auth::user()->role : null;

        $backRoute = match ($role) {
            'admin' => route('admin.page'),
            'donor' => route('donor.page'),
            'student', 'user' => route('user.page'),
            default => route('loginpage'),
        };

        return view('components.campaignpage', compact('campaign', 'role', 'backRoute'));
    }
    
    /**
     * @param \App\Http\Requests\StoreCampaignRequest $request
     */

    public function store(StoreCampaignRequest $request)
    {
        // Validation and Authorization passed automatically by the StoreCampaignRequest    

        // Retrieve validated data
        $validatedData = $request->validated();

        // Handle File Uploads (Example)
       $imagePath = null;
        // Use the global request() helper for reliable file handling
        if (request()->hasFile('image')) {
            // Handle File Uploads: stores the file and returns the path (e.g., 'campaign_images/filename.jpg')
            $imagePath = request()->file('image')->store('campaign_images', 'public');
        }

        // Create the campaign record
        Campaign::create([
            'creator_id' => Auth::id(), // Use the logged-in user's UUID
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            // ... map other validated fields
            'image' => $imagePath, // Store the path
            'status' => 'pending', // New campaigns start as pending for admin approval
            // The HasUuid trait automatically generates the 'id' UUID here
        ]);

        return redirect()->route('user.campaign')->with('success', 'Campaign submitted for approval!');
        return view('components.campaignpage', compact('role', 'backRoute'));
    }
}
