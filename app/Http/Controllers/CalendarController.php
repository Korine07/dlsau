<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Holiday;
use Carbon\Carbon;
use App\Models\Reservation;

class CalendarController extends Controller
{
    public function index()
    {
        return view("calendar.calendar");
    }
    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:32'
        ]);

        $holiday = Holiday::create($request->all());

        return response()->json([
            'message' => 'Holiday added successfully!',
            'holiday' => $holiday  // Make sure this is returned
        ], 201);
    }
    public function update(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string|max:32'
        ]);

        $holiday = Holiday::findOrFail($id);
        $holiday->update($request->all());

        return response()->json([
            'message' => 'Holiday updated successfully!',
            'holiday' => $holiday
        ]);
    }
    public function getEvents()
    {
        // Fetch holidays
        $holidays = Holiday::select('id', 'start_date', 'end_date', 'reason')->get()->map(function ($holiday) {
            return [
                'id' => "holiday-" . $holiday->id,
                'title' => $holiday->reason,
                'start' => Carbon::parse($holiday->start_date)->format('Y-m-d'), // ✅ Ensure format
                'end' => Carbon::parse($holiday->end_date)->addDay()->format('Y-m-d'), // ✅ Fix for FullCalendar
                'backgroundColor' => '#28a745', // ✅ Green background
                'borderColor' => '#28a745', // ✅ Green border
                'textColor' => '#ffffff', // ✅ White text
                'allDay' => true
            ];
        });

        // Fetch reservations
        $reservations = Reservation::with('venue')
        ->where('status', '!=', 'archived')
        ->get()
        ->map(function ($reservation) {
            $color = $this->getEventColor($reservation->status);
            return [
                'id' => $reservation->id,
                'title' => $reservation->venue->venue_name,
                'start' => "{$reservation->check_in_date}T{$reservation->check_in_time}",
                'end' => "{$reservation->check_out_date}T{$reservation->check_out_time}",
                'backgroundColor' => $color, // Apply new color scheme
                'borderColor' => $color,
                'textColor' => '#ffffff',
                'extendedProps' => [
                    'check_in_time' => date("h:ia", strtotime($reservation->check_in_time)),
                    'check_out_time' => date("h:ia", strtotime($reservation->check_out_time)),
                    'first_name' => $reservation->first_name,
                    'last_name' => $reservation->last_name,
                    'activity' => $reservation->activity_nature,
                    'status' => ucfirst($reservation->status), // Ensure status is properly formatted
                ]
            ];
        });

        return response()->json([...$holidays, ...$reservations]); // Merge holidays and reservations
    }

    private function getEventColor($status)
{
    switch ($status) {
        case 'pending': return '#ffc107'; // Yellow
        case 'confirmed': return '#fd7e14'; // Orange
        case 'completed': return '#007bff'; // Blue
        case 'cancelled': return '#dc3545'; // Red
        default: return '#6c757d'; // Gray for unknown status
    }
}
}
