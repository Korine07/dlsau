<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Categories;

class HomeController extends Controller
{
    public function index()
    {
        // Fetch all categories
        $categories = Categories::all();

        // Pass categories to the homepage view
        return view('home.home', compact('categories'));
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