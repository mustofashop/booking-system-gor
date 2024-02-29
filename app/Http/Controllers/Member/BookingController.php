<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Event;
use App\Models\Label;
use App\Models\Member;
use App\Models\TransactionBooking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BookingController extends Controller
{
    public function index()
    {
        $label = Label::all();
        $data = TransactionBooking::with('event', 'member')
            ->where('member_id', Auth::user()->member->id)
            ->paginate(10);
        return view('member.booking.index', compact('data', 'label'));
    }

    public function showBookingForm($id)
    {
        $label = Label::all();
        $data = Event::find($id);
        $member = Member::where('user_id', Auth::user()->id)->first();
        $quota = TransactionBooking::where('event_id', $data->id)->sum('event_id');

        return view('member.booking.show', compact('data', 'label', 'member', 'quota'));
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
            $booking->member_id = $member->id;
            $booking->created_by = strtoupper(Auth::user()->username);
            $booking->save();
            return redirect()->route('booking.index')->with('success', 'Booking success');
        } else {
            return redirect()->route('booking.index')->with('error', 'Booking failed, quota is full');
        }
    }

    public function store()
    {

    }
}
