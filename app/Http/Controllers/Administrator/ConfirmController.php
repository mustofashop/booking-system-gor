<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Label;
use App\Models\Button;
use App\Models\Event;
use App\Models\Member;
use App\Models\TransactionBooking;
use App\Models\TransactionInvoice;
use App\Models\TransactionPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

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

            $this->update($request->event_id);
        }
        //redirect to index
        return redirect()->route('confirm.index')->with(['success' => 'Payment confirmation created successfully']);
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

    public function destroy($id)
    {
        //
    }
}
