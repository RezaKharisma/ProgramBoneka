<x-app-layout title="Edit User">
    <div class="row justify-content-center">
        <div class="col-12">
            <h2 class="page-title">Tambah Data</h2>
            <p class="text-muted">Tambah data barang baku pembuatan boneka.</p>

            <div class="mt-4 shadow card">
                <div class="card-header">
                    <strong class="card-title">Form Input</strong>
                </div>
                <div class="card-body">
                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <x-input-label for="name" value="Nama Lengkap" />
                                    <x-text-input id="name" type="text" name="name" :value="old('name') ?? $user->name" placeholder="Nama Lengkap" readonly/>
                                    <x-input-error record="name" />
                                </div>
                                <div class="form-group">
                                    <x-input-label for="email" value="Email" />
                                    <x-text-input id="email" type="email" name="email" :value="old('email') ?? $user->email" placeholder="Email" readonly/>
                                    <x-input-error record="email" />
                                </div>
                                <div class="form-group">
                                    <x-input-label for="alamat" value="Alamat" />
                                    <textarea class="form-control" name="alamat" id="alamat" rows="5" placeholder="Alamat" readonly>{{ old('alamat') ?? $user->alamat }}</textarea>
                                    <x-input-error record="alamat" />
                                </div>
                                <div class="form-group">
                                    <x-input-label for="no_telp" value="Nomor Telepon" />
                                    <x-text-input id="no_telp" type="number" name="no_telp" :value="old('no_telp') ?? $user->no_telp" placeholder="Nomor Telepon" readonly/>
                                    <x-input-error record="no_telp" />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3 form-group">
                                    <label for="example-select">Role</label>
                                    <select class="form-control" id="example-select" name="role">
                                        <option value="Staff" @if ($user->role == "Staff") selected @endif>Staff</option>
                                        <option value="Customer" @if ($user->role == "Customer") selected @endif>Customer</option>
                                    </select>
                                </div>
                                <div class="mt-4">
                                    <a href="{{ route('user.index') }}" class="btn btn-warning"><i class="fe fe-arrow-left"></i> Kembali</a>
                                    <button type="reset" class="btn btn-secondary">Reset</button>
                                    <button type="submit" class="btn btn-primary">Simpan</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
