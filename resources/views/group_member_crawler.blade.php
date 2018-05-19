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
                    var text = $('#crawl-text').val();

                    $.post({
                        url: '/member/crawl',
                        data: {
                            text: text
                        },
                        success: function(data) {
                            var data = JSON.parse(data);
                            
                            var cursor = data.cursor;

                            $('#crawl-text').val('');

                            // open to new tab
                            
                            var url = 'https://www.facebook.com/ajax/browser/list/group_confirmed_members/?gid=1478508079108523&order=alphabetical&view=list&limit=400&sectiontype=all_members&cursor=' + cursor + '&start=400&dpr=1&__user=100024253506111&__a=1&__dyn=7AgNe-4amaxx2u6aJGeFxqeCwDKEKEW8x2C-C267Uqzob4q2i5U4e1Fx-K9wPG2OUG4XzEeUK3uczobrzoeopDxicxu1Zxa2m4o6fx_wyxG7WwaWu0w899UhCK6ooxu6U6O11x-8wywnogzoW4Wx28ho6aEyJ7x3x69wyXAx-lxdwEx2cByoC6o8Kq1ewLx2awUyUigG4FFU&__req=9i&__be=1&__pc=PHASED%3ADEFAULT&__rev=3925772&__spin_r=3925772&__spin_b=trunk&__spin_t=1526743819';

                            console.log("Finished");
                            window.open(url, '_blank');
                        }
                    });
                });
            });
        </script>
    </body>
</html>
