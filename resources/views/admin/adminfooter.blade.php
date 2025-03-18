
    <!-- container-scroller -->
    <!-- plugins:js -->
    <script src="admin/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="admin/assets/vendors/bootstrap-datepicker/bootstrap-datepicker.min.js"></script>
    <!-- endinject -->
    <!-- Plugin js for this page -->
    <script src="admin/assets/vendors/chart.js/chart.umd.js"></script>
    <script src="admin/assets/vendors/progressbar.js/progressbar.min.js"></script>
    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="admin/assets/js/off-canvas.js"></script>
    <script src="admin/assets/js/template.js"></script>
    <script src="admin/assets/js/settings.js"></script>
    <script src="admin/assets/js/hoverable-collapse.js"></script>
    <script src="admin/assets/js/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="admin/assets/js/jquery.cookie.js" type="text/javascript"></script>
    <script src="admin/assets/js/dashboard.js"></script>
    <!-- <script src="assets/js/Chart.roundedBarCharts.js"></script> -->
    <!-- End custom js for this page-->

  <style>
    .footer {
    position: fixed;
    bottom: 0;
    left: 220px; /* Match sidebar width */
    width: calc(100% - 220px); /* Adjust width */
    background-color: #f8f9fa;
    text-align: center;
    padding: 10px 0;
    font-size: 14px;
    color: #6c757d;
    border-top: 1px solid #dee2e6;
    transition: left 0.3s ease, width 0.3s ease;
}

/* Adjust footer when sidebar is collapsed */
.sidebar.collapsed ~ .footer {
    left: 60px;
    width: calc(100% - 60px);
}

  </style>