<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\About;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CountController extends Controller
{
    public function index()
    {
        $data = About::paginate(10);
        $label = Label::all();
        return view('admin.count.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $ordering = About::pluck('ordering')->last() + 1;
        return view('admin.count.create', compact('label', 'ordering'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'count' => 'required|integer',
            'ordering' => 'required|integer|unique:setup_counts,ordering',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, simpan data baru
        $about = new About;
        $about->image = $request->input('icon');
        $about->title = $request->input('title');
        $about->count = $request->input('count');
        $about->ordering = $request->input('ordering');
        $about->status = $request->input('status');
        $about->created_by = strtoupper(auth()->user()->username);
        $about->save();

        return redirect()->route('count.index')->with('success', 'About has been created');
    }

    public function show($id)
    {
        $label = Label::all();
        return view('admin.count.show', compact('label'));
    }

    public function edit($id)
    {
        $data = About::findOrFail($id);
        $label = Label::all();
        return view('admin.count.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'count' => 'required|integer',
            'ordering' => 'required|integer|unique:setup_counts,ordering,' . $id,
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $about = About::findOrFail($id);
        if (!$about) {
            return redirect()->route('about.index')->with('error', 'About not found');
        }

        // Update data
        $about->image = $request->input('icon');
        $about->title = $request->input('title');
        $about->count = $request->input('count');
        $about->ordering = $request->input('ordering');
        $about->status = $request->input('status');
        $about->updated_by = strtoupper(auth()->user()->username);
        $about->save();

        return redirect()->route('count.index')->with('success', 'About has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = About::where('id', $id)->delete();

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
