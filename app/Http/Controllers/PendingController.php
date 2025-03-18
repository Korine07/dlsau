<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Pending;
use App\Models\Venue;
use Illuminate\View\View;

class PendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('pending.pending', compact('pendingReservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('pending.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Pending::create($input);
        return redirect('pending')->with('flash_message', 'Pending Addedd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $pending = Pending::find($id);
        return view('pending.show')->with('pending', $pending);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $pending = Pending::find($id);
        return view('pending.edit')->with('pending', $pending);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $pending = Pending::findOrFail($id);

        // Validate input
        $request->validate([
            'first_name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',  
            'last_name' => 'required|string|max:255|regex:/^[\pL\s]+$/u',  
            'email' => 'required|email|max:255',  
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'check_in_date' => 'required|date',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'check_in_time' => 'required',
            'check_out_time' => 'required',
        ]);
        

        // Update reservation with new values
        $pending->update([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'expected_guests' => $request->input('expected_guests'),
            'status' => $request->input('status'),
            'venue_id' => $request->input('venue_id'),
            'check_in_date' => $request->input('check_in_date'),
            'check_in_time' => $request->input('check_in_time'),
            'check_out_date' => $request->input('check_out_date'),
            'check_out_time' => $request->input('check_out_time'),
        ]);
        

        return redirect('pending')->with('success', 'Reservation updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Pending::destroy($id);
        return redirect('pending')->with('flash_message', 'pending deleted!'); 
    }
}
