<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta http-equiv="X-UA-Compatible" cntent="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" rel="stylesheet" integrity="sha384-wvfXpqpZZVQGK6TAh5PVlGOfQNHSoD2xbE+QkPxCAFlNEevoEH3Sl0sibVcOQVnN" crossorigin="anonymous">
    <link href="{{url('/css/style.css')}}" type="text/css" rel="stylesheet">
    <link href="{{url('/css/prettyPhoto.css')}}" type="text/css" rel="stylesheet"/>
</head>
<body>
<div class="screen"><!----【screen 追加分】----->
    <!--- ここからヘッダ --->
    <header>
        @include('commons.header')
    </header>
 
    <!--- ここから本文 --->
    <div class="content">
        @yield('content')
    </div>

    <div id="menus"></div><!----【追加分】----->
    <!--- ここからフッタ --->
    <footer id="footer">
        @yield('add_footer')
        <address id="address">@include('commons.footer',['year'=>Carbon\Carbon::now()->format('Y')])</address>
    </footer>

</div><!-----【screen 追加分】----->

    <!-- 以下、jsの読み込み -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
    <script src="{{url('/js/tools.js')}}"></script>
    <script src="{{url('/js/jquery.prettyPhoto.js')}}"></script>
    @yield('add_javascript')
</body>
</html>
