<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Listing;
use Illuminate\View\View;
use App\Models\Category;
use Illuminate\Database\Eloquent\Builder;
use App\Enums\ListingCondition;
use Illuminate\Support\Str;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\StoreListingRequest;

class ListingController extends Controller
{


    public function mesAnnonces(Request $request, string $user_name): View
    {
        $user = auth()->user();

        if (! $user) {
            abort(401);
        }

        if ($user->name !== $user_name) {
            abort(403);
        }
        $articles = $this->filteredListings($request)
            ->latest()
            ->paginate(12)
            ->where('user_id', auth()->id());

        $categories = Category::orderBy('name')->get();

        return view('mes-annonces', compact('articles', 'categories'));
    }

    public function accueil(Request $request): View
    {
        $articles = $this->filteredListings($request)
            ->latest()
            ->paginate(6)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('accueil', compact('articles', 'categories'));
    }

    public function create(): View
    {
    return view('listings.create', [
        'categories' => Category::orderBy('name')->get(),
        'conditions' => ListingCondition::cases(),
    ]);
    }

    public function edit(string $slug): View
    {
        $listing = Listing::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $listing->user_id) {
            abort(403);
        }
    return view('listings.edit', [
        'categories' => Category::orderBy('name')->get(),
        'conditions' => ListingCondition::cases(),
        'listing' => $listing,
    ]);
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
  

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreListingRequest $request): RedirectResponse
    {
        $listing = $request->user()->listings()->create([
            ...$request->validated(),
            'slug' => Str::slug($request->validated('title')) . '-' . Str::lower(Str::random(6)),
        ]);

        return redirect()->route('annonce', $listing)
            ->with('success', 'Annonce publiée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug)
    {
        $listing = Listing::with(['category', 'user'])->where('slug', $slug)->firstOrFail();
        return view('detailArticle', ['article' => $listing]);
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
