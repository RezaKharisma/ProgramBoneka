<x-app-layout title="Produk">
    <div class="my-3 row align-items-center">
        <div class="col">
            <h2 class="page-title">Produk</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('produk.index') }}" class="mr-3 btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></a>
            <a href="{{ route('produk.create') }}" class="btn btn-primary"><i class="mr-2 fe fe-plus fe-16"></i>Tambah Data</a>
        </div>
    </div>

    <div class="my-4 row">
        <!-- Small table -->
        <div class="col-md-12">
            <div class="shadow card">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables nowrap table-hover" id="dataProduk">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Kode</th>
                                <th>Nama</th>
                                <th>Harga Beli</th>
                                <th>Harga Jual</th>
                                <th>Stok</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp @forelse ($produk as $p)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $p->kode_produk }}</td>
                                <td>
                                    <div class="row">
                                        <div class="col-auto"><img src="{{ asset('produk_photo/'.$p->foto) }}" alt="{{ $p->nama }}" width="80px"></div>
                                        <div class="col-auto mt-3">
                                            <span ><strong>{{ $p->nama }}</strong></span><br>
                                            <span class="text-muted small">{{ Str::words($p->deskripsi,7) }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>Rp. {{ currency_IDR($p->harga_beli) }}</td>
                                <td>Rp. {{ currency_IDR($p->harga_jual) }}</td>
                                <td>{!! stokCheck($p->stok) !!}</td>
                                <td>
                                    <form action="{{ route('produk.updateStatus', $p->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        @if ($p->status == "Aktif")
                                            <button class="btn btn-success btn-sm" type="submit">{{ $p->status }}</button>
                                        @else
                                            <button class="btn btn-danger btn-sm" type="submit">{{ $p->status }}</button>
                                        @endif
                                    </form>
                                </td>
                                <td>
                                    <button class="mb-1 btn btn-info btn-sm btnViewProduk" data-kode="{{ $p->kode_produk }}">View</button>
                                    <a href="{{  route('produk.edit',$p->kode_produk)  }}" class="mb-1 btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('produk.delete', $p->kode_produk) }}" method="POST" class="d-inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="mb-1 btn btn-danger btn-sm confirm-delete">Hapus</button>
                                    </form>
                                    <a href="{{ route('produk.createStok', $p->kode_produk) }}" class="mb-1 btn btn-primary btn-sm">Tambah Stok</a>
                                </td>
                            </tr>
                            @php $no++; @endphp @empty
                            <tr>
                                <td colspan="8" align="center">
                                    <div class="alert alert-warning">DATA KOSONG!</div>
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

    @section('modals')
    <div class="modal fade" id="viewProduk" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="verticalModalTitle">Detail Bahan Baku</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="content-center">
                    <div class="text-center">
                        <h3 class="mt-4 mb-0 h5 kode_produk"></h3>
                        <p class="text-muted status_produk"></p>
                        <span class="mb-0 h1 nama_produk"></span>
                        <p class="text-muted deskripsi_produk"></p>
                    </div>

                    <div class="pl-2 pr-2">
                        <table class="table" id="tabelBahanBaku">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Nama Bahan Baku</th>
                                    <th class="text-right">Jumlah</th>
                                    <th class="text-right">Harga</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>

                    <div class="mb-4 mr-3 text-right">
                        <p class="mb-2 h6">
                            <span class="text-muted">Harga Total : </span>
                            <strong class="harga_beli">$285.00</strong>
                        </p>
                        <p class="mb-2 h6">
                            <span class="text-muted">Harga Jual :</span>
                            <strong class="harga_jual">$28.50</strong>
                        </p>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <a href="#" class="btn btn-warning linkEditProduk">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endsection @push('scripts')
    <script>
        $(document).ready(function () {
            $("#dataProduk").DataTable({
                autoWidth: true,
                columns: [null, null, null, null, null, null, null, { searchable: false, orderable: false }],
            });

            $(document).on("click", "button.confirm-delete", function () {
                var form = $(this).closest("form");
                event.preventDefault();
                Swal.fire({
                    title: "Apa kamu yakin?",
                    text: "Data akan terhapus!",
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
    </script>
    <script>
        $("#dataProduk").on("click", "button.btnViewProduk", function (e) {
            $("#tabelBahanBaku tbody").html("");
            $.ajax({
                type: "GET",
                url: "/produk/get_data_produk",
                data: {
                    kode_produk: $(this).data("kode"),
                },
                dataType: "json",
                success: function (response) {
                    $("#viewProduk").modal("show");
                    $(".kode_produk").html(response.kode_produk);

                    if (response.status == "Aktif") {
                        $(".status_produk").html('<span class="badge badge-success">' + response.status + "</span>");
                    } else {
                        $(".status_produk").html('<span class="badge badge-danger">' + response.status + "</span>");
                    }

                    $(".nama_produk").html(response.nama);
                    $(".deskripsi_produk").html(response.deskripsi);

                    $.each(response.bahan_baku, function (key, item) {
                        $("#tabelBahanBaku tbody").append('<tr><th scope="row">'+(key+1)+'</th><td width="60%">'+item['nama']+'</td><td class="text-right">'+item['jumlah']+'</td><td class="text-right" width="40%">Rp. '+formatRupiah(item['harga'])+'</td></tr>');
                    });

                    $(".harga_beli").html(response.harga_beli);
                    $(".harga_jual").html(response.harga_jual);
                    $(".linkEditProduk").attr("href", '/produk/'+response.kode_produk+'/edit');
                },
            });
        });
    </script>
    <script>
        /* Fungsi formatRupiah */
        function formatRupiah(angka, prefix) {
            var number_string = angka.toString(),
                split = number_string.split(","),
                sisa = split[0].length % 3,
                rupiah = split[0].substr(0, sisa),
                ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            // tambahkan titik jika yang di input sudah menjadi angka ribuan
            if (ribuan) {
                separator = sisa ? "." : "";
                rupiah += separator + ribuan.join(".");
            }

            rupiah = split[1] != undefined ? rupiah + "," + split[1] : rupiah;
            return prefix == undefined ? rupiah : rupiah ? "Rp. " + rupiah : "";
        }
    </script>
    @endpush
</x-app-layout>
