<x-app-layout title="Dashboard">
    <div class="row justify-content-center">
        @if (Auth()->user()->role == 'Admin' || Auth()->user()->role == 'Staff')
        <div class="col-12">
            <div class="mb-2 row align-items-center">
                <div class="col">
                    <h2 class="h5 page-title">Welcome!</h2>
                </div>
                <div class="col-auto">
                    <form class="form-inline">
                        <div class="form-group d-none d-lg-inline">
                            <label for="reportrange" class="sr-only">Date Ranges</label>
                            <div class="px-2 py-2 text-muted">
                                <span class="small">{{ Carbon\Carbon::parse(now())->translatedFormat('d F Y'); }}</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="mb-4 col-md-4 col-xl-4">
                    <div class="border-0 shadow card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="text-center col-3">
                                    <span class="circle circle-sm bg-primary">
                                        <i class="mb-0 text-white fe fe-16 fe-codepen"></i>
                                    </span>
                                </div>
                                <div class="pr-0 col">
                                    <p class="mb-0 small text-muted">Total Bahan Baku</p>
                                    <span class="mb-0 h3">{{ $countBahan }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-md-4 col-xl-4">
                    <div class="border-0 shadow card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="text-center col-3">
                                    <span class="circle circle-sm bg-primary">
                                        <i class="mb-0 text-white fe fe-16 fe-package"></i>
                                    </span>
                                </div>
                                <div class="col">
                                    <p class="mb-0 small text-muted">Total Produk</p>
                                    <span class="mb-0 h3">{{ $countProduk }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-md-4 col-xl-4">
                    <div class="border-0 shadow card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="text-center col-3">
                                    <span class="circle circle-sm bg-primary">
                                        <i class="mb-0 text-white fe fe-16 fe-shopping-cart"></i>
                                    </span>
                                </div>
                                <div class="col">
                                    <p class="mb-0 small text-muted">Total Transaksi Hari Ini</p>
                                    <span class="mb-0 h3">{{ $transaksiHariIni }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="mb-4 col-md-12 col-lg-8">
                    <div class="shadow card">
                        <div class="card-header">
                            <strong class="card-title">Transaksi Terbaru</strong>
                        </div>
                        <div class="card-body my-n2">
                            <table class="table table-striped table-hover table-borderless">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Nama Customer</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp @forelse ($transaksiPending as $t)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>
                                            {{ $t->invoice }} <br />
                                            <div class="my-0 text-muted small">Tanggal : {{ Carbon\Carbon::parse($t->created_at)->translatedFormat('d F Y') }}</div>
                                        </td>
                                        <td>
                                            <small><strong>{{ $t->nama_customer }}</strong></small>
                                            <div class="my-0 text-muted small">+62 {{ $t->no_telp }}</div>
                                            <div class="my-0 text-muted small">{{ Str::words($t->alamat,7) }}</div>
                                        </td>
                                        <td>
                                            @if ($t->status == "Pending")
                                            <span class="badge badge-warning">{{ $t->status }}</span>
                                            @elseif ($t->status == 'Pembayaran')
                                            <span class="badge badge-primary">{{ $t->status }}</span>
                                            @elseif ($t->status == 'Proses')
                                            <span class="badge badge-info">{{ $t->status }}</span>
                                            @elseif ($t->status == 'Selesai')
                                            <span class="badge badge-success">{{ $t->status }}</span>
                                            @else
                                            <span class="badge badge-danger">{{ $t->status }}</span>
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('transaksi.index') }}" class="btn btn-info btn-sm">View</a>
                                        </td>
                                    </tr>
                                    @php $no++; @endphp @empty
                                    <tr>
                                        <td colspan="8" align="center">
                                            <div class="mb-0 alert alert-warning">DATA KOSONG!</div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                            {{ $transaksiPending->links('layouts.pagination') }}
                        </div>
                    </div>
                </div>
                <!-- .col -->
                <div class="col-md-4">
                    <div class="mb-4 shadow card">
                        <div class="card-header">
                            <strong class="card-title">Top Produk</strong>
                        </div>
                        <div class="card-body">
                            @php $no = 1; @endphp @forelse ($topProduk as $top)
                            <div class="list-group list-group-flush my-n3">
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-3 col-md-2">
                                            <img src="{{ asset('produk_photo/'.$top->produk->foto) }}" alt="{{ $top->produk->nama }}" class="thumbnail-sm" />
                                        </div>
                                        <div class="col">
                                            <strong>{{ $top->produk->nama }}</strong>
                                            <div class="my-0 text-muted small">{{ $top->produk->deskripsi }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @php $no++; @endphp @empty
                            <div class="mb-0 alert alert-warning">DATA KOSONG!</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif

        @if (Auth()->user()->role == 'Customer')
        <div class="col-12">
            <div class="mb-2 row align-items-center">
                <div class="col">
                    <h2 class="h5 page-title">Welcome!</h2>
                </div>
                <div class="col-auto">
                    <form class="form-inline">
                        <div class="form-group d-none d-lg-inline">
                            <label for="reportrange" class="sr-only">Date Ranges</label>
                            <div class="px-2 py-2 text-muted">
                                <span class="small">{{ Carbon\Carbon::parse(now())->translatedFormat('d F Y'); }}</span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="my-4 row">
                <div class="col-md-4">
                    <div class="mb-4 shadow card">
                        <div class="card-body my-n3">
                            <div class="row align-items-center">
                                <div class="text-center col-3">
                                    <span class="circle circle-lg bg-light">
                                        <i class="fe fe-user fe-24 text-primary"></i>
                                    </span>
                                </div>
                                <!-- .col -->
                                <div class="col">
                                    <a href="#">
                                        <h3 class="mt-4 mb-1 h5">Profil</h3>
                                    </a>
                                    <p class="text-muted"></p>
                                </div>
                                <!-- .col -->
                            </div>
                            <!-- .row -->
                        </div>
                        <!-- .card-body -->
                        <div class="card-footer">
                            <a href="{{ route('profile.index') }}" class="d-flex justify-content-between text-muted"><span>Pengaturan Profil</span><i class="fe fe-chevron-right"></i></a>
                        </div>
                        <!-- .card-footer -->
                    </div>
                    <!-- .card -->
                </div>
                <!-- .col-md-->
                <div class="col-md-4">
                    <div class="mb-4 shadow card">
                        <div class="card-body my-n3">
                            <div class="row align-items-center">
                                <div class="text-center col-3">
                                    <span class="circle circle-lg bg-light">
                                        <i class="fe fe-shield fe-24 text-primary"></i>
                                    </span>
                                </div>
                                <!-- .col -->
                                <div class="col">
                                    <a href="#">
                                        <h3 class="mt-4 mb-1 h5">Security</h3>
                                    </a>
                                    <p class="text-muted"></p>
                                </div>
                                <!-- .col -->
                            </div>
                            <!-- .row -->
                        </div>
                        <!-- .card-body -->
                        <div class="card-footer">
                            <a href="{{ route('security.index') }}" class="d-flex justify-content-between text-muted"><span>Pengaturan Keamanan</span><i class="fe fe-chevron-right"></i></a>
                        </div>
                        <!-- .card-footer -->
                    </div>
                    <!-- .card -->
                </div>
            </div>
        </div>
        @endif
    </div>

    @push('scripts')
    <script>
        $(".select2").select2({
            theme: "bootstrap4",
        });
        $(".select2-multi").select2({
            multiple: true,
            theme: "bootstrap4",
        });
        $(".drgpicker").daterangepicker({
            singleDatePicker: true,
            timePicker: false,
            showDropdowns: true,
            locale: {
                format: "MM/DD/YYYY",
            },
        });
        $(".time-input").timepicker({
            scrollDefault: "now",
            zindex: "9999" /* fix modal open */,
        });
        /** date range picker */
        if ($(".datetimes").length) {
            $(".datetimes").daterangepicker({
                timePicker: true,
                startDate: moment().startOf("hour"),
                endDate: moment().startOf("hour").add(32, "hour"),
                locale: {
                    format: "M/DD hh:mm A",
                },
            });
        }
        var start = moment().subtract(29, "days");
        var end = moment();

        function cb(start, end) {
            $("#reportrange span").html(start.format("MMMM D, YYYY") + " - " + end.format("MMMM D, YYYY"));
        }
        $("#reportrange").daterangepicker(
            {
                startDate: start,
                endDate: end,
                ranges: {
                    Today: [moment(), moment()],
                    Yesterday: [moment().subtract(1, "days"), moment().subtract(1, "days")],
                    "Last 7 Days": [moment().subtract(6, "days"), moment()],
                    "Last 30 Days": [moment().subtract(29, "days"), moment()],
                    "This Month": [moment().startOf("month"), moment().endOf("month")],
                    "Last Month": [moment().subtract(1, "month").startOf("month"), moment().subtract(1, "month").endOf("month")],
                },
            },
            cb
        );
        cb(start, end);
        $(".input-placeholder").mask("00/00/0000", {
            placeholder: "__/__/____",
        });
        $(".input-zip").mask("00000-000", {
            placeholder: "____-___",
        });
        $(".input-money").mask("#.##0,00", {
            reverse: true,
        });
        $(".input-phoneus").mask("(000) 000-0000");
        $(".input-mixed").mask("AAA 000-S0S");
        $(".input-ip").mask("0ZZ.0ZZ.0ZZ.0ZZ", {
            translation: {
                Z: {
                    pattern: /[0-9]/,
                    optional: true,
                },
            },
            placeholder: "___.___.___.___",
        });
        // editor
        var editor = document.getElementById("editor");
        if (editor) {
            var toolbarOptions = [
                [
                    {
                        font: [],
                    },
                ],
                [
                    {
                        header: [1, 2, 3, 4, 5, 6, false],
                    },
                ],
                ["bold", "italic", "underline", "strike"],
                ["blockquote", "code-block"],
                [
                    {
                        header: 1,
                    },
                    {
                        header: 2,
                    },
                ],
                [
                    {
                        list: "ordered",
                    },
                    {
                        list: "bullet",
                    },
                ],
                [
                    {
                        script: "sub",
                    },
                    {
                        script: "super",
                    },
                ],
                [
                    {
                        indent: "-1",
                    },
                    {
                        indent: "+1",
                    },
                ], // outdent/indent
                [
                    {
                        direction: "rtl",
                    },
                ], // text direction
                [
                    {
                        color: [],
                    },
                    {
                        background: [],
                    },
                ], // dropdown with defaults from theme
                [
                    {
                        align: [],
                    },
                ],
                ["clean"], // remove formatting button
            ];
            var quill = new Quill(editor, {
                modules: {
                    toolbar: toolbarOptions,
                },
                theme: "snow",
            });
        }
        // Example starter JavaScript for disabling form submissions if there are invalid fields
        (function () {
            "use strict";
            window.addEventListener(
                "load",
                function () {
                    // Fetch all the forms we want to apply custom Bootstrap validation styles to
                    var forms = document.getElementsByClassName("needs-validation");
                    // Loop over them and prevent submission
                    var validation = Array.prototype.filter.call(forms, function (form) {
                        form.addEventListener(
                            "submit",
                            function (event) {
                                if (form.checkValidity() === false) {
                                    event.preventDefault();
                                    event.stopPropagation();
                                }
                                form.classList.add("was-validated");
                            },
                            false
                        );
                    });
                },
                false
            );
        })();
    </script>
    <script>
        var uptarg = document.getElementById("drag-drop-area");
        if (uptarg) {
            var uppy = Uppy.Core()
                .use(Uppy.Dashboard, {
                    inline: true,
                    target: uptarg,
                    proudlyDisplayPoweredByUppy: false,
                    theme: "dark",
                    width: 770,
                    height: 210,
                    plugins: ["Webcam"],
                })
                .use(Uppy.Tus, {
                    endpoint: "https://master.tus.io/files/",
                });
            uppy.on("complete", (result) => {
                console.log("Upload complete! We’ve uploaded these files:", result.successful);
            });
        }
    </script>
    <script>
        window.dataLayer = window.dataLayer || [];

        function gtag() {
            dataLayer.push(arguments);
        }
        gtag("js", new Date());
        gtag("config", "UA-56159088-1");
    </script>
    @endpush
</x-app-layout>
