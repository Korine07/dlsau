@extends('vreport.layout')

@section('content')

<div class="container mt-4">
    <div class="row">
        <div class="col-lg-12 d-flex justify-content-between align-items-center">
            <h2 class="text-dark">Generate Reservation Report</h2>
        </div>
    </div>

    <hr style="border: 1px solid green;">

    {{-- Venue & Date Filter Form --}}
    <form action="{{ route('venue.reservation.generate') }}" method="POST">
        @csrf
        <div class="row">
            <!-- Venue Dropdown -->
            <div class="col-md-3">
                <label for="venue_id" class="form-label">Select Venue:</label>
                <select id="venue_id" name="venue_id" class="form-control" required>
                    <option value="" disabled selected>-- Select Venue --</option>
                    <option value="all">All</option> 
                    @foreach($venues as $venue)
                        <option value="{{ $venue->id }}">{{ $venue->venue_name }}</option>
                    @endforeach
                </select>
            </div>

            <!-- Reservation Status Dropdown -->
            <div class="col-md-2">
                <label for="status" class="form-label">Select Status:</label>
                <select id="status" name="status" class="form-control" required>
                    <option value="" disabled selected>-- Select Status --</option> <!-- Ensures validation -->
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                    <option value="archived">Archived</option>
                </select>
                @error('status')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Start Date -->
            <div class="col-md-3">
                <label for="start_date" class="form-label">Start Date:</label>
                <input type="date" id="start_date" name="start_date" class="form-control" required>
                @error('start_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- End Date -->
            <div class="col-md-3">
                <label for="end_date" class="form-label">End Date:</label>
                <input type="date" id="end_date" name="end_date" class="form-control" required>
                @error('end_date')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
            </div>

            <!-- Submit Button -->
            <div class="col-md-2 d-flex align-items-end">
                <button type="submit" class="btn btn-success w-100">
                    <i class="fa fa-file-text" aria-hidden="true"></i> Generate Report
                </button>
            </div>
        </div>
    </form>
</div>

<script>
    document.getElementById('end_date').addEventListener('change', function () {
    let startDate = new Date(document.getElementById('start_date').value);
    let endDate = new Date(this.value);
    let errorMessage = document.getElementById('endDateError');

    if (endDate < startDate) { // Changed condition to allow equal dates
        errorMessage.style.display = 'block';
        errorMessage.textContent = 'End date must be the same or later than the start date.';
        this.value = ''; // Reset invalid input
    } else {
        errorMessage.style.display = 'none';
    }
});

</script>

@endsection
