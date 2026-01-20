<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class UserProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            // Add other profile fields you want to update
        ]);

        $user->forceFill([
            'name' => $request->name,
            'email' => $request->email,
        ])->save();

        return response()->json(['message' => 'Profile updated successfully.', 'user' => $user]);
    }

    public function updateAvatar(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'avatar' => ['required', 'image', 'max:2048'], // Max 2MB image
        ]);

        if ($user->avatar) {
            Storage::disk('public')->delete($user->avatar);
        }

        $path = $request->file('avatar')->store('avatars', 'public');

        $user->forceFill([
            'avatar' => $path,
        ])->save();
        
        // Append a temporary avatar_url for immediate response
        $user->avatar_url = Storage::url($path);

        return response()->json(['message' => 'Avatar updated successfully.', 'user' => $user]);
    }
}
