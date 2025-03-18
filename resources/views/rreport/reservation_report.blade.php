@extends('rreport.layoutt')

@section('content')
<div class="container">
    <h1 style="text-align: center;">De La Salle Araneta University</h1>
    <p style="text-align: center;">Salvador Araneta Campus, 303 Victoneta Ave, Potrero, Malabon, 1475 Metro Manila</p>
    <p style="text-align: center;">(02) 8330 9128</p>
    <hr>

    <h2 style="text-align: center;">Reservation List - Complete</h2>
    <p style="text-align: center;">Showing results from <strong>{{ \Carbon\Carbon::parse($startDate)->format('M d, Y') }}</strong> 
       to <strong>{{ \Carbon\Carbon::parse($endDate)->format('M d, Y') }}</strong></p>

    @if($reports->isEmpty())
        <p style="text-align: center;">No completed reservations found for this date range.</p>
    @else
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Venue</th>
                    <th>Guest Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Hours</th>
                    <th>Amount Paid</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($reports as $key => $report)
                <tr>
                    <td>{{ $key + 1 }}</td>
                    <td>{{ optional($report->venue)->venue_name ?? 'No Venue Assigned' }}</td> {{-- Handle missing venue --}}
                    <td>{{ $report->first_name }} {{ $report->last_name }}</td>
                    <td>{{ $report->email }}</td>
                    <td>{{ $report->phone }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->check_in_date)->format('M d, Y') }} {{ $report->check_in_time }}</td>
                    <td>{{ \Carbon\Carbon::parse($report->check_out_date)->format('M d, Y') }} {{ $report->check_out_time }}</td>
                    <td>{{ $report->total_hours }}</td>
                    <td>₱{{ number_format($report->total_price, 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <br>
    <a href="{{ route('reservation.list') }}" style="display: block; text-align: center;">Go Back</a>
</div>
@endsection
