<x-app-layout title="Bahan Baku">
    <div class="my-3 row align-items-center">
        <div class="col">
            <h2 class="page-title">Bahan Baku</h2>
        </div>
        <div class="col-auto">
            <a href="{{ route('bahan.index') }}" class="mr-3 btn btn-sm"><span class="fe fe-refresh-ccw fe-16 text-muted"></span></a>
            <a href="{{ route('bahan.create') }}" class="btn btn-primary"><i class="mr-2 fe fe-plus fe-16"></i>Tambah Data</a>
        </div>
    </div>

    <div class="my-4 row">
        <!-- Small table -->
        <div class="col-md-12">
            <div class="shadow card">
                <div class="card-body">
                    <!-- table -->
                    <table class="table datatables nowrap table-hover" id="dataBarangBaku" >
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Nama</th>
                                <th>Stok</th>
                                <th>Satuan</th>
                                <th>Harga</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $no = 1; @endphp @forelse ($bahanBaku as $barang)

                            <tr>
                                <td>{{ $no }}</td>
                                <td>{{ $barang->nama }}</td>
                                <td>{!! stokCheck($barang->stok) !!}</td>
                                <td>{{ $barang->satuan }}</td>
                                <td>Rp. {{ currency_IDR($barang->harga) }}</td>
                                <td>
                                    <button type="button" class="mb-1 btn btn-secondary btn-sm data-stok" data-toggle="modal" data-target="#tambah-stok" data-slug="{{ $barang->slug }}">Tambah Stok</button>
                                    <a href="{{  route('bahan.edit',$barang->slug)  }}" class="mb-1 btn btn-warning btn-sm">Edit</a>
                                    <form action="{{ route('bahan.delete', $barang->slug) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="mb-1 btn btn-danger btn-sm confirm-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @php $no++; @endphp @empty
                            <tr>
                                <td colspan="6" align="center">
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
    <!-- Modal tambah stok-->
    <div class="modal fade" id="tambah-stok" tabindex="-1" role="dialog" aria-labelledby="verticalModalTitle" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="verticalModalTitle">Tambah Stok</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
            </div>
            <form action="{{ route('bahan.tambahStok') }}" method="POST" class="mt-3">
                @csrf
                @method('PUT')
                <input type="hidden" name="slug" value="" id="value-slug">
                <div class="modal-body">
                    <div class="text-center">
                        <h3 class="h5" id="data-nama-barang"></h3>
                        <p class="text-muted">Stok saat ini</p>
                        <span class="h1" id="data-stok-barang"></span>
                    </div>
                        <div class="mt-3 form-group">
                            <x-input-label for="harga" value="Harga" />
                            <div class="mb-3 input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="basic-addon1">Rp</span>
                                </div>
                                <x-text-input for="harga" id="data-harga-barang" type="text" name="harga" readonly/>
                            </div>
                        </div>
                        <div class="mt-3 form-group">
                            <x-input-label for="stok" value="Tambah Stok Barang" />
                            <x-text-input for="stok" type="number" name="stok" required min="0" onkeypress="return isNumberKey(event);"/>
                            <x-input-error record="stok" />
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="mb-2 btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="mb-2 btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
        </div>
    </div>
    @endsection

    @push('scripts')
        <script>
            $(document).ready(function () {
                $("#dataBarangBaku").DataTable({
                    autoWidth: true,
                    columns: [null, null, null, null, null, { searchable: false, orderable: false }],
                    // dom: 'Bfrtip',
                });

                $(document).on('click', 'button.confirm-delete', function () {
                    var form =  $(this).closest("form");
                    event.preventDefault();
                    Swal.fire({
                        title: 'Apa kamu yakin?',
                        text: "Data akan terhapus!",
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yakin',
                        cancelButtonText: 'Batal',
                    }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                    });
                });
            });
        </script>
        <script>
            $(document).on('click', 'button.data-stok', function (e) {
                $.ajax({
                    type: "GET",
                    url: "/bahan-baku/get-data",
                    data: {
                        slug : $(this).data('slug')
                    },
                    dataType: "json",
                    success: function (response) {
                        $('#data-nama-barang').html(response.nama);
                        $('#data-stok-barang').html(response.stok);
                        $('#data-harga-barang').val(response.harga);
                        $('#value-slug').val(response.slug);
                    }
                });
            });
        </script>
    @endpush
</x-app-layout>
