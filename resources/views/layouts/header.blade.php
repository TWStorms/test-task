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
{{--    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/css/bootstrap.min.css" rel="stylesheet"--}}
{{--          integrity="sha384-KyZXEAg3QhqLMpG8r+8fhAXLRk2vvoC2f3B09zVXn8CA5QIVfZOJ3BCsw2P0p/We" crossorigin="anonymous">--}}
{{----}}
{{----}}
{{--    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css"--}}
{{--          integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />--}}
{{----}}
{{--    <script src="https://code.jquery.com/jquery-3.1.0.min.js"></script>--}}
{{--    <script src="{{asset('bootstrap/js/bootstrap.js/bootstrap.min.js')}}"></script>--}}
    <style>
        html, body, #maps, .mmp {
            height: 100%;
        }

        .mmp {
            position: inherit !important;
        }

        #maps .mmp {
            position: relative !important;
            width: 100%;
            height: 61vh;
        }
    </style>
    <style>
        #container {
            max-width: 400px;
            height: 400px;
            margin: auto;
        }
    </style>
    <style>
        .btn_wohover {
            background-color: #7665bf !important;
            border-color: #ffffff !important;
            color: #ffffff !important;
            padding-right: 1.5rem !important;
            padding-left: 1.5rem !important;
            font-weight: 700 !important;
        }

        .btn_forgot:hover {
            background-color: #d6d5df2a;
        }

        .btn_hover:hover {
            background-color: #ffffff !important;
            border-color: #7665bf !important;
            color: #7665bf !important;
        }

        input:hover {
            box-shadow: 1px 2px 10px 1px #ffffff;
        }

        .heading_style {
            font-weight: bold
        }

        .footer_links {
            color: #7665bf;
            font-weight: bold
        }

        .footer_links:hover {
            color: #000000
        }

        @media(max-width:767px)
        {
            .screen_set{
                border-radius: 5% 5% 5% 5% !important;
            }
        }
        @media(min-width:767px)
        {
            .screen_set{
                border-radius: 0% 5% 5% 0% !important;

            }
        }
        .loader{
            background: transparent;
            position: absolute;
            margin-top: 5%;
            margin-left: 35%;
            /*top: 20px;*/
            /*left: 20px;*/
            height: 30%;
            width: 30%;
            /*z-index: 9999999;*/
            /*background: white;*/
            /*align-content: center;*/
            /*width:100%;*/
            /*height:100%;*/
            z-index:99999999;
        }
    </style>
</head>
