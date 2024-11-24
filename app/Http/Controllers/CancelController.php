<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Cancel;
use Illuminate\View\View;

class CancelController extends Controller
{
    public function index(): View
    {
        $cancel = Cancel::all();
        return view ('cancel.cancel')->with('cancel', $cancel);
    }
 
    public function create(): View
    {
        return view('cancel.create');
    }
  
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Cancel::create($input);
        return redirect('cancel')->with('flash_message', 'cancel Addedd!');
    }
    public function show(string $id): View
    {
        $cancel = Cancel::find($id);
        return view('cancel.show')->with('cancel', $cancel);
    }
    public function edit(string $id): View
    {
        $cancel = Cancel::find($id);
        return view('cancel.edit')->with('cancel', $cancel);
    }
    public function update(Request $request, string $id): RedirectResponse
    {
        $cancel = Cancel::find($id);
        $input = $request->all();
        $cancel->update($input);
        return redirect('cancel')->with('flash_message', 'cancel Updated!');  
    }
    
    public function destroy(string $id): RedirectResponse
    {
        Cancel::destroy($id);
        return redirect('cancel')->with('flash_message', 'cancel deleted!'); 
    }
}
