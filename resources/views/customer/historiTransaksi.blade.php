<x-app-layout title="Histori Transaksi">
    <div class="row justify-content-center">
        <div class="mb-4 col-12">
            <div class="shadow card">
                <div class="card-header">
                    <strong class="card-title">Transaksi Terbaru</strong>
                </div>
                <div class="card-body my-n2">
                    <table class="table datatables nowrap table-hover" id="terbaru">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
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
                            @forelse ($transaksiTerbaru as $item)
                            <tr>
                                <td>{{ $no }}</td>
                                <td>
                                    {{ $item->invoice }} <br/>
                                    <div class="my-0 text-muted small">Tanggal : {{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</div>
                                </td>
                                <td>
                                    <ol>
                                        @foreach ($detailTransaksi as $dt)
                                            @if ($dt->id_transaksi == $item->id)
                                            <li style="margin-left: -25px;">{{ $dt->produk->nama }} ({{ $dt->jumlah }})</li>
                                            @endif
                                        @endforeach
                                    </ol>
                                </td>
                                <td>Rp. {{ currency_IDR($item->total) }}</td>
                                <td>
                                    @if ($item->status == "Pending")
                                    <span class="badge badge-warning">{{ $item->status }}</span>
                                    @elseif ($item->status == 'Pembayaran')
                                    <span class="badge badge-primary">{{ $item->status }}</span>
                                    @elseif ($item->status == 'Proses')
                                    <span class="badge badge-info">{{ $item->status }}</span>
                                    @endif
                                </td>
                                <td>
                                    <a class="mb-1 btn btn-info btn-sm" href="{{ route('histori-transaksi.invoice', $item->invoice) }}">View</a>
                                </td>
                            </tr>
                            @php
                                $no++;
                            @endphp
                            @empty
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

        <div class="mb-4 col-12">
            <div class="shadow card">
                <div class="card-header">
                    <strong class="card-title">Transaksi Selesai</strong>
                </div>
                <div class="card-body my-n2">
                    <table class="table datatables nowrap table-hover" id="histori">
                        <thead class="thead-dark">
                            <tr>
                                <th>#</th>
                                <th>Invoice</th>
                                <th>Produk</th>
                                <th>Tanggal</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                            $no = 1;
                        @endphp
                        @forelse ($transaksiSelesai as $item)
                        <tr>
                            <td>{{ $no }}</td>
                            <td>{{ $item->invoice }}</td>
                            <td>
                                <ol>
                                    @foreach ($detailTransaksi as $dt)
                                    @if ($dt->id_transaksi == $item->id)
                                    <li style="margin-left: -25px;">{{ $dt->produk->nama }} ({{ $dt->jumlah }})</li>
                                    @endif
                                    @endforeach
                                </ol>
                            </td>
                            <td>
                                <div class="my-0 small">Tanggal Transaksi: {{ Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y') }}</div>
                                <div class="my-0 small">Tanggal Transaksi Selesai: {{ Carbon\Carbon::parse($item->updated_at)->translatedFormat('d F Y') }}</div>
                            </td>
                            <td>Rp. {{ currency_IDR($item->total) }}</td>
                            <td>
                                @if ($item->status == "Selesai")
                                <span class="badge badge-success">{{ $item->status }}</span>
                                @elseif ($item->status == 'Batal')
                                <span class="badge badge-danger">{{ $item->status }}</span>
                                @endif
                            </td>
                            <td>
                                <a class="mb-1 btn btn-info btn-sm" href="{{ route('histori-transaksi.invoice', $item->invoice) }}">View</a>
                            </td>
                        </tr>
                        @php
                            $no++;
                        @endphp
                        @empty
                        <tr>
                            <td colspan="8" align="center">
                                <div class="mb-0 alert alert-warning">Belum Ada Transaksi Selesai.</div>
                            </td>
                        </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(function () {
            $("#terbaru").DataTable({
                autoWidth: true,
                columns: [null, null, null, null, null, { searchable: false, orderable: false }],
            });
        });
        $(document).ready(function () {
            $("#histori").DataTable({
                autoWidth: true,
                columns: [null, null, { orderable: false }, null, null, { searchable: false, orderable: false }],
            });
        });
    </script>
    @endpush
</x-app-layout>
