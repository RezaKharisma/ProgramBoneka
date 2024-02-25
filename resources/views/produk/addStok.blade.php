<x-app-layout title="Tambah Stok Produk">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="page-title">Tambah Stok Produk</h2>
            <p class="text-muted">Tambah stok pada produk.</p>
            <div class="card-deck">
                <div class="mb-4 shadow card">
                    <div class="card-header">
                        <strong class="card-title">Form Tambah Stok</strong>
                    </div>
                    <div class="card-body">
                        <form method="POST" action="{{ route('produk.updateStok', $produk->kode_produk) }}">
                            @csrf
                            @method('PUT')
                            <div class="form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Kode Produk</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email" value="{{ $produk->kode_produk }}" readonly/>
                                </div>
                            </div>
                            <div class="mb-4 form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Nama Produk</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email" value="{{ $produk->nama }}" readonly/>
                                </div>
                            </div>
                            <div class="mb-4 form-group row">
                                <label for="inputEmail3" class="col-sm-3 col-form-label">Stok Produk</label>
                                <div class="col-sm-9">
                                    <input type="email" class="form-control" id="inputEmail3" placeholder="Email" value="{{ $produk->stok }}" readonly/>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12 col-sm-6 col-md-6">
                                    <label for="inputEmail3" class="form-label">Bahan Baku Produk</label>
                                    <table class="table mt-3 mb-3 text-justify table-striped" id="tabelBahanBaku">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Bahan Baku</th>
                                                <th>Jumlah Digunakan</th>
                                                <th>Harga Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($bahanProduk as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $item['nama'] }}</td>
                                                    <td><span class="jumlahBahanProduk">{{ $item['jumlah'] }}</span> {{ $item['satuan'] }}</td>
                                                    <td>Rp. {{ currency_IDR($item['harga_total']) }}</td>
                                                </tr>
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                                <div class="col-12 col-sm-6 col-md-6">
                                    <label for="inputEmail3" class="form-label">Stok Bahan Baku</label>
                                    <table class="table mt-3 mb-3 text-justify table-striped" id="tabelBahanBaku">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nama Bahan Baku</th>
                                                <th>Jumlah Tersisa</th>
                                                <th>Harga</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $no = 1;
                                            @endphp
                                            @foreach ($storeBahanBaku as $item)
                                                <tr>
                                                    <td>{{ $no }}</td>
                                                    <td>{{ $item['nama'] }}</td>
                                                    <td><span class="stokBahanProduk">{{ $item['stok'] }}</span> {{ $item['satuan'] }}</td>
                                                    <td>Rp. {{ currency_IDR($item['harga']) }}</td>
                                                </tr>
                                                @php
                                                    $no++;
                                                @endphp
                                            @endforeach
                                        </tbody>
                                    </table>
                                    <div class="d-block p">
                                        <span style="color: red"></span>
                                    </div>
                                </div>
                            </div>
                            @error('stok')
                            <div class="alert alert-warning" role="alert">
                                <span class="mr-2 fe fe-alert-triangle fe-16"></span> Stok tidak mencukupi dengan jumlah yang ditentukan.
                            </div>
                            @enderror
                            <div class="mt-4 mb-3 form-group row">
                                <x-input-label for="stok" value="Jumlah Produksi" class="col-sm-3 col-form-label" />
                                <div class="col-sm-9">
                                    <x-text-input for="stok" type="number" min="0" name="stok" id="jumlahProduksi" :value="old('stok')" class="mb-2" required onkeypress="return isNumberKey(event);" />
                                    {{-- <x-input-error record="stok" />     --}}
                                    <span class="help-block"><small>Jumlah bahan baku yang digunakan akan dikalikan jumlah produksi.</small></span>
                                </div>
                            </div>
                            <div class="mt-5 mb-2 form-group">
                                <button type="submit" class="btn btn-primary">Tambah Stok</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
