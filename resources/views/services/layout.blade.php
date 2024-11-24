<!DOCTYPE html>
<html>
<head>
    <!-- css -->
    @include('admin.admincss')

    <title>Services</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>
<body>
  
    <!-- navbar -->
    @include('admin.adminnavbar')

    <!-- sidebar -->
    @include('admin.adminsidebar')

    <div class="main-panel">
        <div class="page-header">
            <div class="row">
                <div class="col-sm-12">

                <div class="container">
                    @yield('content')
                </div>

                </div>
            </div>
        </div>
    </div>

    <!-- footer -->
    @include('admin.adminfooter')

</body>
</html>




  
    

    
    
    