<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Title -->
    <title>{{env('APP_NAME')}}</title>

    <!-- Required Meta Tags Always Come First -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{asset('/favicon.ico')}}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:400,600,700" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.8.1/css/all.min.css" rel="stylesheet">
    <link href="{{asset('/vendor/nova-icons/nova-icons.css')}}" rel="stylesheet">

    <!-- CSS Implementing Libraries -->
    <link rel="stylesheet" href="{{asset('/vendor/animate.css/animate.min.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/flatpickr/dist/flatpickr.min.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/select2/dist/css/select2.min.css')}}">
    <link rel="stylesheet" href="{{asset('/vendor/chartist/dist/chartist.min.css')}}">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <!-- CSS Nova Template -->
    <link rel="stylesheet" href="{{asset('/css/theme.css')}}">

    @yield('stylesheet')
    <script type="text/javascript">
        var BASE_URL = '{{url("")}}';
    </script>
</head>

<body class="has-sidebar has-fixed-sidebar-and-header">
    <!-- Header -->
    <header class="header header-light bg-white">
        <nav class="navbar flex-nowrap p-0">
            <div class="navbar-brand-wrapper col-auto" style="background-color:transparent;padding:5px;">
                <!-- Logo For Mobile View -->
                <a class="navbar-brand navbar-brand-mobile" href="{{url('')}}">
                    <img class="img-fluid w-100" src="{{asset('/img/logo-mini.jpg')}}" alt="Nova">
                </a>
                <!-- End Logo For Mobile View -->

                <!-- Logo For Desktop View -->
                <a class="navbar-brand navbar-brand-desktop" href="{{asset('')}}">
                    <img class="side-nav-show-on-closed" src="{{asset('/img/logo-mini.jpg')}}" alt="Nova" style="height: 33px;">
                    <img class="side-nav-hide-on-closed" src="{{asset('/img/logo.jpg')}}" alt="Nova" style="height: 65px;">
                </a>
                <!-- End Logo For Desktop View -->
            </div>

            <div class="header-content col px-md-3 px-md-3">
                <div class="d-flex align-items-center">
                    @if(Auth::check())
                        @include('partials.header-dropdowns')
                    @else
                        <div class="dropdown ml-auto">
                            <a href="{{url('login')}}" class="text-capitalize">
                                Login
                            </a>
                            |
                            <a href="{{url('register')}}" class="text-capitalize">
                                Signup
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </nav>
    </header>
    <!-- End Header -->

    <main class="main pl-0">

        <div class="content">
            <div class="py-4 px-3 px-md-4">

                @yield('content')

            </div>

            <!-- Footer -->
            <footer class="small bg-white p-3 px-md-4 mt-auto d-print-none">
                <div class="row justify-content-between">
                    <div class="col-lg text-center text-lg-left">
                        &copy; {{date('Y')}} Eronka Pty Ltd. All Rights Reserved.
                    </div>

                    <div class="col-lg text-center mb-3 mb-lg-0">
                        <ul class="list-inline mb-0">
                            <li class="list-inline-item mx-2"><a class="link-muted" href="#"><i class="nova-twitter-alt"></i></a></li>
                            <li class="list-inline-item mx-2"><a class="link-muted" href="#"><i class="nova-vimeo-alt"></i></a></li>
                            <li class="list-inline-item mx-2"><a class="link-muted" href="#"><i class="nova-github"></i></a></li>
                        </ul>
                    </div>

                    <div class="col-lg text-center text-lg-right mb-3 mb-lg-0">
                        <ul class="list-dot list-inline mb-0">
                            <li class="list-inline-item mr-lg-2"><a class="link-dark" href="#">About US</a></li>|
                            <li class="list-inline-item mr-lg-2"><a class="link-dark" href="#">Contact us</a></li>|
                            <li class="list-inline-item mr-lg-2"><a class="link-dark" href="#">Privacy Policy</a></li>
                        </ul>
                    </div>
                </div>
            </footer>
            <!-- End Footer -->
        </div>
    </main>

    <datalist id="friends-list">
        <?php
            $list = getFriendsList();

            if($list){
                foreach($list as $fr){
                    echo '<option value="'.$fr->invited_email.'" text="'.$fr->invited_name.'"/>';
                }
            }
        ?>
    </datalist>

    <!-- JS Global Compulsory -->
    <script src="{{asset('/vendor/jquery/dist/jquery.min.js')}}"></script>
    <script src="{{asset('/vendor/jquery-migrate/dist/jquery-migrate.min.js')}}"></script>
    <script src="{{asset('/vendor/popper.js/dist/umd/popper.min.js')}}"></script>
    <script src="{{asset('/vendor/bootstrap/dist/js/bootstrap.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@8"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-loading-overlay/2.1.6/loadingoverlay.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lodash.js/4.17.11/lodash.core.min.js"></script>

    <!-- JS Implementing Libraries -->
    <script src="{{asset('/vendor/malihu-custom-scrollbar-plugin/jquery.mCustomScrollbar.concat.min.js')}}"></script>
    <script src="{{asset('/vendor/flatpickr/dist/flatpickr.min.js')}}"></script>
    <script src="{{asset('/vendor/select2/dist/js/select2.full.min.js')}}"></script>
    <script src="{{asset('/vendor/chartist/dist/chartist.min.js')}}"></script>
    <script src="{{asset('/vendor/chartist-bar-labels/src/scripts/chartist-bar-labels.js')}}"></script>
    <script src="{{asset('/vendor/resize-sensor/dist/resizeSensor.min.js')}}"></script>
    <script src="{{asset('/vendor/datatables/media/js/jquery.dataTables.min.js')}}"></script>

    <!-- JS Nova -->
    <script src="{{asset('/js/hs.core.js')}}"></script>
    <script src="{{asset('/js/components/hs.malihu-scrollbar.js')}}"></script>
    <script src="{{asset('/js/components/hs.side-nav.js')}}"></script>
    <script src="{{asset('/js/components/hs.unfold.js')}}"></script>
    <script src="{{asset('/js/components/hs.flatpickr.js')}}"></script>
    <script src="{{asset('/js/components/hs.header-search.js')}}"></script>
    <script src="{{asset('/js/components/hs.select2.js')}}"></script>
    <script src="{{asset('/js/components/hs.chartist-bar.js')}}"></script>
    <script src="{{asset('/js/components/hs.bs-tabs.js')}}"></script>
    <script src="{{asset('/js/components/hs.datatables.js')}}"></script>


    <!-- JS Libraries Init. -->
    <script>
        $(document).on('ready', function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                }
            });

            // initialization of custom scroll
            $.HSCore.components.HSMalihuScrollBar.init($('.js-custom-scroll'));

            // initialization of dropdown component
            $.HSCore.components.HSUnfold.init($('[data-unfold-target]'), {
                unfoldHideOnScroll: false,
                afterOpen: function() {
                    // initialization of charts
                    $.HSCore.components.HSChartistBar.init('#activity .js-bar-chart');

                    setTimeout(function() {
                        $('#activity .js-bar-chart').css('opacity', 1);
                    }, 100);

                    // help function for accordions in hidden block
                    $('#headerProjects .accordion-header').on('click', function() {
                        // vars
                        var target = $(this).data('target');

                        $(target).collapse('show');
                    });
                }
            });

            // initialization of range datepicker
            $.HSCore.components.HSFlatpickr.init('#headerRightSidebarDatepicker', {
                locale: {
                    weekdays: {
                        shorthand: ["Sun", "Mon", "Tue", "Wed", "Thu", "Fri", "Sat"]
                    }
                },
                nextArrow: '<i class="nova-arrow-right icon-text icon-text-xs"></i>',
                prevArrow: '<i class="nova-arrow-left icon-text icon-text-xs"></i>'
            });

            // initialization of show on type module
            $.HSCore.components.HSSelect2.init('.js-custom-select');
        });
    </script>

    @yield('scripts')
</body>

</html>
