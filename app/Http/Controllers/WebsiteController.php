<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Validator;
use App\Models\Navbar;
use App\Models\NavbarSub;
use App\Models\Slider;
use App\Models\History;
use App\Models\Label;
use App\Models\EventCategory;
use App\Models\Event;
use App\Models\Gallery;
use App\Models\News;
use App\Models\About;
use App\Models\Button;
use App\Models\Team;
use App\Models\Procedure;
use App\Models\Testimonial;
use App\Models\Question;
use App\Models\Message;
use App\Models\Image;
use App\Models\Slogan;

class WebsiteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {

        // Menu
        $navbars = Navbar::with('navbarsub')->orderBy('ordering')->get();
        $subnavbars = NavbarSub::orderBy('ordering')->get();

        // Label
        $label = Label::orderBy('ordering')->get();

        // Button
        $button = Button::orderBy('created_at')->get();

        // Image
        $image = Image::orderBy('ordering')->get();

        // Stories
        $historys = History::orderBy('ordering')->get();

        // Count
        $about = About::orderBy('ordering')->get();

        // Team
        $team = Team::orderBy('created_at')->take(4)->get();

        // Testimonial
        $testimonial = Testimonial::orderBy('ordering')->get();

        // Galeri
        $gallery = Gallery::inRandomOrder()->take(8)->get();

        // Berita
        $news = News::orderBy('created_at')->take(6)->get();

        // Kegiatan
        $event = Event::orderBy('created_at')->take(6)->get();

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
            'event' => $event
        ]);
    }


    /**
     * show
     *
     * @param  mixed $data
     * @return void
     */
    public function login()
    {
        return view('auth.login');
    }
}
