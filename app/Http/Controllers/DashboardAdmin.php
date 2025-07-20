<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardAdmin extends Controller
{
    public function index()
    {
        $nav = $this->sections();
        return view('admin.dashboard', compact('nav'));
    }
}
