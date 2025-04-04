@extends('vreport.layoutt')

@section('content')
<div class="container">
    <h1 style="text-align: center;">De La Salle Araneta University</h1>
    <p style="text-align: center;">Salvador Araneta Campus, 303 Victoneta Ave, Potrero, Malabon, 1475 Metro Manila</p>
    <hr>

    <h2 style="text-align: center;">Reservation List - Venue Specific</h2>
    <p style="text-align: center;">Showing results for 
        @if($isAllVenuesSelected)
            <strong>All Venues</strong>
        @else
            <strong>{{ $venue->venue_name }}</strong>
        @endif
        from <strong>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</strong> 
        to <strong>{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</strong>
        with status: <strong>{{ ucfirst($status) }}</strong>
    </p>

<!-- ✅ Add Export Button Here -->
<div class="d-flex justify-content-end mb-3">
        <form action="{{ route('venue.reservation.export') }}" method="POST">
            @csrf
            <input type="hidden" name="start_date" value="{{ $startDate }}">
            <input type="hidden" name="end_date" value="{{ $endDate }}">
            <input type="hidden" name="venue_id" value="{{ request('venue_id') }}">
            <input type="hidden" name="status" value="{{ request('status') }}">

            <button type="submit" class="btn btn-success">
                <i class="fa fa-file-excel"></i> Export to Excel
            </button>
        </form>
    </div>

    @if($reports->isEmpty())
        <p style="text-align: center;">No reservations found for this venue and date range.</p>
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
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $key => $report)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ $report->venue->venue_name }}</td> 
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
                    <td>
                        <span class="status-badge status-{{ strtolower($report->status) }}">
                            {{ ucfirst($report->status) }}
                        </span>
                    </td> 
                </tr>
                @endforeach
            </tbody>
        </table>

    @endif

    <br>
    <a href="{{ route('venue.reservation.list') }}" style="display: block; text-align: center;">Go Back</a>
</div>

<style>
    .status-badge {
    display: inline-block;
    padding: 6px 12px;
    border-radius: 6px;
    font-size: 11px;
    font-weight: bold;
    color: white;
    text-align: center;
}

/* Color Coordination for Different Statuses */
.status-pending {
    background-color: #ffc107; /* Yellow */
}

.status-confirmed {
    background-color: #28a745; /* Green */
}

.status-completed {
    background-color: #007bff; /* Blue */
}

.status-cancelled {
    background-color: #dc3545; /* Red */
}

.status-archived {
    background-color: #6c757d; /* Gray */
}

</style>
@endsection
