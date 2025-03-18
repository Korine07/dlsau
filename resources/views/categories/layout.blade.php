<!DOCTYPE html>
<html lang=""eng>
    <head>

    <!-- css -->
    @include('admin.admincss')
    
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Categories</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">

        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">
    </head>
    <body>

    <!-- preloder -->
    @include('admin.preloader')

    <!-- navbar -->
    @include('admin.adminnavbar')

    <!-- sidebar -->
    @include('admin.adminsidebar')

    
    <div class="main-panel">
        <div class="page-header">
            <div class="row">
                

                <div class="main-content">
                    @yield('content')
                </div>

                
            </div>
        </div>
    </div>

    <!-- footer -->
    @include('admin.adminfooter')

        <!-- JavaScript -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kJT5GmK+2KMXAkb7RRBs2KOUuUxrAMWLI15JFBMqBIH+53B1wU9cUGn7Wv7eaJZ9" crossorigin="anonymous"></script>
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

        <!-- jQuery & DataTables JS -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    </body>
    </html>

<style>
.main-content {
  margin-left: 325px; /* Push content to the right */
  padding: 20px;
  width: calc(100% - 220px); /* Fill remaining width */
  transition: margin-left 0.25s ease;
}
</style>
    