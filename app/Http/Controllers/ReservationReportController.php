<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exports\VenueReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\ReservationReport;
use App\Models\Reservation;
use App\Models\Venue;


class ReservationReportController extends Controller
{
     // Show the reservation list page with datepickers
    public function showReservationList()
    {
        return view('rreport.rreport'); // Show the form to select date range
    }

    // Handle form submission and redirect to the report page
    public function generateReservationReport(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $startDate = $request->start_date;
        $endDate = $request->end_date;

        $reports = Reservation::whereBetween('check_in_date', [$startDate, $endDate])
            ->where('status', 'completed') // Only include completed reservations
            ->with('venue') // Ensure venue data is loaded
            ->get();

        return view('rreport.reservation_report', compact('reports', 'startDate', 'endDate'));
    }

    // Show the reservation report page with the filtered data
    public function showGeneratedReport(Request $request)
    {
        $startDate = $request->query('start_date');
        $endDate = $request->query('end_date');

        // Fetch reservations again to display in the report
        $reports = ReservationReport::whereBetween('check_in_date', [$startDate, $endDate])
            ->get();

        return view('rreport.reservation_report', compact('reports', 'startDate', 'endDate'));
    }
    // Show the page with the date picker form
    public function showArchivedList()
    {
        $venues = Venue::all();
        return view('rreport.archived_list', compact('venues')); // Load form view
    }

    // Generate filtered archived reservations
    public function generateArchivedReport(Request $request)
    {
        $request->validate([
            'venue_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date', // Allowing same start & end date
        ], [
            'venue_id.required' => 'Please select a venue.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Invalid start date format.',
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'Invalid end date format.',
            'end_date.after_or_equal' => 'End date must be the same or later than the start date.',
        ]);
    
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $isAllVenuesSelected = false;
    
        if ($request->venue_id == 'all') {
            $reports = Reservation::whereBetween('check_in_date', [$startDate, $endDate])
                ->where('status', 'archived') 
                ->with('venue') 
                ->get();
    
            $isAllVenuesSelected = true; 
        } else {
            $venue = Venue::findOrFail($request->venue_id);
            $reports = Reservation::where('venue_id', $venue->id)
                ->whereBetween('check_in_date', [$startDate, $endDate])
                ->where('status', 'archived')
                ->get();
        }
    
        // Pass the venue variable only if a specific venue is selected
        if (isset($venue)) {
            return view('rreport.archived_report', compact('reports', 'startDate', 'endDate', 'isAllVenuesSelected', 'venue'));
        } else {
            return view('rreport.archived_report', compact('reports', 'startDate', 'endDate', 'isAllVenuesSelected'));
        }
    }
    // Show the venue report selection page
    public function showVenueReportForm()
    {
        $venues = Venue::all();
        return view('vreport.report', compact('venues'));
    }

    // Generate the venue-specific reservation report
    public function generateVenueReport(Request $request)
    {
        $request->validate([
            'venue_id' => 'required',
            'status' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ], [
            'venue_id.required' => 'Please select a venue.',
            'status.required' => 'Please select a status.',
            'start_date.required' => 'Start date is required.',
            'start_date.date' => 'Invalid start date format.',
            'end_date.required' => 'End date is required.',
            'end_date.date' => 'Invalid end date format.',
            'end_date.after_or_equal' => 'End date must be the same or later than the start date.',
        ]);
    
        $startDate = $request->start_date;
        $endDate = $request->end_date;
        $status = $request->status;
        $isAllVenuesSelected = false;
    
        // Query the database based on venue selection
        if ($request->venue_id == 'all') {
            $query = Reservation::whereBetween('check_in_date', [$startDate, $endDate])
                ->with('venue'); // Ensure venue data is loaded

            $isAllVenuesSelected = true;
        } else {
            $venue = Venue::findOrFail($request->venue_id);
            $query = Reservation::where('venue_id', $venue->id)
                ->whereBetween('check_in_date', [$startDate, $endDate]);
        }

        // Apply status filter if not "all"
        if ($status !== 'all') {
            $query->where('status', $status);
        }

        $reports = $query->get();
    
        // Pass the venue variable only if a specific venue is selected
        if (isset($venue)) {
            return view('vreport.venue_report', compact('reports', 'startDate', 'endDate', 'isAllVenuesSelected', 'venue', 'status'));
        } else {
            return view('vreport.venue_report', compact('reports', 'startDate', 'endDate', 'isAllVenuesSelected', 'status'));
        }
    }
    public function exportToExcel(Request $request)
    {
        $request->validate([
            'venue_id' => 'required',
            'status' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
        ]);

        $fileName = 'Venue_Reservation_Report_' . now()->format('Y-m-d_H-i-s') . '.xlsx';

        return Excel::download(
            new VenueReportExport(
                $request->start_date,
                $request->end_date,
                $request->venue_id,
                $request->status
            ), 
            $fileName
        );
    }
}
