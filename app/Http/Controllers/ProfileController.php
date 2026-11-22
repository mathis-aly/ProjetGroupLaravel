<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $request->user()->fill($request->validated());

        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        $request->user()->save();

        if (str_contains((string) $request->headers->get('referer'), '/dashboard')) {
            return Redirect::route('dashboard')->with('status', 'profile-updated');
        }

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Update the user's secret Vesper profile (photo, alias, rdv type, bio, etc.).
     */
    public function updateSecret(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'alias' => ['required', 'string', 'max:80'],
            'age' => ['required', 'integer', 'min:18', 'max:99'],
            'gender' => ['nullable', 'string', 'in:femme,homme,non_binaire'],
            'seeking' => ['nullable', 'string', 'in:femmes,hommes,tous'],
            'district' => ['required', 'string', 'max:100'],
            'rdv_type' => ['required', 'string', 'max:120'],
            'preferred_hour' => ['required', 'string', 'max:120'],
            'bio' => ['required', 'string', 'max:1000'],
            'passphrase' => ['nullable', 'string', 'max:160'],
            'preset_photo' => ['nullable', 'string', 'max:500'],
            'photo_upload' => ['nullable', 'image', 'max:4096'],
            'is_verified' => ['nullable', 'boolean'],
            'subscription_tier' => ['nullable', 'string', 'in:free,bronze,or_noir'],
        ]);

        $user = $request->user();
        $current = $user->secretProfile();
        $photoUrl = $validated['preset_photo'] ?: ($current['photo'] ?? '');

        if ($request->hasFile('photo_upload')) {
            $file = $request->file('photo_upload');
            $dir = public_path('uploads/vesper');
            if (! is_dir($dir)) {
                mkdir($dir, 0755, true);
            }
            $filename = 'vesper_user_' . $user->id . '_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move($dir, $filename);
            $photoUrl = '/uploads/vesper/' . $filename;
        }

        $data = array_merge($current, [
            'alias' => $validated['alias'],
            'age' => (int) $validated['age'],
            'gender' => $validated['gender'] ?? ($current['gender'] ?? 'homme'),
            'seeking' => $validated['seeking'] ?? ($current['seeking'] ?? 'tous'),
            'district' => $validated['district'],
            'rdv_type' => $validated['rdv_type'],
            'preferred_hour' => $validated['preferred_hour'],
            'bio' => $validated['bio'],
            'passphrase' => $validated['passphrase'] ?? '',
            'photo' => $photoUrl,
            'questionnaire_completed' => true,
            'is_verified' => isset($validated['is_verified']) ? (bool) $validated['is_verified'] : ($current['is_verified'] ?? true),
            'subscription_tier' => $validated['subscription_tier'] ?? ($current['subscription_tier'] ?? 'free'),
        ]);

        $storageDir = storage_path('app/secret_profiles');
        if (! is_dir($storageDir)) {
            mkdir($storageDir, 0755, true);
        }

        file_put_contents(
            $storageDir . '/user_' . $user->id . '.json',
            json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        return Redirect::route('dashboard')->with('status', 'secret-profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
