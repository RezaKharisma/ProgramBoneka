<x-app-layout title="Laporan Transaksi">
    <div class="mb-3 row align-items-center">
        <div class="col">
            <h2 class="page-title">Laporan Transaksi</h2>
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="mb-4 col-md-12">
            <div class="row">
                <div class="mb-4 col-md-6 col-xl-3">
                    <div class="shadow card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="text-center col-3">
                                    <span class="circle circle-sm bg-primary">
                                        <i class="mb-0 text-white fe fe-16 fe-package"></i>
                                    </span>
                                </div>
                                <div class="pr-0 col">
                                    <p class="mb-0 small text-muted">Total Transaksi</p>
                                    <span class="mb-0 h3">{{ count($dataTransaksi) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-md-6 col-xl-3">
                    <div class="shadow card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="text-center col-3">
                                    <span class="circle circle-sm bg-info">
                                        <i class="mb-0 text-white fe fe-16 fe-folder-plus"></i>
                                    </span>
                                </div>
                                <div class="pr-0 col">
                                    <p class="mb-0 small text-muted">Transaksi Bulan Ini</p>
                                    <span class="mb-0 h3">{{ $transaksiBulanIni }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="mb-4 col-md-6 col-xl-4">
                    <div class="shadow card">
                        <div class="card-body">
                            <div class="row align-items-center">
                                <div class="text-center col-3">
                                    <span class="circle circle-sm bg-success">
                                        <i class="mb-0 text-white fe fe-16 fe-shopping-bag"></i>
                                    </span>
                                </div>
                                <div class="pr-0 col">
                                    <p class="mb-0 small text-muted">Pendapatan Bulan Ini</p>
                                    <span class="mb-0 h3">Rp. {{ currency_IDR($transaksiTotalBulanIni) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="mb-3 shadow card">
                        <strong class="card-header">Alat</strong>
                        <div class="card-body row">
                            <div class="col-12">
                                <a href="{{ route('produk.exportExcel') }}" class="btn btn-success">Export All Tabel Excel</a>
                                <a href="{{ route('produk.exportPdf') }}" class="btn btn-warning" target="_blank">Export All Tabel PDF</a>
                            </div>
                            <div class="mt-3 col-6 col-md-4">
                                <div class="shadow card">
                                    <div class="card-header">Pencarian Tanggal</div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="simple-select2">Bulan</label>
                                            <select class="form-control select2 btn-block" id="bulan" required>
                                                <option value="0" selected>...</option>
                                                <option value="Januari">Januari</option>
                                                <option value="Februari">Februari</option>
                                                <option value="Maret">Maret</option>
                                                <option value="April">April</option>
                                                <option value="Mei">Mei</option>
                                                <option value="Juni">Juni</option>
                                                <option value="Juli">Juli</option>
                                                <option value="Agustus">Agustus</option>
                                                <option value="September">September</option>
                                                <option value="Oktober">Oktober</option>
                                                <option value="November">November</option>
                                                <option value="Desember">Desember</option>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="simple-select2">Tahun</label>
                                            <input type="number" class="form-control" id="tahun" onkeypress="return isNumberKey(event);">
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button class="btn btn-primary btn-block">Reset</button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-md-4">

                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-12">
                    <div class="mb-3 shadow card">
                        <strong class="card-header">Data Transaksi</strong>
                        <div class="card-body">
                            <table class="table datatables nowrap table-hover" id="tabelTransaksi">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>#</th>
                                        <th>Invoice</th>
                                        <th>Nama Customer</th>
                                        <th>Total</th>
                                        <th>Status</th>
                                        <th>Tanggal</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $no = 1; @endphp @forelse ($dataTransaksi as $t)
                                    <tr>
                                        <td>{{ $no }}</td>
                                        <td>{{ $t->invoice }}</td>
                                        <td>
                                            <small><strong>{{ $t->nama_customer }}</strong></small>
                                            <div class="my-0 text-muted small">+62 {{ $t->no_telp }}</div>
                                            <div class="my-0 text-muted small">{{ Str::words($t->alamat,7) }}</div>
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
                                            {{ Carbon\Carbon::parse($t->created_at)->translatedFormat('d F Y') }}<br/>
                                            Oleh : {{ $t->user->name }}
                                        </td>
                                        <td>
                                            <a class="mb-1 btn btn-info btn-sm" href="{{ route('transaksi.invoice', $t->invoice) }}">View</a>
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
            </div>
        </div>
    </div>
    @push('scripts')
    <script>
        $(document).ready(function () {
            var table = $("#tabelTransaksi").DataTable({
                autoWidth: true,
                columns: [null, null, null, null, null, null, { searchable: false, orderable: false }],
            });

            $(".select2").select2({
                theme: "bootstrap4",
            });

            $('#bulan').on('change', function () {
                var bulan = $(this).val();
                table.column(6).search(bulan).draw();
            });

            $('#tahun').on('keyup', function () {
                var tahun = $(this).val();
                table.column(6).search(tahun).draw();
            });
        });
    </script>
    @endpush
</x-app-layout>
