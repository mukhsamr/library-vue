<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('storage/images/logo.png') }}" type="image/x-icon">

    <title>{{ env('APP_NAME', 'Library') }}</title>

    @routes
    @vite(['resources/css/app.css','resources/js/app.js'])

    @inertiaHead
</head>

<body>
    @inertia
</body>

</html>