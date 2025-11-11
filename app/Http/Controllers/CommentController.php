<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    public function store(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'content' => 'required|string|min:1|max:1000',
        ]);

        Comment::create([
            'campaign_id' => $campaign->id,
            'user_id' => Auth::id(),
            'content' => $validated['content'],
        ]);

        return back()->with('success', 'Comment posted.');
    }
}


