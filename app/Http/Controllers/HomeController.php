<?php

namespace App\Http\Controllers;

use App\Models\Listing;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function __invoke(): View
    {
        $latestListings = Cache::remember('home.latest', 600, fn () => Listing::available()
            ->with(['category', 'user'])
            ->latest()
            ->take(8)
            ->get()
        );

        return view('accueil', ['articles' => $latestListings]);
    }
}
