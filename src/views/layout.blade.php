<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />

        <title>@yield('title')</title>

        <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
        <meta name="viewport" content="width=device-width" />

        {{ Manavo\LaravelToolkit\Utilities::asset('builds/app.css') }}
        @if(!empty($css))
            @foreach($css as $cssFile)
            {{ Manavo\LaravelToolkit\Utilities::asset($cssFile) }}
            @endforeach
        @endif

        <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">

        @yield('head')
    </head>
    <body>
        @yield('nav')

        @yield('above-content')

        <div class="container wrapper">
            <div class="section">
                @yield('content')
            </div>
        </div>

        @yield('footer')

        {{ Manavo\LaravelToolkit\Utilities::asset('builds/app.js') }}
        @if(!empty($js))
            @foreach($js as $jsFile)
            {{ Manavo\LaravelToolkit\Utilities::asset($jsFile) }}
            @endforeach
        @endif
    </body>
</html>
