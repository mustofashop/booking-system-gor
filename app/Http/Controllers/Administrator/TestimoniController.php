<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TestimoniController extends Controller
{
    public function index()
    {
        $data = Testimonial::paginate(10);
        $label = Label::all();
        return view('admin.testimoni.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $ordering = Testimonial::pluck('ordering')->last() + 1;
        return view('admin.testimoni.create', compact('label', 'ordering'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
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
            $imageFile->storePubliclyAs('testimoni', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            $model = new Testimonial;
            $model->image = $imageName;
            $model->name = $request->input('name');
            $model->position = $request->input('position');
            $model->desc = $request->input('desc');
            $model->ordering = $request->input('ordering');
            $model->status = $request->input('status');
            $model->created_by = strtoupper(auth()->user()->username);
            $model->save();
        }


        return redirect()->route('testimoni.index')->with('success', 'Testimonial has been created');
    }

    public function show($id)
    {
        $label = Label::all();
        return view('admin.testimoni.show', compact('label'));
    }

    public function edit($id)
    {
        $data = Testimonial::findOrFail($id);
        $label = Label::all();
        return view('admin.testimoni.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'name' => 'required|string|max:255',
            'position' => 'required|string|max:255',
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
        $model = Testimonial::findOrFail($id);
        if (!$model) {
            return redirect()->route('testimoni.index')->with('error', 'Testimonial not found');
        }

        // Update data
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($model->image) {
                Storage::delete('public/testimoni/' . $model->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('testimoni', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $model->image = $imageName;
        }

        // Melakukan pembaruan (update) pada atribut lainnya
        $model->name = $request->input('name');
        $model->position = $request->input('position');
        $model->desc = $request->input('desc');
        $model->ordering = $request->input('ordering');
        $model->status = $request->input('status');
        $model->updated_by = strtoupper($request->user()->username);
        $model->save();


        return redirect()->route('testimoni.index')->with('success', 'Testimonial has been updated');
    }

    public function destroy($id)
    {
        // Temukan data testimonial berdasarkan ID
        $testimonial = Testimonial::find($id);

        // Pastikan data testimonial ditemukan
        if (!$testimonial) {
            return response()->json([
                'success' => false,
                'message' => 'Testimonial not found.'
            ]);
        }

        // Hapus gambar dari penyimpanan (storage)
        if ($testimonial->image) {
            Storage::delete('public/testimoni/' . $testimonial->image);
        }

        // Hapus data testimonial dari database
        if ($testimonial->delete()) {
            $success = true;
            $message = "Testimonial deleted successfully.";
        } else {
            $success = false;
            $message = "Failed to delete testimonial!";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

}
