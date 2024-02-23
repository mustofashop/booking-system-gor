<?php

use App\Http\Controllers\Administrator\AboutController;
use App\Http\Controllers\Administrator\ButtonController;
use App\Http\Controllers\Administrator\CountController;
use App\Http\Controllers\Administrator\FaqController;
use App\Http\Controllers\Administrator\ImageController;
use App\Http\Controllers\Administrator\LabelController;
use App\Http\Controllers\Administrator\TestimoniController;
use App\Http\Controllers\Administrator\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
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

    // Role Administrator
    Route::middleware(['administrator'])->group(function () {
        Route::get('/profil', ProfilController::class)->name('profil');

        // User Management
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{id}', [UserController::class, 'show'])->name('user.show');
        Route::get('/user/{id}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{id}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{id}', [UserController::class, 'destroy'])->name('user.destroy');

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
        Route::get('/faq', [FaqController::class, 'index'])->name('faq.index');
        Route::get('/faq/create', [FaqController::class, 'create'])->name('faq.create');
        Route::post('/faq', [FaqController::class, 'store'])->name('faq.store');
        Route::get('/faq/{id}', [FaqController::class, 'show'])->name('faq.show');
        Route::get('/faq/{id}/edit', [FaqController::class, 'edit'])->name('faq.edit');
        Route::put('/faq/{id}', [FaqController::class, 'update'])->name('faq.update');
        Route::delete('/faq/destroy/{id}', [FaqController::class, 'destroy'])->name('faq.destroy');

    });

    // Role Event
    Route::middleware(['event'])->group(function () {
        Route::get('/profil', ProfilController::class)->name('profil');
    });

    // Role Member
    Route::middleware(['member'])->group(function () {
        Route::get('/profil', ProfilController::class)->name('profil');
    });

});

