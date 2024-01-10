<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{

    public function show()
    {
        // Logic to show a specific profile by $id

        // Retrieve the authenticated user's profile details
        $user = Auth::user(); // Fetch the authenticated user

        // Pass the user's data to the 'profiles.show' view to render
        return view('profiles.show', ['user' => $user]);
    }

    // Other actions related to profiles

    public function edit()
    {
        // Retrieve the authenticated user's profile details
        $user = Auth::user(); // Fetch the authenticated user

        // Pass the user's data to the 'profiles.edit' view for editing
        return view('profiles.edit', ['user' => $user]);
    }

    public function update(Request $request)
{
    // Retrieve the authenticated user
    $user = Auth::user();

    // Check if the user instance exists and is an instance of the User model
    if ($user instanceof \App\Models\User) {
        // Validate the form data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,'.$user->id,
            // Add more fields and validation rules as needed
        ]);

        // Update the user's profile details with the submitted data
        $user->name = $validatedData['name'];
        $user->email = $validatedData['email'];
        // Add more fields to update as needed

        $user->save();

        return redirect()->route('profiles.show')->with('success', 'Profile updated successfully');
    } else {
        // Handle the case where the user instance is not valid
        return redirect()->route('profiles.show')->with('error', 'Unable to update profile');
    }
}
}
