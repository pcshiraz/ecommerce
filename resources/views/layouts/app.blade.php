<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="@lang('platform.direction')">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <base href="{{ config('app.url') }}">

    <meta name="description" content="@yield('description')">
    <meta name="keywords" content="@yield('keywords')">
    <meta name="author" content="@yield('author')">

    <link rel="shortcut icon" href="{{ asset('favicon.ico') }}">
    <title>@yield('title'){{ config('platform.name', 'ShirazPlatform') }}</title>
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    @yield('css')
</head>
<body class="rtl">
<div id="app">
    <header class="{{ config('platform.header-position') }}">
        <nav class="navbar navbar-expand-md {{ config('platform.navbar-type') }}">
            <div class="{{ config('platform.navbar-container') }}">
                <button class="navbar-toggler" type="button" data-toggle="collapse"
                        data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                        aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <a class="navbar-brand ml-auto" href="{{ url('/') }}">
                    <i class="fa {{ config('platform.main-icon') }}"></i> {{ config('platform.name', 'ShirazPlatform') }}
                </a>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        @guest

                        @else

                        @endguest
                        <li><a class="nav-link{{ Request::segment(1) == 'product' ? ' active' : '' }}"
                               href="{{ route('shop') }}"><i class="fa fa-shopping-bag"></i> فروشگاه</a></li>
                    </ul>
                    <form class="my-auto mx-auto w-50 d-none d-md-block d-lg-block d-xl-block" onsubmit="return false;">
                        <div class="input-group">
                            <input type="text" autocomplete="off" id="keyword" name="keyword" class="form-control"
                                   placeholder="جستجو..." aria-label="جستجوی ..." aria-describedby="navbar-search">
                            <div class="input-group-append">
                                <button id="search-btn" class="btn btn-warning" type="button" id="navbar-search"><i
                                            class="fa fa-search" id="search-icon"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
                        <!-- Authentication Links -->
                        @if(Cart::count())
                            <li>
                                <a class="nav-link{{ Request::segment(1) == 'cart' ? ' active' : '' }}"
                                   href="{{ route('cart') }}"><i class="fa fa-shopping-basket"></i> سبد خرید<span
                                            class="badge badge-pill badge-info">{{Cart::count()}}</span></a>
                            </li>
                        @endif
                        @guest
                            <li><a class="nav-link{{ Request::segment(1) == 'login' ? ' active' : '' }}"
                                   href="{{ route('login') }}"><i class="fa fa-sign-in"></i>ورود </a></li>
                            @if(config('platform.enable-register'))
                                <li><a class="nav-link{{ Request::segment(1) == 'register' ? ' active' : '' }}"
                                       href="{{ route('register') }}"><i class="fa fa-user-plus"></i> ثبت نام</a></li>
                            @endif
                        @else
                            <li><a class="nav-link{{ Request::segment(1) == 'notification' ? ' active' : '' }}"
                                   href="{{ route('notification') }}"><i class="fa fa-bullhorn"></i> اطلاعیه ها
                                    <notification-navbar-component></notification-navbar-component>
                                </a></li>
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                                   aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user-circle-o"></i> {{ Auth::user()->name }} <span
                                            class="caret"></span>
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">

                                    <a class="dropdown-item{{ Request::segment(1) == 'dashboard' ? ' active' : '' }}"
                                       href="{{ route('dashboard') }}"><i class="fa fa-dashboard"></i> پیشخوان</a>
                                    @can('admin')
                                        <a class="dropdown-item{{ Request::segment(1) == config('platform.admin-route') ? ' active' : '' }}"
                                           href="{{ route('admin.dashboard') }}"><i class="fa fa-cogs"></i> مدیریت سیستم</a>
                                    @endcan

                                    <a class="dropdown-item{{ Request::segment(1) == 'profile' ? ' active' : '' }}"
                                       href="{{ route('profile') }}">
                                        <i class="fa fa-user"></i> مشخصات کاربری
                                    </a>
                                    <a class="dropdown-item{{ Request::segment(1) == 'password' ? ' active' : '' }}"
                                       href="{{ route('password') }}">
                                        <i class="fa fa-key"></i> تغییر رمز عبور
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        <i class="fa fa-sign-out"></i> خروج
                                    </a>

                                    <form id="logout-form" action="{{ route('logout') }}" method="POST"
                                          style="display: none;">
                                        @csrf
                                    </form>
                                </div>
                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>
        <div class="d-block d-md-none d-lg-none d-xl-none w-100">
            <form onsubmit="return false;">
                <div class="input-group">
                    <input type="text" autocomplete="off" id="keyword-mobile" name="keyword-mobile" class="form-control"
                           placeholder="جستجو..." aria-label="جستجوی ..." aria-describedby="navbar-search">
                    <div class="input-group-append">
                        <button id="search-mobile-btn" class="btn btn-warning" type="button" id="navbar-search"><i
                                    class="fa fa-search" id="search-mobile-icon"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </header>
    <main class="py-4" role="main">
        <div class="{{ config('platform.main-container') }}">
            @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            @yield('content')
        </div>

    </main>
    <footer class="{{ config('platform.footer-position') }}">
        <nav class="navbar navbar-expand-lg {{ config('platform.navbar-bottm-type') }}">
            <div class="{{ config('platform.navbar-container') }}">
                <ul class="navbar-nav ml-auto">
                    <li><a class="nav-link" href="{{ route('contact-us') }}"><i class="fa fa-envelope"></i> تماس با
                            ما</a></li>
                    <li><a class="nav-link" href="{{ route('about-us') }}"><i class="fa fa-info"></i> درباره ماه</a>
                    </li>
                    <li><a class="nav-link" href="{{ route('tos') }}"><i class="fa fa-balance-scale"></i> قوانین و
                            مقررات</a></li>
                    <li><a class="nav-link" href="{{ route('complaint') }}"><i class="fa fa-user-times"></i> ثبت
                            شکایت</a></li>
                </ul>
                <div class="mr-auto">
                    <a href="https://pcshiraz.com" target="_blank">قدرت گرفته از پی سی شیراز</a>
                </div>
            </div>
        </nav>
    </footer>
    <div class="search-result mx-auto w-50 center-block" id="search-result">
        <div id="search-result-box" class="p-2">
            <i class="fa fa-spinner fa-pulse fa-lg fa-fw" aria-hidden="true"></i> در حال جستجو ...
        </div>
    </div>
    <div class="search-mobile-result w-100" id="search-mobile-result">
        <div id="search-mobile-result-box" class="p-2">
            <i class="fa fa-spinner fa-pulse fa-lg fa-fw" aria-hidden="true"></i> در حال جستجو ...
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
@include('flash::message')
@yield('js')
</body>
</html>
