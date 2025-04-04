<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;

class HolidayController extends Controller
{
    // Fetch all holidays
    public function index()
    {
        return response()->json(Holiday::all());
    }

    // Store new holiday
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255'
        ]);

        $holiday = Holiday::create($request->all());

        return response()->json([
            'message' => 'Holiday added successfully!',
            'holiday' => $holiday
        ], 201);
    }

    // Update existing holiday
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:255'
        ]);

        $holiday = Holiday::findOrFail($id);
        $holiday->update($request->all());

        return response()->json([
            'message' => 'Holiday updated successfully!',
            'holiday' => $holiday
        ]);
    }

    // Delete holiday
    public function destroy($id)
    {
        $holiday = Holiday::findOrFail($id);
        $holiday->delete();

        return response()->json([
            'message' => 'Holiday deleted successfully!'
        ]);
    }
}

