@extends('dashboard.layout')
@section('content')
<div class="container-fluid">

    <h2 class="mt-4"></h2>

    <!-- Summary Cards -->
    <div class="row gx-2 gy-2"> <!-- Reduced spacing for a more compact layout -->
        <div class="col-lg-3 col-md-6 col-sm-6"> 
            <div class="card shadow-sm p-3 bg-white rounded custom-card">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted">Pending</h6>
                    <h2 class="font-weight-bold text-warning">{{ $total_pending }}</h2>
                    <span class="text-muted">Upcoming bookings</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6"> 
            <div class="card shadow-sm p-3 bg-white rounded custom-card">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted">Confirmed</h6>
                    <h2 class="font-weight-bold" style="color: #fd7e14;">{{ $total_confirmed }}</h2>
                    <span class="text-muted">Approved bookings</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6"> 
            <div class="card shadow-sm p-3 bg-white rounded custom-card">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted">Completed</h6>
                    <h2 class="font-weight-bold text-primary">{{ $total_completed }}</h2>
                    <span class="text-muted">Finished bookings</span>
                </div>
            </div>
        </div>
        <div class="col-lg-3 col-md-6 col-sm-6"> 
            <div class="card shadow-sm p-3 bg-white rounded custom-card">
                <div class="card-body text-center">
                    <h6 class="card-title text-muted">Total Revenue</h6>
                    <h2 class="font-weight-bold text-info">₱{{ number_format($total_revenue, 2) }}</h2>
                    <span class="text-muted">Generated earnings</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Graphs -->
    <div class="row mt-4 d-flex flex-nowrap overflow-auto"> 
        <div class="col-lg-4 col-md-5 col-sm-12 d-flex flex-column min-width-chart">
            <h4 class="text-dark">Monthly Revenue</h4>
            <div class="card shadow-sm p-3 bg-white rounded custom-revenue-card flex-grow-1">
                <canvas id="monthlyRevenueChart"></canvas>
            </div>
        </div>

        <!-- Reservation Table -->
        <div class="col-lg-8 col-md-7 col-sm-12 d-flex flex-column min-width-table">
            <h4 class="text-dark">Reservations</h4>
            <div class="custom-table-container card shadow-sm p-3 bg-white rounded flex-grow-1">
                <table class="table table-striped table-hover text-center">
                    <thead class="bg-light">
                        <tr>
                            <th>Customer</th>
                            <th>Activity</th>
                            <th>Venue</th>
                            <th>Check-in</th>
                            <th>Check-out</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($upcomingReservations as $reservation)
                            <tr>
                                <td>{{ $reservation->first_name }} {{ $reservation->last_name }}</td>
                                <td>
                                    <span data-bs-toggle="tooltip" data-bs-placement="top" title="{{ $reservation->activity_nature }}">
                                        {{ Str::limit($reservation->activity_nature, 16, '...') }}
                                    </span>
                                </td>
                                <td>{{ $reservation->venue->venue_name }}</td>
                                <td>{{ $reservation->check_in_date }} {{ date('h:i A', strtotime($reservation->check_in_time)) }}</td>
                                <td>{{ $reservation->check_out_date }} {{ date('h:i A', strtotime($reservation->check_out_time)) }}</td>
                                <td>
                                    @if($reservation->status == 'pending')
                                        <span class="status-badge bg-warning text-dark">Pending</span>
                                    @elseif($reservation->status == 'confirmed')
                                        <span class="status-badge bg-orange text-white">Confirmed</span>
                                    @elseif($reservation->status == 'completed')
                                        <span class="status-badge bg-primary text-white">Completed</span>
                                    @else
                                        <span class="status-badge bg-secondary text-white">Unknown</span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var monthlyRevenueCtx = document.getElementById('monthlyRevenueChart').getContext('2d');
        var monthlyRevenueChart = new Chart(monthlyRevenueCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode(array_keys($monthlyRevenue->toArray())) !!},
                datasets: [{
                    label: 'Total Revenue',
                    data: {!! json_encode(array_values($monthlyRevenue->toArray())) !!},
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 0, 255, 0.2)',
                    borderWidth: 2
                }]
            }
        });
        //activity tooltip
        document.addEventListener("DOMContentLoaded", function () {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
</div>

<style>
/* General Card Styling */
.custom-card {
    width: 100%; /* Ensures it fits within the column */
    height: auto; /* Adjust height dynamically */
    padding: 15px;
    border-radius: 10px;
    transition: all 0.3s ease-in-out;
}
.custom-card:hover {
    transform: translateY(-3px); /* Subtle lift effect */
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}
.row.gx-2 {
    flex-wrap: wrap;
}
.col-lg-3 {
    max-width: 100%; /* Full width on small screens */
}

@media (min-width: 576px) {
    .col-sm-6 {
        max-width: 50%;
    }
}
@media (min-width: 992px) {
    .col-lg-3 {
        max-width: 24%;
    }
}
.table thead {
    font-weight: bold;
    border-bottom: 2px solid #ddd;
}
.table tbody tr:hover {
    background-color: rgba(0, 0, 0, 0.05);
}
.custom-revenue-card, .custom-table-container {
    height: 100%;
    min-height: 350px;
}
.row.mt-4 {
    display: flex;
    flex-wrap: wrap; /* Allows stacking on smaller screens */
    gap: 20px;
    overflow-x: auto;
    white-space: nowrap;
}
.min-width-chart {
    min-width: 400px; /* Reduced width */
    max-width: 100%;
    flex-grow: 1;
}
.min-width-table {
    min-width: 700px; /* Expanding width */
    max-width: 900px; /* Maximum space allocation */
    flex-grow: 1;
}

@media (max-width: 992px) {
    .row.mt-4 {
        flex-direction: column;
    }
}
.custom-table-container {
    width: 100%; /* Default: Full width of column */
    max-width: 750px; /* Adjust this value to increase/decrease width */
    height: 310px; /* Ensure it matches Monthly Revenue height */
    max-height: 350px; /* Prevents overflow */
    overflow-y: auto;
    overflow-x: auto;
    padding: 15px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.1);
}
.status-badge {
    font-size: 11px; /* Keep font size consistent */
    font-weight: bold;
    padding: 8px 12px; /* Ensure same padding as before */
    border-radius: 6px; /* Keep the same rounded corners */
    display: inline-block;
    text-align: center;
    min-width: 80px; /* Ensures uniform width */
    color: white !important;
}

/* Custom Orange Color for 'Confirmed' Status */
.bg-orange {
    background-color: #fd7e14 !important; /* Bootstrap's Orange */
}
.bg-warning {
    color: white !important;
}
.container {
    width: 100%;
    max-width: 1200px;
    padding: 10px;
}

@media (max-width: 768px) {
    .container {
        width: 95%;
    }
}
@media (max-width: 768px) {
    .row.mt-4 {
        display: flex;
        flex-wrap: nowrap; /* Keeps them in one row */
        overflow-x: auto;
    }
    .min-width-chart,
    .min-width-table {
        min-width: 450px; /* Prevents them from stacking */
    }
}
</style>

@endsection
