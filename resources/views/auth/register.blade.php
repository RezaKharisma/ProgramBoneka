<x-login-layout title="Registrasi">
    @section('style')
        <style>
            html, body{
                overflow-x:hidden
            }
        </style>
    @endsection
    <form class="mx-auto col-lg-6 col-md-8 col-10" action="{{ route('register') }}" method="POST">
        @csrf

        <div class="text-center">
            <img src="{{ asset('logo/'.getLogo()) }}" class="mb-3" alt="" style="max-height: 100px"/>
            <h2 class="mb-4">Registrasi Akun</h2>
        </div>

        {{-- Nama --}}
        <div class="form-group">
            <x-input-label for="name" value="Nama" />
            <x-text-input id="name" type="text" name="name" :value="old('name')" class="form-control-lg" autofocus placeholder="Nama" />
            <x-input-error record="name" />
        </div>

        {{-- Email --}}
        <div class="form-row">
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" class="form-control-lg" placeholder="Email" />
            <x-input-error record="email" />
        </div>

        <hr class="my-4" />

        {{-- Password --}}
        <div class="mb-4 row">
            <div class="col-md-6">
                <div class="form-group">
                    <x-input-label for="password" value="Password" />
                    <x-text-input id="password" type="password" name="password" class="form-control-lg" placeholder="Password" />
                    <x-input-error record="password" />
                </div>
                <div class="form-group">
                    <x-input-label for="password_confirmation" value="Konfirmasi Password" />
                    <x-text-input id="password_confirmation" type="password" name="password_confirmation" class="form-control-lg" placeholder="Konfirmasi Password" />
                    <x-input-error record="password_confirmation" />
                </div>
            </div>
            <div class="col-md-6">
                <p class="mb-2">Syarat Password</p>
                <p class="mb-2 small text-muted">Untuk membuat password, kamu harus melengkapi persyaratan berikut:</p>
                <ul class="pl-4 mb-0 small text-muted">
                    <li>Minimal 8 karakter</li>
                    <li>Minimal Terdapat satu karakter spesial dan satu angka</li>
                </ul>
            </div>
        </div>

        <x-primary-button class="mb-4 btn-block" type="submit">
            Registrasi
        </x-primary-button>

        <a href="{{ route('login') }}" class="d-flex justify-content-center">
            Kembali Ke Login
        </a>

        <p class="mt-4 mb-3 text-center text-muted">© 2023</p>
    </form>
</x-login-layout>
