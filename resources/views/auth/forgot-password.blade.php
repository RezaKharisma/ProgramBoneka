<x-login-layout title="Lupa Password">
    @section('style')
        <style>
            html, body {margin: 0; height: 100%; overflow: hidden}
        </style>
    @endsection

    <form class="mx-auto text-center col-lg-3 col-md-4 col-10" action="{{ route('password.email') }}" method="POST" >
        @csrf

        <img src="{{ asset('logo/'.getLogo()) }}" class="mb-3" alt="" style="max-height: 100px">
        <h2 class="mb-4">Lupa Password</h2>

        <p class="text-muted">Masukkan email kamu, nanti kami kirim email untuk melakukan reset password.</p>

        <div class="form-group">
            <x-input-label class="sr-only" for="email" value="Email" />
            <x-text-input id="email" type="email" name="email" :value="old('email')" autofocus placeholder="Email"/>
            <x-input-error record="email" />
        </div>
        <x-primary-button class="mb-4 btn-block" type="submit" id="btnReset">
            Reset Password
        </x-primary-button>

        <a href="{{ route('login') }}">
            Sudah Ingat?
        </a>

        <p class="mt-4 mb-3 text-muted">© 2023</p>
    </form>
    @push('script')
        <script>
            $("#btnReset").on('click', function(){
                Swal.fire({
                    title:"Proses",
                    text:"Mohon tunggu sebentar... Jangan refresh browser",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    icon: "warning"
                });
            });
        </script>
    @endpush
</x-login-layout>
