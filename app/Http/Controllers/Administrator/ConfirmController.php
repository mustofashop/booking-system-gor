<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Button;
use App\Models\Event;
use App\Models\TransactionBooking;
use App\Models\TransactionInvoice;
use App\Models\TransactionPayment;
use Illuminate\Http\Request;

class ConfirmController extends Controller
{
    public function index(Request $request)
    {
        $label = Label::all();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Event
        $month = $request->input('month'); // Mengambil nilai bulan dari permintaan
        $search = $request->input('search'); // Mengambil nilai pencarian dari permintaan

        $query = TransactionInvoice::query();

        if ($month) {
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $query->whereMonth('date', $month);
        }

        if ($search) {
            // Jika ada kata kunci pencarian, tambahkan kondisi pencarian berdasarkan judul atau deskripsi event
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', '%' . $search . '%')
                    ->orWhere('description', 'like', '%' . $search . '%')
                    ->orWhere('location', 'like', '%' . $search . '%');
            });
        } else {
            // $data = Event::latest()->paginate(5);
            $data = $query->orderBy('date', 'desc')->paginate(10);
        }

        // Ambil data event berdasarkan kondisi yang telah ditetapkan
        // $events = $query->orderBy('date', 'desc')->get();

        return view('admin.confirm.index', [
            'data' => $data,
            'label' => $label,
            'button' => $button
        ]);
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
