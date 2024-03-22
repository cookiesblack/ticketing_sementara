<!doctype html>
<html lang="en" class="no-focus">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">

    <title>{{ $title }}</title>

    <meta name="description" content="TicketingSchema">
    <meta name="author" content="pixelcave">
    <meta name="robots" content="noindex, nofollow">

    <!-- Open Graph Meta -->
    <meta property="og:title" content="TicketingSchema">
    <meta property="og:site_name" content="Codebase">
    <meta property="og:description" content="TicketingSchema">
    <meta property="og:type" content="website">
    <meta property="og:url" content="">
    <meta property="og:image" content="">

    <!-- Icons -->
    <!-- The following icons can be replaced with your own, they are used by desktop and mobile browsers -->
    <link rel="shortcut icon" href="{{ asset('assets') }}/images/ticketing.ico">
    <link rel="icon" type="image/png" sizes="192x192" href="{{ asset('assets') }}/images/ticketing.ico">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets') }}/images/ticketing.ico">
    <!-- END Icons -->

    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet"
        href="{{ asset('assets') }}/vendor/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/bootstrap-select/dist/css/bootstrap-select.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/css/style.css">
    <!-- Page JS Plugins CSS -->
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/chartist/css/chartist.min.css">
    <link rel="stylesheet" href="{{ asset('assets') }}/vendor/datatables/css/jquery.dataTables.min.css">

    <link href="{{ asset('assets') }}/vendor/fullcalendar/css/main.min.css" rel="stylesheet">
    <!-- Fonts and Codebase framework -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Muli:300,400,400i,600,700">
    <style>
        .text-italic {
            font-style: italic !important;
        }
    </style>
    <!-- You can include a specific file from css/themes/ folder to alter the default color theme of the template. eg: -->
    <!-- <link rel="stylesheet" id="css-theme" href="{{ asset('assets') }}/css/themes/flat.min.css"> -->
    <!-- END Stylesheets -->
</head>

<body>
    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
        <div class="sk-three-bounce">
            <div class="sk-child sk-bounce1"></div>
            <div class="sk-child sk-bounce2"></div>
            <div class="sk-child sk-bounce3"></div>
        </div>
    </div>
    <!--*******************
        Preloader end
    ********************-->
    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">
        @include('layout.header-new')
        @include('layout.sidemenu-new')


        <!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- Page Content -->
            @yield('content')
            <!-- END Page Content -->
        </div>
        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="http://dexignzone.com/"
                        target="_blank">DexignZone</a> <span class="current-year">2023</span></p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->
    </div>

    <!-- Required vendors -->
    <script src="{{ asset('assets') }}/vendor/global/global.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/bootstrap-select/dist/js/bootstrap-select.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/chart-js/chart.bundle.min.js"></script>
    <script src="{{ asset('assets') }}/vendor/bootstrap-datetimepicker/js/moment.js"></script>
    <script src="{{ asset('assets') }}/vendor/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js"></script>
    <!-- Apex Chart -->
    <script src="{{ asset('assets') }}/vendor/apexchart/apexchart.js"></script>
    <!-- Chart piety plugin files -->
    <script src="{{ asset('assets') }}/vendor/peity/jquery.peity.min.js"></script>
    <!-- Dashboard 1 -->
    <script src="{{ asset('assets') }}/js/dashboard/dashboard-1.js"></script>
    <script src="{{ asset('assets') }}/vendor/fullcalendar/js/main.min.js"></script>
    <script src="{{ asset('assets') }}/js/plugins-init/fullcalendar-init.js"></script>

    <script src="{{ asset('assets') }}/js/custom.min.js"></script>
    <script src="{{ asset('assets') }}/js/deznav-init.js"></script>
    <script src="{{ asset('assets') }}/js/demo.js"></script>
    <script src="{{ asset('assets') }}/js/styleSwitcher.js"></script>
    <!-- Page JS Plugins -->
    {{-- <script src="{{ asset('assets') }}/vendor/ckeditor/ckeditor.js"></script> --}}

    <script>
        jQuery(document).ready(function() {
            setTimeout(function() {
                dezSettingsOptions.version = 'light';
                new dezSettings(dezSettingsOptions);
                setCookie('version', 'light');
            }, 1500)
        });
    </script>

</body>

</html>
