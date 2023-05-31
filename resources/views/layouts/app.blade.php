<!DOCTYPE html>
<html lang="en" dir="rtl">
<head>
    <base href="./">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <meta name="theme-color" content="#ffffff">
    <link rel="stylesheet" href="{{asset('css/dataTables.bootstrap5.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/jquery.dataTables.css')}}">
    <link rel="stylesheet" href="{{asset('css/style.css')}}">
    @vite('resources/sass/app.scss')
</head>
<body>
<div class="sidebar sidebar-success sidebar-fixed" id="sidebar">
    <div class="sidebar-brand d-none d-md-flex">
        <h3 class="text-center sidebar-brand-full" width="118" height="46">الخدمات الطبية</h3>
        <img src="{{asset('assets/imgs/il_794xN.2591975979_qdfz.jpg')}}" class="sidebar-brand-narrow" width="46" height="46" alt="CoreUI Logo">
    </div>
    @include('layouts.navigation')
    <button class="sidebar-toggler" type="button" data-coreui-toggle="unfoldable"></button>
</div>
<div class="wrapper d-flex flex-column min-vh-100 bg-success">
    @yield('header')
    <div class="body flex-grow-1 px-3">
        <div class="container-lg">
            @yield('content')
        </div>
    </div>
    <footer class="footer">
        <div><a href="https://coreui.io">CoreUI </a><a href="https://coreui.io">Bootstrap Admin Template</a> &copy; 2021
            creativeLabs.
        </div>
        <div class="ms-auto">Powered by&nbsp;<a href="https://coreui.io/bootstrap/ui-components/">CoreUI UI
                Components</a></div>
    </footer>
</div>
<script src="{{asset('js/jquery-3.7.0.min.js')}}"></script>
<script src="{{asset('js/jquery.dataTables.js')}}"></script>
<script src="{{asset('js/dataTables.bootstrap5.min.css')}}"></script>
<script src="{{ asset('js/coreui.bundle.min.js') }}"></script>
<script src="{{asset('js/custom.js')}}"></script>
</body>
</html>
