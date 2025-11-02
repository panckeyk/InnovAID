<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function layout()
    {
        return view('admin.adminlayoutpage');
    }

    public function dashboard()
    {
        return view('admin.admindashboard');
    }

    public function profile()
    {
        return view('admin.adminprofilepage');
    }
}
