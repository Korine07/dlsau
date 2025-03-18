<!DOCTYPE html>
<html lang="en">

  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Set Page Title -->
    <title>DLSAU</title>

    <!-- Set Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/DLSAU.png') }}">
    
    <!-- css -->
  @include('facilities.facilitiescss')

  </head>

<body>

<!-- preloader -->
@include('facilities.preloader')

<!-- subheader -->
@include('facilities.subheader')

<!-- header -->
@include('facilities.header')

<!-- facilities -->
@include('facilities.facilitiesdown')

<!-- footer -->
@include('facilities.footer')



  </body>
</html>