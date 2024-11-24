<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Completed;
use Illuminate\View\View;

class CompletedController extends Controller
{
    public function index(): View
    {
        $completed = Completed::all();
        return view ('completed.completed')->with('completed', $completed);
    }
 
    public function create(): View
    {
        return view('completed.create');
    }
  
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Completed::create($input);
        return redirect('completed')->with('flash_message', 'completed Addedd!');
    }
    public function show(string $id): View
    {
        $completed = Completed::find($id);
        return view('completed.show')->with('completed', $completed);
    }
    public function edit(string $id): View
    {
        $completed = Completed::find($id);
        return view('completed.edit')->with('completed', $completed);
    }
    public function update(Request $request, string $id): RedirectResponse
    {
        $completed = Completed::find($id);
        $input = $request->all();
        $completed->update($input);
        return redirect('completed')->with('flash_message', 'completed Updated!');  
    }
    
    public function destroy(string $id): RedirectResponse
    {
        Completed::destroy($id);
        return redirect('completed')->with('flash_message', 'completed deleted!'); 
    }
}
