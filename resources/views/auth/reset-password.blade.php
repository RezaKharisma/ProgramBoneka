<x-login-layout>
    @section('style')
    <style>
        html, body{
            overflow-x:hidden
        }
    </style>
    @endsection

    <form class="mx-auto col-lg-6 col-md-8 col-10" method="POST" action="{{ route('password.store') }}">
        @csrf

        <div class="text-center">
            <img src="{{ asset('logo/'.getLogo()) }}" class="mb-3" alt="" style="max-height: 100px"/>
            <h2 class="mb-4">Reset Password</h2>
        </div>

        <!-- Password Reset Token -->
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        <!-- Email Address -->
        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="block w-full mt-1" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username"/>
            <x-input-error record="email" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="block w-full mt-1" type="password" name="password" required autocomplete="new-password" />
            <x-input-error record="password" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" value="Confirm Password" />

            <x-text-input id="password_confirmation" class="block w-full mt-1"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

            <x-input-error record="password_confirmation" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button>
                {{ __('Reset Password') }}
            </x-primary-button>
        </div>
    </form>
</x-login-layout>
