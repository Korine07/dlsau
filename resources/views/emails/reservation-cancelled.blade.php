<!DOCTYPE html>
<html>
<head>
    <title>Reservation Cancelled</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #ddd; background: #eee; }
        .header { color: white; text-align: center; padding: 20px; border-radius: 5px 5px 0 0; }
        .header img { max-width: 500px; margin-bottom: 5px; }
        .header { text-align: center; color: white; padding: 10px; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .btn { background: #dc3545; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px; }
        .home-btn { background: #007bff; color: white; padding: 10px 20px; text-decoration: none; display: inline-block; border-radius: 5px; }
    </style>
</head>
<body>

    <div class="container">
        <div class="header">
            <img src="{{ asset('assets/images/DLSAUU.png') }}" alt="De La Salle Araneta University Logo">
        </div>
        <div class="content">
            <p>Dear {{ $reservation->first_name }} {{ $reservation->last_name }},</p>
            <p>We regret to inform you that your reservation has been <strong>cancelled</strong>. If this was unintentional or if you need to reschedule, please visit our Adserve Office with your receipt.</p>

            <p><strong>If you want to book again, click the button below:</strong></p>
            <p style="text-align: center;">
                <a href="http://127.0.0.1:8000/home" class="home-btn">Book Again</a>
            </p>

            <p>For refunds or rescheduling, please proceed to the Adserve Office.</p>

            <p>Best regards,</p>
            <p><strong>De La Salle Araneta University</strong><br>
            Adserve@gmail.com</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AdServe | 2101 | 2125 | 2143</p>
        </div>
    </div>

</body>
</html>
