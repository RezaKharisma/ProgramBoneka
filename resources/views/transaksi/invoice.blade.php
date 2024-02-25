<x-app-layout title="Invoice">
    <div class="row justify-content-center">
    <div class="col-12 col-lg-10 col-xl-8">
        <div class="mb-4 row align-items-center">
            <div class="col">
                <h2 class="h5 page-title">
                    <small class="text-muted text-uppercase">Invoice</small><br />
                    {{ $transaksi->invoice }}
                </h2>
            </div>
            <div class="col-auto">
                <a href="{{ route('transaksi.exportPdf', $transaksi->invoice) }}" class="btn btn-warning" target="_blank">Print</a>
            </div>
        </div>
        <div class="shadow card">
            <div class="p-5 card-body">
                <div class="mb-5 row">
                    <div class="mb-4 text-center col-12">
                        <img src="{{ asset('logo/'.getLogo()) }}" class="mx-auto mb-4 navbar-brand-img" width="50px" alt="..." />
                        <h2 class="mb-0 text-uppercase">Invoice</h2>
                        <p class="text-muted">
                            {{ getNamaPerusahaan() }}<br />
                            {{ getAlamatPerusahaan() }}
                        </p>
                    </div>
                    <div class="col-md-7">
                        <p class="mb-2 small text-muted text-uppercase">Invoice from</p>
                        <p class="mb-4">
                            <strong>{{ getUsers($transaksi->id_user)->name }}</strong><br />
                            {{ getNamaPerusahaan() }}<br />
                            {{ getEmailPerusahaan(1) }}<br />
                            {{ getAlamatPerusahaan() }}<br/>
                            {{ getNoTelp(1) }}<br />
                        </p>
                        <p>
                            <span class="small text-muted text-uppercase">Invoice #</span><br />
                            <strong>{{ $transaksi->invoice }}</strong>
                        </p>
                    </div>
                    <div class="col-md-5">
                        <p class="mb-2 small text-muted text-uppercase">Invoice to</p>
                        <p class="mb-4">
                            <strong>{{ $transaksi->nama_customer }}</strong><br />
                            {{ $transaksi->email }}<br />
                            (+62) {{ $transaksi->no_telp }}<br />
                            {{ $transaksi->alamat }}<br />
                        </p>
                        <p>
                            <small class="small text-muted text-uppercase">Tanggal</small><br />
                            <strong>{{ Carbon\Carbon::parse($transaksi->created_at)->format('d F Y') }}</strong>
                        </p>
                    </div>
                </div>
                <!-- /.row -->
                <table class="table table-borderless table-striped">
                    <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Produk</th>
                            <th scope="col" class="text-right">Harga</th>
                            <th scope="col" class="text-right">Jumlah</th>
                            <th scope="col" class="text-right">Total</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $no = 1;
                        @endphp
                        @foreach ($detailTransaksi as $item)
                        <tr>
                            <th scope="row">{{ $no }}</th>
                            <td>
                                [{{ $item->produk->kode_produk }}] {{ $item->produk->nama }}<br />
                                <span class="small text-muted">{{ $item->produk->deskripsi }}</span>
                            </td>
                            <td class="text-right">Rp. {{ currency_IDR($item->produk->harga_jual) }}</td>
                            <td class="text-right">{{ $item->jumlah }}</td>
                            <td class="text-right">Rp. {{ currency_IDR($item->total) }}</td>
                        </tr>
                        @php
                            $no++;
                        @endphp
                        @endforeach
                    </tbody>
                </table>
                <div class="mt-5 row">
                    <div class="text-center col-2">
                        <img src="./assets/images/qrcode.svg" class="mx-auto my-4 navbar-brand-img brand-sm" alt="..." />
                    </div>
                    <div class="col-md-5">
                        <p class="text-muted small"><strong>Catatan :</strong> Barang yang sudah dibeli tidak bisa dikembalikan.</p>
                    </div>
                    <div class="col-md-5">
                        <div class="mr-2 text-right">
                            <p class="mb-2 h6">
                                <span class="text-muted">Subtotal : </span>
                                <strong>Rp. {{ currency_IDR($item->total) }}</strong>
                            </p>
                            <p class="mb-2 h6">
                                <span class="text-muted">Diskon : </span>
                                <strong>0</strong>
                            </p>
                            <p class="mb-2 h6">
                                <span class="text-muted">Total : </span>
                                <span>Rp. {{ currency_IDR($item->total) }}</span>
                            </p>
                        </div>
                    </div>
                </div>
                <!-- /.row -->
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    </div>
</x-app-layout>
