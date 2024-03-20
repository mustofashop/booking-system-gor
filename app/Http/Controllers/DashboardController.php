<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Permission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

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

    public function show()
    {
        $page_title = 'Profile';
        $page_description = 'Ini adalah halaman profile';
        $action = __FUNCTION__;

        $label = Label::all();

        $data = User::where('id', auth()->user()->id)->first();

        $permission = Permission::where('status', 'ACTIVE')->get();

        return view('layout.dashboard.account ', compact(
            'page_title',
            'page_description',
            'action',
            'label',
            'data',
            'permission'
        ));
    }

    public function reset(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = User::find($id);

        if (password_verify($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('account')->with('success', 'Password has been changed');
        } else {
            return redirect()->route('account')->with('error', 'Old password is wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('account')->with('success', 'Profile has been updated');
    }
}
