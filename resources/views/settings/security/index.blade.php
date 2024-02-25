<x-app-layout title="Security">
    <div class="row justify-content-center">
        <div class="col-10 col-lg-10 col-xl-10">
            <h2 class="mb-4 h3 page-title">Settings</h2>
            <div class="my-4">

                @include('settings.partials.header')

                <h5 class="mt-5 mb-0">Ubah Password</h5>
                <p>Pastikan password kamu aman dengan update berkala.</p>

                <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
                    @csrf
                    @method('put')

                    <div class="row">
                        <div class="col-md-12">
                            <div class="mb-4 shadow card">
                                <div class="card-body">
                                    <div class="form-group">
                                        <x-input-label for="current_password" value="Password Anda" />
                                        <x-text-input id="current_password" name="current_password" type="password" class="block w-full mt-1" autocomplete="current-password" placeholder="Password Anda" />
                                        <x-input-error record="current_password" class="mt-2" />
                                    </div>
                                    <hr class="mt-4 mb-4">
                                    <div class="form-group">
                                        <x-input-label for="password" value="Password Baru" />
                                        <x-text-input id="password" name="password" type="password" class="block w-full mt-1" autocomplete="new-password" placeholder="Password Baru" />
                                        <x-input-error record="password" class="mt-2" />
                                    </div>
                                    <div class="form-group">
                                        <x-input-label for="password_confirmation" value="Konfirmasi  Password" />
                                        <x-text-input id="password_confirmation" name="password_confirmation" type="password" class="block w-full mt-1" autocomplete="new-password" placeholder="Konfirmasi Password"/>
                                        <x-input-error record="password_confirmation" class="mt-2" />
                                    </div>
                                </div>
                                <div class="card-footer">
                                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
