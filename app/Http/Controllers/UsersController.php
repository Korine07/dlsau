<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\View\View;

class UsersController extends Controller
{

    public function index(Request $request): View
    {
        $users = User::all();

        return view('users.users', compact('users'));
    }

 
    public function create(): View
    {
        return view('users.create');
    }

  
    public function store(Request $request): RedirectResponse
{
    // Optional: Check if the current user is an admin (if needed)
    if (auth()->user()->usertype != 1) {
        abort(403, 'Unauthorized action.');
    }

    // Validate input
    $validatedData = $request->validate([
        'name' => 'required|string|max:16',
        'username' => 'required|string|max:16|unique:users',
        'email' => 'required|email|max:32|unique:users',
        'password' => 'required|string|min:8|confirmed',
        'password_confirmation' => 'required|string|min:8',
        'usertype' => 'required|in:0,1', 
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB = 5120KB
    ], [
        'email.required' => 'Please enter your email address.',
        'email.email' => 'Please include an "@, ." in the email address.',
        'email.max' => 'The email address should not exceed 32 characters.',
        'email.unique' => 'This email address is already taken.',
        'password.required' => 'Please enter a password.',
        'password.min' => 'The password must be at least 8 characters long.',
        'password.confirmed' => 'The password confirmation does not match.',
        'password_confirmation.required' => 'Please confirm your password.',
        'password_confirmation.min' => 'The password confirmation must be at least 8 characters long.',
        'usertype.required' => 'Please select a user role.',
        'usertype.in' => 'Please select a valid role.',
        
        'profile_photo.max' => 'The profile photo must not exceed 5MB.',
    ]);

    // Handle file upload
   
    $profilePhotoPath = null;
    if ($request->hasFile('profile_photo')) {
        $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
    }
    

    // Create the user and save to the database
    User::create([
        'name' => $validatedData['name'],
        'username' => $validatedData['username'],
        'email' => $validatedData['email'],
        'password' => bcrypt($validatedData['password']),
        'usertype' => $validatedData['usertype'],
        'profile_photo_path' => $profilePhotoPath, // Save photo path
    ]);

    // Redirect to the users index with a success message
    return redirect()->route('users.index')->with('success', 'User created successfully!');
}

    public function show(string $id): View
    {
        $users = User::find($id);
        return view('users.show')->with('users', $users);
    }

    public function edit(string $id): View
    {
        $users = User::find($id);
        return view('users.edit')->with('users', $users);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $user = User::findOrFail($id);

    // Validate input
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users,username,' . $id,
        'email' => 'required|email|max:255|unique:users,email,' . $id,
        'usertype' => 'required|in:0,1',
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:5120', // 5MB = 5120KB
    ]);

    // Check if a new profile photo was uploaded
    if ($request->hasFile('profile_photo')) {
        // Delete the old photo if it exists
        if ($user->profile_photo_path && \Storage::exists('public/' . $user->profile_photo_path)) {
            \Storage::delete('public/' . $user->profile_photo_path);
        }

        // Store new profile photo
        $profilePhotoPath = $request->file('profile_photo')->store('profile_photos', 'public');
        $user->profile_photo_path = $profilePhotoPath;
    }


    // Update user
    $user->update([
        'name' => $validatedData['name'],
        'username' => $validatedData['username'],
        'email' => $validatedData['email'],
        'usertype' => $validatedData['usertype'],
        'profile_photo_path' => $user->profile_photo_path ?? $user->profile_photo_path, // Keep old photo if no new one is uploaded
    ]);

    return redirect()->route('users.index')->with('success', 'User Updated!');
    }

    
    public function destroy(string $id): RedirectResponse
    {
        User::destroy($id);
        return redirect('users')->with('success', 'User deleted!'); 
    }
}