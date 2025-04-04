<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Successful</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/DLSAU.png') }}">
    <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background: linear-gradient(135deg, #d4edda, #f8f9fa);
            margin: 0;
            font-family: 'Poppins', sans-serif;
            text-align: center;
        }
        .success-container {
            background: white;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0px 6px 20px rgba(0, 0, 0, 0.1);
            max-width: 450px;
            border-top: 6px solid #28a745;
            transition: transform 0.3s;
        }
        .success-container:hover {
            transform: translateY(-5px);
        }
        .logo {
            width: 200px;
            margin-bottom: 15px;
        }
        .success-icon {
            font-size: 80px;
            color: #28a745;
            margin-bottom: 15px;
        }
        .success-title {
            font-size: 24px;
            color: #155724;
            font-weight: 600;
            margin-bottom: 10px;
        }
        .success-message {
            font-size: 16px;
            color: #333;
            margin-bottom: 20px;
        }
        .home-btn {
            display: inline-block;
            padding: 12px 30px;
            font-size: 16px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
        }
        .home-btn:hover {
            background-color: #218838;
            transform: scale(1.05);
        }
    </style>
</head>
<body>
    <div class="success-container">
        <img src="{{ asset('assets/images/success.png') }}" alt="Success Icon" class="logo">
        <i class="fas fa-check-circle success-icon"></i>
        <h1 class="success-title">Booking Confirmed!</h1>
        <p class="success-message">Your booking has been successfully submitted. A confirmation email has been sent to your inbox or check your spam.</p>
        <a href="{{ url('/home') }}" class="home-btn">Return to Home</a>
    </div>
</body>
</html>
