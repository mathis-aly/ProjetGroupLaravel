<?php

namespace App\Http\Controllers;

use App\Enums\ListingCondition;
use App\Http\Requests\StoreListingRequest;
use App\Models\Category;
use App\Models\Listing;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ListingController extends Controller
{
    public function mesAnnonces(Request $request, string $user_name): View
    {
        $user = auth()->user();

        if ($user->name !== $user_name) {
            abort(403);
        }

        $articles = $this->filteredListings($request)
            ->where('user_id', auth()->id())
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Cache::rememberForever('categories', fn () => Category::orderBy('name')->get()
        );

        return view('mes-annonces', compact('articles', 'categories'));
    }

    public function create(): View
    {
        return view('listings.create', [
            'categories' => Cache::rememberForever('categories', fn () => Category::orderBy('name')->get()),
            'conditions' => ListingCondition::cases(),
        ]);
    }

    public function edit(string $slug): View
    {
        $listing = Listing::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $listing->user_id) {
            abort(403);
        }

        return view('listings.update', [
            'listing' => $listing,
            'categories' => Cache::rememberForever('categories', fn () => Category::orderBy('name')->get()),
            'conditions' => ListingCondition::cases(),
        ]);
    }

    public function update(Request $request, string $slug): RedirectResponse
    {
        $listing = Listing::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $listing->user_id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            'condition' => ['required', Rule::in(array_column(ListingCondition::cases(), 'value'))],
            'price' => ['required', 'numeric', 'min:0'],
            'city' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ]);

        $listing->update($validated);

        return redirect()->route('annonce', $listing)
            ->with('success', 'Annonce mise à jour !');
    }

    public function annonces(Request $request): View
    {
        $articles = $this->filteredListings($request)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Cache::rememberForever('categories', fn () => Category::orderBy('name')->get()
        );

        return view('annonces', compact('articles', 'categories'));
    }

    private function filteredListings(Request $request): Builder
    {
        return Listing::query()
            ->available()
            ->with(['category', 'user'])
            ->when($request->filled('q'), fn ($query) => $query->where('title', 'like', '%'.$request->input('q').'%'))
            ->when($request->filled('category'), fn ($query) => $query->whereRelation('category', 'slug', $request->input('category')))
            ->when($request->filled('max_price'), fn ($query) => $query->where('price', '<=', $request->input('max_price')));
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
            'slug' => Str::slug($request->validated('title')).'-'.Str::lower(Str::random(6)),
        ]);

        return redirect()->route('annonce', $listing)
            ->with('success', 'Annonce publiée !');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $slug): View
    {
        $listing = Listing::with(['category', 'user'])->where('slug', $slug)->firstOrFail();

        return view('detailArticle', ['article' => $listing]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $slug): RedirectResponse
    {
        $listing = Listing::where('slug', $slug)->firstOrFail();

        if (auth()->id() !== $listing->user_id) {
            abort(403);
        }

        $listing->delete();

        return redirect()->route('annonces')
            ->with('success', 'Annonce supprimée !');
    }
}
