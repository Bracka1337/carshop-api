<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <div>
        <strong>Username</strong> {{ $user->username }}<br>
    </div>
    @foreach ($user->orders as $order)
    <div>
        <strong>Order ID:</strong> {{ $order->id }}<br>
        <strong>Product Name:</strong> {{ $order->product_name }}<br>
        <strong>Quantity:</strong> {{ $order->quantity }}<br>
    </div>
@endforeach
</body>
</html>