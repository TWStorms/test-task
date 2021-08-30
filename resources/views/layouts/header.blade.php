<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="robots" content="noindex, nofollow">

    {{--CSRF Token--}}
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name') }} | @yield('title')</title>

    {{--CSS--}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/style.css') }}" rel="stylesheet">
{{--    <link rel="stylesheet" href="{{ asset('css/style.css') }}">--}}
{{--    <link rel="stylesheet" href="{{ asset('css/log.css') }}">--}}
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"--}}
{{--          integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">--}}
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/sweetalert2.min.css') }}"/>
    <link rel="stylesheet"
          href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css"
          integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm"
          crossorigin="anonymous">
</head>
