<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holiday Plan PDF</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
          integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@0,100;0,300;0,400;0,500;0,700;0,900;1,100;1,300;1,400;1,500;1,700;1,900&display=swap"
        rel="stylesheet">
    <style>
        body {
            font-family: 'Roboto', sans-serif;
            color: #333;
            background-color: #f8f9fa;
        }

        h1 {
            font-weight: 700;
            color: #007bff;
        }

        h2 {
            font-weight: 700;
            color: #495057;
        }

        p {
            font-size: 1rem;
            line-height: 1.6;
            color: #6c757d;
        }

        .container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        hr {
            border: 1px solid #007bff;
        }

        .mb-4 {
            margin-bottom: 1.5rem !important;
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-5">Holiday Plan - {{ $holidayPlan->user_id }}</h1>


    <div class="mb-4">
        <h2 class="h4">Title</h2>
        <p>{{ $holidayPlan->title }}</p>
    </div>

    <div class="mb-4">
        <h2 class="h4">Description</h2>
        <p>{{ $holidayPlan->description }}</p>
    </div>

    <div class="mb-4">
        <h2 class="h4">Date From</h2>
        <p>{{ $holidayPlan->date_from}}</p>
    </div>

    <div class="mb-4">
        <h2 class="h4">Date To</h2>
        <p>{{ $holidayPlan->date_to}}</p>
    </div>

    <div class="mb-4">
        <h2 class="h4">Status</h2>
        <p>{{ $holidayPlan->status }}</p>
    </div>

    <div class="mb-4">
        <h2 class="h4">Location</h2>
        <p>{{ $holidayPlan->location }}</p>
    </div>

</div>


</body>
</html>
