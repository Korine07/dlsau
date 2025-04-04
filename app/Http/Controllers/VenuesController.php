<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use Illuminate\Support\Facades\DB;
use App\Models\Categories;




class VenuesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {    
        $categories = Categories::all(); // Fetch all categories
        $venues = Venue::with('categories')->get(); // Fetch venues with their categories

        // Pass both $categories and $venues to the view
        return view('venues.venues', compact('categories', 'venues'));
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = Categories::all(); // Fetch all categories
        $venues = Venue::with('categories')->get(); // Fetch venues with their categories

        return view('venues.venues', compact('categories', 'venues'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'venue_name' => 'required|string|max:32',
            'venue_description' => 'required|string|max:255', 
            'venue_details' => 'required|string|max:255', 
            'venue_capacity' => 'required|integer|min:1',
            'venue_category' => 'required|integer',
            'guest_price' => 'required|numeric|min:0',
            'member_price' => 'required|numeric|min:0',
            'venue_notes' => 'required|string|max:255',
            'cover_photo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'slider_images' => 'required|array|min:1',
            'slider_images.*' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
        ], [
            'venue_name.required' => 'Venue name is required.',
            'venue_name.max' => 'Venue name must be at most 32 characters.',
            'venue_description.required' => 'Venue description is required.',
            'venue_description.max' => 'Venue description must be at most 255 characters.',
            'venue_details.required' => 'Venue details are required.',
            'venue_details.max' => 'Venue details must be at most 255 characters.',
            'venue_capacity.required' => 'Venue capacity is required.',
            'venue_capacity.integer' => 'Venue capacity must be a number.',
            'venue_capacity.min' => 'Venue capacity must be at least 1.',
            'venue_category.required' => 'Venue category is required.',
            'venue_category.integer' => 'Invalid category selected.',
            'guest_price.required' => 'Guest price is required.',
            'guest_price.numeric' => 'Guest price must be a number.',
            'guest_price.min' => 'Guest price must be at least 0.',
            'member_price.required' => 'Member price is required.',
            'member_price.numeric' => 'Member price must be a number.',
            'member_price.min' => 'Member price must be at least 0.',
            'venue_notes.required' => 'Venue notes are required.',
            'venue_notes.max' => 'Venue notes must be at most 255 characters.',
            'cover_photo.required' => 'Cover photo is required.',
            'cover_photo.image' => 'Cover photo must be an image (jpeg, png, jpg, gif).',
            'cover_photo.mimes' => 'Cover photo must be a jpeg, png, jpg, or gif.',
            'cover_photo.max' => 'Cover photo size must be 5MB or less.',
            'slider_images.required' => 'Slider images are required.',
            'slider_images.*.image' => 'Each slider image must be an image (jpeg, png, jpg, gif).',
            'slider_images.*.mimes' => 'Slider images must be of type jpeg, png, jpg, or gif.',
            'slider_images.*.max' => 'Each slider image must be 5MB or less.',
        ]);
    
    
        // Handle cover photo upload
        $coverPhoto = null;
        if ($request->hasFile('cover_photo')) {
            // Store the uploaded cover photo in 'public' disk
            $coverPhoto = $request->file('cover_photo')->store('venues/cover_photos', 'public');
        }
    
        // Handle slider images upload
        $sliderImages = [];
        if ($request->hasFile('slider_images')) {
            foreach ($request->file('slider_images') as $sliderImage) {
                $sliderImages[] = $sliderImage->store('venues/slider_images', 'public');
            }
        }
    
        // Save venue
        Venue::create([
            'venue_name' => $request->input('venue_name'),
            'venue_description' => $request->input('venue_description'),
            'venue_details' => $request->input('venue_details'),
            'venue_capacity' => $request->input('venue_capacity'),
            'venue_category_id' => $request->input('venue_category'),
            'guest_price' => $request->input('guest_price'),
            'member_price' => $request->input('member_price'),
            'venue_notes' => $request->input('venue_notes'),
            'cover_photo' => $coverPhoto,
            'slider_images' => json_encode($sliderImages), // Store as JSON array
        ]);
    
        // Redirect back to the homepage or the venues page
        return redirect()->back()->with('success', 'Venue created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        
    }
    public function disableVenue($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->status = 'disabled';
        $venue->save();

        return redirect()->back()->with('success', 'Venue has been disabled.');
    }

    public function enableVenue($id)
    {
        $venue = Venue::findOrFail($id);
        $venue->status = 'active';
        $venue->save();

        return redirect()->back()->with('success', 'Venue has been enabled.');
    }

}
