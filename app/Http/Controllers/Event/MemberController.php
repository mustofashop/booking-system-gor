<?php

namespace App\Http\Controllers\Event;

//import Model "Post
use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\Label;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;


//return type View
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

//return type redirectResponse
use Illuminate\Http\RedirectResponse;

use Illuminate\Http\Request;
use Carbon\Carbon;

class MemberController extends Controller
{
    public function index(): View
    {
        //get posts
        $data = Member::latest()->paginate(5);
        $label = Label::all();

        //render view with data
        return view('event.rider.index', compact('data', 'label'));
    }

    public function create(): View
    {
        $label = Label::all();
        return view('event.rider.create', compact('label'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            // 'code'          => 'required',
            'name'          => 'required',
            'nickname'      => 'required',
            'place'         => 'required',
            'date'          => 'required',
            'gender'        => 'required',
            'height'        => 'required',
            'weight'        => 'required',
            'address'       => 'required',
            'phone'         => 'required',
            'email'         => 'required',
            'socmed'        => 'required',
            'status'        => 'required',
            // 'created_by'    => 'required',
            // 'updated_by'    => 'required',
            'number_booking' => 'required',
            'number_identity' => 'required',
            'story'         => 'required',
            // 'banner'        => 'required',

        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $member = \App\Models\Member::latest()->first();
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
            $member->image       = $imageName;
            $member->code        = $kodeMember;
            // $member->name        = $request->input('user_id');
            $member->name        = $request->input('name');
            $member->nickname    = $request->input('nickname');
            $member->place       = $request->input('place');
            $member->date        = $request->input('date');
            $member->gender      = $request->input('gender');
            $member->height      = $request->input('height');
            $member->weight      = $request->input('weight');
            $member->address     = $request->input('address');
            $member->phone       = $request->input('phone');
            $member->email       = $request->input('email');
            $member->socmed      = $request->input('socmed');
            $member->status      = $request->input('status');
            // $member->created_by  = $request->input('created_by');
            // $member->updated_by  = $request->input('updated_by');
            $member->number_booking       = $request->input('number_booking');
            $member->number_identity      = $request->input('number_identity');
            $member->story                = $request->input('story');
            $member->user_id              = auth()->id();
            // $member->banner               = $request->input('banner');
            $member->save();
        }
        //redirect to index
        return redirect()->route('member.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show(string $id): View
    {
        //get post by ID
        $data = Member::findOrFail($id);
        $label = Label::all();

        //render view with data
        return view('event.rider.show', compact('data', 'label'));
    }

    public function edit(string $id): View
    {
        $data = Member::findOrFail($id);
        $label = Label::all();
        return view('event.rider.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
            // 'code'          => 'required',
            'name'          => 'required',
            'nickname'      => 'required',
            'place'         => 'required',
            'date'          => 'required',
            'gender'        => 'required',
            'height'        => 'required',
            'weight'        => 'required',
            'address'       => 'required',
            'phone'         => 'required',
            'email'         => 'required',
            'socmed'        => 'required',
            'status'        => 'required',
            // 'created_by'    => 'required',
            // 'updated_by'    => 'required',
            'number_booking' => 'required',
            'number_identity' => 'required',
            'story'         => 'required',
            // 'banner'        => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $member =   Member::find($id);
        if (!$member) {
            return redirect()->route('event.rider.index')->with('error', 'User not found.');
        }

        // Kode Otomatis
        $member = \App\Models\Member::latest()->first();
        $kodeMember = "R-";
        if ($member == null) {
            $kodeMember = "R-001";
        } else {
            $kodeMember = "R-" . sprintf("%03s", $member->id + 1);
        }

        //upload image
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($member->image) {
                Storage::delete('public/rider/' . $member->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('image', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $member->image = $imageName;
        }

        $member->image       = $imageName;
        $member->code        = $kodeMember;
        // $member->name        = $request->input('user_id');
        $member->name        = $request->input('name');
        $member->nickname    = $request->input('nickname');
        $member->place       = $request->input('place');
        $member->date        = $request->input('date');
        $member->gender      = $request->input('gender');
        $member->height      = $request->input('height');
        $member->weight      = $request->input('weight');
        $member->address     = $request->input('address');
        $member->phone       = $request->input('phone');
        $member->email       = $request->input('email');
        $member->socmed      = $request->input('socmed');
        $member->status      = $request->input('status');
        // $member->created_by  = $request->input('created_by');
        // $member->updated_by  = $request->input('updated_by');
        $member->number_booking       = $request->input('number_booking');
        $member->number_identity      = $request->input('number_identity');
        $member->story                = $request->input('story');
        $member->user_id              = auth()->id();
        // $member->banner               = $request->input('banner');
        $member->save();

        return redirect()->route('member.index')->with('success', 'User updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        //get post by ID
        Member::findOrFail($id)->delete();

        //redirect to index
        return redirect()->route('event.rider.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
