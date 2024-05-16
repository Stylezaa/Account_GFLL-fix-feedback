<!DOCTYPE html>

<html lang="en" class="light-style layout-navbar-fixed layout-menu-fixed " dir="ltr" data-theme="theme-default" data-assets-path="{{asset('assets/')}}/" data-template="vertical-menu-template">

<head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0"/>

   
    <title>@yield('title','ACCOUNTANT')</title>

    <meta name="description" content="Most Powerful &amp; accountant system for local government"/>
    <meta name="keywords" content="finance, accountant, finance system, accountant system, account system, lao account, ministry of accountant, lao ministry of accountant">


    <link href="assets/css/login/bootstrap.min.css" rel="stylesheet">
    <link href="assets/css/login/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/login/style.css" rel="stylesheet">

    <!-- Favicon -->
    {{-- <link rel="icon" type="image/x-icon" href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/assets/img/favicon/favicon.ico"/> --}}

    <!-- Fonts -->
    {{-- <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Public+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;1,300;1,400;1,500;1,600;1,700&amp;display=swap" rel="stylesheet"> --}}

    <!-- Core CSS -->
    {{-- <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/core.css')}}" class="template-customizer-core-css"/>
    <link rel="stylesheet" href="{{asset('assets/vendor/css/rtl/theme-default.css')}}" class="template-customizer-theme-css"/>

    <link rel="stylesheet" href="{{asset('assets/vendor/libs/formvalidation/dist/css/formValidation.min.css')}}"> --}}
    <!-- Page CSS -->

    <!-- Helpers -->
    {{-- <script src="{{asset('assets/vendor/js/helpers.js')}}"></script> --}}

    <!--? Config:  Mandatory theme config file contain global vars & default theme options, Set your preferred theme option in this file.  -->
    {{-- <script src="{{asset('assets/js/config.js')}}"></script> --}}
</head>

<body>

<!-- Google Tag Manager (noscript) (Default ThemeSelection: GTM-5DDHKGP, PixInvent: GTM-5J3LMKC) -->
{{-- <noscript>
    <iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5DDHKGP" height="0" width="0" style="display: none; visibility: hidden"></iframe>
</noscript>
<!-- End Google Tag Manager (noscript) --> --}}

<!-- Layout wrapper -->
{{-- <div class="layout-wrapper layout-content-navbar  "> --}}
    {{-- <div class="layout-container"> --}}

        <!-- Layout container -->
        {{-- <div class="layout-page"> --}}

            <!-- / Navbar -->

            <!-- Content wrapper -->
            {{-- <div class="content-wrapper"> --}}

                <!-- Content -->

                {{-- <div class="container-xxl"> --}}
                    @yield('content')
                {{-- </div> --}}
            {{-- </div> --}}
                <!-- / Content -->


                <!-- Footer -->
                <footer class="content-footer footer bg-footer-theme">
                    <div class="container-xl d-flex flex-wrap justify-content-between py-2 flex-md-row flex-column">
                        <div class="mb-2 mb-md-0">
                            ©
                            <script>
                                document.write(new Date().getFullYear())
                            </script>, by <a href="https://themeselection.com/" target="_blank" class="footer-link fw-bolder">MCH TECH</a>
                        </div>
                        {{--<div>

                            <a href="https://themeselection.com/license/" class="footer-link me-4" target="_blank">License</a>
                            <a href="https://themeselection.com/" target="_blank" class="footer-link me-4">More
                                Themes</a>

                            <a href="https://demos.themeselection.com/sneat-bootstrap-html-admin-template/documentation/"
                               target="_blank" class="footer-link me-4">Documentation</a>


                            <a href="https://themeselection.com/support/" target="_blank"
                               class="footer-link d-none d-sm-inline-block">Support</a>

                        </div>--}}
                    </div>
                </footer>
                <!-- / Footer -->
                {{-- <div class="content-backdrop fade"></div> --}}
            {{-- </div> --}}
            <!-- Content wrapper -->
        {{-- </div> --}}
        <!-- / Layout page -->
    {{-- </div> --}}


    <!-- Overlay -->
    {{-- <div class="layout-overlay layout-menu-toggle"></div> --}}


    <!-- Drag Target Area To SlideIn Menu On Small Screens -->
    {{-- <div class="drag-target"></div> --}}

</div>
<!-- / Layout wrapper -->

<!-- Core JS -->
<!-- build:js assets/vendor/js/core.js -->
{{-- <script src="{{asset('assets/vendor/libs/jquery/jquery.js')}}"></script>
<script src="{{asset('assets/vendor/libs/popper/popper.js')}}"></script>
<script src="{{asset('assets/vendor/js/bootstrap.js')}}"></script>
<script src="{{asset('assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js')}}"></script>

<script src="{{asset('assets/vendor/libs/hammer/hammer.js')}}"></script>
<script src="{{asset('assets/vendor/libs/i18n/i18n.js')}}"></script>
<script src="{{asset('assets/vendor/libs/typeahead-js/typeahead.js')}}"></script>
<script src="{{asset('assets/vendor/libs/formvalidation/dist/js/FormValidation.min.js')}}"></script>

<script src="{{asset('assets/vendor/js/menu.js')}}"></script> --}}
<!-- endbuild -->

<!-- Vendors JS -->
{{-- <script src="{{asset('assets/vendor/libs/apex-charts/apexcharts.js')}}"></script> --}}

<!-- Main JS -->
{{-- <script src="{{asset('assets/js/main.js')}}"></script> --}}

<!-- Page JS -->
{{-- <script src="{{asset('assets/js/dashboards-analytics.js')}}"></script> --}}
@stack('script')
</body>
</html>

<!-- beautify ignore:end -->

