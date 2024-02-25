<x-app-layout title="Laporan Produk">
    <div class="mb-3 row align-items-center">
        <div class="col">
            <h2 class="page-title">Laporan Produk</h2>
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
                                    <p class="mb-0 small text-muted">Total Produk</p>
                                    <span class="mb-0 h3">{{ $totalProduk }}</span>
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
                                    <p class="mb-0 small text-muted">Produksi Bulan Ini</p>
                                    <span class="mb-0 h3">{{ $laporanPembuatanProduk }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xl-4 col-md-6 col-sm-12">
                    <div class="mb-3 shadow card">
                        <strong class="card-header">Alat</strong>
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-2 col-12">
                                    <a href="{{ route('produk.index') }}" class="mb-1 btn btn-info btn-block">Tabel Produk</a>
                                    <div class="mt-0 btn-group btn-block" role="group" aria-label="Basic example">
                                        <a href="{{ route('produk.exportExcel') }}" class="mb-1 btn btn-success">Export All Tabel Excel</a>
                                        <a href="{{ route('produk.exportPdf') }}" class="mb-1 btn btn-warning" target="_blank">Export All Tabel PDF</a>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="shadow card">
                                        <div class="card-header">Export</div>
                                        <form method="post" id="formPengeluaran" action="{{ route('bahan.exportPengeluaran') }}">
                                            @csrf
                                            <div class="card-body">
                                                <div class="form-group">
                                                    <label for="simple-select2">Bulan</label>
                                                    <select class="form-control select2 btn-block" id="bulan" name="bulan" required>
                                                        <option value="0" selected>All</option>
                                                        <option value="1">Januari</option>
                                                        <option value="2">Februari</option>
                                                        <option value="3">Maret</option>
                                                        <option value="4">April</option>
                                                        <option value="5">Mei</option>
                                                        <option value="6">Juni</option>
                                                        <option value="7">Juli</option>
                                                        <option value="8">Agustus</option>
                                                        <option value="9">September</option>
                                                        <option value="10">Oktober</option>
                                                        <option value="11">November</option>
                                                        <option value="12">Desember</option>
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label for="simple-select2">Tahun</label>
                                                    <input type="number" class="form-control" id="tahun" name="tahun" required onkeypress="return isNumberKey(event);">
                                                </div>
                                            </div>
                                            <div class="card-footer">
                                                <div class="btn-group btn-block" role="group" aria-label="Basic example">
                                                    <button type="submit" class="mb-1 btn btn-success" name="exportExcel">Export Excel</button>
                                                    <button type="submit" class="mb-1 btn btn-warning" name="exportPdf">Export PDF</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-md-6 col-sm-12">
                    <div class="shadow card">
                        <div class="card-header">
                            <a class="float-right small text-muted" href="{{ route('bahan.index') }}"></a>
                            <strong class="card-title">Log Aktifitas</strong>
                        </div>
                        <div class="card-body">
                            <div class="list-group list-group-flush my-n3">
                                @forelse ($laporanProduk as $laporan)
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            @if ($laporan->keterangan == 'Tambah Produk')
                                            <span class="fe fe-plus fe-24"></span>
                                            @elseif ($laporan->keterangan == 'Update Produk')
                                            <span class="fe fe-edit fe-24"></span>
                                            @elseif ($laporan->keterangan == 'Penambahan Stok Produk')
                                            <span class="fe fe-folder-plus fe-24"> {{ $laporan->jumlah }}</span>
                                            @elseif ($laporan->keterangan == 'Pengurangan Stok Produk')
                                            <span class="fe fe-folder-minus fe-24"> {{ $laporan->jumlah }}</span>
                                            @elseif ($laporan->keterangan == 'Produk Terjual')
                                            <span class="fe fe-shopping-cart fe-24"> {{ $laporan->jumlah }}</span>
                                            @else
                                            <span class="fe fe-x fe-24"></span>
                                            @endif
                                        </div>
                                        <div class="col">
                                            <small><strong>{{ $laporan->keterangan }}</strong></small>
                                            <div class="my-0 text-muted small">{{ $laporan->produk->nama }}</div>
                                        </div>
                                        <div class="mt-3 mt-sm-0 col-12 col-sm-auto">
                                            <small class="badge badge-pill badge-light text-muted">{{ \Carbon\Carbon::parse($laporan->created_at)->diffForHumans() }} {{ '@'.$laporan->user->name }}</small>
                                        </div>
                                    </div>
                                </div>
                                @empty
                                <div class="list-group-item">
                                    <div class="row align-items-center">
                                        <div class="col-12">
                                            <div class="text-center alert alert-warning">Data Log Kosong!</div>
                                        </div>
                                    </div>
                                </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script>
            $(document).ready(function () {
                $("#pengeluaranExcel").click(function (e) {
                    e.preventDefault();
                    $('#formPengeluaran').attr('action', '/laporan-bahan-baku/export-excel-pengeluaran');
                    $('#formPengeluaran').submit();
                });

                $("#pengeluaranPdf").click(function (e) {
                    e.preventDefault();
                    $('#formPengeluaran').attr('action', '/laporan-bahan-baku/export-pdf-pengeluaran');
                    $('#formPengeluaran').submit();
                });
            });
        </script>
    @endpush
</x-app-layout>
