<?php
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AnnouncementController;
use App\Http\Controllers\CertificateRequestController;
use App\Http\Controllers\ConcernController;
use App\Http\Controllers\ActivityLogController;
use Illuminate\Support\Facades\Route;

// Home / Welcome Page (public)
Route::get('/', function () {
    $announcements = \App\Models\Announcement::latest()->take(5)->get();
    return view('welcome', compact('announcements'));
})->name('home');

// =====================
// ADMIN ONLY ROUTES
// =====================
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

Route::middleware(['auth', 'admin'])->group(function () {

    // Announcements (Admin only: create, delete)
    Route::get('/announcements/create', [AnnouncementController::class, 'create'])
        ->name('announcements.create');
    Route::post('/announcements', [AnnouncementController::class, 'store'])
        ->name('announcements.store');
    Route::delete('/announcements/{announcement}', [AnnouncementController::class, 'destroy'])
        ->name('announcements.destroy');

    // Admin: Certificate Requests Management
    Route::get('/admin/certificates', [CertificateRequestController::class, 'adminIndex'])
        ->name('certificates.admin');
    Route::put('/admin/certificates/{certificate}', [CertificateRequestController::class, 'updateStatus'])
        ->name('certificates.updateStatus');

    // Admin: Concerns Management
    Route::get('/admin/concerns', [ConcernController::class, 'adminIndex'])
        ->name('concerns.admin');
    Route::put('/admin/concerns/{concern}', [ConcernController::class, 'respond'])
        ->name('concerns.respond');

    // Admin: Activity Logs / Records
    Route::get('/records', [ActivityLogController::class, 'index'])
        ->name('logs.index');
    Route::delete('/records/{log}', [ActivityLogController::class, 'destroy'])
        ->name('logs.destroy');
    Route::delete('/records-all', [ActivityLogController::class, 'destroyAll'])
        ->name('logs.destroyAll');
});

// =====================
// AUTHENTICATED ROUTES
// =====================
Route::middleware('auth')->group(function () {

    // Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Households CRUD
    Route::resource('households', HouseholdController::class);

    // Residents CRUD
    Route::get('households/{household}/residents/create',
        [ResidentController::class, 'create'])->name('residents.create');
    Route::post('households/{household}/residents',
        [ResidentController::class, 'store'])->name('residents.store');
    Route::get('residents/{resident}/edit',
        [ResidentController::class, 'edit'])->name('residents.edit');
    Route::put('residents/{resident}',
        [ResidentController::class, 'update'])->name('residents.update');
    Route::delete('residents/{resident}',
        [ResidentController::class, 'destroy'])->name('residents.destroy');

    // Announcements (Everyone can view)
    Route::get('/announcements', [AnnouncementController::class, 'index'])
        ->name('announcements.index');

    // Certificate Requests (Resident)
    Route::get('/certificates', [CertificateRequestController::class, 'index'])
        ->name('certificates.index');
    Route::get('/certificates/create', [CertificateRequestController::class, 'create'])
        ->name('certificates.create');
    Route::post('/certificates', [CertificateRequestController::class, 'store'])
        ->name('certificates.store');

    // Concerns / Reports (Resident)
    Route::get('/concerns', [ConcernController::class, 'index'])
        ->name('concerns.index');
    Route::get('/concerns/create', [ConcernController::class, 'create'])
        ->name('concerns.create');
    Route::post('/concerns', [ConcernController::class, 'store'])
        ->name('concerns.store');
});

require __DIR__.'/auth.php';