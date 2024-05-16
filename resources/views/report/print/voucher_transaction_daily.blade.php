<!DOCTYPE html>

<html lang="{{ str_replace('', '-', app()->getLocale()) }}" class="light-style layout-navbar-fixed layout-menu-fixed "
    dir="ltr" data-theme="theme-default" data-assets-path="{{ asset('assets/') }}/"
    data-template="vertical-menu-template">

<head>
    <meta charset="utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
    <meta http-equiv="Permissions-Policy" content="interest-cohort=()">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'ACCOUNTANT')</title>

    <meta name="description" content="Most Powerful &amp; accountant system for local government" />
    <meta name="keywords"
        content="finance, accountant, finance system, accountant system, account system, lao account, ministry of accountant, lao ministry of accountant">


    <!-- Favicon -->
    {{-- <link rel="icon" type="image/x-icon"
        href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/favicon/favicon.ico" /> --}}
    <link rel="icon" type="image/x-icon" href="{{ asset('assets\images\pacc_logo.ico') }}" />
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap"
        rel="stylesheet">

    <!-- Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/boxicons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/fontawesome.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/fonts/flag-icons.css') }}" />
    <link rel="stylesheet" href="{{ asset('assets/css/sweetalert.css') }}">

    <!-- Core CSS -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/core.css') }}" class="template-customizer-core-css" />
    <link rel="stylesheet" href="{{ asset('assets/vendor/css/rtl/theme-default.css') }}"
        class="template-customizer-theme-css" />

    <!-- Vendors CSS -->
    <!--    <link rel="stylesheet" href="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css') }}"/>-->

    @stack('css')

    <!-- Helpers -->
    <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    <script src="{{ asset('assets/js/config.js') }}"></script>

</head>

<body>

    <div id="print-transaction-daily-report">
    </div>

    <script src="{{ asset('/react/component/containers/print/voucher_transaction_daily.js') }}"></script>

    <script src="{{ asset('assets/vendor/libs/jquery/jquery.js/') }}"></script>


    <script src="{{ asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/sweetalert.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/js/menu.js') }}"></script>
    <script src="{{ asset('assets/js/main.js') }}"></script>
    {{-- <script src="{{ asset('assets/js/bootstrap.js') }}"></script> --}}
    {{-- <script src="{{ asset('assets/vendor/js/bootstrap.js') }}"></script> --}}

    <script src="{{ mix('js/app.js') }}"></script>
    @stack('script')

</body>

</html>

<!-- beautify ignore:end -->
