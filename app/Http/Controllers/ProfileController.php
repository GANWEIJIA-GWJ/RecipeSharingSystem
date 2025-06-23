<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ProfileController extends Controller
{
    // Show the current user's profile
    public function show()
    {
        $user = auth()->user(); 
        $recipes = $user->recipes()->paginate(5);
        return view('profile.show', compact('user', 'recipes'));
    }

    // Show the form to edit the user's profile
    public function edit()
    {
        $user = auth()->user();
        return view('profile.edit', compact('user'));
    }

    // Update the user's profile information
    public function update(Request $request)
    {
        $user = auth()->user();

        // Validate the incoming request data
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        // Handle avatar upload if a new file is provided
        if ($request->hasFile('avatar')) {
            $path = $request->file('avatar')->store('avatars', 'public');
            $data['avatar'] = $path;
        }

        // Update the user's profile with validated data
        $user->update($data);

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully.');
    }

    public function editCredentials()
    {
        $user = auth()->user(); // Get the authenticated user
        return view('profile.editCredentials', compact('user'));
    }

    public function updateCredentials(Request $request)
    {
        $user = auth()->user();

        // Validate input data, including current password check and new credentials
        $data = $request->validate([
            'current_password' => 'required',
            'email' => 'required|email|unique:users,email,' . $user->id,
            // new password is nullable; if provided, must be at least 8 characters and confirmed
            'password' => 'nullable|string|min:8|confirmed',
        ]);

        // Check if the current password is correct
        if (!Hash::check($data['current_password'], $user->password)) {
            return back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }

        // Update the email if it is changed
        if ($user->email !== $data['email']) {
            $user->email = $data['email'];
        }

        // Update password only if a new password is provided
        if (!empty($data['password'])) {
            $user->password = Hash::make($data['password']);
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Credentials updated successfully.');
    }

    // Upgrade normal user to recipe owner
    public function becomeRecipeOwner(Request $request)
    {
        $user = auth()->user();

        // Check if user is already not a normal user
        if ($user->role !== 'user') {
            return redirect()->back()->with('error', 'You are already a Recipe Owner or Admin.');
        }

        // Update the role to recipeOwner
        $user->update(['role' => 'recipeOwner']);

        return redirect()->back()->with('success', 'You are now a Recipe Owner and can create recipes.');
    }
}
