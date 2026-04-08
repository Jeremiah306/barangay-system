<?php
use App\Http\Controllers\HouseholdController;
use App\Http\Controllers\ResidentController;
use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

// Admin Routes
Route::middleware(['auth', 'admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');
});

// Authenticated Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::resource('households', HouseholdController::class);

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
});

require __DIR__.'/auth.php';