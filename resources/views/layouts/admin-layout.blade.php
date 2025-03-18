<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>

    <!-- Mantis CSS -->
    <link rel="stylesheet" href="{{ asset('assets/mantis/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/mantis/css/custom.css') }}">

    <!-- Bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/mantis/vendor/bootstrap/css/bootstrap.min.css') }}">
</head>
<body>
    <!-- Sidebar -->
    @include('adminn.sidebar')

    <!-- Navbar -->
    @include('adminn.navbar')

    <!-- Main Content -->
    <div class="main-content">
        <div class="container">
            @yield('content')
        </div>
    </div>

    <!-- Footer -->
    @include('adminn.footer')

    <!-- Scripts -->
    <script src="{{ asset('assets/mantis/vendor/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/mantis/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/mantis/js/scripts.js') }}"></script>
</body>
</html>
