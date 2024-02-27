<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Button;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\History;
use App\Models\Image;
use App\Models\Label;
use App\Models\Navbar;
use App\Models\NavbarSub;
use App\Models\News;
use App\Models\Question;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;

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
        $subnavbars = NavbarSub::orderBy('ordering')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Stories
        $historys = History::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Count
        $about = About::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Team
        $team = Team::orderBy('created_at')->take(4)->where('status', 'ACTIVE')->get();

        // Testimonial
        $testimonial = Testimonial::orderBy('ordering')->where('status', 'ACTIVE')->get();

        // Galeri
        $gallery = Gallery::inRandomOrder()->take(8)->where('status', 'ACTIVE')->get();

        // Berita
        $news = News::orderBy('created_at')->take(6)->where('status', 'ACTIVE')->get();

        // Kegiatan
        $event = Event::orderBy('created_at')->take(6)->where('status', 'ACTIVE')->get();

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
        $subnavbars = NavbarSub::orderBy('ordering')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Event
        $events = Event::orderBy('date', 'desc')->get();

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
        $subnavbars = NavbarSub::orderBy('ordering')->get();

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
        $subnavbars = NavbarSub::orderBy('ordering')->get();

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

        // Ambil data event berdasarkan kondisi yang telah ditetapkan
        $events = $query->orderBy('date', 'desc')->get();


        return view('front.calendar', [
            'navbars' => $navbars,
            'subnavbars' => $subnavbars,
            'label' => $label,
            'button' => $button,
            'image' => $image,
            'events' => $events
        ]);
    }
}
