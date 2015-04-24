<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>RESTful explorer for apiDoc</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        {!! Explore::style('bootstrap/css/bootstrap.min.css') !!}
        {!! Explore::style('styles/docs.css') !!}
        {!! Explore::style('styles/inherit.css') !!}
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        {!! Explore::style('highlightjs/default.min.css') !!}
    </head>
    <body>
        <header class="navbar navbar-default navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <a href="/" class="navbar-brand">RESTful explorer for apiDoc</a>
                </div>
            </div>
        </header>

        <!-- Begin Body -->
        <div class="container">
            <div class="row">
                <div class="col-md-3" id="leftCol">
                    @include(Config::get('explore.sidebar'))
                </div>
                <div class="col-md-9">
                    @yield('content')
                </div>
            </div>
            @include(Config::get('explore.footer'))
        </div>

        {!! Explore::script('scripts/jquery.min.js') !!}
        {!! Explore::script('highlightjs/highlight.min.js') !!}
        {!! Explore::script('bootstrap/js/bootstrap.min.js') !!}
        {!! Explore::script('scripts/inherit.js') !!}
    </body>
</html>