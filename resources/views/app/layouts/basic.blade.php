<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
    <title>@yield('title')</title>
</head>
<body>

    <div id="app">
        @component('app._components.navbar')
        @endcomponent
        @yield('content')
    </div>

</body>
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
</html>
