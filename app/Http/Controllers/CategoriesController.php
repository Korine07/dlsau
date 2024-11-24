<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Categories;
use Illuminate\View\View;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $categories = Categories::all();
        return view ('categories.categories')->with('categories', $categories);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): View
    {
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request): RedirectResponse
    {
       // Validate the input
    $request->validate([
        'name' => 'required|string|max:255',
    ]);

    // Save the category to the database
    Categories::create($request->all());

    // Redirect to the categories list with a success message
    return redirect('categories')->with('flash_message', 'Category added successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): View
    {
        $categories = Categories::find($id);
        return view('categories.show')->with('categories', $categories);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id): View
    {
        $categories = Categories::find($id);
        return view('categories.edit')->with('categories', $categories);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id): RedirectResponse
    {
        $categories = Categories::find($id);
        $input = $request->all();
        $categories->update($input);
        return redirect('categories')->with('flash_message', 'Category Updated!');  
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): RedirectResponse
    {
        Categories::destroy($id);
        return redirect('categories')->with('flash_message', 'Category deleted!'); 
    }
}
