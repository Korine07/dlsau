<!DOCTYPE html>
<html>
<head>
    <title>Reservation Confirmation</title>
    <style>
        body { font-family: Arial, sans-serif; background: #f9f9f9; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #eee; padding: 20px; border-radius: 5px; box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1); }
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

            <p>Your reservation has been <strong>confirmed</strong>. Please find your receipt below:</p>

            <p><a href="{{ $receiptLink }}" class="btn">View Receipt</a></p>

            <p>To complete your payment, kindly proceed to <strong>Adserve/Cashier</strong> and present the <strong>receipt</strong>. Please also bring supporting documents, such as the approval of activity or the program of the activity, to the AdServe office for verification and processing.</p>

            <p class="text-muted"><em>If you have already submitted these documents to the AdServe office, you may ignore this reminder.</em></p>

            <p>If you have any questions, feel free to contact us.</p>

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
