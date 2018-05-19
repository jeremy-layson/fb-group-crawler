<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Member Crawler</title>
        <style type="text/css">
            body {
                padding: 10px;
            }
        </style>
        <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    </head>
    <body>
        <textarea id="crawl-text" rows="25" style="width:100%;"></textarea>
        <button role="button" id="crawl-button">Crawl</button>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#crawl-button').on('click', function(){
                    alert(1);
                });
            });
        </script>
    </body>
</html>
