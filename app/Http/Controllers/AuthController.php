<?php

namespace App\Http\Controllers;

use App\Models\Button;
use App\Models\Label;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()) {
            return redirect()->route('dashboard');
        } else {
            return redirect()->route('login');
        }
    }

    public function showLoginForm()
    {

        if (Auth::check()) {
            return redirect()->route('dashboard'); // Redirect to dashboard if user already logged in
        }

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        return view('auth.login', compact('label', 'button')
        );
    }

    public function login(Request $request)
    {
        $username = $request->input('email');
        $password = $request->input('password');

        $user = User::with('permissions')->where('email', $username)->first();

        if (!$user) {
            // Username tidak ditemukan
            return redirect()->back()->withInput()->withErrors(['error' => 'Account not found']);
        } elseif ($user->status === 'INACTIVE') {
            // Akun tidak aktif
            return redirect()->back()->withInput()->withErrors(['error' => 'Account is not active']);
        } elseif (!Hash::check($password, $user->password)) {
            // Password tidak cocok
            return redirect()->back()->withInput()->withErrors(['error' => 'Password is incorrect']);
        } else {
            // Login berhasil
            Auth::login($user);

            // Periksa peran pengguna setelah login
            $userRoles = $user->permissions; // Perlu diubah menjadi permissions

            if (!$userRoles) {
                // Pengguna tidak memiliki peran
                return redirect()->back()->withInput()->withErrors(['error' => 'User does not have any permission']);
            } else {
                // Redirect sesuai peran pengguna
                if ($userRoles->contains('ADMIN')) {
                    return redirect()->intended(route('dashboard.admin'));
                } elseif ($userRoles->contains('EVENT')) {
                    return redirect()->intended(route('dashboard.event'));
                } elseif ($userRoles->contains('MEMBER')) {
                    return redirect()->intended(route('dashboard.member'));
                } else {
                    // Pengguna memiliki peran yang tidak dikenali
                    return redirect()->back()->withInput()->withErrors(['error' => 'User has an unknown permission']);
                }
            }
        }
    }


    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Invalidate session data
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect()->route('login'); // Redirect to login page
    }

    public function showRegisterForm()
    {
        if (Auth::check()) {
            return redirect()->route('dashboard'); // Redirect to dashboard if user already logged in
        }

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        return view('auth.register', compact('label', 'button')
        );
    }

    public function register(Request $request)
    {
        // Validasi data input
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:master_users'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:master_users'],
            'phone' => ['required', 'string', 'max:15', 'unique:master_users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Buat user baru
        try {
            $user = User::create([
                'name' => $request->input('name'),
                'username' => $request->input('username'),
                'email' => $request->input('email'),
                'phone' => $request->input('phone'),
                'password' => Hash::make($request->input('password')),
                'permission' => 'MEMBER', // Atur peran pengguna sebagai 'MEMBER'
                'status' => 'INACTIVE', // Atur status pengguna sebagai 'INACTIVE'
            ]);
        } catch (\Exception $e) {
            // Jika terjadi kesalahan saat pembuatan user
            return redirect()->back()->withInput()->with('error', 'Failed to create user! ' . $e->getMessage());
        }

        // Tampilkan pesan sukses dan redirect ke halaman login
        return redirect()->route('login')->with('success', 'User created successfully! Please login to continue');
    }
}
