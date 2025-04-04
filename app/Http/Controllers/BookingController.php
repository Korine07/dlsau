<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Venue;
use App\Models\Reservation;
use Carbon\Carbon;
use App\Models\Holiday;
use App\Models\Services;
use App\Mail\BookingConfirmationMail;
use Illuminate\Support\Facades\Mail;
use App\Mail\BookingConfirmedMail;
use App\Mail\ReservationCompletedMail;
use App\Mail\ReservationCancelledMail;

class BookingController extends Controller
{
    public function index()
    {
        return view("booking.book");
    }

    public function show($id)
    {
        $venue = Venue::with('categories')->findOrFail($id);
        $services = \App\Models\Services::all();
        return view('booking.book', compact('venue', 'services'));
    }

    public function store(Request $request)
    {
        $holidays = Holiday::select('start_date', 'end_date')->get();
        $disabledDates = [];
    
        foreach ($holidays as $holiday) {
            $startDate = Carbon::parse($holiday->start_date);
            $endDate = Carbon::parse($holiday->end_date);
    
            while ($startDate->lte($endDate)) {
                $disabledDates[] = $startDate->format('Y-m-d');
                $startDate->addDay();
            }
        }

        $request->validate([
            'first_name' => 'required|string|regex:/^[A-Za-z\s]+$/|max:255',  
            'last_name' => 'required|string|regex:/^[A-Za-z\s]+$/|max:255',
            'phone' => 'required|regex:/^\+?[0-9]{10,15}$/',
            'expected_guests' => 'required|integer|min:1',
            'check_in_date' => 'required|date|after_or_equal:today',
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'check_in_time' => 'required|date_format:H:i|after_or_equal:08:00|before:22:00',
            'check_out_time' => 'required|date_format:H:i|after:check_in_time|before:22:00',
            'memtyp' => 'required|in:guest,member',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'integer|min:1',
            'terms' => 'required|accepted',
            'activity_nature' => 'required|string|max:64',
            'email' => ['required', 'email', 'regex:/^[a-zA-Z0-9._%+-]+@(gmail\.com|yahoo\.com)$/'],
        ], [
            'email.regex' => 'Please enter a valid Gmail or Yahoo email address.',
        ]);
        
    
        $venue = Venue::findOrFail($request->venue_id);
    
        if ($request->expected_guests > $venue->venue_capacity) {
            return back()->withErrors(['expected_guests' => 'Number of guests exceeds venue capacity']);
        }
    
        // Convert check-in and check-out to timestamps
        $checkIn = Carbon::parse("{$request->check_in_date} {$request->check_in_time}");
        $checkOut = Carbon::parse("{$request->check_out_date} {$request->check_out_time}");
    
        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            return back()->withErrors(['check_out_time' => 'Check-out time must be later than check-in time.']);
        }

        // ✅ Prevent Double Booking
        $existingBooking = Reservation::where('venue_id', $venue->id)
            ->where('check_in_date', $request->check_in_date)
            ->where(function ($query) use ($request) {
                $query->where('check_in_time', '<', $request->check_out_time)
                    ->where('check_out_time', '>', $request->check_in_time);
            })
            ->first();

        if ($existingBooking) {
            return back()->withErrors(['check_in_time' => 'Selected time slot is already booked. Please choose another time.']);
        }
    
        $daysBooked = Carbon::parse($request->check_in_date)->diffInDays(Carbon::parse($request->check_out_date)) + 1;
        $hoursPerDay = Carbon::parse($request->check_in_time)->diffInHours(Carbon::parse($request->check_out_time));
        $totalHours = $hoursPerDay * $daysBooked;

        if ($totalHours <= 0) {
            return back()->withErrors(['check_out_time' => 'Check-out time must be at least 1 hour after check-in.']);
        }
    
        $pricePerHour = ($request->memtyp === 'member') ? $venue->member_price : $venue->guest_price;
        $baseTotalPrice = $totalHours * $pricePerHour;

        $reservation = Reservation::create([
            'venue_id' => $venue->id,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'expected_guests' => $request->expected_guests,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'memtyp' => $request->memtyp,
            'activity_nature' => $request->activity_nature,
            'total_hours' => $totalHours,
            'total_price' => $baseTotalPrice, // Temporary, will update after adding services
            'status' => 'pending',
        ]);
        

        // Calculate total service cost
        $serviceTotal = 0;
        $servicesData = [];

        // Calculate total service cost
        if ($request->services) {
            foreach ($request->services as $index => $serviceId) {
                $service = Services::find($serviceId);
                if ($service) {
                    $quantity = $request->quantities[$index] ?? 1;
                    $serviceTotal += $service->price * $quantity;
                    $servicesData[$serviceId] = ['quantity' => $quantity];
                }
            }
        }

        // Store services in pivot table (assuming you have a reservation_service table)
        if (!empty($servicesData)) {
            $reservation->services()->attach($servicesData);
        }
    
        $finalTotalPrice = $baseTotalPrice + $serviceTotal;
        $reservation->update(['total_price' => $finalTotalPrice]);

        // ✅ Send Email Confirmation
        Mail::to($request->email)->send(new BookingConfirmationMail($reservation));
    
        return redirect('/booking/success')->with('success', 'Booking successful!');
    }
    public function getCalendarEvents()
    {
        $reservations = Reservation::with('venue')
        ->where('status', '!=', 'archived') // Exclude archived reservations
        ->get();
        $holidays = Holiday::select('start_date', 'end_date', 'reason')->get();

        $events = [];

        // ✅ Add Holidays
        foreach ($holidays as $holiday) {
            $events[] = [
                'id' => "holiday-" . $holiday->id,
                'title' => $holiday->reason,
                'start' => $holiday->start_date,
                'end' => Carbon::parse($holiday->end_date)->addDay()->toDateString(),
                'color' => '#28a745', 
                'allDay' => true
            ];
        }

        // ✅ Add Reservations
        foreach ($reservations as $reservation) {
            // Set different colors based on reservation status
            $color = match ($reservation->status) {
                'pending' => '#ffc107', // Yellow
                'confirmed' => '#007bff', // Blue
                'completed' => '#28a745', // Green
                'cancelled' => '#dc3545', // Red
                default => '#6c757d' // Gray for unknown
            };

            $events[] = [
                'id' => $reservation->id,
                'title' => $reservation->venue->venue_name,
                'start' => "{$reservation->check_in_date}T{$reservation->check_in_time}",
                'end' => "{$reservation->check_out_date}T{$reservation->check_out_time}",
                'color' => $color,
                'extendedProps' => [
                    'check_in_time' => date("h:ia", strtotime($reservation->check_in_time)),
                    'check_out_time' => date("h:ia", strtotime($reservation->check_out_time)),
                    'status' => ucfirst($reservation->status),
                ]
            ];
        }

        return response()->json($events);
    }
    public function getHolidays()
    {
        $holidays = Holiday::select('start_date', 'end_date')->get();
    
        $disabledDates = [];

        foreach ($holidays as $holiday) {
            $startDate = Carbon::parse($holiday->start_date);
            $endDate = Carbon::parse($holiday->end_date);

            while ($startDate->lte($endDate)) {
                $disabledDates[] = $startDate->format('Y-m-d');
                $startDate->addDay();
            }
        }
    
        return response()->json($disabledDates);
    }    
    public function getAvailableTimes(Request $request)
    {
        try {
            $date = $request->input('date');
            $venueId = $request->input('venue_id');
            $reservationId = $request->input('reservation_id');

            if (!$date || !$venueId) {
                return response()->json(['error' => 'Missing required parameters'], 400);
            }

            $openTime = Carbon::createFromTime(8, 0); // 07:00 AM
            $closeTime = Carbon::createFromTime(22, 0); // 5:00 PM
            $allTimes = [];

            // Generate all 30-minute interval times
            while ($openTime < $closeTime) {
                $allTimes[] = $openTime->format('H:i');
                $openTime->addMinutes(30);
            }

            // Fetch booked times for this venue & date
            $bookings = Reservation::where('venue_id', $venueId)            
                ->where('status', '!=', 'cancelled') 
                ->where(function ($query) use ($date) {
                    $query->whereDate('check_in_date', '<=', $date)
                        ->whereDate('check_out_date', '>=', $date);
                })
                ->when($reservationId, function ($query) use ($reservationId) {
                    return $query->where('id', '!=', $reservationId); // Exclude the current reservation
                })
                ->select('check_in_time', 'check_out_time')
                ->get();

            $bookedTimes = [];

            foreach ($bookings as $booking) {
                $startTime = Carbon::parse($booking->check_in_time)->format('H:i');
                $endTime = Carbon::parse($booking->check_out_time)->format('H:i');
                $bookedTimes[] = [$startTime, $endTime]; // Store booked time ranges
            }

            // Remove booked times
            $availableTimes = array_filter($allTimes, function ($time) use ($bookedTimes) {
                foreach ($bookedTimes as $range) {
                    if ($time >= $range[0] && $time < $range[1]) {
                        return false;
                    }
                }
                return true;
            });

            return response()->json(['availableTimes' => array_values($availableTimes)]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function pending()
    {
        // Retrieve all pending reservations
        $pendingReservations = Reservation::with(['venue', 'services'])->where('status', 'pending')->get();

        $services = Services::all(); 
        $holidays = Holiday::select('start_date', 'end_date')->get();

        // Pass the reservations to the view
        return view('pending.pending', compact('pendingReservations', 'services', 'holidays'));
    }
    public function update(Request $request, $id)
    {
        // Convert total_price to a numeric value
        $request->merge([
            'total_price' => preg_replace('/[^0-9.]/', '', $request->total_price) // Remove ₱ and non-numeric characters
        ]);

        $reservation = Reservation::findOrFail($id);
        
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'status' => 'required|in:pending,confirmed,completed,cancelled',
            'services' => 'nullable|array',
            'services.*' => 'exists:services,id',
            'quantities' => 'nullable|array',
            'quantities.*' => 'integer|min:1',
            'check_in_date' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($reservation) {
                    if ($value < now()->format('Y-m-d') && $value != $reservation->check_in_date) {
                        $fail('You cannot change the check-in date to a past date.');
                    }
                }
            ],
            'check_out_date' => 'required|date|after_or_equal:check_in_date',
            'check_in_time' => 'required|date_format:H:i|after_or_equal:08:00|before:22:00',
            'check_out_time' => 'required|date_format:H:i|after:check_in_time|before:22:00',
            'total_price' => 'required|numeric|min:0',
        ]);

        $checkIn = Carbon::parse("{$request->check_in_date} {$request->check_in_time}");
        $checkOut = Carbon::parse("{$request->check_out_date} {$request->check_out_time}");

        if ($checkOut->lessThanOrEqualTo($checkIn)) {
            return back()->withErrors(['check_out_time' => 'Check-out time must be later than check-in time.']);
        }

        // If the reservation is being canceled, free up the time slots
        if ($request->status == 'cancelled') {
            $reservation->update([
                'status' => 'cancelled'
            ]);

            return redirect()->route('pending.reservations')->with('success', 'Reservation cancelled successfully. Time slots are now available.');
        }

        // Calculate the total days booked
        $daysBooked = Carbon::parse($request->check_in_date)->diffInDays(Carbon::parse($request->check_out_date)) + 1;
        $hoursPerDay = Carbon::parse($request->check_in_time)->diffInHours(Carbon::parse($request->check_out_time));
        $totalHours = $hoursPerDay * $daysBooked;

        if ($totalHours <= 0) {
            return back()->withErrors(['check_out_time' => 'Check-out time must be at least 1 hour after check-in.']);
        }

        // Calculate new total price
        $venue = $reservation->venue;
        $pricePerHour = ($reservation->memtyp === 'member') ? $venue->member_price : $venue->guest_price;
        $baseTotalPrice = $totalHours * $pricePerHour;

        // Remove existing services
        $reservation->services()->detach();

        // Remove specific services if needed
        if (!empty($request->removed_services)) {
            $removedServiceIds = array_filter(explode(',', $request->removed_services));
            if (!empty($removedServiceIds)) {
                $reservation->services()->detach($removedServiceIds);
            }
        }            

        // Calculate new service total
        $serviceTotal = 0;
        $servicesData = [];
        if ($request->services) {
            foreach ($request->services as $index => $serviceId) {
                $service = Services::find($serviceId);
                if ($service) {
                    $quantity = $request->quantities[$index] ?? 1;
                    $servicesData[$serviceId] = ['quantity' => $quantity];
                }
            }
        }

        // Sync services (removes unselected ones and updates quantities)
        $reservation->services()->sync($servicesData);

        // Calculate total service cost
        $serviceTotal = 0;
        foreach ($servicesData as $serviceId => $serviceData) {
            $service = Services::find($serviceId);
            $serviceTotal += $service->price * $serviceData['quantity'];
        }

        // Final price calculation
        $finalTotalPrice = $baseTotalPrice + $serviceTotal;

        $reservation->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'phone' => $request->phone,
            'status' => $request->status,
            'check_in_date' => $request->check_in_date,
            'check_out_date' => $request->check_out_date,
            'check_in_time' => $request->check_in_time,
            'check_out_time' => $request->check_out_time,
            'total_price' => $finalTotalPrice,
        ]);

        if ($request->has('redirect_to')) {
            return redirect($request->input('redirect_to'))->with('success', 'Reservation updated successfully!');
        }
    
        // Default redirect if no referring page is specified
        return response()->json(['success' => 'Reservation updated successfully!']);
    }

    public function destroy($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        return redirect()->route('pending.reservations')->with('success', 'Reservation deleted successfully!');
    }
    public function confirm()
    {
        // Retrieve all confirmed reservations
        $confirmedReservations = Reservation::with(['venue', 'services'])->where('status', 'confirmed')->get();
        $services = Services::all();

        // Pass the reservations to the confirm view
        return view('confirm.confirm', compact('confirmedReservations', 'services'));
    }
    public function markAsCompleted($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'completed']);

        return redirect()->route('confirmed.reservations')->with('success', 'Reservation marked as completed!');
    }
    public function completed()
    {
        // Retrieve all completed reservations
        $completedReservations = Reservation::with(['venue', 'services'])->where('status', 'completed')->get();

        // Pass the reservations to the completed view
        return view('completed.completed', compact('completedReservations'));
    }
    public function archive($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'archived']); // Ensure 'archived' is a string

        return redirect()->route('completed.reservations')->with('success', 'Reservation archived successfully!');
    }
    
    public function cancelled()
    {
        $cancelledReservations = Reservation::with(['venue', 'services'])
        ->where('status', 'cancelled')
        ->get();

        return view('cancelled.cancelled', compact('cancelledReservations'));
    }
    public function restore($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'pending']);
    
        return redirect()->route('cancelled.reservations')->with('success', 'Reservation restored successfully!');
    }
    // Permanently delete a cancelled reservation
    public function delete(Request $request, $id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->delete();

        // Determine the referring page and redirect accordingly
        if ($request->has('redirect_to')) {
            return redirect($request->input('redirect_to'))->with('success', 'Reservation permanently deleted!');
        }

        // Default redirect if no source is provided
        return redirect()->route('cancelled.reservations')->with('success', 'Reservation permanently deleted!');
    }

    public function unarchive($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'completed']); // Restore to completed

        return redirect()->route('archived.reservations')->with('success', 'Reservation restored from archive!');
    }
    public function archived(Request $request)
    {
        $archivedReservations = Reservation::with(['venue', 'services'])
        ->where('status', 'archived')
        ->get();

        return view('archived.archived', compact('archivedReservations'));
    }
    
    // Restore Archived Reservation
    public function restoreArchived($id)
    {
        $reservation = Reservation::findOrFail($id);
        $reservation->update(['status' => 'completed']);
    
        return redirect()->route('archived.reservations')->with('success', 'Reservation restored successfully!');
    }
    public function showReceipt($id)
    {
        $booking = Reservation::with(['venue', 'services'])->findOrFail($id);
        return view('receipt', compact('booking'));
    }
    public function confirmBooking(Request $request)
    {
        $booking = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'check_in' => $request->input('check_in'),
            'check_out' => $request->input('check_out'),
            'guests' => $request->input('guests'),
            'total_price' => $request->input('total_price'),
        ];

        // Save booking to database (assuming you have a Booking model)
        $newBooking = \App\Models\Booking::create($booking);

        // Send email confirmation
        Mail::to($booking['email'])->send(new BookingConfirmationMail($booking));

        return back()->with('success', 'Booking confirmed! A confirmation email has been sent.');
    }
    public function sendConfirmationEmail($id)
    {
        $reservation = Reservation::findOrFail($id);
    
        // Send the email
        Mail::to($reservation->email)->send(new BookingConfirmedMail($reservation));
    
        return back()->with('success', 'Confirmation email sent successfully!');
    }
    public function sendCompletedEmail($id)
    {
        $reservation = Reservation::findOrFail($id);
    
        // Send email with receipt button
        Mail::to($reservation->email)->send(new ReservationCompletedMail($reservation));
    
        return back()->with('success', 'Completion email sent successfully with receipt link!');
    }
    public function sendCancelledEmail($id)
    {
        $reservation = Reservation::findOrFail($id);

        // Send cancellation email
        Mail::to($reservation->email)->send(new ReservationCancelledMail($reservation));

        return back()->with('success', 'Cancellation email sent successfully!');
    }
}