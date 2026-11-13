<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\View\View;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;

class ListingController extends Controller
{

    public function accueil(Request $request): View
    {
        $articles = $this->filteredListings($request)
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('accueil', compact('articles', 'categories'));
    }

    public function annonces(Request $request): View
    {
        $articles = $this->filteredListings($request)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('annonces', compact('articles', 'categories'));
    }

    private function filteredListings(Request $request): Builder
    {
        return Listing::query()
            ->available()
            ->with(['category', 'user'])
            ->when($request->filled('q'), fn ($query) =>
                $query->where('title', 'like', '%' . $request->input('q') . '%'))
            ->when($request->filled('category'), fn ($query) =>
                $query->whereRelation('category', 'slug', $request->input('category')))
            ->when($request->filled('max_price'), fn ($query) =>
                $query->where('price', '<=', $request->input('max_price')));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $listing = Listing::with(['category', 'user'])->findOrFail($id);
        return view('detailArticle', ['article' => $listing]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
