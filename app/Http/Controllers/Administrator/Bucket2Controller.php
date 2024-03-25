<?php

namespace App\Http\Controllers\Administrator;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Label;
use App\Models\Member;
use App\Models\TransactionBooking;
use App\Models\TransactionInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Bucket2Controller extends Controller
{
    public function index()
    {
        $label = Label::all();

        $data = TransactionBooking::paginate(10);
        return view('admin.booking.index', compact('data', 'label'));
    }

    public function create()
    {
        $label = Label::all();
        $event = Event::where('status', 'ACTIVE')->get();
        $member = Member::where('status', 'ACTIVE')->get();
        $category = EventCategory::where('status', 'ACTIVE')->get();
        return view('admin.booking.create', compact('event', 'member', 'label', 'category'));
    }

    public function store(Request $request)
    {
        $event = Event::find($request->event_id);
        $member = Member::find($request->member_id);
        $quota = TransactionBooking::where('event_id', $event->id)->sum('event_id');

        if ($quota < $event->count_limit) {
            $booking = new TransactionBooking;
            $booking->code = 'BK' . date('YmdHis');
            $booking->date = date('Y-m-d');
            $booking->note = $request->input('note');
            $booking->category = $request->input('category');
            $booking->event_id = $event->id;
            $booking->event_category_id = $request->input('event_category_id');
            $booking->member_id = $member->id;
            $booking->created_by = strtoupper(Auth::user()->username);
            $booking->save();

            $this->generateInvoice($booking->id);

            return redirect()->route('bucket-2.index')->with('success', 'Booking success, invoice has been generated');
        } else {
            return redirect()->route('bucket-2.index')->with('error', 'Booking failed, quota is full');
        }
    }

    public function generateInvoice($id)
    {
        $booking = TransactionBooking::with('event')->find($id);

        if (!$booking) {
            return; // Tambahkan logika error handling di sini jika diperlukan
        }

        $data = $booking->event; // Mengakses relasi event

        TransactionInvoice::create([
            'code' => 'INV' . date('YmdHis'),
            'method' => 'TRANSFER', // Perhatikan penulisan method yang benar
            'description' => 'Invoice Booking Event ' . $data->title, // Mengakses nama event dari relasi
            'amount' => $data->price, // Mengakses harga event dari relasi
            'date' => date('Y-m-d'),
            'category' => 'UNPAID',
            'booking_id' => $booking->id,
            'created_by' => strtoupper(Auth::user()->username),
        ]);
    }

    public function showInvoice($id)
    {
        $label = Label::all();
        $booking = TransactionBooking::find($id);
        if (!$booking) {
            return redirect()->route('bucket-2.index')->with('error', 'Booking not found');
        } else {
            $data = TransactionInvoice::with('booking')->where('booking_id', $booking->id)->first();
            return view('admin.booking.invoice', compact('data', 'label'));
        }
    }

    public function getBucketById2($id)
    {
        // Cari event berdasarkan ID
        $event = Event::find($id);

        // Jika event tidak ditemukan, kembalikan respon error
        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        // Hitung kuota berdasarkan jumlah total transaksi
        $quota = TransactionBooking::where('event_id', $event->id)->sum('event_id');

        // Kembalikan data event beserta kuota dalam format JSON
        return response()->json([
            'event' => $event,
            'quota' => $quota,
        ]);
    }

    public function getMemberById2($id)
    {
        // Cari member berdasarkan ID
        $member = Member::find($id);

        // Jika member tidak ditemukan, kembalikan respon error
        if (!$member) {
            return response()->json(['error' => 'Member not found'], 404);
        }

        // Kembalikan data member dalam format JSON
        return response()->json([
            'member' => $member,
        ]);
    }
}
