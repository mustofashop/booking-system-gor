<?php

namespace App\Http\Controllers\Administrator;

use App\Models\Label;
use App\Models\Gallery;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class GalleryController extends Controller
{
    public function index()
    {
        $label = Label::all();
        $data = Gallery::paginate(10);

        return view('admin.gallery.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        return view('admin.gallery.create', compact('label'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'desc' => 'required',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Validasi jika file gambar ada sebelum menyimpan
        if ($request->hasFile('image')) {
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('gallery', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            $image = new Gallery;
            $image->image = $imageName;
            $image->title = $request->input('title');
            $image->desc = $request->input('desc');
            $image->status = $request->input('status');
            $image->save();
        }

        return redirect()->route('gallery.index')->with('success', 'Gallery has been created');
    }

    public function edit($id)
    {
        $data = Gallery::findOrFail($id);
        $label = Label::all();
        return view('admin.gallery.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'desc' => 'required',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $image = Gallery::findOrFail($id);
        if (!$image) {
            return redirect()->route('gallery.index')->with('error', 'Gallery not found');
        }

        // Update data
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($image->image) {
                Storage::delete('public/gallery/' . $image->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('gallery', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $image->image = $imageName;
        }

        // Melakukan pembaruan (update) pada atribut lainnya
        $image->title = $request->input('title');
        $image->desc = $request->input('desc');
        $image->status = $request->input('status');
        $image->updated_by = strtoupper($request->user()->username);
        $image->save();


        return redirect()->route('gallery.index')->with('success', 'Gallery has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Gallery::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "Gallery deleted successfully !";
        } else {
            $success = false;
            $message = "Gallery failed to delete !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
