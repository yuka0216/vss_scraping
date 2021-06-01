<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        
        <title>vesselsearch</title>
        <script src="{{ asset('js/app.js') }}" defer></script>
        
        <link rel="dns-prefetch" href="fonts.gstatic.com">
        <link href="fonts.googleapis.com/css2?family=Lato:wght@400;700&family=Noto+Sans+JP:wght@400;700&display=swap" rel="stylesheet">
        
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('css/vessel.css') }}" rel="stylesheet">
    </head>
    <body>
        @yield('content')
    </body>
</html>