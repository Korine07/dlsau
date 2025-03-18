<!DOCTYPE html>
<html lang=""eng>
    <head>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- css -->
    @include('admin.admincss')
    
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Calendar</title>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    </head>
    <body>

    <!-- preloader -->
    @include('admin.preloader')

    <!-- navbar -->
    @include('admin.adminnavbar')

    <!-- sidebar -->
    @include('admin.adminsidebar')

        <div class="main-content">
            @yield('content')
        </div>

    <!-- footer -->
    @include('admin.adminfooter')

    <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
        <script>
            // Auto-close flash message after 3 seconds
            document.addEventListener("DOMContentLoaded", function() {
                const flashMessage = document.getElementById("flash-message");
                if (flashMessage) {
                    setTimeout(() => {
                        flashMessage.classList.remove("show");
                        flashMessage.remove(); // Optional: Completely remove the element from the DOM
                    }, 2000); // Adjust the time (2000ms = 2 seconds)
                }
            });
        </script>

        <!-- Add before the closing </body> tag -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

        <!-- jQuery and DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

    </body>
    </html>

<style>
.main-content {
  margin-left: 250px; /* Push content to the right */
  padding: 20px;
  width: calc(100% - 350px); /* Fill remaining width */
  transition: margin-left 0.25s ease;
}

</style>
    