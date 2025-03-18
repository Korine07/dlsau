<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Services;

class ServiceReportController extends Controller
{
    // Show the service report page with date filters
    public function showServiceList()
    {
        return view('sreport.services_list'); // Show the form to select a date range
    }

    // Generate the report based on the date range
    public function generateServiceReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Invalid start date format.',
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'Invalid end date format.',
            'end_date.after_or_equal' => 'End date must be the same or later than the start date.',
        ]);
        
        $startDate = $request->start_date;
        $endDate = $request->end_date;

        // Fetch services created within the date range
        $services = Services::whereBetween('created_at', [$startDate, $endDate])
            ->orderBy('created_at', 'asc')
            ->get();

        return view('sreport.services_report', compact('services', 'startDate', 'endDate'));
    }
}
