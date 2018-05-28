<!doctype html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Member Management</title>
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
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Joined Date</th>
                    <th>Verdict</th>
                    <th>Link</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($members as $member)
                    <tr>
                        <td>{{$member->fb_member_id}}</td>
                        <td>{{$member->member_name}}</td>
                        <td>{{\Carbon\Carbon::parse($member->join_date)->format('F d, Y')}}</td>
                        <td>
                            <button class="stay" data-id="{{$member->id}}">Stay</button>
                            <button class="warning" data-id="{{$member->id}}">Warning</button>
                            <button class="remove" data-id="{{$member->id}}">Remove</button>
                        </td>
                        <td>
                            <a href="https://www.facebook.com/groups/SobrangShortStoriesHub/search/?query={{$member->query}}&filters_rp_chrono_sort=%7B%22name%22%3A%22chronosort%22%2C%22args%22%3A%22%22%7D" target="_blank">View</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        {{$members->links()}}
        <script type="text/javascript">
            $(document).ready(function(){
                $('.stay').on('click', function(e){
                    var id = $(this).attr('data-id');
                    sendVerdict('stay', id);
                    $(this).parent().parent().remove();
                    $('table a').first().click();
                });

                $('.warning').on('click', function(e){
                    var id = $(this).attr('data-id');
                    sendVerdict('warning', id);
                    $(this).parent().parent().remove();
                    $('table a').first().click();
                });

                $('.remove').on('click', function(e){
                    var id = $(this).attr('data-id');
                    sendVerdict('remove', id);
                    $(this).parent().parent().remove();
                    $('table a').first().click();
                });

                function sendVerdict(status, id)
                {
                    $.post({
                        method: 'PUT',
                        url: '/member/crawl/' + id,
                        data: {
                            id: id,
                            verdict: status
                        },
                        success: function(data){

                        }
                    });
                }
            });
        </script>
    </body>
</html>
