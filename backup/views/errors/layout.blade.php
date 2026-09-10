<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | Football News</title>

    @vite(['resources/css/app.css'])

    <link href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">

<div class="min-h-screen flex items-center justify-center px-6">

    <div class="bg-white rounded-2xl shadow-xl p-10 text-center max-w-xl w-full">

        @yield('content')

    </div>

</div>

</body>
</html>