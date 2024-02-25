<x-app-layout title="Tambah Barang Baku">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="page-title">Tambah Data</h2>
            <p class="text-muted">Tambah data bahan baku.</p>

            <div class="mt-4 shadow card">
                <div class="card-header">
                    <strong class="card-title">Form Input</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('bahan.save') }}" method="POST">
                    <div class="row">
                            @csrf
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <x-input-label for="nama" value="Nama Barang" />
                                    <x-text-input for="nama" type="text" name="nama" :value="old('nama')" autofocus required/>
                                    <x-input-error record="nama" />
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="deskripsi" value="Deskripsi" />
                                    <textarea name="deskripsi" rows="10" class="form-control">{{ old('deskripsi') }}</textarea>
                                    <x-input-error record="deskripsi" />
                                </div>
                            </div>
                            <!-- /.col -->
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <x-input-label for="satuan" value="Satuan" />
                                    <select class="form-control @if($errors->has('satuan'))is-invalid @endif" name="satuan" required>
                                        <option value="0" disabled selected>...</option>
                                        <option value="Kilogram">Kilogram</option>
                                        <option value="Gram">Gram</option>
                                        <option value="Lusin">Lusin</option>
                                    </select>
                                    <x-input-error record="satuan" class="d-block"/>
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="stok" value="Stok" />
                                    <x-text-input for="stok" type="number" name="stok" :value="old('stok')" required min="0" onkeypress="return isNumberKey(event);"/>
                                    <x-input-error record="stok" />
                                </div>
                                <div class="mb-3 form-group">
                                    <x-input-label for="harga" value="Harga" />
                                    <div class="mb-1 input-group">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text" id="basic-addon1">Rp</span>
                                        </div>
                                        <x-text-input for="harga" id="format-rupiah" type="text" name="harga" :value="currency_IDR(old('harga'))" required/>
                                        <x-input-error record="harga" />
                                    </div>
                                    <span class="mt-0 help-block"><small>Input harga per satuan.</small></span>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('bahan.index') }}" class="btn btn-warning"><i class="fe fe-arrow-left"></i> Kembali</a>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
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
