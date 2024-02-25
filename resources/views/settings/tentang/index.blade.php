<x-app-layout title="Tentang">
    <div class="row justify-content-center">
        <div class="col-10 col-lg-10 col-xl-10">
            <h2 class="mb-4 h3 page-title">Settings</h2>
            <div class="my-4">

                @include('settings.partials.header')

                <h5 class="mt-5 mb-0">Tentang Perusahaan</h5>
                <p>Atur data tentang perusahaan kamu.</p>
                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="shadow card">
                                <form action="{{ route('tentang.update', $tentang->id) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="card-body">
                                        <div class="form-group">
                                            <x-input-label for="nama" value="Nama" require/>
                                            <x-text-input id="nama" name="nama" type="text" class="block w-full mt-1" placeholder="Nama" :value="old('nama') ?? $tentang->nama" required/>
                                            <x-input-error record="judul" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <x-input-label for="alamat" value="Alamat" require/>
                                            <textarea class="form-control @if($errors->has('alamat')) is-invalid @endif" name="alamat" id="alamat" rows="5" placeholder="Alamat" required>{{ old('alamat') ?? $tentang->alamat }}</textarea>
                                            <x-input-error record="deskripsi" class="mt-2" />
                                        </div>
                                        <div class="form-group">
                                            <x-input-label for="deskripsi" value="Deksipsi" require/>
                                            <textarea class="form-control @if($errors->has('deskripsi')) is-invalid @endif" name="deskripsi" id="deskripsi" rows="5" placeholder="Deskripsi" required>{{ old('deskripsi') ?? $tentang->deskripsi }}</textarea>
                                            <x-input-error record="deskripsi" class="mt-2" />
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <x-input-label for="no_tlp1" value="Nomor Telepon 1" require/>
                                                <div class="mb-1 input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">+62</span>
                                                    </div>
                                                    <x-text-input id="no_tlp1" name="no_tlp1" type="number" placeholder="Nomor Telepon 1" :value="old('no_tlp1') ?? $tentang->no_tlp1" required/>
                                                    <x-input-error record="no_tlp1" class="mt-2" />
                                                </div>
                                            </div>
                                            <div class="form-group col-md-6">
                                                <x-input-label for="no_tlp2" value="Nomor Telepon 2"/>
                                                <div class="mb-1 input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text" id="basic-addon1">+62</span>
                                                    </div>
                                                    <x-text-input id="no_tlp2" name="no_tlp2" type="number" placeholder="Nomor Telepon 2" :value="old('no_tlp2') ?? $tentang->no_tlp2" />
                                                    <x-input-error record="no_tlp2" class="mt-2" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-6">
                                                <x-input-label for="email1" value="Email 1" require/>
                                                <x-text-input id="email1" name="email1" type="email" class="block w-full mt-1" placeholder="Email 1" :value="old('email1') ?? $tentang->email1" required/>
                                                <x-input-error record="email1" class="mt-2" />
                                            </div>
                                            <div class="form-group col-md-6">
                                                <x-input-label for="email2" value="Email 2"/>
                                                <x-text-input id="email2" name="email2" type="email" class="block w-full mt-1" placeholder="Email 2" :value="old('email2') ?? $tentang->email2" />
                                                <x-input-error record="email2" class="mt-2" />
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <x-input-label for="facebook" value="Facebook"/>
                                                <x-text-input id="facebook" name="facebook" type="text" class="block w-full mt-1" placeholder="https://" :value="old('facebook') ?? $tentang->facebook" />
                                                <x-input-error record="facebook" class="mt-2" />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <x-input-label for="instagram" value="Instagram"/>
                                                <x-text-input id="instagram" name="instagram" type="text" class="block w-full mt-1" placeholder="https://" :value="old('instagram') ?? $tentang->instagram" />
                                                <x-input-error record="instagram" class="mt-2" />
                                            </div>
                                            <div class="form-group col-md-4">
                                                <x-input-label for="x" value="X | Twitter"/>
                                                <x-text-input id="x" name="x" type="text" class="block w-full mt-1" placeholder="https://" :value="old('x') ?? $tentang->x" />
                                                <x-input-error record="x" class="mt-2" />
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>

    @push('scripts')
    @endpush
</x-app-layout>
