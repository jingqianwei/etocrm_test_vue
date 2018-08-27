<!Doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    {{--<meta name="viewport" content="width=device-width, initial-scale=1">--}}
    <meta name="viewport" content="user-scalable=no,width=device-width,initial-scale=1.0">
    <title>我的CK</title>
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">
    <link rel="stylesheet" href="{{ mix('css/shop.css') }}">
</head>
<body>
<div id="app">

</div>
<script src="{{ mix('js/shop.js') }}"></script>
</body>
</html>