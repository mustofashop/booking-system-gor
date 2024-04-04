<?php

namespace App\Http\Controllers;

use App\Models\Label;
use App\Models\Permission;
use App\Models\User;
use App\Models\Event;
use App\Models\Member;
use App\Models\TransactionBooking;
use App\Models\TransactionPoint;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        if ($request->user()) {
            // User is authenticated, redirect to the dashboard
            return redirect()->route('dashboard.welcome');
        } else {
            // User is not authenticated, redirect to the login page
            return redirect()->route('login');
        }
    }

    public function welcome()
    {
        $page_title = 'Dashboard';
        $page_description = 'Ini adalah halaman dashboard';
        $action = __FUNCTION__;

        return view('layout.dashboard.welcome ', compact(
            'page_title',
            'page_description',
            'action'
        ));
    }

    public function show()
    {
        $page_title = 'Profile';
        $page_description = 'Ini adalah halaman profile';
        $action = __FUNCTION__;

        $label = Label::all();

        $data = User::where('id', auth()->user()->id)->first();

        $permission = Permission::where('status', 'ACTIVE')->get();

        return view('layout.dashboard.account ', compact(
            'page_title',
            'page_description',
            'action',
            'label',
            'data',
            'permission'
        ));
    }

    public function reset(Request $request, $id)
    {
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        $user = User::find($id);

        if (password_verify($request->old_password, $user->password)) {
            $user->password = Hash::make($request->password);
            $user->save();

            return redirect()->route('account')->with('success', 'Password has been changed');
        } else {
            return redirect()->route('account')->with('error', 'Old password is wrong');
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'username' => 'required',
            'email' => 'required|email',
            'phone' => 'required',
        ]);

        $user = User::find($id);
        $user->name = $request->name;
        $user->email = $request->email;
        $user->username = $request->username;
        $user->phone = $request->phone;
        $user->save();

        return redirect()->route('account')->with('success', 'Profile has been updated');
    }

    public function home(Request $request)
    {
        $month = $request->input('month'); // Mengambil nilai bulan dari permintaan

        $bulan = date('m'); // Mengambil bulan saat ini

        // User
        $user = User::query();
        
        // Event
        $event = Event::query();

        // Booking
        $booking = TransactionBooking::query();

        // Member
        $member = Member::query();

        // Article
        $article = News::query();

        // Point
        $point = TransactionPoint::whereMonth('created_at', $bulan)->where('status', 'ACTIVE')->orderBy('total_point', 'desc')->take(5)->get();
        
        if ($month) {
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $q = $event->whereMonth('date', $month)->get();
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $b = $booking->whereMonth('date', $month)->get();
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $m = $member->whereMonth('date', $month)->get();
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $u = $user->whereMonth('created_at', $month)->get();
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $a = $article->whereMonth('created_at', $month)->get();

            // Ambil data event berdasarkan kondisi yang telah ditetapkan
            $events = $q->count();
            // Ambil data booking berdasarkan kondisi yang telah ditetapkan
            $bookings = $b->count();
            // Ambil data member berdasarkan kondisi yang telah ditetapkan
            $members = $m->count();
            // Ambil data user berdasarkan kondisi yang telah ditetapkan
            $users = $u->count();
            // Ambil data article berdasarkan kondisi yang telah ditetapkan
            $articles = $a->count();
        } else {
            // Jika tidak ada bulan yang dipilih, ambil semua data event
            $events = $event->count();
            // Jika tidak ada bulan yang dipilih, ambil semua data booking
            $bookings = $booking->count();
            // Jika tidak ada bulan yang dipilih, ambil semua data member
            $members = $member->count();
            // Jika tidak ada bulan yang dipilih, ambil semua data user
            $users = $user->count();
            // Jika tidak ada bulan yang dipilih, ambil semua data article
            $articles = $article->count();
        }

        $no8 = "08";
        $no9 = "09";

        $total1 = Event::whereMonth('date', 01)->get()->count();
        $total2 = Event::whereMonth('date', 02)->get()->count();
        $total3 = Event::whereMonth('date', 03)->get()->count();
        $total4 = Event::whereMonth('date', 04)->get()->count();
        $total5 = Event::whereMonth('date', 05)->get()->count();
        $total6 = Event::whereMonth('date', 06)->get()->count();
        $total7 = Event::whereMonth('date', 07)->get()->count();
        $total8 = Event::whereMonth('date', intval($no8))->get()->count();
        $total9 = Event::whereMonth('date', intval($no9))->get()->count();
        $total10 = Event::whereMonth('date', 10)->get()->count();
        $total11 = Event::whereMonth('date', 11)->get()->count();
        $total12 = Event::whereMonth('date', 12)->get()->count();

        return view('admin.dashboard.index ', [
            'events' => $events,
            'members' => $members,
            'bookings' => $bookings,
            'users' => $users,
            'articles' => $articles,
            'point' => $point,
            'total1' => $total1,
            'total2' => $total2,
            'total3' => $total3,
            'total4' => $total4,
            'total5' => $total5,
            'total6' => $total6,
            'total7' => $total7,
            'total8' => $total8,
            'total9' => $total9,
            'total10' => $total10,
            'total11' => $total11,
            'total12' => $total12,
        ]);
    }

    public function home1(Request $request)
    {
        $month = $request->input('month'); // Mengambil nilai bulan dari permintaan

        $bulan = date('m'); // Mengambil bulan saat ini

        // User
        $user = User::query();
        
        // Event
        $event = Event::query();

        // Booking
        $booking = TransactionBooking::query();

        // Member
        $member = Member::query();

        // Article
        $article = News::query();

        // Point
        $point = TransactionPoint::whereMonth('created_at', $bulan)->where('status', 'ACTIVE')->orderBy('total_point', 'desc')->take(5)->get();
        
        if ($month) {
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $q = $event->whereMonth('date', $month)->get();
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $b = $booking->whereMonth('date', $month)->get();
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $m = $member->whereMonth('date', $month)->get();
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $u = $user->whereMonth('created_at', $month)->get();
            // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
            $a = $article->whereMonth('created_at', $month)->get();

            // Ambil data event berdasarkan kondisi yang telah ditetapkan
            $events = $q->count();
            // Ambil data booking berdasarkan kondisi yang telah ditetapkan
            $bookings = $b->count();
            // Ambil data member berdasarkan kondisi yang telah ditetapkan
            $members = $m->count();
            // Ambil data user berdasarkan kondisi yang telah ditetapkan
            $users = $u->count();
            // Ambil data article berdasarkan kondisi yang telah ditetapkan
            $articles = $a->count();
        } else {
            // Jika tidak ada bulan yang dipilih, ambil semua data event
            $events = $event->count();
            // Jika tidak ada bulan yang dipilih, ambil semua data booking
            $bookings = $booking->count();
            // Jika tidak ada bulan yang dipilih, ambil semua data member
            $members = $member->count();
            // Jika tidak ada bulan yang dipilih, ambil semua data user
            $users = $user->count();
            // Jika tidak ada bulan yang dipilih, ambil semua data article
            $articles = $article->count();
        }

        $no8 = "08";
        $no9 = "09";

        $total1 = Event::whereMonth('date', 01)->get()->count();
        $total2 = Event::whereMonth('date', 02)->get()->count();
        $total3 = Event::whereMonth('date', 03)->get()->count();
        $total4 = Event::whereMonth('date', 04)->get()->count();
        $total5 = Event::whereMonth('date', 05)->get()->count();
        $total6 = Event::whereMonth('date', 06)->get()->count();
        $total7 = Event::whereMonth('date', 07)->get()->count();
        $total8 = Event::whereMonth('date', intval($no8))->get()->count();
        $total9 = Event::whereMonth('date', intval($no9))->get()->count();
        $total10 = Event::whereMonth('date', 10)->get()->count();
        $total11 = Event::whereMonth('date', 11)->get()->count();
        $total12 = Event::whereMonth('date', 12)->get()->count();

        return view('event.dashboard.index ', [
            'events' => $events,
            'members' => $members,
            'bookings' => $bookings,
            'users' => $users,
            'articles' => $articles,
            'point' => $point,
            'total1' => $total1,
            'total2' => $total2,
            'total3' => $total3,
            'total4' => $total4,
            'total5' => $total5,
            'total6' => $total6,
            'total7' => $total7,
            'total8' => $total8,
            'total9' => $total9,
            'total10' => $total10,
            'total11' => $total11,
            'total12' => $total12,
        ]);
    }

    public function home2(Request $request)
    {
        $month = $request->input('month'); // Mengambil nilai bulan dari permintaan

        $bulan = date('m'); // Mengambil bulan saat ini

        // User
        $user = User::query();
        $akun = $user->where('id', Auth::user()->id)->first();
        $permission = $akun->permission;
        
        // Event
        $event = Event::query();

        // Booking
        $booking = TransactionBooking::query();

        // Member
        $member = Member::query();

        // Article
        $article = News::query();

        // Point
        $point = TransactionPoint::whereMonth('created_at', $bulan)->where('status', 'ACTIVE')->orderBy('total_point', 'desc')->take(5)->get();
        
        if ($permission == 'MEMBER'){
            $auth = Member::where('member_id', Auth::user()->id)->first();
            if ($auth == null) {
                $id = Auth::user()->id;
                $member_id = Auth::user()->id;
            } else {
                $id = $auth->id;
                $member_id = $auth->member_id;
            }

            if ($month) {
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
                $jumlah_data = DB::table('transaction_booking')
                                ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                                ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                                ->where('transaction_booking.member_id', $id)
                                ->whereRaw('MONTH(master_events.date) = ?', [$month])
                                ->first();
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
                $b = $booking->whereMonth('date', $month)->where('member_id', $id)->get();
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
                $m = $member->whereMonth('date', $month)->where('member_id', $member_id)->get();
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
                $u = $user->whereMonth('created_at', $month)->where('id', $member_id)->get();
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
                $a = $article->whereMonth('created_at', $month)->get();

                // Ambil data event berdasarkan kondisi yang telah ditetapkan
                $events = $jumlah_data->jumlah_event;
                // Ambil data booking berdasarkan kondisi yang telah ditetapkan
                $bookings = $b->count();
                // Ambil data member berdasarkan kondisi yang telah ditetapkan
                $members = $m->count();
                // Ambil data user berdasarkan kondisi yang telah ditetapkan
                $users = $u->count();
                // Ambil data article berdasarkan kondisi yang telah ditetapkan
                $articles = $a->count();
            } else {
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
                $b = $booking->where('member_id', $id)->get();
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
                $m = $member->where('member_id', $member_id)->get();
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan
                $u = $user->where('id', $member_id)->get();
                // Jika ada bulan yang dipilih, tambahkan kondisi pencarian berdasarkan bulan  
                $jumlah_data = $booking->selectRaw('COUNT(DISTINCT event_id) as jumlah_event')
                                        ->where('member_id', $id)
                                        ->first();

                // Jika tidak ada bulan yang dipilih, ambil semua data event
                $events = $jumlah_data->jumlah_event;
                // Jika tidak ada bulan yang dipilih, ambil semua data booking
                $bookings = $b->count();
                // Jika tidak ada bulan yang dipilih, ambil semua data member
                $members = $m->count();
                // Jika tidak ada bulan yang dipilih, ambil semua data user
                $users = $u->count();
                // Jika tidak ada bulan yang dipilih, ambil semua data article
                $articles = $article->count();
            }

            $no8 = "08";
            $no9 = "09";

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [01])
                        ->first();
            $total1 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [02])
                        ->first();
            $total2 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [03])
                        ->first();
            $total3 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [04])
                        ->first();
            $total4 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [05])
                        ->first();
            $total5 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [06])
                        ->first();
            $total6 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [07])
                        ->first();
            $total7 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [intval($no8)])
                        ->first();
            $total8 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [intval($no9)])
                        ->first();
            $total9 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [10])
                        ->first();
            $total10 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [11])
                        ->first();
            $total11 = $total->jumlah_event;

            $total = DB::table('transaction_booking')
                        ->join('master_events', 'transaction_booking.event_id', '=', 'master_events.id')
                        ->select(DB::raw('COUNT(DISTINCT transaction_booking.event_id) as jumlah_event'))
                        ->where('transaction_booking.member_id', $id)
                        ->whereRaw('MONTH(master_events.date) = ?', [12])
                        ->first();
            $total12 = $total->jumlah_event;
        }

        return view('member.dashboard.index ', [
            'events' => $events,
            'members' => $members,
            'bookings' => $bookings,
            'users' => $users,
            'articles' => $articles,
            'point' => $point,
            'total1' => $total1,
            'total2' => $total2,
            'total3' => $total3,
            'total4' => $total4,
            'total5' => $total5,
            'total6' => $total6,
            'total7' => $total7,
            'total8' => $total8,
            'total9' => $total9,
            'total10' => $total10,
            'total11' => $total11,
            'total12' => $total12,
        ]);
    }
}
