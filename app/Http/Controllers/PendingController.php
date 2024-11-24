<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Pending;
use Illuminate\View\View;

class PendingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $pending = Pending::all();
        return view ('pending.pending')->with('pending', $pending);
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
        $pending = Pending::find($id);
        $input = $request->all();
        $pending->update($input);
        return redirect('pending')->with('flash_message', 'pending Updated!');  
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
