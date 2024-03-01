<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Member;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class RiderController extends Controller
{
    public function index()
    {
        $label = Label::all();
        $data = Member::where('user_id', Auth::user()->id)->first();

        if (!$data) {
            $user = User::where('id', Auth::user()->id)->first();
            return view('member.rider.create', compact('label', 'user'));
        } else {
            return view('member.rider.index', compact('data', 'label'));
        }
    }

    public function update(Request $request, $id)
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

        return redirect()->route('profile.index')->with('success', 'Rider has been updated');
    }

    public function create()
    {
        $label = Label::all();
        $data = User::where('id', Auth::user()->id)->first();
        return view('member.profile.create', compact('label', 'data'));
    }

    public function store(Request $request): RedirectResponse
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
            $member->user_id = auth()->id();
            $member->created_by = strtoupper($request->user()->username);
            $member->save();
        }
        //redirect to index
        return redirect()->route('profile.index')->with(['success' => 'Rider created successfully']);
    }

}
