<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Service;
use App\Models\Member;
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
            'cost' => 'required|string|max:255',
            'code' => '',
            'status' => 'required',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $member = Member::find($request->member_id);
        // Jika validasi berhasil, simpan data user baru
        $invoice = new Service();
        $invoice->cost      = $request->input('cost');
        $invoice->code      = 'INV' . date('YmdHis');
        $invoice->status    = $request->input('status');
        $invoice->member_id = $member->id;
        $invoice->save();
        return redirect()->route('invoice.index')->with('success', 'invoice has been created');
    }

    public function edit($id)
    {
        $data = Service::findOrFail($id);
        $label = Label::all();
        $member = Member::where('status', 'ACTIVE')->get();
        return view('admin.invoice.edit', compact('data', 'label', 'member'));
    }

    public function update(Request $request, $id)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'cost' => '',
            // 'code' => '' . $id,
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
            return redirect()->route('invoice.index')->with('error', 'invoice not found');
        }

        $member = Member::find($request->member_id);
        // Update data
        $invoice->cost      = $request->input('cost');
        $invoice->code      = $request->input('code');
        $invoice->status    = $request->input('status');
        $invoice->member_id = $member->id;
        $invoice->save();
        return redirect()->route('invoice.index')->with('success', 'invoice has been updated');
    }

    public function destroy($id)
    {
        //delete data
        $delete = Service::where('id', $id)->delete();

        if ($delete == 1) {
            $success = true;
            $message = " deleted successfully.";
        } else {
            $success = false;
            $message = " deleted failed !";
        }

        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }
}
