<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Confirm;
use Illuminate\View\View;

class ConfirmController extends Controller
{
    public function index(Request $request): View
    {
    return view('confirm.confirm', compact('confirmedReservations'));
    }
 
    public function create(): View
    {
        return view('confirm.confirm');
    }
  
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Confirm::create($input);
        return redirect('confirm')->with('flash_message', 'confirm Addedd!');
    }
    public function show(string $id): View
    {
        $confirm = Confirm::find($id);
        return view('confirm.show')->with('confirm', $confirm);
    }
    public function edit(string $id): View
    {
        $confirm = Confirm::find($id);
        return view('confirm.edit')->with('confirm', $confirm);
    }
    public function update(Request $request, string $id): RedirectResponse
    {
        $confirm = Confirm::find($id);

    // Validate input
    $request->validate([
        'first_name' => 'required|string|regex:/^[a-zA-Z\s0-9\-\_\.]+$/',  
        'last_name' => 'required|string|regex:/^[a-zA-Z\s0-9\-\_\.]+$/',  
        'email' => 'required|email',  
        'phone' => 'required|regex:/^(09|\+639)\d{9}$/', 
        'check_in_date' => 'required|date',
        'check_out_date' => 'required|date|after_or_equal:check_in_date',
        'check_in_time' => 'required',
        'check_out_time' => 'required',
    ]);

    // Update reservation with new values
    $confirm->update([
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

    return redirect('confirm')->with('success', 'Reservation updated successfully!');
    }
    
    public function destroy(string $id): RedirectResponse
    {
        Confirm::destroy($id);
        return redirect('confirm')->with('flash_message', 'confirm deleted!'); 
    }
}
