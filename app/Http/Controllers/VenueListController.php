<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Venue_List;
use Illuminate\View\View;


class VenueListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $venue_list = Venue_List::all();
        return view ('venue_list.venue')->with('venue_list', $venue_list);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('venue_list.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Venue_list::create($input);
        return redirect('venue_list')->with('flash_message', 'Venue Addedd!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $venue_list = Venue_list::find($id);
        return view('venue_list.show')->with('venue_list', $venue_list);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $venue_list = Venue_list::find($id);
        return view('venue_list.edit')->with('venue_list', $venue_list);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $venue_list = Venue_list::find($id);
        $input = $request->all();
        $venue_list->update($input);
        return redirect('venue_list')->with('flash_message', 'Venue Updated!');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Venue_list::destroy($id);
        return redirect('venue_list')->with('flash_message', 'Venue deleted!'); 
    }
}
