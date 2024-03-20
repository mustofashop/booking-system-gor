<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Label;
use App\Models\Member;
use App\Models\TransactionBooking;
use App\Models\TransactionInvoice;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $label = Label::all();

        $member = Member::where('member_id', Auth::user()->id)->first();

        if (!$member) {
            return view('member.booking.info', compact('label'));
        } else {
            $data = TransactionBooking::where('member_id', $member->id)->paginate(10);
            return view('member.booking.index', compact('data', 'label'));
        }
    }

    public function showBookingForm($id)
    {
        $label = Label::all();
        $data = Event::find($id);

        if (!$data) {
            $member = Member::where('member_id', Auth::user()->id)->first();
            $event = Event::where('status', 'ACTIVE')
                ->whereDoesntHave('booking', function ($query) use ($member) {
                    $query->where('member_id', $member->id);
                })
                ->get();

            $category = EventCategory::where('status', 'ACTIVE')->get();

            return view('member.booking.create', compact('label', 'event', 'member', 'category'));
        } else {
            $member = Member::where('user_id', Auth::user()->id)->first();
            $quota = TransactionBooking::where('event_id', $data->id)->sum('event_id');
            // cek booking userid
            $booking = TransactionBooking::where('event_id', $data->id)
                ->where('member_id', $member->id)
                ->first();

            if ($booking) {
                $category = EventCategory::where('status', 'ACTIVE')->get();
                $event = Event::where('status', 'ACTIVE')
                    ->whereDoesntHave('booking', function ($query) use ($member) {
                        $query->where('member_id', $member->id);
                    })
                    ->get();
                return view('member.booking.create', compact('label', 'event', 'member', 'category'));
            } else {
                // cek event status
                $event = Event::find($id);
                return view('member.booking.show', compact('data', 'label', 'member', 'quota', 'event'));
            }
        }
    }

    public function storeBookingForm(Request $request)
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

            return redirect()->route('booking.index')->with('success', 'Booking success, invoice has been generated');
        } else {
            return redirect()->route('booking.index')->with('error', 'Booking failed, quota is full');
        }
    }

    public function getEventById($id)
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


    public function store(Request $request)
    {
        $event = Event::find($request->event_id);
        $member = Member::find($request->member_id);
        $quota = TransactionBooking::where('event_id', $event->id)->sum('event_id');

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

        return redirect()->route('booking.index')->with('success', 'Booking success, invoice has been generated');
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
            return redirect()->route('booking.index')->with('error', 'Booking not found');
        } else {
            $data = TransactionInvoice::with('booking')->where('booking_id', $booking->id)->first();
            return view('member.booking.invoice', compact('data', 'label'));
        }
    }
}
