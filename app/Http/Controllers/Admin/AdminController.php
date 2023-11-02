<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

class AdminController extends Controller
{
    public function __construct()
    {
        return $this->middleware('auth');
    }

    public function dashboard()
    {
        return view('admin.index');
    }
}
