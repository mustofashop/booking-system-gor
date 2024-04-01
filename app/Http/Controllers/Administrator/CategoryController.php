<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\EventCategory;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    public function index()
    {
        $label = Label::all();
        $data = EventCategory::paginate(10);
        $category = EventCategory::all();
        return view('admin.category.index', compact('data', 'category', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $category = EventCategory::all();
        return view('admin.category.create', compact('category', 'label'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'required',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, simpan data user baru
        $category = new EventCategory;
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->save();

        return redirect()->route('category.index')->with('success', 'category has been created');
    }

    public function show($id)
    {
        $category = EventCategory::all();
        return view('admin.category.show', compact('category'));
    }

    public function edit($id)
    {
        $label = Label::all();
        $data = EventCategory::findOrFail($id);
        $category = EventCategory::all();
        return view('admin.category.edit', compact('data', 'category', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255' . $id,
            'description' => 'required',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $category = EventCategory::findOrFail($id);
        if (!$category) {
            return redirect()->route('category.index')->with('error', 'category not found');
        }

        // Update data
        $category->title = $request->input('title');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->updated_by = strtoupper(auth()->user()->username);
        $category->save();

        return redirect()->route('category.index')->with('success', 'category has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = EventCategory::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "Event Category deleted successfully.";
        } else {
            $success = false;
            $message = "Event Category deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
