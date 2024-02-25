<x-login-layout title="Login">
    @section('style')
        <style>
            html, body {margin: 0; height: 100%; overflow: hidden}
        </style>
    @endsection

    <form class="mx-auto text-center col-lg-3 col-md-4 col-10" method="POST" action="{{ route('login') }}">
        @csrf

        <img src="{{ asset('logo/'.getLogo()) }}" class="mb-3" alt="" style="max-height: 100px">
        <h2 class="mb-4">Silakan login</h2>

        <x-alert type="success" />

        {{-- Email --}}
        <div class="form-group">
            <x-input-label class="sr-only" for="email" value="Email" />
            <x-text-input for="email" type="email" name="email" :value="old('email')" class="form-control-lg" autofocus placeholder="Email"/>
            <x-input-error record="email" />
        </div>

        {{-- Password --}}
        <div class="form-group">
            <x-input-label class="sr-only" for="password" value="Password" />
            <x-text-input for="password" type="password" name="password" :value="old('password')" class="form-control-lg" placeholder="Password"/>
            <x-input-error record="password" />
        </div>

        <x-primary-button class="mb-4 btn-block">
            Masuk
        </x-primary-button>

        <div>
            <a href="{{ route('register') }}">
                Buat Akun Baru
            </a>

            <p class="mt-4 mb-3 ml-1 mr-1 text-muted d-inline">|</p>

            <a href="{{ route('password.request') }}">
                Lupa Password?
            </a>
        </div>

        <p class="mt-4 mb-5 text-muted">© 2023</p>
    </form>
</x-login-layout>
