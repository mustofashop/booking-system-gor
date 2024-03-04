<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\TransactionBooking;
use App\Models\TransactionInvoice;
use App\Models\TransactionPayment;
use Illuminate\Http\Request;

class ConfirmController extends Controller
{
    public function index()
    {
        $label = Label::all();
        $data = TransactionInvoice::paginate(10);
        return view('admin.confirm.index', ['data' => $data, 'label' => $label]);
    }

    public function create()
    {
        return view('admin.confirm.create');
    }

    public function store(Request $request)
    {
        //
    }

    public function show($id)
    {
        $label = Label::all();
        $data = TransactionInvoice::find($id);
        if (!$data) {
            return redirect()->route('confirm.index')->with('error', 'Booking not found');
        } else {
            return view('admin.confirm.show', compact('data', 'label'));
        }
    }

    public function edit($id)
    {
        $label = Label::all();
        $data = TransactionInvoice::find($id);
        return view('admin.confirm.edit', compact('label', 'data'));
    }

    public function update(Request $request, $id)
    {
        // update payment category
        $confirm = TransactionPayment::findOrFail($id);
        if (!$confirm) {
            return redirect()->back()->with('error', 'Data not found');
        }

        $confirm->category = $request->category;
        $confirm->updated_by = strtoupper(auth()->user()->username);
        $confirm->save();

        // update invoice status
        $invoice = TransactionInvoice::where('code', $confirm->invoice_number)->first();
        $invoice->category = 'PAID';
        $invoice->updated_by = strtoupper(auth()->user()->username);
        $invoice->save();

        // update booking status
        $booking = TransactionBooking::where('id', $invoice->booking_id)->first();
        $booking->category = 'RESERVATION';
        $booking->updated_by = strtoupper(auth()->user()->username);
        $booking->save();

        //redirect to index
        return redirect()->route('confirm.index')->with(['success' => 'Payment verification created successfully']);
    }

    public function destroy($id)
    {
        //
    }


}
