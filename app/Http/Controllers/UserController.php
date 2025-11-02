<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function layout()
    {
        return view('user.userlayoutpage');
    }

    public function myCampaign()
    {
        return view('user.usermycampaignpage');
    }

    public function createCampaign()
    {
        return view('user.usercreatecampaignpage');
    }

    public function profile()
    {
        return view('user.userprofilepage');
    }
}
