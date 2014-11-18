<!DOCTYPE html>
<html lang="en">
    <head>
        <meta http-equiv="content-type" content="text/html; charset=UTF-8">
        <title>RESTful explorer for apiDoc</title>
        <meta name="generator" content="Bootply" />
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
        {{ Explore::style('bootstrap/css/bootstrap.min.css') }}
        {{ Explore::style('jsonview/jquery.jsonview.css') }}
        <style>
            body { background-color: white; color: #666; }
        </style>
    </head>
    <body>
        <div id="json">
            @if ($dataResponse['httpCode'] != 200 or ! Explore::isJson($dataResponse['response'])) {{ $dataResponse['response'] }} @endif
        </div>


        {{ Explore::script('scripts/jquery.min.js') }}
        {{ Explore::script('highlightjs/highlight.min.js') }}
        {{ Explore::script('bootstrap/js/bootstrap.min.js') }}
        {{ Explore::script('jsonview/jquery.jsonview.js') }}
        {{ Explore::script('scripts/inherit.js') }}

        <script>
            var json = {{ $dataResponse['response'] }}

            $(function() {
                $("#json").JSONView(json);
                // with options
                $("#json-collasped").JSONView(json, {collapsed: true});
            });
        </script>
    </body>
</html>