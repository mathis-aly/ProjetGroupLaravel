<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ListingController;


$articles = [
    [
        'id' => 1,
        'title' => 'Le burger du quartier',
        'description' => 'Un burger gourmand préparé avec un steak frais, du cheddar fondant et une sauce maison.',
    ],
    [
        'id' => 2,
        'title' => 'Tacos croustillant',
        'description' => 'Un tacos généreux garni de poulet mariné, de légumes frais et de notre sauce crémeuse.',
    ],
    [
        'id' => 3,
        'title' => 'Brunch ensoleillé',
        'description' => 'Un brunch fait maison avec tartines, fruits de saison et jus pressé du jour.',
    ],
    [
        'id' => 4,
        'title' => 'Pizza du marché',
        'description' => 'Une pizza artisanale garnie de légumes frais, de mozzarella fondante et de basilic.',
    ],
    [
        'id' => 5,
        'title' => 'Bowl coloré',
        'description' => 'Un bowl équilibré avec du riz, des légumes croquants, de l’avocat et une sauce citronnée.',
    ],
    [
        'id' => 6,
        'title' => 'Cookie tout chaud',
        'description' => 'Un cookie moelleux aux pépites de chocolat, préparé et cuit sur place.',
    ],
    [
        'id' => 7,
        'title' => 'Sandwich veggie',
        'description' => 'Un sandwich généreux aux légumes grillés, fromage frais et pain croustillant.',
    ],
    [
        'id' => 8,
        'title' => 'Jus frais du jour',
        'description' => 'Un mélange rafraîchissant de fruits pressés, préparé avec les produits de saison.',
    ],
];

Route::get('/accueil', function () use ($articles) {
    return view('accueil', compact('articles'));
});

Route::get('/annonces', [ListingController::class, 'index'])->name('annonces.index');

Route::get('/annonce/{listing}', [ListingController::class, 'show'])->name('annonce');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
