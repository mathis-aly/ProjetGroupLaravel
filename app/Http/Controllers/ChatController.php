<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\ChatAnnonce;
use App\Models\Listing;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function chat(Request $request, string $user_name) // va être renvoyer dans detailArticle.blade.php
    {
        $user = auth()->user();

        if ($user->name !== $user_name) {
            abort(403);
        }

        $chatMessages = ($request)
            ->latest()
            ->paginate(12)
            ->where('user_id', auth()->id());

        return view('detailArticle', compact('chatMessages'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, Listing $listing): RedirectResponse
    {
        abort_if((int) $request->user()->id === (int) $listing->user_id, 403);

        $validated = $request->validate([
            'message' => ['required', 'string', 'min:10', 'max:2000'],
        ]);

        $message = ChatAnnonce::create([
            'user_id' => $request->user()->id,
            'listing_id' => $listing->id,
            'message' => $validated['message'],
        ]);

        MessageSent::dispatch($message);

        return back()->with('success', 'Votre message a été envoyé au vendeur.');

        return redirect()
            ->route('annonce', $listing)
            ->with('status', 'Votre message a été envoyé.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
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
