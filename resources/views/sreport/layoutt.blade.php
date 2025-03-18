<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="{{ asset('assets/images/DLSAU.png') }}">
    <title>Services Report</title>
    <style>
        @page {
            size: 8.5in 11in;  /* Letter size paper */
            margin: 0.5in;  /* Margin for the page */
        }

        body { 
            font-family: Arial, sans-serif; 
            margin: 0; 
            padding: 0;
            width: 100%;
            word-wrap: break-word;
        }

        .container { 
            width: 80%;
            text-align: center;
            margin: auto;
            padding: 10px;
        }

        table { 
            width: 80%; 
            border-collapse: collapse; 
            margin-top: 20px;
            table-layout: auto;  /* Ensures columns auto adjust */
        }

        th, td { 
            border: 1px solid black; 
            padding: 6px; 
            text-align: left;
            white-space: normal;  /* Allow content to wrap inside cells */
            overflow-wrap: break-word;  /* Ensure text doesn't overflow */
        }

        th { 
            background-color: #f2f2f2;
        }

        td {
            max-width: 150px; /* Limit max width to keep table within page */
        }

        h1, h2 {
            text-align: center;
            margin: 10px 0;
        }

        .small-text {
            font-size: 0.8em;
        }

        /* Print-specific styles */
        @media print {
            table {
                width: 80%;
                table-layout: auto;
            }

            td, th {
                word-wrap: break-word;  /* Allow content to break lines */
                max-width: 150px;  /* Limit width of columns */
                white-space: normal;  /* Allow text to wrap */
            }

            .container {
                width: 80%;
                padding: 0;
            }

            /* Ensure that content fits into one page */
            body {
                font-size: 10px;
            }

            /* Handle long content and page break issues */
            .table-container {
                overflow-x: auto;  /* Enable horizontal scrolling if necessary */
            }

            /* Add a page-break after the table if content is too long */
            .page-break {
                page-break-before: always;
            }
        }

    </style>
</head>
<body>

    <div class="container">
        @yield('content')
    </div>

</body>
</html>
