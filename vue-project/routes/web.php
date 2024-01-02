<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\CalculatorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    // Check if the user is authenticated
    if (auth()->check()) {
        // If authenticated, redirect to the home page
        return redirect()->route('home');
    }

    // If not authenticated, render the registration page
    return Inertia::render('Auth/Register', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
})->name('welcome'); // You can give this route a name if needed

Route::get('/home', function () {
    return Inertia::render('HomePage');
})->middleware(['auth', 'verified'])->name('home');

// ... (Your other routes remain unchanged)

Route::post('/save-calculation', [CalculatorController::class, 'saveCalculationResult']);

Route::get('/show-last-calculations', [CalculatorController::class, 'showLastCalculations'])
    ->middleware(['auth', 'verified'])
    ->name('showLastCalculations');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
