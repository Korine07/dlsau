<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

  <head>
  <!-- css -->
  @include('admin.admincss')
  </head>
  <body>
    <!-- navbar -->
    @include('admin.adminnavbar')

    <!-- sidebar -->
    @include('admin.adminsidebar')

    <!-- body -->
    @include('admin.adminbody')
    
    <!-- footer -->
    @include('admin.adminfooter')
                
  </body>
</html>
