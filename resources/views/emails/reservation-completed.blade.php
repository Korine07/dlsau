<!DOCTYPE html>
<html>
<head>
    <title>Reservation Completed</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: white; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
        .header { color: white; text-align: center; padding: 20px; border-radius: 5px 5px 0 0; }
        .header img { max-width: 500px; margin-bottom: 5px; }
        .content { padding: 20px; }
        .footer { text-align: center; font-size: 12px; color: #777; margin-top: 20px; }
        .btn { background: #008000; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; display: inline-block; }
    </style>
</head>
<body>
    <div class="container">
        
        <div class="content">
            <p>Dear {{ $reservation->first_name }} {{ $reservation->last_name }},</p>
            <p>We are pleased to inform you that your reservation is now <strong>complete</strong>, and your payment has been successfully received.</p>

            <p>Click the button below to view your <strong>PAID receipt</strong>:</p>

            <a href="{{ $receiptLink }}" class="btn" target="_blank">View Receipt</a>

            <p>If you have any questions or need further assistance, feel free to reach out to us.</p>

            <p>Thank you!</p>

            <p>Best regards,<br>
            <strong>De La Salle Araneta University</strong><br>
            Osfr.dlsau@gmail.com</p>
        </div>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AdServe | 2101 | 2125 | 2143</p>
        </div>
    </div>
</body>
</html>
