{{-- @extends('common.layout') --}}


@section('head')
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title ?? '' }}</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css" />
    <link rel="stylesheet" href="{{ URL::asset('css/admBackend.css') }}">
    <style>

    </style>
    @yield('css')
</head>
@endsection


@section('header')
{{-- @inject('AdmService', 'App\Services\AdmService') --}}
<header>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">

        <!-- Logo -->
        <span class="navbar-brand">
            <a href="{{ $rootUrl ?? '' }}"><img src="" alt="Logo"/></a>
            {{-- <a href="{{ $rootUrl }}"><img src="{{ URL::asset('backend/images/Logo_P_default.png') }}" alt="Logo"/></a> --}}
        </span>

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
            aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">

            <!-- 上方左側 - 動態生成 -->
            <ul class="navbar-nav mx-auto">
                {{-- @include('common.menuData', ['login'=>session('admLogin')]) --}}
            </ul>

            <!-- 上方右側 -->
            {{-- <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown"
                        aria-haspopup="true" aria-expanded="false">
                        {{ $AdmService->getLoginInfo() }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                        @if( env('APP_ENV') !== 'prod')
                        <a class="dropdown-item" href="{{ action('Adm\UserController@reLogin') }}">更新登入資料</a>
                        <div class="dropdown-divider"></div>
                        @endif
                        <a class="dropdown-item" href="{{ action('Adm\UserController@changePasswd') }}">變更密碼</a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="{{ action('Adm\UserController@logout') }}">登出</a>
                    </div>
                </li>
            </ul> --}}

        </div>

    </nav>
</header>
@endsection