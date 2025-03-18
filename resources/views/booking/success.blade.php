@extends('booking.layouts')

@section('content')
<div class="container text-center">
    <h2 class="text-success mt-5">🎉 Booking Successful!</h2>
    <p>Your reservation has been submitted successfully. We will contact you soon.</p>
    <a href="{{ route('home') }}" class="btn btn-primary mt-3">Go to Home</a>
</div>
@endsection
