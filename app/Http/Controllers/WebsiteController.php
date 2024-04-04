<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Button;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\History;
use App\Models\Image;
use App\Models\Label;
use App\Models\Member;
use App\Models\Navbar;
use App\Models\NavbarSub;
use App\Models\News;
use App\Models\Question;
use App\Models\Testimonial;
use App\Models\TransactionBooking;
use App\Models\TransactionPayment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class WebsiteController extends Controller
{
    public function __invoke(Request $request)
    {

        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PARALLAX')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Stories
        $historys = History::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Count
        $about = About::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Team members with highest points
        $team = Member::with('point')
            ->has('point') // Filters out members with no points
            ->withCount('point as total_point') // Calculate total points
            ->orderByDesc('total_point') // Order by total points in descending order
            ->orderBy('created_at') // Then order by creation date
            ->where('status', 'ACTIVE')
            ->take(4)
            ->get();

        // Testimonial
        $testimonial = Testimonial::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Galeri
        $gallery = Gallery::inRandomOrder()->take(8)->where('status', 'ACTIVE')->get();

        // Berita
        $news = News::orderBy('created_at')->take(6)->where('status', 'ACTIVE')->get();

        // Kegiatan
        // $event = Event::orderBy('created_at')->take(6)->where('status', 'ACTIVE')->get();

        // Event tanggal aktif
        $currentDate = Carbon::now();
        $event = Event::whereDate('expiry_date', '>=', $currentDate)->take(6)
            ->orderBy('expiry_date', 'asc')
            ->get();

        // FAQ
        $question = Question::orderBy('ordering')->where('status', 'ACTIVE')->get();

        return view('home', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'historys' => $historys,
            'about' => $about,
            'team' => $team,
            'testimonial' => $testimonial,
            'gallery' => $gallery,
            'news' => $news,
            'events' => $event,
            'question' => $question
        ]);
    }


    public function login()
    {
        return view('auth.login');
    }


    public function showEventForm()
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Event
        $currentDate = Carbon::now();
        $events = Event::whereDate('expiry_date', '>=', $currentDate)->get();

        return view('front.event', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'events' => $events
        ]);
    }

    public function showEventDetail($id)
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Event
        $event = Event::find($id);

        return view('front.event-detail', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'event' => $event
        ]);
    }

    public function showCalendarForm(Request $request)
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Event
        $month = $request->input('month'); // Mengambil nilai bulan dari permintaan
        $search = $request->input('search'); // Mengambil nilai pencarian dari permintaan

        $query = Event::query();

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
        }

        // // Ambil data event berdasarkan kondisi yang telah ditetapkan
        // $events = $query->orderBy('date', 'desc')->get();

        // Event
        $currentDate = Carbon::now();
        $events = Event::whereDate('expiry_date', '>=', $currentDate)->get();


        return view('front.calendar', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'events' => $events
        ]);
    }

    public function showCalendarDetail($id)
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // News
        $news = News::orderBy('created_at', 'desc')->get();

        // Event
        $event = Event::find($id);

        return view('front.event-detail', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'news' => $news,
            'event' => $event
        ]);
    }

    public function showNewsForm()
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // News
        $news = News::orderBy('created_at', 'desc')->get();

        return view('front.news', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'news' => $news
        ]);
    }

    public function showNewsDetail($id)
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // News
        $news = News::find($id);

        return view('front.news-detail', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'news' => $news
        ]);
    }

    public function showPointForm()
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // News
        $member = Member::with('point')
            ->has('point') // Filters out members with no points
            ->withCount('point as total_point') // Calculate total points
            ->orderByDesc('total_point') // Order by total points in descending order
            ->orderBy('created_at') // Then order by creation date
            ->where('status', 'ACTIVE')
            ->get();

        return view('front.point', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'team' => $member
        ]);
    }

    public function showPointDetail($id)
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Member
        $member = Member::find($id);

        return view('front.point-detail', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'member' => $member
        ]);
    }

    public function store(Request $request)
    {

        // Validasi data yang diterima dari form
        $validator = Validator::make($request->all(), [
            'image' => 'required|image|mimes:jpeg,jpg,png|max:2048',
            'invoice_number' => 'required|string|max:255',
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

            $member = new TransactionPayment;
            $member->file = $imageName;
            $member->invoice_number = $request->invoice_number;
            $member->sender = $request->sender;
            $member->methode = $request->methode;
            $member->from = $request->from;
            $member->paid_date = $request->paid_date;
            $member->note = $request->note;
            $member->amount = $request->amount;
            $member->category = 'SEND';
            $member->event_id = $request->event_id;
            $member->save();

            // $this->confirm($request->event_id);
        }

        return redirect()->route('confirms-payment')->with('success', 'Booking success, invoice has been generated');
    }

    public function showConfirms()
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();

        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        $button = Button::all();
        $label = Label::all();
        // Master data event
        $event = Event::where('status', 'ACTIVE')->get();
        // List data booking
        $booking = TransactionBooking::where('status', 'ACTIVE')->get();
        // var_dump($data);
        return view('front.confirm-invoice', compact('label', 'event', 'booking', 'navbars', 'subnavbars', 'button'));
    }

    public function getConfirmById($id)
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

    public function showBooking(Request $request)
    {

        // Button
        $button = Button::orderBy('created_at')->get();

        // Event
        $month = $request->input('month'); // Mengambil nilai bulan dari permintaan
        $search = $request->input('search'); // Mengambil nilai pencarian dari permintaan

        $query = Member::query();

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
        }

        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();

        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        $button     = Button::all();
        $label      = Label::all();

        // List data booking
        $data = Member::latest()->paginate(10);

        // Ambil data event berdasarkan kondisi yang telah ditetapkan
        $member = $query->orderBy('date', 'desc')->get();

        return view('front.booking-list', compact('label', 'data', 'navbars', 'subnavbars', 'button', 'member'));
    }

    public function showRiderForm()
    {
        // Menu
        $navbars = Navbar::with('navbarsub')
            ->where('status', 'ACTIVE')
            ->where('category', 'PAGES')
            ->orderBy('ordering')
            ->get();
        $subnavbars = NavbarSub::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // News
        //        $member = Member::with('point')
        //            ->has('point') // Filters out members with no points
        //            ->withCount('point as total_point') // Calculate total points
        //            ->orderByDesc('total_point') // Order by total points in descending order
        //            ->orderBy('created_at') // Then order by creation date
        //            ->where('status', 'ACTIVE')
        //            ->get();

        $member = Member::leftJoin('transaction_point', 'master_members.id', '=', 'transaction_point.member_id')
            ->select(
                'master_members.id',
                'master_members.image',
                'master_members.code',
                'master_members.name',
                'master_members.place',
                'master_members.date',
                'transaction_point.category_id',
                'transaction_point.point_rank',
                'transaction_point.point_participation',
                'transaction_point.total_point',
                'transaction_point.rank'
            )
            ->orderBy('master_members.created_at')
            ->where('master_members.status', 'ACTIVE')
            ->get();


        return view('front.rider', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'team' => $member
        ]);
    }
}
