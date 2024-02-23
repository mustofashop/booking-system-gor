<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Image;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class ImageController extends Controller
{
    public function index()
    {
        $data = Image::paginate(10);
        $label = Label::all();
        return view('admin.image.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        return view('admin.image.create', compact('label'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:setup_images',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'desc' => 'required',
            'ordering' => 'required|integer',
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
            $imageFile->storePubliclyAs('image', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            $image = new Image;
            $image->code = $request->input('code');
            $image->image = $imageName;
            $image->title = $request->input('title');
            $image->desc = $request->input('desc');
            $image->ordering = $request->input('ordering');
            $image->status = $request->input('status');
            $image->save();
        }


        return redirect()->route('image.index')->with('success', 'Image has been created');
    }

    public function show($id)
    {
        $label = Label::all();
        return view('admin.image.show', compact('label'));
    }

    public function edit($id)
    {
        $data = Image::findOrFail($id);
        $label = Label::all();
        return view('admin.image.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:setup_images,code,' . $id,
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'title' => 'required|string|max:255',
            'desc' => 'required',
            'ordering' => 'required|integer',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $image = Image::findOrFail($id);
        if (!$image) {
            return redirect()->route('image.index')->with('error', 'Image not found');
        }

        // Update data
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($image->image) {
                Storage::delete('public/image/' . $image->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('image', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $image->image = $imageName;
        }

        // Melakukan pembaruan (update) pada atribut lainnya
        $image->code = $request->input('code');
        $image->title = $request->input('title');
        $image->desc = $request->input('desc');
        // ordering
        $last = Image::pluck('ordering')->last();
        $image->ordering = $last + 1;
        $image->status = $request->input('status');
        $image->updated_by = strtoupper($request->user()->username);
        $image->save();


        return redirect()->route('image.index')->with('success', 'Image has been updated');
    }

    public function destroy($id)
    {
        return redirect()->route('image.index')->with('success', 'Image has been deleted');
    }
}
