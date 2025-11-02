<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CampaignController extends Controller
{
    public function showCampaignPage()
    {
        $role = Auth::check() ? Auth::user()->role : null;

        $backRoute = match ($role) {
            'admin' => route('admin.page'),
            'donor' => route('donor.page'),
            'student', 'user' => route('user.page'),
            default => route('loginpage'),
        };

        return view('components.campaignpage', compact('role', 'backRoute'));
    }
}
