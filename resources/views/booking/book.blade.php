<!DOCTYPE html>
<html lang="en">

  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Set Page Title -->
    <title>DLSAU</title>

    <!-- Set Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/DLSAU.png') }}">

    <!-- css -->
    @include('booking.bookcss')
  </head>

<body>

   <!-- preloader -->
   @include('booking.preloader')

   <!-- subheader -->
   @include('booking.subheader')

   <!-- header -->
   @include('booking.header')

   <!-- booking -->
   @include('booking.bookingprocess')

   <!-- preloader -->
   @include('booking.footer')
  
  </body>
</html>