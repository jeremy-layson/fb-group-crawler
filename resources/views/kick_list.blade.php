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
            tr:hover {
                background-color: yellow;
            }
        </style>
        <script type="text/javascript" src="{{asset('js/jquery.min.js')}}"></script>
    </head>
    <body>
        <?php $batch = 0; $count = 4; ?>
        @foreach ($members as $member)
            <?php $count++; ?>
            @if ($count % 5 === 0)
                <?php $batch++; ?>
                <br>
                <pre>Batch {{$batch}}</pre>
                
            @endif
            <pre>{{$member->member_name}}</pre>

            
        @endforeach
    </body>
</html>
