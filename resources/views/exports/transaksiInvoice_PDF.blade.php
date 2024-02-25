<html lang="en">
    <head>
        <meta charset="UTF-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta http-equiv="X-UA-Compatible" content="ie=edge" />
        <title>Data Invoice Transaksi</title>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous" />
        <style type="text/css">
            table tr td,
            table tr th {
                /* font-size: 12pt; */
            }
        </style>
    </head>
    <body>
        <div class="p-3">
            <div class="mb-2 row">
                <div class="mb-5 text-center col-12">
                    <img src="{{ $logo }}" class="mx-auto mb-4 navbar-brand-img" width="50px" alt="..." />
                    <h2 class="mb-0 text-uppercase">Invoice</h2>
                    <p class="text-muted">
                        {{ getNamaPerusahaan() }}<br />
                        {{ getAlamatPerusahaan() }}
                    </p>
                </div>
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 60%">
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
                                <strong>{{ $transaksi['invoice'] }}</strong>
                            </p>
                        </td>
                        <td>
                            <p class="mb-2 small text-muted text-uppercase">Invoice to</p>
                            <p class="mb-4">
                                <strong>{{ $transaksi['nama_customer'] }}</strong><br />
                                {{ $transaksi['email'] }}<br />
                                (+62) {{ $transaksi['no_telp'] }}<br />
                                {{ $transaksi['alamat'] }}<br />
                            </p>
                            <p>
                                <small class="small text-muted text-uppercase">Tanggal</small><br />
                                <strong>{{ Carbon\Carbon::parse($transaksi['created_at'])->format('d F Y') }}</strong>
                            </p>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /.row -->
            <table class="table table-striped">
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
                <table class="table table-borderless">
                    <tr>
                        <td style="width: 60%">
                            <p class="text-muted small"><strong>Catatan :</strong> Barang yang sudah dibeli tidak bisa dikembalikan.</p>
                        </td>
                        <td>
                            <div class="mr-2 text-right">
                                <p class="mb-2 h6">
                                    <span class="small text-muted text-uppercase">Subtotal : </span>
                                    <strong>Rp. {{ currency_IDR($item->total) }}</strong>
                                </p>
                                <p class="mb-2 h6">
                                    <span class="small text-muted text-uppercase">Diskon : </span>
                                    <strong>0</strong>
                                </p>
                                <p class="mb-2 h6">
                                    <span class="small text-muted text-uppercase">Total : </span>
                                    <strong>Rp. {{ currency_IDR($item->total) }}</strong>
                                </p>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <!-- /.row -->
        </div>
    </body>
</html>
