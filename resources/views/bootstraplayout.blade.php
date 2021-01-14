<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="shortcut icon" href="/wuchna-16x16.png">
    @yield('seo',view('partials.seo',['title'=>'Wuchna','description'=>'Wuchna']))
{{--    <link rel="stylesheet" href="{{asset('css/app.css')}}" />--}}
    @include('partials.css1')
    @yield('styles')
</head>
<body>
<div id="app">
    @yield('preheader')
    @yield('header', View::make('header'))
    @yield('pagelinks')
    @yield('jumbotron')
    <main role="main" class="container">
        @yield('main')
    </main>
    @yield('footer',view('footer'))
    @yield('postfooter')

</div>
@yield('scripts')
</body>
</html>
