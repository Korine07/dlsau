<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Members;
use Illuminate\View\View;

class MembersController extends Controller
{

    public function index(): View
    {
        $members = Members::all();
        return view ('members.members')->with('members', $members);
    }

 
    public function create(): View
    {
        return view('members.create');
    }

  
    public function store(Request $request): RedirectResponse
{
    // Custom validation rules with error messages
    $request->validate([
        'first_name' => 'required|string|max:255',
        'last_name' => 'required|string|max:255',
        'memtyp' => 'required|in:student,employee',
        'idnum' => [
            'nullable',
            'numeric',
            'unique:members,idnum', // validate if the idnum is unique
            function ($attribute, $value, $fail) use ($request) {
                // Custom check for students: ID number must be unique for students
                if ($request->memtyp == 'student' && Members::where('idnum', $value)->exists()) {
                    return $fail('This ID number already exists. Please choose another one.');
                }
            },
        ],
    ], [
        'idnum.unique' => 'The ID number has already been taken. Please choose a different one.',
        'idnum.numeric' => 'The ID number must be a valid number.',
        'first_name.required' => 'First Name is required.',
        'last_name.required' => 'Last Name is required.',
        'memtyp.required' => 'Please select a member type.',
    ]);

    // Create the new member
    Members::create($request->all());

    // Redirect with success message
    return redirect('members')->with('flash_message', 'Member Added!');
}

    public function show(string $id): View
    {
        $members = Members::find($id);
        return view('members.show')->with('members', $members);
    }

    public function edit(string $id): View
    {
        $members = Members::find($id);
        return view('members.edit')->with('members', $members);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $members = Members::find($id);
        $input = $request->all();
        $members->update($input);
        return redirect('members')->with('flash_message', 'Member Updated!');  
    }

    
    public function destroy(string $id): RedirectResponse
    {
        Members::destroy($id);
        return redirect('members')->with('flash_message', 'Member deleted!'); 
    }
}