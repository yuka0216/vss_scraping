@extends('vss.layouts.admin')
@section('content')
<div class="container">
    <h1>最新入船情報</h1>
    <form action="{{ action('Admin\VssController@yokohama') }}" method="GET">    
        <div class="col-md-4">
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
        <h2 class="text-title">SCHEDULE：横浜</h2>
        <div class="row">
            @foreach($weeks as $week)
                <div class="col">{{ $week }}</div>
            @endforeach
        </div>    
        <div class="row">
            @foreach($vessels as $infos)
            <div class="col">
                @foreach($infos as $info)
                    <div>
                    <div class="name">
                        <p>{{ $info->vessel }}</p>
                    </div>
                    <div>
                        <p>{{ $info->voyage }}</p>
                        <p>{{ $info->eta }} (ETA)</p>
                        <p>{{ $info->etd }} (ETD)</p>
                        <p>{{ $info->yard }}</p>
                    </div>
                    </div>
                @endforeach
            </div>    
            @endforeach
        </div>
    </div>
</div><!-- end container-->
@endsection