<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DonorController extends Controller
{
    public function layout()
    {
        return view('donor.donorlayoutpage');
    }

    public function profile()
    {
        return view('donor.donorprofilepage');
    }
}
