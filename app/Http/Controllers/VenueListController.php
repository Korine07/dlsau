<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\VenueList;
use Illuminate\View\View;
use App\Models\Categories;
use App\Models\Venue;
use Illuminate\Support\Facades\Storage;


class VenueListController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        $venues = Venue::all();
        $categories = Categories::all();
        return view('venue_list.venue_list', compact('venues', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('venue_list.venue_list');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'venue_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id', // Ensure category exists
            'guest_price' => 'required|numeric|min:0',
            'member_price' => 'required|numeric|min:0',
            'venue_capacity' => 'required|integer|min:0',
        ]);
    
        Venue_List::create($request->all());
    
        return redirect('venue_list.venue_list')->with('success', 'Venue added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $venue_list = Venuelist::find($id);
        return view('venue_list.venue_list')->with('venue_list', $venue_list);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $venue_list = Venuelist::find($id);
        return view('venue_list.venue_list')->with('venue_list', $venue_list);
    }
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $venue = Venue::findOrFail($id);

    // ✅ Validate the request
    $request->validate([
        'venue_name' => 'required|string|max:255',
        'venue_description' => 'required|string|max:255', 
        'venue_details' => 'required|string|max:255',  
        'venue_capacity' => 'required|integer|min:0',  
        'venue_category_id' => 'required|integer',  
        'guest_price' => 'required|numeric|min:0',  
        'member_price' => 'required|numeric|min:0',  
        'venue_notes' => 'required|string|max:255',  
        'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        'delete_slider_images' => 'array',
        'delete_slider_images.*' => 'string',
    ]);

    // ✅ Update venue details
    $venue->update([
        'venue_name' => $request->venue_name,
        'venue_description' => $request->venue_description,
        'venue_details' => $request->venue_details,
        'venue_capacity' => $request->venue_capacity,
        'venue_category_id' => $request->venue_category_id,
        'guest_price' => $request->guest_price,
        'member_price' => $request->member_price,
        'venue_notes' => $request->venue_notes,
    ]);

    // ✅ Handle Cover Photo Upload
    if ($request->hasFile('cover_photo')) {
        if ($venue->cover_photo && Storage::disk('public')->exists($venue->cover_photo)) {
            Storage::disk('public')->delete($venue->cover_photo);
        }
        $venue->cover_photo = $request->file('cover_photo')->store('venues/cover_photos', 'public');
    }

    // ✅ Handle Cover Photo Deletion
    if ($request->has('delete_cover_photo')) {
        if ($venue->cover_photo && Storage::disk('public')->exists($venue->cover_photo)) {
            Storage::disk('public')->delete($venue->cover_photo);
        }
        $venue->cover_photo = null;
    }

    // ✅ Handle Slider Images Deletion
    $existingSliderImages = json_decode($venue->slider_images, true) ?? [];

    if ($request->has('delete_slider_images')) {
        foreach ($request->delete_slider_images as $image) {
            if (Storage::disk('public')->exists($image)) {
                Storage::disk('public')->delete($image);
            }
            $existingSliderImages = array_values(array_diff($existingSliderImages, [$image]));
        }
    }

    // ✅ Append New Slider Images Without Overwriting
    if ($request->hasFile('slider_images')) {
        foreach ($request->file('slider_images') as $sliderImage) {
            if ($sliderImage->isValid()) {
                $path = $sliderImage->store('venues/slider_images', 'public');
                $existingSliderImages[] = $path; // Append images properly
            }
        }
    }

    // ✅ Save the Updated Slider Images
    $venue->slider_images = json_encode($existingSliderImages);
    $venue->save();

    return redirect()->route('venue_list.index')->with('success', 'Venue updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        // Debugging step to ensure method is called
    $venue = Venue::find($id);
    if (!$venue) {
        return redirect()->route('venue_list.index')->with('error', 'Venue not found!');
    }

    // Delete the venue
    $venue->delete();

    return redirect()->route('venue_list.index')->with('success', 'Venue deleted successfully!');
    }
}