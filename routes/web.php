<?php

use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ListingController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/accueil');

Route::get('/accueil', HomeController::class)->name('accueil');

Route::get('/annonces', [ListingController::class, 'annonces'])->name('annonces');

Route::get('/annonce/{listing:slug}', [ListingController::class, 'show'])->name('annonce');

Route::get('/dashboard', function () {
    return view('dashboard', [
        'user' => auth()->user(),
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/secret', [ProfileController::class, 'updateSecret'])->name('profile.secret.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/annonces/creer', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/annonces', [ListingController::class, 'store'])->name('listings.store');
    Route::get('/annonce/{listing:slug}/modifier', [ListingController::class, 'edit'])->name('listings.edit');
    Route::put('/annonce/{listing:slug}', [ListingController::class, 'update'])->name('listings.update');
    Route::delete('/annonce/{listing:slug}', [ListingController::class, 'destroy'])->name('listings.destroy');
    Route::post('/annonce/{listing:slug}/messages', [ChatController::class, 'store'])->name('chat.store');
    Route::get('/mes-annonces/{user_name}', [ListingController::class, 'mesAnnonces'])->name('mesAnnonces');
});

require __DIR__.'/auth.php';
