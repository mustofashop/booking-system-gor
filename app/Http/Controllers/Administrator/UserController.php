<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Permission;
use App\Models\SetupPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $data = User::paginate(10);
        $label = Label::all();
        return view('admin.user.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $permission = Permission::all();
        return view('admin.user.create', compact('permission', 'label'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:master_users',
            'email' => 'required|email|unique:master_users',
            'phone' => 'required|numeric|unique:master_users',
            'password' => 'required|min:8|confirmed',
            'permission' => 'required',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, simpan data user baru
        $user = new User;
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->password = Hash::make($request->input('password'));
        $user->permission = $request->input('permission');
        $user->status = $request->input('status');
        $user->save();

        // Cek peran pengguna
        $userPermissions = Permission::where('level', $user->permission)->first();
        // Buat setup permission untuk user
        SetupPermission::create([
            'user_id' => $user->id,
            'permission_id' => $userPermissions->id,
        ]);

        // Redirect ke halaman lain dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'User created successfully.');
    }

    public function show($id)
    {
        $data = User::findOrFail($id);
        return view('admin.user.show', compact('data'));
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        $label = Label::all();
        $permission = Permission::all();
        return view('admin.user.edit', compact('data', 'permission', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'username' => 'required|unique:master_users,username,' . $id,
            'email' => 'required|email|unique:master_users,email,' . $id,
            'phone' => 'required',
            'permission' => 'required',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('user.index')->with('error', 'User not found.');
        }

        // Update data user
        $user->name = $request->input('name');
        $user->username = $request->input('username');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->permission = $request->input('permission');
        $user->status = $request->input('status');
        $user->save();

        // Cek peran pengguna
        $userPermissions = Permission::where('level', $user->permission)->first();
        // Update setup permission untuk user
        SetupPermission::where('user_id', $user->id)->update([
            'permission_id' => $userPermissions->id,
        ]);

        // Cek reset_password
        if ($request->input('reset_password') === "true") {
            $user->password = Hash::make($request->input('password'));
            $user->save();
        }

        // Redirect ke halaman lain dengan pesan sukses
        return redirect()->route('user.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id)
    {
        // Temukan pengguna berdasarkan ID
        $user = User::findOrFail($id);

        // Hapus setup permission untuk user
        SetupPermission::where('user_id', $user->id)->delete();

        // Hapus data pengguna dari database
        $deleted = $user->delete();

        if ($deleted) {
            $success = true;
            $message = "User deleted successfully!";
        } else {
            $success = false;
            $message = "Failed to delete user!";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }


}
