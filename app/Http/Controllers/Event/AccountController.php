<?php

namespace App\Http\Controllers\Event;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Member;
use App\Models\Permission;
use App\Models\SetupPermission;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function index()
    {
        $data = User::where('permission', 'MEMBER')->paginate(10);
        $label = Label::all();
        return view('event.user.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $permission = Permission::where('level', 'MEMBER')->get();
        return view('event.user.create', compact('permission', 'label'));
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

    public function add($id)
    {
        $user = User::findOrFail($id);
        $label = Label::all();
        return view('event.user.add', compact('user', 'label'));
    }

    public function storeProfile(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'name' => 'required',
            'nickname' => 'required|unique:master_members,nickname',
            'place' => 'required',
            'date' => 'required',
            'gender' => 'required',
            'height' => 'required',
            'weight' => 'required',
            'address' => 'required',
            'phone' => 'required',
            'email' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $member = Member::latest()->first();
        $kodeMember = "R-";
        if ($member == null) {
            $kodeMember = "R-001";
        } else {
            $kodeMember = "R-" . sprintf("%03s", $member->id + 1);
        }

        //upload image
        if ($request->hasFile('image')) {
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('rider', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            //create post
            $member = new Member;
            $member->image = $imageName;
            $member->code = $kodeMember;
            $member->name = strtoupper($request->input('name'));
            $member->nickname = $request->input('nickname');
            $member->place = strtoupper($request->input('place'));
            $member->date = $request->input('date');
            $member->gender = $request->input('gender');
            $member->height = $request->input('height');
            $member->weight = $request->input('weight');
            $member->address = $request->input('address');
            $member->phone = $request->input('phone');
            $member->email = $request->input('email');
            $member->member_id = $request->input('member_id');
            $member->created_by = strtoupper($request->user()->username);
            $member->save();
        }
        //redirect to index
        return redirect()->route('user.index')->with(['success' => 'Rider created successfully']);
    }

    public function show($id)
    {
        $data = Member::where('member_id', $id)->first();
        $label = Label::all();
        return view('event.user.show', compact('data', 'label'));
    }

    public function updateProfile(Request $request, $id)
    {
// Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:master_members,code,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'nickname' => 'required|string|unique:master_members,nickname,' . $id,
            'gender' => 'required|string|max:1',
            'place' => 'required|string|max:255',
            'date' => 'required|date',
            'height' => 'required|numeric',
            'weight' => 'required|numeric',
            'phone' => 'required|numeric',
            'email' => 'required|string|email',
            'address' => 'required|string',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $image = Member::findOrFail($id);
        if (!$image) {
            return redirect()->route('profile.index')->with('error', 'Rider not found');
        }

        // Update data
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($image->image) {
                Storage::delete('public/rider/' . $image->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('rider', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $image->image = $imageName;
        }

        // Melakukan pembaruan (update) pada atribut lainnya
        $image->code = $request->code;
        $image->name = strtoupper($request->name);
        $image->nickname = $request->nickname;
        $image->gender = $request->gender;
        $image->place = strtoupper($request->place);
        $image->date = $request->date;
        $image->height = $request->height;
        $image->weight = $request->weight;
        $image->phone = $request->phone;
        $image->email = $request->email;
        $image->address = $request->address;
        $image->updated_by = strtoupper($request->user()->username);
        $image->save();

        return redirect()->route('user.index')->with('success', 'Rider has been updated');
    }

    public function edit($id)
    {
        $data = User::findOrFail($id);
        $label = Label::all();
        $permission = Permission::where('level', 'MEMBER')->get();
        return view('event.user.edit', compact('data', 'permission', 'label'));
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
        $user->updated_by = strtoupper($request->user()->username);
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

        // Hapus data rider
        Member::where('member_id', $user->id)->delete();

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
