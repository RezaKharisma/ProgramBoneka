<x-app-layout title="Profile">
    @section('style')
    <style>
        .crop-img {
            width: 150px;
            height: auto;
            object-fit: cover;
        }
    </style>
    @endsection

    <div class="row justify-content-center">
        <div class="col-10 col-lg-10 col-xl-10">
            <h2 class="mb-4 h3 page-title">Settings</h2>

            @include('settings.partials.header')

            <form method="POST" action="{{ route('profile.updatePhoto') }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="mt-5 row align-items-center">
                    <div class="col-md-12">
                        <div class="shadow card">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="text-center col-6 col-md-3">
                                        @if (Auth()->user()->foto)
                                        <img src="{{ asset('profile_photo/'.Auth()->user()->foto) }}" alt="..." class="crop-img" id="imgPreview" />
                                        @else
                                        <img src="{{ asset('profile_photo/default.png') }}" alt="..." class="crop-img" id="imgPreview" />
                                        @endif
                                    </div>
                                    <div class="mt-4 col-12 col-md-9 mt-sm-3 mt-md-0">
                                        <div class="mb-3 form-group">
                                            <label for="customFile">Foto</label>
                                            <div class="custom-file">
                                                <label class="custom-file-label" for="customFile">Choose file</label>
                                                <input type="file" class="custom-file-input" id="foto" name="foto" />
                                            </div>
                                            @error('foto')
                                                <div class="invalid-feedback d-block">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                        <a href="{{ route('profile.index') }}" class="btn btn-secondary">Reset</a>
                                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <form method="POST" action="{{ route('profile.update') }}">
                @csrf @method('PUT')

                <hr class="my-4" />
                <div class="form-group">
                    <x-input-label for="name" value="Nama Lengkap" require />
                    <x-text-input id="name" type="text" name="name" :value="old('name') ?? $user->name" placeholder="Nama Lengkap" />
                    <x-input-error record="name" />
                </div>
                <div class="form-group">
                    <x-input-label for="email" value="Email" require />
                    <x-text-input id="email" type="email" name="email" :value="old('email') ?? $user->email" placeholder="Email" />
                    <x-input-error record="email" />
                </div>
                <div class="form-group">
                    <x-input-label for="alamat" value="Alamat" />
                    <textarea class="form-control" name="alamat" id="alamat" rows="5" placeholder="Alamat">{{ old('alamat') ?? $user->alamat }}</textarea>
                    <x-input-error record="alamat" />
                </div>
                <div class="form-group">
                    <x-input-label for="no_telp" value="Nomor Telepon" require />
                    <x-text-input id="no_telp" type="number" name="no_telp" :value="old('no_telp') ?? $user->no_telp" placeholder="Nomor Telepon" />
                    <x-input-error record="no_telp" />
                </div>
                <button type="submit" class="mt-3 btn btn-primary">Simpan Perubahan</button>
            </form>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(() => {
            $("#foto").change(function () {
                const file = this.files[0];
                console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $("#imgPreview").attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
