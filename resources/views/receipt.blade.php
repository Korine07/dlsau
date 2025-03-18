<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Receipt</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/DLSAU.png') }}">
    <style>
        body { font-family: Arial, sans-serif; margin: 20px; padding: 0; font-size: 10px; }
            @page {
            size: 8.5in 11in; /* Keep the letter size in portrait */
            margin: 0;
        }
        .receipt-container { width: 100%;  max-width: 5.5in; margin: auto; border: 1px solid #ddd; padding: 20px; box-shadow: 0px 0px 10px #ddd; }
        .header { text-align: center; width: 100%; }
        .header h2 { margin: 0; }
        .logo { width: 50px; height: 50px; margin-bottom: 10px; }
        .details { margin-top: 20px; }
        .details-row { display: flex; justify-content: space-between; margin-bottom: 8px; }
        .details-col { width: 48%; }

        .tables-container { display: flex; justify-content: space-between; margin-top: 5px; }
        .summary-table, .payment-table, .services-table { width: 48%; }
        table { width: 100%; border-collapse: collapse; font-size: 10px; }
        th, td { border: 1px solid #ddd; padding: 6px; text-align: left; }

        .footer { margin-top: 20px; text-align: center; font-size: 9px; }
        .print-btn { margin-top: 20px; text-align: center; }
        .print-btn button { padding: 10px 20px; font-size: 11px; background-color: #28a745; color: #fff; border: none; cursor: pointer; }
    </style>
</head>
<body>

<div class="receipt-container">
    <div class="header">
        <img src="{{ asset('assets/images/DLSAU.png') }}" alt="Company Logo" class="logo">
        <h2>Receipt</h2>
    </div>

    <div class="details">
        <div class="details-row">
            <div class="details-col"><strong>Receipt No:</strong> #{{ $booking->id }}</div>
            <div class="details-col"><strong>Created Date:</strong> {{ \Carbon\Carbon::parse($booking->created_at)->format('d M Y, h:i A') }}</div>
        </div>
        <div class="details-row">
            <div class="details-col"><strong>Customer:</strong> {{ $booking->first_name }} {{ $booking->last_name }}</div>
            <div class="details-col"><strong>Email:</strong> {{ $booking->email }}</div>
        </div>
        <div class="details-row">
            <div class="details-col"><strong>Contact:</strong> {{ $booking->phone }}</div>
            <div class="details-col"><strong>Member Type:</strong> {{ ucfirst($booking->memtyp) }}</div>
        </div>
    </div>

    <div class="tables-container">
        <!-- Booking Details -->
        <div class="summary-table">
            <h3>Booking Details</h3>
            <table>
                <tr><th>Venue</th><td>{{ $booking->venue->venue_name }}</td></tr>
                <tr><th>Nature of Activity</th><td>{{ $booking->activity_nature ?? 'Not specified' }}</td></tr>
                <tr><th>Price Per Hour</th>
                    <td>
                        @if($booking->memtyp === 'member')
                            ₱{{ number_format($booking->venue->member_price, 2) }} 
                        @else
                            ₱{{ number_format($booking->venue->guest_price, 2) }} 
                        @endif
                    </td>
                </tr>
                <tr><th>Check-In</th><td>{{ \Carbon\Carbon::parse($booking->check_in_date)->format('d M Y') }} at {{ $booking->check_in_time }}</td></tr>
                <tr><th>Check-Out</th><td>{{ \Carbon\Carbon::parse($booking->check_out_date)->format('d M Y') }} at {{ $booking->check_out_time }}</td></tr>
                <tr><th>Hours</th><td>{{ $booking->total_hours }} hour(s)</td></tr>
                <tr><th>Guests</th><td>{{ $booking->expected_guests }}</td></tr>
            </table>
        </div>

        <!-- Payment Summary -->
        <div class="payment-table">
            <h3>Payment Summary</h3>
            <table>
                <tr>
                    <th>Base Price</th>
                    <td>₱{{ number_format(($booking->memtyp === 'member' ? $booking->venue->member_price : $booking->venue->guest_price) * $booking->total_hours, 2) }}</td>
                </tr>
                <tr>
                    <th>Service Total</th>
                    <td>₱{{ number_format($booking->services->sum(fn($service) => $service->price * $service->pivot->quantity), 2) }}</td>
                </tr>
                <tr>
                    <th>Total Amount</th>
                    <td>
                        @if($booking->memtyp === 'member')
                            <strong>Paid</strong>
                        @else
                            <strong>₱{{ number_format($booking->total_price, 2) }}</strong>
                        @endif
                    </td>
                </tr>
                <tr><th>Status</th><td>{{ ucfirst($booking->status) }}</td></tr>
            </table>
        </div>
    </div>

    <!-- Services Section -->
    <div class="tables-container">
        <div class="services-table">
            <h3>Services</h3>
            <table>
                <tr><th>Service</th><th>Price</th><th>Qty</th><th>Total</th></tr>
                @foreach ($booking->services as $service)
                    <tr>
                        <td>{{ $service->name }}</td>
                        <td>₱{{ number_format($service->price, 2) }}</td>
                        <td>{{ $service->pivot->quantity }}</td>
                        <td>₱{{ number_format($service->price * $service->pivot->quantity, 2) }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </div>

    <div class="footer">
        <p>Keep this receipt as proof of your reservation.</p>
    </div>

    <div class="print-btn">
        <button onclick="window.print()">Print Receipt</button>
    </div>
</div>

</body>
</html>
