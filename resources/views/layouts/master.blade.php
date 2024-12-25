<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>@yield('title') - {{ config('app.name') }}</title>
    <!-- Favicon icon -->
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('admin/images/applogo.png') }}">
    <link rel="stylesheet" href="{{ asset('admin/vendor/bootstrap-select/dist/css/bootstrap-select.min.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('admin/css/skin.css') }}">
    <link href="{{ asset('admin/vendor/summernote/summernote.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('admin/vendor/toastr/css/toastr.min.css') }}">
    <link href="{{ asset('admin/vendor/datatables/css/jquery.dataTables.min.css') }}" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('admin/vendor/select2/css/select2.min.css') }}">

    @stack('after-styles')
    @if (trim($__env->yieldContent('page-styles')))
    @yield('page-styles')
    <style id="csscontainer"></style>
    @endif
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

        <!--**********************************
            Nav header start
        ***********************************-->
        <div class="nav-header">
            <a href="{{ route('admin.home') }}" class="brand-logo" style="background-color: #3651a0;">
                <img class="" style="width: 300px; height:78px" src="{{ asset('admin/images/applogo.png') }}" alt="">
                <!-- <img class="brand-title" src="{{ asset('admin/asset/images/logo-text-white.png') }}" alt=""> -->
            </a>

            <div class="nav-control">
                <div class="hamburger">
                    <span class="line"></span><span class="line"></span><span class="line"></span>
                </div>
            </div>
        </div>
        <input type="hidden" value="{{ App::environment() }}" id="app_environment">
        <input type="hidden" value="{{url('')}}" id="base_url">
        <input type="hidden" value="{{asset('')}}" id="assets_url">
        <input type="hidden" value="{{url(Request::path())}}" id="request_path">
        <!--**********************************
            Nav header end
        ***********************************-->

        <!--**********************************
            Header start
        ***********************************-->
        @include('layouts.header')
        <!--**********************************
            Header end ti-comment-alt
        ***********************************-->

        <!--**********************************
            Sidebar start
        ***********************************-->
        @include('layouts.sidebar')
        <!--**********************************
            Sidebar end
        ***********************************-->

        <!--**********************************
            Content body start
        ***********************************-->
        @yield('content')
        <!--**********************************
            Content body end
        ***********************************-->


        <!--**********************************
            Footer start
        ***********************************-->
        <div class="footer">
            <div class="copyright">
                <p>Copyright © Designed &amp; Developed by <a href="#" target="_blank">Legible</a> 2024</p>
            </div>
        </div>
        <!--**********************************
            Footer end
        ***********************************-->

        <!--**********************************
           Support ticket button start
        ***********************************-->

        <!--**********************************
           Support ticket button end
        ***********************************-->


    </div>
    <!--**********************************
        Main wrapper end
    ***********************************-->
    @stack('before-scripts')
    <!-- Required vendors -->
    <script src="{{ asset('admin/vendor/global/global.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/bootstrap-select/dist/js/bootstrap-select.min.js') }}"></script>
    <script src="{{ asset('admin/js/custom.min.js') }}"></script>
    <!-- Chart Morris plugin files -->
    <script src="{{ asset('admin/vendor/raphael/raphael.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/morris/morris.min.js') }}"></script>
    <!-- Chart piety plugin files -->
    <script src="{{ asset('admin/vendor/peity/jquery.peity.min.js') }}"></script>
    <!-- Demo scripts -->
    <script src="{{ asset('admin/js/dashboard/dashboard-2.js') }}"></script>
    <!-- Svganimation scripts -->
    <script src="{{ asset('admin/vendor/svganimation/vivus.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/svganimation/svg.animation.js') }}"></script>
    <!-- theme setting script  -->
    <script src="{{ asset('admin/js/dlabnav-init.js') }}"></script>

    <!-- <script src="{{ asset('js/styleSwitcher.js') }}"></script> -->

    <!-- Summernote -->
    <script src="{{ asset('admin/vendor/summernote/js/summernote.min.js') }}"></script>
    <!-- Summernote init -->
    <script src="{{ asset('admin/js/plugins-init/summernote-init.js') }}"></script>

    <!-- Toastr -->
    <script src="{{ asset('admin/vendor/toastr/js/toastr.min.js') }}"></script>
    <!-- All init script -->
    <script src="{{ asset('admin/js/plugins-init/toastr-init.js') }}"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- Datatable -->
    <script src="{{ asset('admin/vendor/datatables/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins-init/datatables.init.js') }}"></script>


    <script src="{{ asset('admin/vendor/select2/js/select2.full.min.js') }}"></script>
    <script src="{{ asset('admin/js/plugins-init/select2-init.js') }}"></script>

    @stack('after-scripts')
    @if (trim($__env->yieldContent('page-script')))
    @yield('page-script')
    @endif
</body>

</html>