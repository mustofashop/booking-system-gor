<?php

use App\Http\Controllers\Administrator\AboutController;
use App\Http\Controllers\Administrator\ArticleController;
use App\Http\Controllers\Administrator\ButtonController;
use App\Http\Controllers\Administrator\ConfirmController;
use App\Http\Controllers\Administrator\CountController;
use App\Http\Controllers\Administrator\FAQController;
use App\Http\Controllers\Administrator\ImageController;
use App\Http\Controllers\Administrator\LabelController;
use App\Http\Controllers\Administrator\TestimoniController;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Event\AccountController;
use App\Http\Controllers\Event\BucketController;
use App\Http\Controllers\Event\EventController;
use App\Http\Controllers\Event\MemberController;
use App\Http\Controllers\Event\PointController;
use App\Http\Controllers\Member\BookingController;
use App\Http\Controllers\Member\PaymentController;
use App\Http\Controllers\Member\RiderController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\WebsiteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', WebsiteController::class);
Route::get('/event-all', [WebsiteController::class, 'showEventForm'])->name('event-all');
Route::get('/event-show/{id}', [WebsiteController::class, 'showEventDetail'])->name('event-show');
Route::get('/news-all', [WebsiteController::class, 'showNewsForm'])->name('news-all');
Route::get('/news-show/{id}', [WebsiteController::class, 'showNewsDetail'])->name('news-show');
Route::get('/calendar', [WebsiteController::class, 'showCalendarForm'])->name('calendar');
Route::get('/calendar-show/{id}', [WebsiteController::class, 'showCalendarDetail'])->name('calendar-show');
Route::get('/point-all', [WebsiteController::class, 'showPointForm'])->name('point-all');
Route::get('/point-show/{id}', [WebsiteController::class, 'showPointDetail'])->name('point-show');

// Manage Auth
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::get('/forgot-password', [AuthController::class, 'showForgotPasswordForm'])->name('forgot-password');
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);

Route::middleware(['auth'])->group(function () {
    // Dashboard Auth
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/welcome', [DashboardController::class, 'welcome'])->name('dashboard.welcome');
    // Account Auth
    Route::get('/account', ProfilController::class)->name('account');

    // Role Administrator
    Route::middleware(['administrator'])->group(function () {
        Route::get('/profil', ProfilController::class)->name('profil');

        // Article Management
        Route::get('/article', [ArticleController::class, 'index'])->name('article.index');
        Route::get('/article/create', [ArticleController::class, 'create'])->name('article.create');
        Route::post('/article', [ArticleController::class, 'store'])->name('article.store');
        Route::get('/article/{id}', [ArticleController::class, 'show'])->name('article.show');
        Route::get('/article/{id}/edit', [ArticleController::class, 'edit'])->name('article.edit');
        Route::put('/article/{id}', [ArticleController::class, 'update'])->name('article.update');
        Route::delete('/article/destroy/{id}', [ArticleController::class, 'destroy'])->name('article.destroy');

        // User Management
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/destroy/{id}', [UserController::class, 'destroy'])->name('user.destroy');

        // Label Management
        Route::get('/label', [LabelController::class, 'index'])->name('label.index');
        Route::get('/label/create', [LabelController::class, 'create'])->name('label.create');
        Route::post('/label', [LabelController::class, 'store'])->name('label.store');
        Route::get('/label/{id}', [LabelController::class, 'show'])->name('label.show');
        Route::get('/label/{id}/edit', [LabelController::class, 'edit'])->name('label.edit');
        Route::put('/label/{id}', [LabelController::class, 'update'])->name('label.update');
        Route::delete('/label/{id}', [LabelController::class, 'destroy'])->name('label.destroy');

        // Button Management
        Route::get('/button', [ButtonController::class, 'index'])->name('button.index');
        Route::get('/button/create', [ButtonController::class, 'create'])->name('button.create');
        Route::post('/button', [ButtonController::class, 'store'])->name('button.store');
        Route::get('/button/{id}', [ButtonController::class, 'show'])->name('button.show');
        Route::get('/button/{id}/edit', [ButtonController::class, 'edit'])->name('button.edit');
        Route::put('/button/{id}', [ButtonController::class, 'update'])->name('button.update');
        Route::delete('/button/{id}', [ButtonController::class, 'destroy'])->name('button.destroy');

        // Image Management
        Route::get('/image', [ImageController::class, 'index'])->name('image.index');
        Route::get('/image/create', [ImageController::class, 'create'])->name('image.create');
        Route::post('/image', [ImageController::class, 'store'])->name('image.store');
        Route::get('/image/{id}', [ImageController::class, 'show'])->name('image.show');
        Route::get('/image/{id}/edit', [ImageController::class, 'edit'])->name('image.edit');
        Route::put('/image/{id}', [ImageController::class, 'update'])->name('image.update');
        Route::delete('/image/{id}', [ImageController::class, 'destroy'])->name('image.destroy');

        // About Management
        Route::get('/about', [AboutController::class, 'index'])->name('about.index');
        Route::get('/about/create', [AboutController::class, 'create'])->name('about.create');
        Route::post('/about', [AboutController::class, 'store'])->name('about.store');
        Route::get('/about/{id}', [AboutController::class, 'show'])->name('about.show');
        Route::get('/about/{id}/edit', [AboutController::class, 'edit'])->name('about.edit');
        Route::put('/about/{id}', [AboutController::class, 'update'])->name('about.update');
        Route::delete('/about/destroy/{id}', [AboutController::class, 'destroy'])->name('about.destroy');

        // Count Management
        Route::get('/count', [CountController::class, 'index'])->name('count.index');
        Route::get('/count/create', [CountController::class, 'create'])->name('count.create');
        Route::post('/count', [CountController::class, 'store'])->name('count.store');
        Route::get('/count/{id}', [CountController::class, 'show'])->name('count.show');
        Route::get('/count/{id}/edit', [CountController::class, 'edit'])->name('count.edit');
        Route::put('/count/{id}', [CountController::class, 'update'])->name('count.update');
        Route::delete('/count/destroy/{id}', [CountController::class, 'destroy'])->name('count.destroy');

        // Testimoni Management
        Route::get('/testimoni', [TestimoniController::class, 'index'])->name('testimoni.index');
        Route::get('/testimoni/create', [TestimoniController::class, 'create'])->name('testimoni.create');
        Route::post('/testimoni', [TestimoniController::class, 'store'])->name('testimoni.store');
        Route::get('/testimoni/{id}', [TestimoniController::class, 'show'])->name('testimoni.show');
        Route::get('/testimoni/{id}/edit', [TestimoniController::class, 'edit'])->name('testimoni.edit');
        Route::put('/testimoni/{id}', [TestimoniController::class, 'update'])->name('testimoni.update');
        Route::delete('/testimoni/destroy/{id}', [TestimoniController::class, 'destroy'])->name('testimoni.destroy');

        // FAQ Management
        Route::get('/faq', [FAQController::class, 'index'])->name('faq.index');
        Route::get('/faq/create', [FAQController::class, 'create'])->name('faq.create');
        Route::post('/faq', [FAQController::class, 'store'])->name('faq.store');
        Route::get('/faq/{id}', [FAQController::class, 'show'])->name('faq.show');
        Route::get('/faq/{id}/edit', [FAQController::class, 'edit'])->name('faq.edit');
        Route::put('/faq/{id}', [FAQController::class, 'update'])->name('faq.update');
        Route::delete('/faq/destroy/{id}', [FAQController::class, 'destroy'])->name('faq.destroy');

        // Payment Confirmation
        Route::get('/confirm', [ConfirmController::class, 'index'])->name('confirm.index');
        Route::get('/confirm/create', [ConfirmController::class, 'create'])->name('confirm.create');
        Route::post('/confirm', [ConfirmController::class, 'store'])->name('confirm.store');
        Route::get('/confirm/{id}', [ConfirmController::class, 'show'])->name('confirm.show');
        Route::get('/confirm/{id}/edit', [ConfirmController::class, 'edit'])->name('confirm.edit');
        Route::put('/confirm/{id}', [ConfirmController::class, 'update'])->name('confirm.update');
        Route::delete('/confirm/destroy/{id}', [ConfirmController::class, 'destroy'])->name('confirm.destroy');

        // Member Management
        Route::get('/member', [MemberController::class, 'index'])->name('member.index');
        Route::get('/member/create', [MemberController::class, 'create'])->name('member.create');
        Route::post('/member', [MemberController::class, 'store'])->name('member.store');
        Route::get('/member/show/{id}', [MemberController::class, 'show'])->name('member.show');
        Route::get('/member/{id}/edit', [MemberController::class, 'edit'])->name('member.edit');
        Route::put('/member/{id}', [MemberController::class, 'update'])->name('member.update');
        Route::delete('/member/destroy/{id}', [MemberController::class, 'destroy'])->name('member.destroy');

        // User Management
        Route::get('/event', [EventController::class, 'index'])->name('event.index');
        Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
        Route::post('/event', [EventController::class, 'store'])->name('event.store');
        Route::get('/event/show/{id}', [EventController::class, 'show'])->name('event.show');
        Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
        Route::put('/event/{id}', [EventController::class, 'update'])->name('event.update');
        Route::delete('/event/destroy/{id}', [EventController::class, 'destroy'])->name('event.destroy');
    });

    // Role Event
    Route::middleware(['event'])->group(function () {
        Route::get('/profil', ProfilController::class)->name('profil');

        // User Management
        Route::get('/user', [AccountController::class, 'index'])->name('user.index');
        Route::get('/user/create', [AccountController::class, 'create'])->name('user.create');
        Route::post('/user', [AccountController::class, 'store'])->name('user.store');
        Route::get('/user/{id}/edit', [AccountController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [AccountController::class, 'update'])->name('user.update');
        Route::delete('/user/destroy/{id}', [AccountController::class, 'destroy'])->name('user.destroy');
        Route::get('/user/{id}/add', [AccountController::class, 'add'])->name('user.profile');
        Route::post('/user/{id}/add', [AccountController::class, 'storeProfile'])->name('user.profile.store');
        Route::get('/user/{id}/show', [AccountController::class, 'show'])->name('user.profile.show');
        Route::put('/user/{id}/update', [AccountController::class, 'updateProfile'])->name('user.profile.update');

        // User Management
        Route::get('/event', [EventController::class, 'index'])->name('event.index');
        Route::get('/event/create', [EventController::class, 'create'])->name('event.create');
        Route::get('/event/calendar', [EventController::class, 'calendar'])->name('event.calendar');
        Route::post('/event', [EventController::class, 'store'])->name('event.store');
        Route::get('/event/show/{id}', [EventController::class, 'show'])->name('event.show');
        Route::get('/event/{id}/edit', [EventController::class, 'edit'])->name('event.edit');
        Route::put('/event/{id}', [EventController::class, 'update'])->name('event.update');
        Route::delete('/event/destroy/{id}', [EventController::class, 'destroy'])->name('event.destroy');

        // Point Management
        Route::get('/point', [PointController::class, 'index'])->name('point.index');
        Route::get('/point/create', [PointController::class, 'create'])->name('point.create');
        Route::post('/point', [PointController::class, 'store'])->name('point.store');
        Route::get('/point/show/{id}', [PointController::class, 'show'])->name('point.show');
        Route::get('/point/{id}/edit', [PointController::class, 'edit'])->name('point.edit');
        Route::put('/point/{id}', [PointController::class, 'update'])->name('point.update');
        Route::delete('/point/destroy/{id}', [PointController::class, 'destroy'])->name('point.destroy');
        // Point Management
        Route::get('/point', [PointController::class, 'index'])->name('point.index');
        Route::get('/point/create', [PointController::class, 'create'])->name('point.create');
        Route::post('/point', [PointController::class, 'store'])->name('point.store');
        Route::get('/point/show/{id}', [PointController::class, 'show'])->name('point.show');
        Route::get('/point/{id}/edit', [PointController::class, 'edit'])->name('point.edit');
        Route::put('/point/{id}', [PointController::class, 'update'])->name('point.update');
        Route::delete('/point/destroy/{id}', [PointController::class, 'destroy'])->name('point.destroy');
    });

        // Event Management
        Route::get('/bucket', [BucketController::class, 'index'])->name('bucket.index');
        Route::get('/bucket/create', [BucketController::class, 'create'])->name('bucket.create');
        Route::post('/bucket', [BucketController::class, 'store'])->name('bucket.store');
        Route::get('/bucket/{id}', [BucketController::class, 'show'])->name('bucket.show');
        Route::get('/bucket/{id}/edit', [BucketController::class, 'edit'])->name('bucket.edit');
        Route::put('/bucket/{id}', [BucketController::class, 'update'])->name('bucket.update');
        Route::delete('/bucket/destroy/{id}', [BucketController::class, 'destroy'])->name('bucket.destroy');
        Route::get('/getBucketById/{id}', [BucketController::class, 'getBucketById'])->name('bucket.event');
        Route::get('/getMemberById/{id}', [BucketController::class, 'getMemberById'])->name('bucket.member');
        Route::get('/bucket/invoice/{id}', [BucketController::class, 'showInvoice'])->name('bucket.invoice');

    });

    // Role Member
    Route::middleware(['member'])->group(function () {

        // Booking Event
        Route::get('/booking/{id}', [BookingController::class, 'showBookingForm'])->name('booking.show');
        Route::post('/booking/{id}', [BookingController::class, 'storeBookingForm'])->name('booking.bucket');
        Route::get('/booking', [BookingController::class, 'index'])->name('booking.index');
        Route::get('/booking/create', [BookingController::class, 'create'])->name('booking.create');
        Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');
        Route::get('/booking/{id}/edit', [BookingController::class, 'edit'])->name('booking.edit');
        Route::put('/booking/{id}', [BookingController::class, 'update'])->name('booking.update');
        Route::get('/getEventById/{id}', [BookingController::class, 'getEventById'])->name('booking.event');
        Route::get('/booking/invoice/{id}', [BookingController::class, 'showInvoice'])->name('booking.invoice');

        // Rider Management
        Route::get('/profile', [RiderController::class, 'index'])->name('profile.index');
        Route::get('/profile/create', [RiderController::class, 'create'])->name('profile.create');
        Route::post('/profile', [RiderController::class, 'store'])->name('profile.store');
        Route::get('/profile/{id}', [RiderController::class, 'show'])->name('profile.show');
        Route::get('/profile/{id}/edit', [RiderController::class, 'edit'])->name('profile.edit');
        Route::put('/profile/{id}', [RiderController::class, 'update'])->name('profile.update');
        Route::delete('/profile/{id}', [RiderController::class, 'destroy'])->name('profile.destroy');

        // Payment
        Route::get('/payment', [PaymentController::class, 'index'])->name('payment.index');
        Route::get('/payment/create', [PaymentController::class, 'create'])->name('payment.create');
        Route::post('/payment', [PaymentController::class, 'store'])->name('payment.store');
        Route::get('/payment/{id}', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('/payment/{id}/edit', [PaymentController::class, 'edit'])->name('payment.edit');
        Route::put('/payment/{id}', [PaymentController::class, 'update'])->name('payment.update');
        Route::delete('/payment/{id}', [PaymentController::class, 'destroy'])->name('payment.destroy');
    });

});

