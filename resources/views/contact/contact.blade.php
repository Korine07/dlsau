<!DOCTYPE html>
<html lang="en">

  <head>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Set Page Title -->
    <title>DLSAU</title>

    <!-- Set Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/DLSAU.png') }}">

  <!-- css -->
  @include('contact.headercss')
    
  </head>

<body>

<!-- preloader -->
@include('contact.preloader')

<!-- sub-header -->
@include('contact.subheader')

<!-- header -->
@include('contact.header')

<!-- contact -->
@include('contact.contactdown')

<!-- footer -->
@include('contact.footer')

  
  </body>
</html>