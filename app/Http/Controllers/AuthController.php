<?php

namespace App\Http\Controllers;

use App\Models\Button;
use App\Models\Label;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

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
            $errorMessage = 'Akun tidak ditemukan';
        } elseif ($user->status == 'INACTIVE') {
            // Akun tidak aktif
            $errorMessage = 'Akun tidak aktif, silahkan hubungi admin';
        } elseif (!Hash::check($password, $user->password)) {
            // Password tidak cocok
            $errorMessage = 'Password salah';
        } else {
            // Login berhasil
            Auth::login($user);

            // Periksa peran pengguna setelah login
            $userRoles = $user->permission; // Anda harus memiliki relasi permission pada model User

//            echo json_encode($userRoles);
//            die();

            if (!$userRoles) {
                // Pengguna tidak memiliki peran, kirim pesan kesalahan
                $errorMessage = 'Anda tidak memiliki hak akses, silahkan hubungi admin';
            } else {
                if ($userRoles === 'ADMIN') {
                    // Pengguna memiliki peran "ADMIN", atur menu yang sesuai untuk ADMIN
                    return redirect()->intended(route('dashboard'));
                } elseif ($userRoles === 'EVENT') {
                    // Pengguna memiliki peran "EVENT", atur menu yang sesuai untuk EVENT
                    return redirect()->intended(route('dashboard'));
                } elseif ($userRoles === 'MEMBER') {
                    // Pengguna memiliki peran "MEMBER", atur menu yang sesuai untuk MEMBER
                    return redirect()->intended(route('dashboard'));
                } else {
                    // Pengguna memiliki peran yang tidak dikenali, kirim pesan kesalahan
                    $errorMessage = 'Hak akses tidak dikenali, silahkan hubungi admin';
                }
            }
        }

        // Jika ada kesalahan, kirim pesan kesalahan sesuai kondisi
        return redirect()->back()->withInput()->withErrors([
            'login_failed' => $errorMessage,
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout(); // Logout user
        $request->session()->invalidate(); // Invalidate session data
        $request->session()->regenerateToken(); // Regenerate CSRF token

        return redirect()->route('login'); // Redirect to login page
    }
}
