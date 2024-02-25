<x-app-layout title="Pages">
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
            <div class="my-4">

                @include('settings.partials.header')

                <h5 class="mt-5 mb-0">Sistem</h5>
                <p>Atur judul dan deskripsi sistem kamu.</p>

                <form method="POST" action="{{ route('page.update') }}">
                    @csrf
                    @method('PUT')

                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="shadow card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <x-input-label for="judul" value="Judul" />
                                        <x-text-input id="judul" name="judul" type="text" class="block w-full mt-1" placeholder="Judul Website" :value="old('judul') ?? $page->judul" />
                                        <x-input-error record="judul" class="mt-2" />
                                    </div>
                                    <div class="form-group">
                                        <x-input-label for="deskripsi" value="Deskripsi" />
                                        <textarea class="form-control @if($errors->has('deskripsi')) is-invalid @endif" name="deskripsi" id="deskripsi" rows="5" placeholder="Deskripsi">{{ old('deskripsi') ?? $page->deskripsi }}</textarea>
                                        <x-input-error record="deskripsi" class="mt-2" />
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <h5 class="mt-5 mb-0">Logo</h5>
                <p>Atur logo pada sistem. File harus berupa : ".jpg .jpeg .png"</p>

                <form method="POST" action="{{ route('page.updateLogo') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="shadow card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="text-center col-6 col-md-3">
                                            <img src="{{ asset('logo/'.getLogo()) }}" alt="..." class="crop-img" id="logoPreview"/>
                                        </div>
                                        <div class="mt-4 col-12 col-md-9 mt-sm-3 mt-md-0">
                                            <div class="mb-3 form-group">
                                                <div class="custom-file">
                                                    <label class="custom-file-label " for="customFile">Choose file</label>
                                                    <input type="file" class="custom-file-input" id="logo" name="logo">
                                                </div>
                                                @error('logo')
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

                <h5 class="mt-5 mb-0">Favicon</h5>
                <p>Logo pada tab website. File harus berupa : ".jpg .jpeg .png"</p>

                <form method="POST" action="{{ route('page.updateFavicon') }}" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="row align-items-center">
                        <div class="col-md-12">
                            <div class="shadow card">
                                <div class="card-body">
                                    <div class="row align-items-center">
                                        <div class="text-center col-6 col-md-3">
                                            <img src="{{ asset('logo/'.getFavicon()) }}" alt="..." class="crop-img" id="faviconPreview"/>
                                        </div>
                                        <div class="mt-4 col-12 col-md-9 mt-sm-3 mt-md-0">
                                            <div class="mb-3 form-group">
                                                <div class="custom-file">
                                                    <label class="custom-file-label " for="customFile">Choose file</label>
                                                    <input type="file" class="custom-file-input" id="favicon" name="favicon">
                                                </div>
                                                @error('favicon')
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
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
        $(document).ready(() => {
            $("#logo").change(function () {
                const file = this.files[0];
                console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $("#logoPreview").attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });

            $("#favicon").change(function () {
                const file = this.files[0];
                console.log(file);
                if (file) {
                    let reader = new FileReader();
                    reader.onload = function (event) {
                        $("#faviconPreview").attr("src", event.target.result);
                    };
                    reader.readAsDataURL(file);
                }
            });
        });
    </script>
    @endpush
</x-app-layout>
