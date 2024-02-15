<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()) {
            // User is authenticated, redirect to the dashboard
            return redirect()->route('dashboard.welcome');
        } else {
            // User is not authenticated, redirect to the login page
            return redirect()->route('login');
        }
    }

    public function welcome()
    {
        $page_title = 'Dashboard';
        $page_description = 'Ini adalah halaman dashboard';
        $action = __FUNCTION__;

        return view('layout.dashboard.welcome ', compact(
            'page_title',
            'page_description',
            'action'
        ));
    }
}
