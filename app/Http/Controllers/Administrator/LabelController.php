<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class LabelController extends Controller
{
    public function index()
    {
        $data = Label::paginate(10);
        $label = Label::all();
        return view('admin.label.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        return view('admin.label.create', compact('label'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:setup_labels',
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

        // Jika validasi berhasil, simpan data user baru
        $label = new Label;
        $label->code = $request->input('code');
        $label->title = $request->input('title');
        $label->desc = $request->input('desc');
        $label->ordering = $request->input('ordering');
        $label->status = $request->input('status');
        $label->save();

        return redirect()->route('label.index')->with('success', 'Label has been created');
    }

    public function show($id)
    {
        $label = Label::all();
        return view('admin.label.show', compact('label'));
    }

    public function edit($id)
    {
        $data = Label::findOrFail($id);
        $label = Label::all();
        return view('admin.label.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:setup_labels,code,' . $id,
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
        $label = Label::findOrFail($id);
        if (!$label) {
            return redirect()->route('label.index')->with('error', 'Label not found');
        }

        // Update data
        $label->code = $request->input('code');
        $label->title = $request->input('title');
        $label->desc = $request->input('desc');
        $label->ordering = $request->input('ordering');
        $label->status = $request->input('status');
        $label->updated_by = strtoupper(auth()->user()->username);
        $label->save();

        return redirect()->route('label.index')->with('success', 'Label has been updated');
    }

    public function destroy($id)
    {
        return redirect()->route('label.index')->with('success', 'Label has been deleted');
    }
}
