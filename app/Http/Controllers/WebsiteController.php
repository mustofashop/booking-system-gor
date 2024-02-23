<?php

namespace App\Http\Controllers;

use App\Models\About;
use App\Models\Button;
use App\Models\Event;
use App\Models\EventCategory;
use App\Models\Gallery;
use App\Models\History;
use App\Models\Image;
use App\Models\Label;
use App\Models\Message;
use App\Models\Navbar;
use App\Models\NavbarSub;
use App\Models\News;
use App\Models\Procedure;
use App\Models\Question;
use App\Models\Slider;
use App\Models\Slogan;
use App\Models\Team;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use Validator;

class WebsiteController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param \Illuminate\Http\Request $request
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
            'event' => $event,
            'question' => $question
        ]);
    }


    /**
     * show
     *
     * @param mixed $data
     * @return void
     */
    public function login()
    {
        return view('auth.login');
    }
}
