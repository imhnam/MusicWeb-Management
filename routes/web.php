<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ArtistController;
use App\Http\Controllers\Admin\SongController;
use App\Http\Controllers\Admin\GenreController;
use App\Http\Controllers\Admin\PlaylistController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Auth\LoginController;

// Route Auth (Đăng nhập, đăng ký)
Auth::routes();

// Trang chủ → Redirect đến trang login nếu chưa đăng nhập
Route::get('/', function () {
    return redirect('/login');
});

// Nhóm route Admin - Chỉ Admin mới có quyền truy cập
Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('users', UserController::class);
    Route::resource('artists', ArtistController::class);
    Route::resource('songs', SongController::class);
    Route::resource('genres', GenreController::class);
    Route::resource('playlists', PlaylistController::class);
});

// Route dành cho người dùng đã đăng nhập
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [DashboardController::class, 'index'])->name('home');
});

// Route login & logout
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
