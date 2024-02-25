<x-app-layout title="Transaksi">
    <div class="my-3 row align-items-center">
        <div class="col">
            <h2 class="page-title">List Transaksi</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('transaksi.index') }}" class="mr-3 btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></a>
            <a href="{{ route('transaksi.create') }}" class="btn btn-primary"><i class="mr-2 fe fe-plus fe-16"></i>Tambah Data</a>
        </div>
    </div>

    <div class="my-4 row">
        <!-- Small table -->
        <div class="col-md-12">
            <div class="shadow card">
                <div class="card-body">
                    <div class="mb-4 row items-align-center">
                        <div class="col-md">
                            <ul class="nav nav-pills justify-content-start">
                                <li class="nav-item">
                                    <button class="px-2 nav-link text-muted btn btn-link" type="button" id="all">All <span class="ml-2 bg-white border badge badge-pill text-muted">{{ count($transaksi) }}</span></button>
                                </li>
                                <li class="nav-item">
                                    <button class="px-2 nav-link text-muted btn btn-link" type="button" id="pending">Pending <span class="ml-2 bg-white border badge badge-pill text-muted">{{ $status['pending'] }}</span></button>
                                </li>
                                <li class="nav-item">
                                    <button class="px-2 nav-link text-muted btn btn-link" type="button" id="pembayaran">Pembayaran <span class="ml-2 bg-white border badge badge-pill text-muted">{{ $status['pembayaran'] }}</span></button>
                                </li>
                                <li class="nav-item">
                                    <button class="px-2 nav-link text-muted btn btn-link" type="button" id="proses">Proses <span class="ml-2 bg-white border badge badge-pill text-muted">{{ $status['proses'] }}</span></button>
                                </li>
                                <li class="nav-item">
                                    <button class="px-2 nav-link text-muted btn btn-link" type="button" id="selesai">Selesai <span class="ml-2 bg-white border badge badge-pill text-muted">{{ $status['selesai'] }}</span></button>
                                </li>
                                <li class="nav-item">
                                    <button class="px-2 nav-link text-muted btn btn-link" type="button" id="batal">Batal <span class="ml-2 bg-white border badge badge-pill text-muted">{{ $status['batal'] }}</span></button>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <!-- table -->
                    <table class="table datatables nowrap table-hover" id="tabelTransaksi">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Nama Customer</th>
                                <th>Deskripsi</th>
                                <th>Produk</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $no = 1;
                            @endphp
                            @forelse ($transaksi as $t)
                            @php
                                $isValid = false;
                            @endphp
                            <tr>
                                <td>{{ $no }}</td>
                                <td>
                                    {{ $t->invoice }} <br/>
                                    <div class="my-0 text-muted small">Tanggal : {{ Carbon\Carbon::parse($t->created_at)->translatedFormat('d F Y') }}</div>
                                </td>
                                <td>
                                    <small><strong>{{ $t->nama_customer }}</strong></small>
                                    <div class="my-0 text-muted small">+62 {{ $t->no_telp }}</div>
                                    <div class="my-0 text-muted small">{{ Str::words($t->alamat,7) }}</div>
                                </td>
                                <td>{{ $t->deskripsi }}</td>
                                <td>
                                    <ol>
                                        @foreach ($detailTransaksi as $dt)
                                            @if ($dt->id_transaksi == $t->id)
                                                {{-- @if ($dt->produk->stok < $dt->jumlah)
                                                    @php $isValid = false; @endphp
                                                    <li style="margin-left: -25px;">{{ $dt->kode_produk }} ({{ $dt->jumlah }}) <div class="ml-2 badge badge-danger">Stok Kurang</div></li>
                                                @else
                                                    @php $isValid = true; @endphp --}}
                                                    <li style="margin-left: -25px;">{{ $dt->kode_produk }}</li>
                                                {{-- @endif --}}
                                            @endif
                                        @endforeach
                                    </ol>
                                </td>
                                <td>Rp. {{ currency_IDR($t->total) }}</td>
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
                                    <a class="mb-1 btn btn-info btn-sm" href="{{ route('transaksi.invoice', $t->invoice) }}">View</a>
                                    {{-- @if ($isValid == true) --}}
                                        @if ($t->status == "Pending")
                                        <form action="{{ route('transaksi.batalTransaksi', $t->invoice) }}" class="d-inline" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="mb-1 btn btn-danger btn-sm confirm-delete">Batal</button>
                                        </form>
                                        <?php
                                            $message = "Halo ".$t->nama_customer.",%0a".
                                            "Tagihan pembayaran dengan invoice *".$t->invoice."* sudah kami kirimkan ke email anda.";
                                        ?>
                                        <form action="{{ route('transaksi.updateStatus', $t->invoice) }}" id="updatePending-{{ $t->id }}" class="d-none" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="mb-1 btn btn-warning btn-sm">Berhasil Terkirim?</button>
                                        </form>
                                        <a href="https://wa.me/+62{{ $t->no_telp }}?text={{ $message }}" target="_blank" style="color: white;" id="sendWA" data-id="{{ $t->id }}">
                                            <img alt="Chat on WhatsApp" style="margin-bottom: 5px;" src="{{ asset('assets/images/btnWA.png') }}" width="130px" />
                                        </a>
                                        @elseif ($t->status == 'Pembayaran')
                                        <form action="{{ route('transaksi.batalTransaksi', $t->invoice) }}" class="d-inline" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="mb-1 btn btn-danger btn-sm confirm-delete">Batal</button>
                                        </form>
                                        <form action="{{ route('transaksi.updateStatus', $t->invoice) }}" class="d-inline" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="mb-1 btn btn-warning btn-sm">Pembayaran Sukses?</button>
                                        </form>
                                        @elseif ($t->status == 'Proses')
                                        <form action="{{ route('transaksi.batalTransaksi', $t->invoice) }}" class="d-inline" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="mb-1 btn btn-danger btn-sm confirm-delete">Batal</button>
                                        </form>
                                        <form action="{{ route('transaksi.updateStatus', $t->invoice) }}" class="d-inline" method="POST">
                                            @csrf @method('PUT')
                                            <button type="submit" class="mb-1 btn btn-warning btn-sm">Selesai?</button>
                                        </form>
                                        @else @endif
                                    {{-- @endif --}}
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
                </div>
            </div>
        </div>
        <!-- simple table -->
    </div>
    <!-- end section -->

    @push('scripts')
    <script>
        $(document).ready(function () {
            var spannActive = "ml-2 text-white badge badge-pill bg-primary";
            var spannOld = "ml-2 bg-white border badge badge-pill text-muted"
            var buttonActive = "pl-2 pr-2 bg-transparent btn btn-link nav-link active text-primary";
            var buttonOld = "px-2 nav-link text-muted btn btn-link";
            var table = $("#tabelTransaksi").DataTable({
                autoWidth: true,
                columns: [null, null, null, null, null, null, null, { searchable: false, orderable: false }],
            });

            $('#all').on('click', function () {
                activeButton($(this), $('#all span'));
                table.column(6).search('').draw();
            });

            $('#pending').on('click', function () {
                activeButton($(this), $('#pending span'));
                table.column(6).search('Pending').draw();
            });

            $('#pembayaran').on('click', function () {
                activeButton($(this), $('#pembayaran span'));
                table.column(6).search('Pembayaran').draw();
            });

            $('#proses').on('click', function () {
                activeButton($(this), $('#proses span'));
                table.column(6).search('Proses').draw();
            });

            $('#selesai').on('click', function () {
                activeButton($(this), $('#selesai span'));
                table.column(6).search('Selesai').draw();
            });

            $('#batal').on('click', function () {
                activeButton($(this), $('#batal span'));
                table.column(6).search('Batal').draw();
            });

            function activeButton(button,span){
                button.removeClass().addClass(buttonActive);
                span.removeClass().addClass(spannActive);
                $(".nav-item button span").not(span).removeClass(spannActive).addClass(spannOld);
                $(".nav-item button").not(button).removeClass(buttonActive).addClass(buttonOld);
            }

            $(document).on("click", "button.confirm-delete", function () {
                var form = $(this).closest("form");
                event.preventDefault();
                Swal.fire({
                    icon: "warning",
                    title: "Apa kamu yakin?",
                    text: "Data transaksi akan dibatalkan!",
                    showCancelButton: true,
                    confirmButtonColor: "#3085d6",
                    cancelButtonColor: "#d33",
                    confirmButtonText: "Yakin",
                    cancelButtonText: "Batal",
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });

        $("#tabelTransaksi").on("click", "a#sendWA", function () {
            let id = $(this).data("id");
            $(this).addClass("d-none");
            $("#updatePending-" + id).removeClass("d-none").addClass("d-inline");
            $("#updatePending-"+id+" button").on('click', function(){
                Swal.fire({
                    title:"Proses",
                    text:"Mohon tunggu sebentar...",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    icon: "warning"
                });
            });
        });
    </script>
    @endpush
</x-app-layout>
