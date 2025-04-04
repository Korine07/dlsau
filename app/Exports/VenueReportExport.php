<?php

namespace App\Exports;

use App\Models\Reservation;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class VenueReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $startDate, $endDate, $venueId, $status;

    public function __construct($startDate, $endDate, $venueId, $status)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->venueId = $venueId;
        $this->status = $status;
    }

    public function collection()
    {
        $query = Reservation::with('venue')
            ->whereBetween('check_in_date', [$this->startDate, $this->endDate]);

        if ($this->venueId !== 'all') {
            $query->where('venue_id', $this->venueId);
        }

        if ($this->status !== 'all') {
            $query->where('status', $this->status);
        }

        return $query->get()->map(function ($reservation, $key) {
            return [
                '#' => $key + 1,
                'Venue' => $reservation->venue->venue_name,
                'Client' => $reservation->first_name . ' ' . $reservation->last_name,
                'Phone' => $reservation->phone,
                'Guests' => $reservation->expected_guests,
                'Check-in' => $reservation->check_in_date . ' ' . $reservation->check_in_time,
                'Check-out' => $reservation->check_out_date . ' ' . $reservation->check_out_time,
                'Activity' => $reservation->activity_nature ?? 'Not specified',
                'Member Type' => ucfirst($reservation->memtyp),
                'Total Hours' => $reservation->total_hours,
                'Total Price' => '₱' . number_format($reservation->total_price, 2),
                'Status' => ucfirst($reservation->status),
            ];
        });
    }

    public function headings(): array
    {
        return [
            '#', 'Venue', 'Client', 'Phone', 'Guests', 'Check-in', 'Check-out', 
            'Activity', 'Member Type', 'Total Hours', 'Total Price', 'Status'
        ];
    }
}
