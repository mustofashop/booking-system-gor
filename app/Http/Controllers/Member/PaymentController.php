<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Member;
use App\Models\TransactionBooking;
use App\Models\TransactionInvoice;
use App\Models\TransactionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function index()
    {
        $label = Label::all();
        $data = TransactionInvoice::paginate(10);
        return view('member.payment.index', compact('label', 'data'));
    }

    public function create()
    {
        return view('member.payment.create');
    }

    public function store(Request $request)
    {
        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'methode' => 'required|string|max:255',
            'sender' => 'required|string|max:255',
            'from' => 'required|string|max:255',
            'amount' => 'required|numeric',
            'paid_date' => 'required|date',
            'note' => 'required|string|max:255',
        ]);

        // Jika validasi gagal, kembali ke halaman sebelumnya dengan pesan error
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        //upload image
        if ($request->hasFile('image')) {
            // Ubah penyimpanan gambar sesuai kebutuhan Anda, di sini saya asumsikan menggunakan penyimpanan lokal
            $imageFile = $request->file('image');
            $imageName = $imageFile->hashName(); // Mendapatkan nama enkripsi file
            $imageFile->storePubliclyAs('payment', $imageName, 'public'); // Menyimpan file dengan nama spesifik

            //create post
            $member = new TransactionPayment;
            $member->file = $imageName;
            $member->invoice_number = $request->invoice_number;
            $member->methode = $request->methode;
            $member->sender = $request->sender;
            $member->from = $request->from;
            $member->amount = $request->amount;
            $member->paid_date = $request->paid_date;
            $member->note = $request->note;
            $member->category = 'SEND';
            $member->event_id = $request->event_id;
            $member->created_by = strtoupper($request->user()->username);
            $member->save();

            $this->confirm($request->event_id);
        }
        //redirect to index
        return redirect()->route('payment.index')->with(['success' => 'Payment confirmation created successfully']);
    }

    public function show($id)
    {
        $label = Label::all();
        $data = TransactionInvoice::find($id);
        return view('member.payment.show', compact('label', 'data'));
    }

    public function edit($id)
    {
        $label = Label::all();
        $data = TransactionInvoice::find($id);
        return view('member.payment.edit', compact('label', 'data'));
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($id)
    {
        // Delete the payment
    }

    public function confirm($id)
    {
        $member = Member::where('member_id', Auth::user()->id)->first();
        $data = TransactionBooking::where('member_id', $member->id)
            ->where('event_id', $id)
            ->where('category', 'CONFIRMATION')
            ->first();

        if ($data) {
            TransactionInvoice::where('booking_id', $data->id)->update([
                'category' => 'CONFIRMED'
            ]);
            return redirect()->route('payment.index')->with(['success' => 'Payment confirmation success']);
        } else {
            return redirect()->route('payment.index')->with(['error' => 'Payment confirmation failed']);
        }
    }
}
