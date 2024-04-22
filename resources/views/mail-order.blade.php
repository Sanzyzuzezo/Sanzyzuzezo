<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet">
    <title>Order - Received</title>
    <style>
        .btn-primary {
            color: rgb(255, 255, 255);
            background-color: #007bff;
            border-color: #007bff;
        }
        .btn {
            display: inline-block;
            font-weight: 400;
            text-align: center;
            white-space: nowrap;
            vertical-align: middle;
            -webkit-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
            border: 1px solid transparent;
            padding: 0.375rem 0.75rem;
            font-size: 1rem;
            line-height: 1.5;
            border-radius: 0.25rem;
            transition: color .15s ease-in-out,background-color .15s ease-in-out,border-color .15s ease-in-out,box-shadow .15s ease-in-out;
        }
    </style>
</head>
<body>
    <div class="row">
        <div class="card" style="width: 18rem;">
            {{-- <img class="card-img-top" src="{{ url('administrator\assets\media\logos\logo.png') }}" alt="Kijang Mas"> --}}
            <div class="card-header">
                <h3>Kijang Mas</h3>
            </div>
            <div class="card-body">
                <h5 class="card-title">Order Received</h5>
                <p class="card-text">{{ $data['message'] }}</p>
                <a href="{{ $data['link'] }}" class="btn btn-primary">Cek Order</a>
            </div>
        </div>
    </div>
</body>
</html>
