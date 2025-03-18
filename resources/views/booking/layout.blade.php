<!DOCTYPE html>
<html lang="en">

  <head>
    <!-- css -->
    @include('home.homecss')

    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>

    <!-- Moment.js (required by FullCalendar) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>

    <!-- New FullCalendar v6 -->
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.9/main.min.js"></script>
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

  </head>

<body>

  <!-- preloader -->
  @include('home.preloader')

  <!-- sub-header -->
  @include('home.subheader')

  <!-- header -->
  @include('home.header')

  <!-- booking process -->
  @include('booking.bookingprocess')

  <!-- footer -->
  <!--@include('home.footer')-->
  
  <script>
    document.addEventListener('DOMContentLoaded', function () {
        var tooltipTriggerEl = document.getElementById('tooltip-icon');
        var tooltip = new bootstrap.Tooltip(tooltipTriggerEl, {
            placement: 'right'  // Position the tooltip to the right of the icon
        });

        // Trigger tooltip manually when the icon is clicked
        tooltipTriggerEl.addEventListener('click', function () {
            tooltip.show(); // Show the tooltip
        });
    });
</script>


<style>
.tooltip {
    max-width: 200px;  /* Limit tooltip width */
}

#tooltip-icon {
    font-size: 20px;  /* Adjust icon size */
    color: #007bff;   /* Icon color */
}

#tooltip-icon:hover {
    color: #0056b3;   /* Change icon color on hover */
}


</style>

</body>
</html>
