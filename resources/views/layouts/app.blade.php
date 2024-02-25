<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" :content="getDeskripsi()" />
        <meta name="csrf-token" content="{{ csrf_token() }}" />
        <meta name="author" content="" />
        <link rel="icon" href="{{ asset('logo/'.getFavicon()) }}" />
        <title>{{ $title ?? 'NO TITLE!' }} | {{ getJudul() }}</title>
        <!-- Simple bar CSS -->
        <link rel="stylesheet" href="{{ asset('css/simplebar.css') }}" />
        <!-- Fonts CSS -->
        <link href="https://fonts.googleapis.com/css2?family=Overpass:ital,wght@0,100;0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet" />
        <!-- Icons CSS -->
        <link rel="stylesheet" href="{{ asset('css/feather.css') }}" />
        {{-- <link rel="stylesheet" href="{{ asset('css/jquery.dataTables.min.css') }}"> --}}
        <link rel="stylesheet" href="{{ asset('css/dataTables.bootstrap4.css') }}">
        <link rel="stylesheet" href="{{ asset('css/buttons.dataTables.min.css') }}">
        <link rel="stylesheet" href="{{ asset('css/select2.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/dropzone.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/uppy.min.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/jquery.steps.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/jquery.timepicker.css') }}" />
        <link rel="stylesheet" href="{{ asset('css/quill.snow.css') }}" />
        <!-- Date Range Picker CSS -->
        <link rel="stylesheet" href="{{ asset('css/daterangepicker.css') }}" />
        <!-- App CSS -->
        <link rel="stylesheet" href="{{ asset('css/app-light.css') }}" id="lightTheme" />
        <link rel="stylesheet" href="{{ asset('css/app-dark.css') }}" id="darkTheme" disabled />
        @yield('style')
    </head>
    <body class="vertical light">
        @php
            setlocale(LC_TIME, 'id_ID');
            \Carbon\Carbon::setLocale('id');
            \Carbon\Carbon::now()->formatLocalized("%A, %d %B %Y");
        @endphp

        @include('sweetalert::alert')
        <div class="wrapper">

            @include('layouts.menu')

            @include('layouts.sidebar')

            <main role="main" class="main-content">
                <div class="container-fluid">

                    {{ $slot }}

                </div>

                <div class="modal fade modal-notif modal-slide" tabindex="-1" role="dialog" aria-labelledby="defaultModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-sm" role="document">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="defaultModalLabel">Notifications</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div class="modal-body">
                                <div class="list-group list-group-flush my-n3">
                                    <div class="bg-transparent list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="fe fe-box fe-24"></span>
                                            </div>
                                            <div class="col">
                                                <small><strong>Package has uploaded successfull</strong></small>
                                                <div class="my-0 text-muted small">Package is zipped and uploaded</div>
                                                <small class="badge badge-pill badge-light text-muted">1m ago</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-transparent list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="fe fe-download fe-24"></span>
                                            </div>
                                            <div class="col">
                                                <small><strong>Widgets are updated successfull</strong></small>
                                                <div class="my-0 text-muted small">Just create new layout Index, form, table</div>
                                                <small class="badge badge-pill badge-light text-muted">2m ago</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="bg-transparent list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="fe fe-inbox fe-24"></span>
                                            </div>
                                            <div class="col">
                                                <small><strong>Notifications have been sent</strong></small>
                                                <div class="my-0 text-muted small">Fusce dapibus, tellus ac cursus commodo</div>
                                                <small class="badge badge-pill badge-light text-muted">30m ago</small>
                                            </div>
                                        </div>
                                        <!-- / .row -->
                                    </div>
                                    <div class="bg-transparent list-group-item">
                                        <div class="row align-items-center">
                                            <div class="col-auto">
                                                <span class="fe fe-link fe-24"></span>
                                            </div>
                                            <div class="col">
                                                <small><strong>Link was attached to menu</strong></small>
                                                <div class="my-0 text-muted small">New layout has been attached to the menu</div>
                                                <small class="badge badge-pill badge-light text-muted">1h ago</small>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- / .row -->
                                </div>
                                <!-- / .list-group -->
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary btn-block" data-dismiss="modal">Clear All</button>
                            </div>
                        </div>
                    </div>
                </div>

                @yield('modals')
            </main>
            <!-- main -->
        </div>
        <!-- .wrapper -->
        <script src="{{ asset('js/jquery.min.js') }}"></script>
        <script src="{{ asset('js/popper.min.js') }}"></script>
        <script src="{{ asset('js/moment.min.js') }}"></script>
        <script src="{{ asset('js/bootstrap.min.js') }}"></script>
        <script src="{{ asset('js/simplebar.min.js') }}"></script>
        <script src="{{ asset('js/daterangepicker.js') }}"></script>
        <script src="{{ asset('js/jquery.stickOnScroll.js') }}"></script>
        <script src="{{ asset('js/tinycolor-min.js') }}"></script>
        <script src="{{ asset('js/config.js') }}"></script>
        <script src='{{ asset('js/jquery.dataTables.min.js') }}'></script>
        <script src='{{ asset('js/dataTables.bootstrap4.min.js') }}'></script>
        <script src="{{ asset('js/d3.min.js') }}"></script>
        <script src="{{ asset('js/topojson.min.js') }}"></script>
        <script src="{{ asset('js/datamaps.all.min.js') }}"></script>
        <script src="{{ asset('js/datamaps-zoomto.js') }}"></script>
        <script src="{{ asset('js/datamaps.custom.js') }}"></script>
        <script src="{{ asset('js/Chart.min.js') }}"></script>
        <script>
            /* defind global options */
            Chart.defaults.global.defaultFontFamily = base.defaultFontFamily;
            Chart.defaults.global.defaultFontColor = colors.mutedColor;
        </script>
        <script src="{{ asset('js/gauge.min.js') }}"></script>
        <script src="{{ asset('js/jquery.sparkline.min.js') }}"></script>
        <script src="{{ asset('js/apexcharts.min.js') }}"></script>
        <script src="{{ asset('js/apexcharts.custom.js') }}"></script>
        <script src="{{ asset('js/jquery.mask.min.js') }}"></script>
        <script src="{{ asset('js/select2.min.js') }}"></script>
        <script src="{{ asset('js/jquery.steps.min.js') }}"></script>
        <script src="{{ asset('js/jquery.validate.min.js') }}"></script>
        <script src="{{ asset('js/jquery.timepicker.js') }}"></script>
        <script src="{{ asset('js/dropzone.min.js') }}"></script>
        <script src="{{ asset('js/uppy.min.js') }}"></script>
        <script src="{{ asset('js/quill.min.js') }}"></script>
        <script src="{{ asset('js/apps.js') }}"></script>
        <script src="{{ asset('js/numberOnly.js') }}"></script>
        <script src="{{ asset('vendor/sweetalert/sweetalert.all.js') }}"></script>
        <script>
            $.ajaxSetup({
                headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}
            });
        </script>
        @stack('scripts')
    </body>
</html>
