<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OneController extends Controller
{
    public function index()
    {
        return view("one.one");
    }
}