<x-app-layout title="Tambah Barang Baku">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="page-title">Tambah Data</h2>
            <p class="text-muted">Tambah data barang baku pembuatan boneka.</p>

            <div class="mt-4 shadow card">
                <div class="card-header">
                    <strong class="card-title">Form Input</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('bahan.update', $bahanBaku->slug) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <x-input-label for="nama" value="Nama Barang" />
                                    <x-text-input for="nama" type="text" name="nama" :value="old('nama') ?? $bahanBaku->nama"/>
                                    <x-input-error record="nama" />
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="deskripsi" value="Deskripsi" />
                                    <textarea name="deskripsi" rows="10" class="form-control">{{ old('deskripsi') ?? $bahanBaku->deskripsi }}</textarea>
                                    <x-input-error record="deskripsi" />
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <x-input-label for="satuan" value="Satuan" />
                                    <select class="form-control @if($errors->has('satuan'))is-invalid @endif" name="satuan">
                                        <option value="0" disabled>..</option>
                                        <option value="Kilogram" @if ($bahanBaku->satuan == "Kilogram") selected @endif>Kilogram</option>
                                        <option value="Gram" @if ($bahanBaku->satuan == "Gram") selected @endif>Gram</option>
                                        <option value="Lusin" @if ($bahanBaku->satuan == "Lusin") selected @endif>Lusin</option>
                                    </select>
                                    <x-input-error record="satuan" class="d-block"/>
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="harga" value="Harga" />
                                    <div class="mb-3 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" for="basic-addon1">Rp</span>
                                        </div>
                                        <x-text-input for="format-rupiah" type="text" name="harga" :value="currency_IDR(old('harga') ?? $bahanBaku->harga)" />
                                        <x-input-error record="harga" />
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <a href="{{ route('bahan.index') }}" class="btn btn-warning"><i class="fe fe-arrow-left"></i> Kembali</a>
                                    <button type="submit" class="btn btn-primary">Ubah</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!-- .col-12 -->
    </div>
    @push('scripts')
        <script src="{{ asset('js/rupiahFormat.js') }}"></script>
    @endpush
</x-app-layout>
