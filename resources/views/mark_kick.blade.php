<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Kick</title>
        <style type="text/css">
            body {
                padding: 10px;
            }
        </style>
        <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    </head>
    <body>
        <textarea id="mark_kick" rows="30" style="width: 100%;">
            
        </textarea>
        <button id="mark">Mark as Kicked</button>

        <script type="text/javascript">
            $(document).ready(function(){
                $('#mark').on('click', function(){
                    var data = $('#mark_kick').val();

                    $.post({
                        url: '/member/mark',
                        data: {
                            text: data
                        },
                        success: function(data) {
                            var data = JSON.parse(data);
                            console.log(data);
                        }
                    });
                });
            });
        </script>
    </body>
</html>
