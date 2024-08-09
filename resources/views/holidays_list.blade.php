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
            font-size: 12px;
        }

        h1 {
            font-weight: 500;
            color: #007bff;
            font-size: 24px;
            margin-bottom: 1.5rem;
        }

        .table {
            width: 100%;
            margin-bottom: 1rem;
            color: #333;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 0.75rem;
            vertical-align: top;
            border: 1px solid #dee2e6;
            text-align: left;
        }

        .table thead th {
            background-color: #007bff;
            color: #ffffff;
            font-weight: 500;
        }

        .table-striped tbody tr:nth-of-type(odd) {
            background-color: #f2f2f2;
        }

        .container {
            background-color: #ffffff;
            padding: 2rem;
            border-radius: 0.5rem;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center">Holiday Plan </h1>

    <table class="table table-bordered mt-4">
        <thead>
        <tr>
            <th scope="col">Title</th>
            <th scope="col">Description</th>
            <th scope="col">Date From</th>
            <th scope="col">Date To</th>
            <th scope="col">Status</th>
            <th scope="col">Location</th>
            <th scope="col">Participant</th>
        </tr>
        </thead>
        <tbody>
        @foreach($holidayPlans as $plan)
            <tr>
                <td>{{ $plan->title }}</td>
                <td>{{ $plan->description }}</td>
                <td>{{ $plan->date_from}}</td>
                <td>{{ $plan->date_to}}</td>
                <td>{{ $plan->status }}</td>
                <td>{{ $plan->location }}</td>
                <td>{{ $plan->user_id }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
</body>
</html>
