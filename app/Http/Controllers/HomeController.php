<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;
use App\Models\Venue;
use App\Models\Reservation; 
use DB;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch categories
        $categories = Categories::all();

        // Fetch the top 3 most booked venues
        $venues = Venue::withCount('reservations') // Count reservations per venue
        ->orderBy('reservations_count', 'desc') // Order by highest reservation count
        ->take(3) // Get top 3 venues
        ->get();

        // Pass the variables to the home view
        return view('home.home', compact('categories', 'venues'));
    }

    public function redirects()
{
    // Ensure the user is authenticated
    if (!Auth::check()) {
        return redirect()->route('login'); // Redirect to login if unauthenticated
    }

    $usertype = Auth::user()->usertype;

    if ($usertype === '1') {
        return view('admin.adminhome'); // Admin view
    } else {
        return view('home'); // Regular user view
    }
}

}