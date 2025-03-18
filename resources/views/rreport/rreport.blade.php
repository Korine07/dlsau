@extends('rreport.layout')

@section('content')

<!-- Reservation Report Header -->
<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2 class="text-dark">Generate Complete Reservation Report</h2>
        </div>
    </div>

    <hr style="border: 1px solid green;">

    {{-- Date Filter Form --}}
    <form action="{{ route('reservation.list.generate') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-5">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control datepicker" required>
            </div>

            <div class="col-md-5">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control datepicker" required>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100"><i class="fa fa-file-text" aria-hidden="true"></i> Generate Report</button>
            </div>
        </div>
    </form>
</div>

@endsection


