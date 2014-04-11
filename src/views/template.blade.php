<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>RESTFul explorer for apidocjs</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        {{ HTML::style('packages/teepluss/explore/bootstrap/css/bootstrap.min.css') }}
        {{ HTML::style('packages/teepluss/explore/styles/docs.css') }}
        {{ HTML::style('packages/teepluss/explore/styles/inherit.css') }}
        <!--[if lt IE 9]>
        <script src="//html5shim.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        {{ HTML::style('packages/teepluss/explore/highlightjs/default.min.css') }}
    </head>
    <body>
        <header class="navbar navbar-default navbar-fixed-top" role="banner">
            <div class="container">
                <div class="navbar-header">
                    <a href="/" class="navbar-brand">RESTFul explorer for apidocjs</a>
                </div>
            </div>
        </header>

        <!-- Begin Body -->
        <div class="container">
            <div class="row">
                <div class="col-md-3" id="leftCol">
                    @include(Config::get('explore::explore.sidebar'))
                </div>
                <div class="col-md-9">
                    @yield('content')
                </div>
            </div>
            @include(Config::get('explore::explore.footer'))
        </div>



        {{ HTML::script('packages/teepluss/explore/scripts/jquery.min.js') }}
        {{ HTML::script('packages/teepluss/explore/highlightjs/highlight.min.js') }}
        {{ HTML::script('packages/teepluss/explore/bootstrap/js/bootstrap.min.js') }}
        {{ HTML::script('packages/teepluss/explore/scripts/inherit.js') }}


    </body>
</html>