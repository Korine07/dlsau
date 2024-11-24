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
        // Pass the venues to the view
        return view('venues.venues', compact('venues'));

        $categories = Categories::all();
        $venues = Venue::with('categories')->get(); // Fetch venues along with their categories
        return view('facilities.facilities', compact('categories', 'venues'));
     
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $categories = DB::table('categories')->get();
        return view('venues.venues', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'venue_name' => 'required|string|max:255',
            'venue_description' => 'nullable|string',
            'venue_details' => 'nullable|string',
            'venue_capacity' => 'required|integer|min:0',
            'venue_category' => 'required|integer',
            'guest_price' => 'required|numeric|min:0',
            'member_price' => 'required|numeric|min:0',
            'venue_notes' => 'nullable|string',
            'cover_photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'slider_images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
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
            'slider_images' => json_encode($sliderImages),
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
}
