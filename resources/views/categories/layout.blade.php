<!DOCTYPE html>
<html lang=""eng>
    <head>

    <!-- css -->
    @include('admin.admincss')
    
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Categories</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

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

    
    