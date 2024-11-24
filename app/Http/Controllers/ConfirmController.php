<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Confirm;
use Illuminate\View\View;

class ConfirmController extends Controller
{
    public function index(): View
    {
        $confirm = Confirm::all();
        return view ('confirm.confirm')->with('confirm', $confirm);
    }
 
    public function create(): View
    {
        return view('confirm.confirm');
    }
  
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        Confirm::create($input);
        return redirect('confirm')->with('flash_message', 'confirm Addedd!');
    }
    public function show(string $id): View
    {
        $confirm = Confirm::find($id);
        return view('confirm.show')->with('confirm', $confirm);
    }
    public function edit(string $id): View
    {
        $confirm = Confirm::find($id);
        return view('confirm.edit')->with('confirm', $confirm);
    }
    public function update(Request $request, string $id): RedirectResponse
    {
        $confirm = Confirm::find($id);
        $input = $request->all();
        $confirm->update($input);
        return redirect('confirm')->with('flash_message', 'confirm Updated!');  
    }
    
    public function destroy(string $id): RedirectResponse
    {
        Confirm::destroy($id);
        return redirect('confirm')->with('flash_message', 'confirm deleted!'); 
    }
}
