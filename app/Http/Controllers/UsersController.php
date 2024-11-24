<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;
use Illuminate\View\View;

class UsersController extends Controller
{

    public function index(): View
    {
        $users = User::all();
        return view ('users.users')->with('users', $users);
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
        'name' => 'required|string|max:255',
        'username' => 'required|string|max:255|unique:users',
        'email' => 'required|email|max:255|unique:users',
        'password' => 'required|confirmed|min:8', // Ensures password confirmation
        'usertype' => 'required|in:0,1', // Ensures only 0 or 1 is allowed for usertype
        'profile_photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Validates image file
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
        $users = User::find($id);
        $input = $request->all();
        $users->update($input);
        return redirect('users')->with('flash_message', 'User Updated!');  

        if ($request->hasFile('profile_photo')) {
            // Delete the old photo if it exists
            if ($user->profile_photo_path) {
                \Storage::delete('public/' . $user->profile_photo_path);
            }
        
            // Store the new photo and save the path
            $validatedData['profile_photo_path'] = $request->file('profile_photo')->store('profile_photos', 'public');
        }
    }

    
    public function destroy(string $id): RedirectResponse
    {
        User::destroy($id);
        return redirect('users')->with('flash_message', 'User deleted!'); 
    }
}