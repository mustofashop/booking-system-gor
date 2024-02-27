<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\History;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AboutController extends Controller
{
    public function index()
    {
        $data = History::paginate(10);
        $label = Label::all();
        return view('admin.about.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $ordering = History::pluck('ordering')->last() + 1;
        return view('admin.about.create', compact('label', 'ordering'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'required',
            'ordering' => 'required|integer|unique:setup_stories,ordering',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, simpan data baru
        $about = new History;
        $about->image = $request->input('icon');
        $about->title = $request->input('title');
        $about->desc = $request->input('desc');
        $about->ordering = $request->input('ordering');
        $about->status = $request->input('status');
        $about->created_by = strtoupper(auth()->user()->username);
        $about->save();

        return redirect()->route('about.index')->with('success', 'Story has been created');
    }

    public function show($id)
    {
        $label = Label::all();
        return view('admin.about.show', compact('label'));
    }

    public function edit($id)
    {
        $data = History::findOrFail($id);
        $label = Label::all();
        return view('admin.about.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'desc' => 'required',
            'ordering' => 'required|integer|unique:setup_stories,ordering,' . $id,
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $about = History::findOrFail($id);
        if (!$about) {
            return redirect()->route('about.index')->with('error', 'Story not found');
        }

        // Update data
        $about->image = $request->input('icon');
        $about->title = $request->input('title');
        $about->desc = $request->input('desc');
        $about->ordering = $request->input('ordering');
        $about->status = $request->input('status');
        $about->updated_by = strtoupper(auth()->user()->username);
        $about->save();

        return redirect()->route('about.index')->with('success', 'Story has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = History::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "Story deleted successfully.";
        } else {
            $success = false;
            $message = "Story deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
