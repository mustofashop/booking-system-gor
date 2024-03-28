<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Member;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class InvoiceController extends Controller
{
    public function index()
    {
        $data = Service::paginate(10);
        $label = Label::all();
        return view('admin.invoice.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $member = Member::where('status', 'ACTIVE')->get();
        return view('admin.invoice.create', compact('label', 'member'));
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, simpan data user baru
        $invoice = new Service();
        $invoice->code = 'CST' . date('YmdHis');
        $invoice->category = $request->input('category');
        $invoice->name = $request->input('name');
        $invoice->description = $request->input('description');
        $invoice->amount = $request->input('amount');
        $invoice->status = $request->input('status');
        $invoice->save();
        return redirect()->route('invoice.index')->with('success', 'Cost has been created');
    }

    public function edit($id)
    {
        $data = Service::findOrFail($id);
        $label = Label::all();
        return view('admin.invoice.edit', compact('data', 'label'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'category' => 'required',
            'name' => 'required',
            'description' => 'required',
            'amount' => 'required',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        // Jika validasi berhasil, dapatkan data user berdasarkan ID
        $invoice = Service::findOrFail($id);
        if (!$invoice) {
            return redirect()->route('invoice.index')->with('error', 'Cost not found');
        }

        $member = Member::find($request->member_id);
        // Update data
        $invoice->category = $request->input('category');
        $invoice->name = $request->input('name');
        $invoice->description = $request->input('description');
        $invoice->amount = $request->input('amount');
        $invoice->status = $request->input('status');
        $invoice->save();
        return redirect()->route('invoice.index')->with('success', 'Cost has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Service::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = " Cost deleted successfully.";
        } else {
            $success = false;
            $message = " Cost deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
