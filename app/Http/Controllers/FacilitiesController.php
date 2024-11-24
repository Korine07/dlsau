<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Categories;
use App\Models\Venue;


class FacilitiesController extends Controller
{
    public function index()
    {
        // Fetch all categories from the database
        $categories = Categories::all();
        $venues = Venue::with('categories')->get(); // Fetch all venues with their related category

        // Pass categories to the facilities view
        return view('facilities.facilities', compact('categories', 'venues'));
    }
}
