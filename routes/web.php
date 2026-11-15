<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;



Route::get('/accueil', [ListingController::class, 'accueil'])->name('accueil');

Route::get('/annonces', [ListingController::class, 'annonces'])->name('annonces');

Route::get('/annonce/{listing:slug}', [ListingController::class, 'show'])->name('annonce');

Route::get('/annonces/creer', [ListingController::class, 'create'])->name('listings.create');

Route::get('/mesAnnonces/{user_name}', [ListingController::class, 'mesAnnonces'])->name('mesAnnonces');



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/annonces/creer', [ListingController::class, 'create'])->name('listings.create');
    Route::post('/annonces', [ListingController::class, 'store'])->name('listings.store');
});

require __DIR__.'/auth.php';
