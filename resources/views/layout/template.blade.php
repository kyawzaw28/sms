<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="keywords"
        content="wrappixel, admin dashboard, html css dashboard, web dashboard, bootstrap 5 admin, bootstrap 5, css3 dashboard, bootstrap 5 dashboard, Matrix lite admin bootstrap 5 dashboard, frontend, responsive bootstrap 5 admin template, Matrix admin lite design, Matrix admin lite dashboard bootstrap 5 dashboard template">
    <meta name="description"
        content="Matrix Admin Lite Free Version is powerful and clean admin dashboard template, inpired from Bootstrap Framework">
    <meta name="robots" content="noindex,nofollow">
    @yield('ajaxcsrf')
    <title>School Management</title>
   @include('layout.css')
   @yield('custom')
</head>

<body>
    <!-- ============================================================== -->
    <!-- Preloader - style you can find in spinners.css -->
    <!-- ============================================================== -->
    {{-- <div class="preloader">
        <div class="lds-ripple">
            <div class="lds-pos"></div>
            <div class="lds-pos"></div>
        </div>
    </div> --}}
    <!-- ============================================================== -->
    <!-- Main wrapper - style you can find in pages.scss -->
    <!-- ============================================================== -->




    <div id="main-wrapper" class="main-wrapper mini-sidebar" data-layout="vertical" data-navbarbg="skin5" data-sidebartype="full"
        data-sidebar-position="absolute" data-header-position="absolute" data-boxed-layout="full" style="position: fixed;
        display: flex;
        flex-direction: column;
        top: 0;
        bottom: 0;
        left: 0;
        right: 0;">
                        <!-- ============================================================== -->
                        <!-- Topbar header - style you can find in pages.scss -->
                        <!-- ============================================================== -->

                        <header class="topbar" data-navbarbg="skin5">
                            <nav class="navbar top-navbar navbar-expand-md navbar-dark">
                                <div class="navbar-header" data-logobg="skin5">
                                <!-- Logo and navbar -->
                                <!-- ============================================================== -->
                                @include('layout.navbar')
                                <!-- ============================================================== -->
                                <!-- Bread crumb and right sidebar toggle -->
                                <!-- ============================================================== -->

                                {{-- </div>
                            </nav>
                        </header> --}}



                    {{-- <div class="page-wrapper " style="margin-left: 0!important"> --}}
                        <!-- ============================================================== -->
                        <!-- Left Sidebar - style you can find in sidebar.scss  -->
                        <!-- ============================================================== -->
                        @include('layout.sidebar')
                        <!-- ============================================================== -->
                        <!-- Page wrapper  -->
                        <div class="page-wrapper " style="height: 100%">
                        @yield('content')
                        </div>

                       
                    
                    <!-- ============================================================== -->
                    <!-- End Page wrapper  -->
                    <!-- ============================================================== -->
                </div>
    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    @yield('dataloader')
    @include('layout.script')

    @stack('scripts')

    {{-- <script>
        $(document).ready(function() {
            $('.main-wrapper').addClass('mini-sidebar')
        })
    </script> --}}

</body>

</html>
