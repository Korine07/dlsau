<!DOCTYPE html>
<html>
<head>

    <!-- css -->
    @include('admin.admincss')

    <title>Student Laravel 9 CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
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