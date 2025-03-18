@extends('rreport.layoutt')

@section('content')
<div class="container">
    <h1 style="text-align: center;">De La Salle Araneta University</h1>
    <p style="text-align: center;">Salvador Araneta Campus, 303 Victoneta Ave, Potrero, Malabon, 1475 Metro Manila</p>
    <hr>

    <h2 style="text-align: center;">Reservation List - Archive </h2>
    <p style="text-align: center;">Showing results for 
        @if($isAllVenuesSelected)
            <strong>All Venues</strong>
        @else
            <strong>{{ $venue->venue_name }}</strong>
        @endif
        from <strong>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</strong> 
        to <strong>{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</strong>
    </p>

    @if($reports->isEmpty())
        <p style="text-align: center;">No archived reservations found for this date range.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Venue</th>
                    <th>Client</th>
                    <th>Phone</th>
                    <th>Guests</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Activity</th>
                    <th>Member Type</th>
                    <th>Service</th>
                    <th>Total Hours</th>
                    <th>Total Price</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $key => $report)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ optional($report->venue)->venue_name ?? 'No Venue Assigned' }}</td> {{-- Handle missing venue --}}
                    <td>{{ $report->first_name }} {{ $report->last_name }}</td>
                    <td>{{ $report->phone }}</td>
                    <td>{{ $report->expected_guests }}</td> 
                    <td>
                        {{ \Carbon\Carbon::parse($report->check_in_date)->format('M d, Y') }} {{ $report->check_in_time }}
                    </td> 
                    <td>
                        {{ \Carbon\Carbon::parse($report->check_out_date)->format('M d, Y') }} {{ $report->check_out_time }}
                    </td>
                    <td>{{ $report->activity_nature ?? 'Not specified' }}</td>
                    <td>{{ ucfirst($report->memtyp) }}</td>
                    <td>
                        @if($report->services->isNotEmpty())
                            @foreach($report->services as $service)
                                {{ $service->name }} ({{ $service->pivot->quantity }})<br>
                            @endforeach
                        @else
                            None
                        @endif
                    </td>
                    <td>{{ $report->total_hours }}</td>
                    <td>₱{{ number_format($report->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <br>
    <a href="{{ route('reservation.archived') }}" style="display: block; text-align: center;">Go Back</a>
</div>
@endsection
