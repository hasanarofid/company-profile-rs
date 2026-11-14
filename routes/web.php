<?php

use App\Http\Controllers\Admin\AppointmentController as AdminAppointmentController;
use App\Http\Controllers\Admin\CareerController as AdminCareerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DepartmentController as AdminDepartmentController;
use App\Http\Controllers\Admin\DoctorController as AdminDoctorController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CareerController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\DoctorController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes - Company Profile Rumah Sakit
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');

// Direktori & Jadwal Dokter + Unit/Poli
Route::get('/dokter', [DoctorController::class, 'index'])->name('doctors.index');
Route::get('/dokter/{slug}', [DoctorController::class, 'show'])->name('doctors.show');

// Reservasi Janji Temu Pasien (Appointment)
Route::get('/janji-temu', [AppointmentController::class, 'create'])->name('appointments.create');
Route::post('/janji-temu', [AppointmentController::class, 'store'])->name('appointments.store');

// Artikel Kesehatan, Berita & Pengumuman
Route::get('/artikel', [ArticleController::class, 'index'])->name('articles.index');
Route::get('/artikel/{slug}', [ArticleController::class, 'show'])->name('articles.show');

// Portal Karir & Lowongan Kerja
Route::get('/karir', [CareerController::class, 'index'])->name('careers.index');
Route::get('/karir/{slug}', [CareerController::class, 'show'])->name('careers.show');
Route::post('/karir/{slug}/lamar', [CareerController::class, 'apply'])->name('careers.apply');

// Kontak & Informasi Lokasi RS
Route::get('/kontak', [ContactController::class, 'index'])->name('contact.index');
Route::post('/konsultasi', [ContactController::class, 'store'])->name('inquiries.store');

/*
|--------------------------------------------------------------------------
| Auth & Admin CMS Routes
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/', fn () => redirect()->route('admin.dashboard'));
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Manajemen Janji Temu Pasien
    Route::get('/appointments', [AdminAppointmentController::class, 'index'])->name('appointments.index');
    Route::patch('/appointments/{appointment}/status', [AdminAppointmentController::class, 'updateStatus'])->name('appointments.status');
    Route::delete('/appointments/{appointment}', [AdminAppointmentController::class, 'destroy'])->name('appointments.destroy');

    // Manajemen Unit / Poli
    Route::resource('departments', AdminDepartmentController::class)->except(['create', 'edit', 'show']);

    // Manajemen Dokter & Jadwal Praktik
    Route::resource('doctors', AdminDoctorController::class)->except(['create', 'edit', 'show']);

    // Manajemen Lowongan Kerja & Pelamar
    Route::resource('careers', AdminCareerController::class)->except(['create', 'edit', 'show']);
    Route::patch('/career-applications/{application}/status', [AdminCareerController::class, 'updateApplicationStatus'])->name('careers.applications.status');

    // Manajemen Artikel & Kategori
    Route::resource('posts', PostController::class);
    Route::post('categories', [PostController::class, 'storeCategory'])->name('categories.store');
    Route::delete('categories/{category}', [PostController::class, 'destroyCategory'])->name('categories.destroy');

    // Page & Layout Customizer
    Route::resource('pages', PageController::class);
    Route::put('pages/{page}/sections/{section}', [PageController::class, 'updateSection'])->name('pages.sections.update');
    Route::post('pages/{page}/reorder', [PageController::class, 'reorderSections'])->name('pages.sections.reorder');

    // Pengaturan RS & Theme Color Customizer
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');
});

require __DIR__.'/auth.php';
