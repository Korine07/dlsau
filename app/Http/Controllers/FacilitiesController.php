<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Venue;


class FacilitiesController extends Controller
{
    public function index(Request $request)
    {
        // Fetch all categories from the database
        $categories = Categories::all();
        $venuesQuery = Venue::with('categories');

        // Apply search filtering
        if ($request->has('search')) {
            $search = $request->search;
            $venuesQuery->where(function ($query) use ($search) {
                $query->where('venue_name', 'LIKE', "%{$search}%")
                    ->orWhere('venue_capacity', 'LIKE', "%{$search}%");
            });
        }

        // Check if a category filter is applied
        if ($request->ajax()) {
            $category = $request->category;
    
            if (!empty($category)) {
                $venues = Venue::with('categories')
                    ->whereHas('categories', function ($query) use ($category) {
                        $query->where('name', '=', $category);
                    })->get(); // Remove pagination to fetch all results
            } else {
                $venues = Venue::with('categories')->get();
            }
    
            return response()->json([
                'venues' => $venues
            ]);
        }


        // Fetch venues with pagination (9 per page)
        $venues = Venue::with('categories')->paginate(9);

        // Pass categories to the facilities view
        return view('facilities.facilities', compact('categories', 'venues'));
    }
}
