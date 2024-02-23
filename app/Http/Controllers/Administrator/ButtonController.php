<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Button;
use App\Models\Label;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ButtonController extends Controller
{
    public function index()
    {
        $data = Button::paginate(10);
        $label = Label::all();
        return view('admin.button.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        return view('admin.button.create', compact('label'));
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
        $label = new Button;
        $label->code = $request->input('code');
        $label->title = $request->input('title');
        $label->url = $request->input('url');
        $label->status = $request->input('status');
        $label->save();

        return redirect()->route('button.index')->with('success', 'Button has been created');
    }

    public function show($id)
    {
        $label = Label::all();
        return view('admin.button.show', compact('label'));
    }

    public function edit($id)
    {
        $data = Button::findOrFail($id);
        $label = Label::all();
        return view('admin.button.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'code' => 'required|string|max:255|unique:setup_buttons,code,' . $id,
            'title' => 'required|string|max:255',
            'url' => 'required',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $label = Button::findOrFail($id);
        if (!$label) {
            return redirect()->route('button.index')->with('error', 'Button not found');
        }

        // Update data
        $label->code = $request->input('code');
        $label->title = $request->input('title');
        $label->url = $request->input('url');
        $label->status = $request->input('status');

        return redirect()->route('button.index')->with('success', 'Button has been updated');
    }

    public function destroy($id)
    {
        return redirect()->route('button.index')->with('success', 'Button has been deleted');
    }
}
