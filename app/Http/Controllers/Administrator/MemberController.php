<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Member;
use App\Models\User;
use App\Models\Label;
use App\Models\Nationality;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MemberController extends Controller
{
    public function index(): View
    {
        //get posts
        $data           = Member::latest()->paginate(5);
        $label          = Label::all();
        $nations        = Nationality::all();

        //render view with data
        return view('event.rider.index', compact('data', 'label', 'nations'));
    }

    public function create(): View
    {
        $label      = Label::all();
        $member     = User::where('permission', 'MEMBER')->get();
        $nations    = Nationality::all();
        return view('event.rider.create', compact('label', 'member', 'nations'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image'         => 'required|image|mimes:jpeg,jpg,png|max:2048',
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
            'number_booking' => 'required',
            'number_plat' => 'required',
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
        $date = Carbon::now(); // Misalnya, objek Carbon yang sudah ada
        $year = $date->year;

        if ($member) {
            $lastCode = $member->code;
            $lastNumber = (int)substr($lastCode, -4); // Ambil angka terakhir dari kode
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan lengkapi dengan nol di depan
            $newCode = 'RDS' . $year . $request->input('gender') . $newNumber;
        } else {
            $newCode = 'RDS' . $year . $request->input('gender') . '0001'; // Jika tidak ada kode sebelumnya, mulai dengan 0001
        }

        // Mendapatkan input dari form
        $number_plat = $request->number_plat;
        $date = $request->date;

        // Mengambil nomor plat yang sudah ada berdasarkan tahun kelahiran peserta
        $nomor_plat_peserta = Member::whereYear('date', $date)->pluck('number_plat')->toArray();

        // Mengecek apakah nomor plat sudah ada yang dipilih oleh peserta
        if (in_array($number_plat, $nomor_plat_peserta)) {
            // Jika ada, tambahkan suffix berdasarkan urutan nomor plat yang sudah ada
            $suffix = chr(65 + count($nomor_plat_peserta) - 1); // Mengubah angka ke huruf, misalnya: 0 menjadi A, 1 menjadi B, dst.
            $nomor_plat_baru = $number_plat . '-' . $suffix;
        } else {
            // Jika tidak ada, nomor plat tetap sama
            $nomor_plat_baru = $number_plat;
        }
        //upload image
        if ($request->hasFile('image')) {
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('rider', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            //create post
            $member = new Member;
            $member->image                 = $imageName;
            $member->code                  = $newCode;
            $member->date                  = $date;
            $member->number_plat           = $nomor_plat_baru;
            $member->name                  = $request->input('name');
            $member->nickname              = $request->input('nickname');
            $member->place                 = $request->input('place');
            $member->gender                = $request->input('gender');
            $member->height                = $request->input('height');
            $member->weight                = $request->input('weight');
            $member->address               = $request->input('address');
            $member->phone                 = $request->input('phone');
            $member->email                 = $request->input('email');
            $member->socmed                = $request->input('socmed');
            $member->status                = $request->input('status');
            $member->number_booking        = $request->input('number_booking');
            $member->number_identity       = $request->input('number_identity');
            $member->story                 = $request->input('story');
            $member->member_id             = $request->input('member_id');
            $member->nationality_id        = $request->input('nationality_id');
            // $member->banner               = $request->input('banner');
            $member->save();
        }
        //redirect to index
        return redirect()->route('member.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    public function show($id)
    {
        //get post by ID
        $data = Member::findOrFail($id);
        return response()->json($data);
        // $label = Label::all();

        // //render view with data
        // return view('event.rider.show', compact('data', 'label'));
    }

    public function edit(string $id): View
    {
        $data = Member::findOrFail($id);
        $label = Label::all();
        $member = User::where('permission', 'MEMBER')->get();
        $nations    = Nationality::all();
        return view('event.rider.edit', compact('data', 'label', 'member', 'nations'));
    }

    public function update(Request $request, $id): RedirectResponse
    {
        $validator = Validator::make($request->all(), [
            'image'         => 'image|mimes:jpeg,jpg,png|max:2048',
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
            'number_booking' => 'required',
            'number_plat' => 'required',
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
        $date = Carbon::now(); // Misalnya, objek Carbon yang sudah ada
        $year = $date->year;

        if ($member) {
            $lastCode = $member->code;
            $lastNumber = (int)substr($lastCode, -4); // Ambil angka terakhir dari kode
            $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT); // Tambahkan 1 dan lengkapi dengan nol di depan
            $newCode = 'RDS' . $year . $request->input('gender') . $newNumber;
        } else {
            $newCode = 'RDS' . $year . $request->input('gender') . '0001'; // Jika tidak ada kode sebelumnya, mulai dengan 0001
        }

        // Mendapatkan input dari form
        $number_plat = $request->number_plat;
        $date = $request->date;

        // Mengambil nomor plat yang sudah ada berdasarkan tahun kelahiran peserta
        $nomor_plat_peserta = Member::whereYear('date', $date)->pluck('number_plat')->toArray();

        // Mengecek apakah nomor plat sudah ada yang dipilih oleh peserta
        if (in_array($number_plat, $nomor_plat_peserta)) {
            // Jika ada, tambahkan suffix berdasarkan urutan nomor plat yang sudah ada
            $suffix = chr(65 + count($nomor_plat_peserta) - 1); // Mengubah angka ke huruf, misalnya: 0 menjadi A, 1 menjadi B, dst.
            $nomor_plat_baru = $number_plat . '-' . $suffix;
        } else {
            // Jika tidak ada, nomor plat tetap sama
            $nomor_plat_baru = $number_plat;
        }

        //upload image
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($member->image) {
                Storage::delete('public/rider/' . $member->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('rider', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $member->image = $imageName;
        }

        $member->code                 = $newCode;
        $member->date                 = $date;
        $member->number_plat          = $nomor_plat_baru;
        $member->name                 = $request->input('name');
        $member->nickname             = $request->input('nickname');
        $member->place                = $request->input('place');
        $member->gender               = $request->input('gender');
        $member->height               = $request->input('height');
        $member->weight               = $request->input('weight');
        $member->address              = $request->input('address');
        $member->phone                = $request->input('phone');
        $member->email                = $request->input('email');
        $member->socmed               = $request->input('socmed');
        $member->status               = $request->input('status');
        $member->number_booking       = $request->input('number_booking');
        $member->number_identity      = $request->input('number_identity');
        $member->story                = $request->input('story');
        $member->member_id            = $request->input('member_id');
        $member->nationality_id       = $request->input('nationality_id');
        // $member->banner            = $request->input('banner');
        $member->save();

        return redirect()->route('member.index')->with('success', 'Member updated successfully.');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Member::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "About deleted successfully.";
        } else {
            $success = false;
            $message = "About deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
