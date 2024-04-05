<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Member;
use App\Models\User;
use App\Models\Nationality;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Carbon;

class RiderController extends Controller
{
    public function index()
    {
        $label = Label::all();
        $nations = Nationality::all();
        $data = Member::where('member_id', Auth::user()->id)->first();

        if (!$data) {
            $user = User::where('id', Auth::user()->id)->first();
            return view('member.rider.create', compact('label', 'user', 'nations'));
        } else {
            return view('member.rider.index', compact('data', 'label', 'nations'));
        }
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:master_members,code,' . $id,
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'number_plat' => 'required|string',
            'number_identity' => 'required|string',
            'socmed' => 'required|string',
            'banner' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'story' => 'required|string',
            'nationality_id' => 'required|string|max:1',
        ], [
            'image.max' => 'The image may not be greater than 2MB.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'banner.max' => 'The banner may not be greater than 2MB.',
            'banner.mimes' => 'The banner must be a file of type: jpeg, png, jpg, gif, svg.',
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

        // Update data banner
        if ($request->hasFile('banner')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($image->banner) {
                Storage::delete('public/rider/' . $image->banner);
            }

            $bannerFile = $request->file('banner');
            $bannerName = $bannerFile->hashName(); // Mendapatkan nama enkripsi file
            $bannerFile->storePubliclyAs('rider', $bannerName, 'public'); // Menyimpan file dengan nama spesifik
            $image->banner = $bannerName;
        }

        // Melakukan pembaruan (update) pada atribut lainnya
        $image->code                = $request->code;
        $image->name                = strtoupper($request->name);
        $image->nickname            = $request->nickname;
        $image->gender              = $request->gender;
        $image->place               = strtoupper($request->place);
        $image->date                = $request->date;
        $image->height              = $request->height;
        $image->weight              = $request->weight;
        $image->phone               = $request->phone;
        $image->email               = $request->email;
        $image->address             = $request->address;
        $image->number_plat         = $request->number_plat;
        $image->number_identity     = $request->number_identity;
        $image->socmed              = $request->socmed;
        $image->story               = $request->story;
        $image->nationality_id      = $request->nationality_id;
        $image->updated_by          = strtoupper($request->user()->username);
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
            'image' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
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
            'number_plat' => 'required|string',
            'number_identity' => 'required|string',
            'socmed' => 'required|string',
            'banner' => 'mimes:jpeg,png,jpg,gif,svg|max:2048',
            'story' => 'required|string',
            'nationality_id' => 'required|string|max:1',
        ], [
            'image.max' => 'The image may not be greater than 2MB.',
            'image.mimes' => 'The image must be a file of type: jpeg, png, jpg, gif, svg.',
            'banner.max' => 'The banner may not be greater than 2MB.',
            'banner.mimes' => 'The banner must be a file of type: jpeg, png, jpg, gif, svg.',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $member = \App\Models\Member::latest()->first();
        $date = $request->input('date');
        $year = $date ? Carbon::parse($date)->format('Y') : Carbon::now()->format('Y');

        if ($member) {
            $lastCode = $member->code;
            $lastNumber = (int)substr($lastCode, -4); // Ambil angka terakhir dari kode
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan lengkapi dengan nol di depan
            $newCode = 'RDS' . $year . $request->input('gender') . $newNumber;
        } else {
            $newCode = 'RDS' . $year . $request->input('gender') . '0001'; // Jika tidak ada kode sebelumnya, mulai dengan 0001
        }

        //upload image
        if ($request->hasFile('image')){
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('rider', $imageName, 'public'); // Menyimpan file dengan nama spesifik
        }

        if ($request->hasFile('banner')){
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $bannerFile = $request->file('banner');
            $bannerName = $bannerFile->hashName(); // Mendapatkan nama enkripsi file
            $bannerFile->storePubliclyAs('rider', $bannerName, 'public'); // Menyimpan file dengan nama spesifik
        }
        
        //create post
        $member = new Member;
        $member->image                  = $imageName;
        $member->banner                 = $bannerName;
        $member->code                   = $newCode;
        $member->name                   = strtoupper($request->input('name'));
        $member->nickname               = $request->input('nickname');
        $member->place                  = strtoupper($request->input('place'));
        $member->date                   = $request->input('date');
        $member->gender                 = $request->input('gender');
        $member->height                 = $request->input('height');
        $member->weight                 = $request->input('weight');
        $member->address                = $request->input('address');
        $member->phone                  = $request->input('phone');
        $member->email                  = $request->input('email');
        $member->number_plat            = $request->input('number_plat');
        $member->number_identity        = $request->input('number_identity');
        $member->socmed                 = $request->input('socmed');
        $member->story                  = $request->input('story');
        $member->nationality_id         = $request->input('nationality_id');
        $member->member_id              = auth()->id();
        $member->created_by             = strtoupper($request->user()->username);
        $member->save();
        
        //redirect to index
        return redirect()->route('profile.index')->with(['success' => 'Rider created successfully']);
    }

}
