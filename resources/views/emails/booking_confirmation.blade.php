<!DOCTYPE html>
<html>
<head>
    <title>Pending Reservation</title>
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
        <div class="header">
            <img src="{{ asset('assets/images/DLSAUU.png') }}" alt="De La Salle Araneta University Logo">
            
        </div>
        <p>Dear {{ $reservation->first_name }} {{ $reservation->last_name }},</p>
        <p>Thank you for your reservation request. Your booking is currently <strong>pending</strong> and awaiting confirmation. We will notify you once your reservation is confirmed.</p>
        
        <h3>Important Reminder:</h3>
        <p>Please make sure to bring supporting documents, such as the approval of activity or the program of the activity, to the AdServe office for verification and processing.</p>
        
        We appreciate advance notice for any changes or cancellations.

        <p>If you have any questions or need assistance, feel free to contact us.</p>

        <p>Best regards,</p>
        <p><strong>De La Salle Araneta University</strong><br>
        Adserve@gmail.com</p>
        <div class="footer">
            <p>&copy; {{ date('Y') }} AdServe | 2101 | 2125 | 2143</p>
        </div>
    </div>
</body>
</html>
