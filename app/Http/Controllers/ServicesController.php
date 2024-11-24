<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Services;
use Illuminate\View\View;

class ServicesController extends Controller
{

    public function index(): View
    {
        $services = Services::all();
        return view ('services.services')->with('services', $services);
    }

 
    public function create(): View
    {
        return view('services.create');
    }

  
    public function store(Request $request): RedirectResponse
    {
        // Validate the input fields
    $request->validate([
        'name' => 'required|string|max:255',
        'price' => 'required|numeric|min:0', // Price should be a valid number
    ]);

    // Format the price to two decimal places and store it as a float
    $price = number_format($request->price, 2, '.', ''); // Format to 2 decimal places
    $price = (float) $price;  // Ensure it's stored as a float
    
    // Store the new service
    Services::create([
        'name' => $request->name,
        'price' => $price,  // Store formatted price
    ]);

    return redirect('services')->with('flash_message', 'Service Added!');
    }

    public function show(string $id): View
    {
         // Use findOrFail to return 404 if service not found
    $services = Services::findOrFail($id);

    // Format the price (for example, 1234567.89 to 1,234,567.89)
    $formattedPrice = number_format($services->price, 2);  // 2 decimals for price formatting

    return view('services.show', [
        'services' => $services,
        'formattedPrice' => $formattedPrice
    ]);
    }

    public function edit(string $id): View
    {
        $services = Services::find($id);

    // Format the price to 2 decimal places
    $services->price = number_format($services->price, 2, '.', '');

    return view('services.edit')->with('services', $services);
    }

    public function update(Request $request, string $id): RedirectResponse
    {
        $services = Services::find($id);
        $input = $request->all();
        $services->update($input);
        return redirect('services')->with('flash_message', 'Service Updated!');  
    }

    
    public function destroy(string $id): RedirectResponse
    {
        Services::destroy($id);
        return redirect('services')->with('flash_message', 'Service deleted!'); 
    }
}