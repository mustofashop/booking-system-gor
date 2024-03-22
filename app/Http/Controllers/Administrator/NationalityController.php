<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Nationality;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class NationalityController extends Controller
{
    public function index()
    {
        $data = Nationality::paginate(10);
        $label = Label::all();
        return view('admin.nationality.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        return view('admin.nationality.create', compact('label'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:master_nationality',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, simpan data user baru
        $nations = new Nationality();
        $nations->name      = $request->input('name');
        $nations->code      = $request->input('code');
        $nations->status    = $request->input('status');
        $nations->save();
        return redirect()->route('nationality.index')->with('success', 'Nationality has been created');
    }

    public function edit($id)
    {
        $data = Nationality::findOrFail($id);
        $label = Label::all();
        return view('admin.nationality.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:255|unique:master_nationality,code,' . $id,
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $nations = Nationality::findOrFail($id);
        if (!$nations) {
            return redirect()->route('nationality.index')->with('error', 'Nationality not found');
        }

        // Update data
        $nations->name      = $request->input('name');
        $nations->code      = $request->input('code');
        $nations->status    = $request->input('status');
        $nations->save();
        return redirect()->route('nationality.index')->with('success', 'Nationality has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Nationality::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = "Event deleted successfully.";
        } else {
            $success = false;
            $message = "Event deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
