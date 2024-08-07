<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\RedirectResponse;

class ArticleController extends Controller
{
    public function index()
    {
        $label = Label::all();
        $data = News::paginate(10);

        return view('admin.article.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $ordering = News::pluck('ordering')->last() + 1;
        return view('admin.article.create', compact('label', 'ordering'));
    }

    public function store(Request $request): RedirectResponse
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
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
            $imageFile->storePubliclyAs('news', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            $image = new News;
            $image->image = $imageName;
            $image->title = $request->input('title');
            $image->desc = $request->input('desc');
            $image->ordering = $request->input('ordering');
            $image->status = $request->input('status');
            $image->save();
        }

        return redirect()->route('article.index')->with('success', 'Article has been created');
    }

    public function show($id)
    {
        return view('admin.article.show');
    }

    public function edit($id)
    {
        $data = News::findOrFail($id);
        $label = Label::all();
        return view('admin.article.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
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
        $image = News::findOrFail($id);
        if (!$image) {
            return redirect()->route('image.index')->with('error', 'Article not found');
        }

        // Update data
        if ($request->hasFile('image')) {
            // Hapus gambar lama sebelum menyimpan yang baru
            if ($image->image) {
                Storage::delete('public/news/' . $image->image);
            }

            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('news', $imageName, 'public'); // Menyimpan file dengan nama spesifik
            $image->image = $imageName;
        }

        // Melakukan pembaruan (update) pada atribut lainnya
        $image->title = $request->input('title');
        $image->desc = $request->input('desc');
        $image->ordering = $request->input('ordering');
        $image->status = $request->input('status');
        $image->updated_by = strtoupper($request->user()->username);
        $image->save();


        return redirect()->route('article.index')->with('success', 'Article has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = News::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "Article deleted successfully !";
        } else {
            $success = false;
            $message = "Article failed to delete !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
