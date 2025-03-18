<!DOCTYPE html>
<html>
<head>

    <!-- css -->
    @include('admin.admincss')

    <title>Services List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

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

  
    

    
    
   