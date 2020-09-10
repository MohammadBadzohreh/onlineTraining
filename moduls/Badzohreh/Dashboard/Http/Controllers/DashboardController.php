<?php


namespace Badzohreh\Dashboard\Http\Controllers;

use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('Dashboard::index');
    }
}