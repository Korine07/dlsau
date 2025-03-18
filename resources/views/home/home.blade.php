<!DOCTYPE html>
<html lang="en">

  <head>

  <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Set Page Title -->
    <title>DLSAU</title>

    <!-- Set Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('assets/images/DLSAU.png') }}">

    <!-- Include CSS -->
    @include('home.homecss')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">


  </head>

<body>

  <!-- preloader -->
  @include('home.preloader')

  <!-- sub-header -->
  @include('home.subheader')

  <!-- header -->
  @include('home.header')

  <!-- banner -->
  @include('home.banner')

  <!-- video -->
  @include('home.video')

  <!-- venue -->
  @include('home.venue', ['venues' => $venues])

  <!-- amenities -->
  @include('home.amenities')

  <!-- review -->
  @include('home.review')

  <!-- contact -->
  @include('home.h-contact')

  <!-- footer -->
  @include('home.footer')

  </body>
</html>