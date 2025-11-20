<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>@yield('title')</title>
    @stack('styles')
</head>
<body class="bg-gray-100 te xt-gray-800">
    
     
    <x-nav></x-nav>
    
    <section>
        @yield('content')
    </section>

    <footer></footer>

    @stack('scripts')
</body>
</html>