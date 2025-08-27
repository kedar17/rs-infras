<!DOCTYPE html>
<html lang="en">
<head>

    @include('partials.header')

</head>
<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">
        <!-- Sidebar -->
        @include('partials.sidebar')
        <!-- End of Sidebar -->
        <div id="content-wrapper" class="d-flex flex-column">
            <!-- Main Content -->
            <div id="content">
                <!-- Topbar -->
                @include('partials.topbar')
                <!-- End of Topbar -->
                <!-- Body Content Wrapper -->
                @yield('content')
                <!-- End of Body Content Wrapper -->
            </div>
            <!-- End of Main Content -->
            <!-- Footer -->
            @include('partials.copy')

        </div>
    </div>
    <!-- End of Page Wrapper -->
    @include('partials.footer')
   @stack('scripts')
</body>
</html>