<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

     
        <title>vesselsearch</title>
        <script src="{{ secure_asset('js/app.js') }}" defer></script>

        <link rel="dns-prefetch" href="fonts.gstatic.com">
        <link href="fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css">

        <link href="{{ secure_asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ secure_asset('css/vessel.css') }}" rel="stylesheet">
    </head>
    <body>
        <div class="container">
            <h1>最新入船情報</h1>
                
            <form action="{{ action('Admin\VssController@index') }}" method="GET">    
                <div class="col-md-8">
                    <input type="text" class="form-control" name="cond_title" value="{{ isset($cond_title) ? $cond_title : "" }}">
                </div>
                <div class="col-md-2">
                    {{ csrf_field() }}
                <input type="submit" value="検索" class="btn btn-primary" >
                </div>
            </form>
                
            <div class="card-contents">
                <h2 class="text-title">PORT</h2>
                <div class="port-list">
                    <a href="/admin/vessel/tokyo">東京</a>
                    <a href="/admin/vessel/yokohama">横浜</a>
                    <a href="/admin/vessel/ohsaka">大阪</a>
                    <a href="/admin/vessel/kobe">神戸</a>
                </div>
            </div>
            
            <div class="card-contents">
                <h2 class="text-title">SCHEDULE</h2>
                <div class="row">
                    @foreach($weeks as $week)
                        <div class="col">{{ $week }}
                        </div>
                    @endforeach
                </div>    
                <div class="row">
                    @foreach($vessels as $infos)
                    <div class="col">
                        @foreach($infos as $info)
                            <div>
                                <p>{{ $info->eta }}</p>
                                <p>{{ $info->vessel }}</p>
                            </div>
                        @endforeach
                    </div>    
                    @endforeach
                </div>
            </div>
        </div><!-- end container-->
    </body>
</html>