<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Test Credentials Info -->
    <div class="mb-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <h3 class="text-lg font-medium text-blue-900 mb-2">Test Credentials</h3>
        <div class="text-sm text-blue-800">
            <div class="mb-2">
                <p><strong>Admin Account:</strong></p>
                <p>Email: admin@ecommerce.com</p>
                <p>Password: password</p>
                <button type="button" onclick="fillAdmin()" class="mt-1 px-3 py-1 bg-blue-600 text-white text-xs rounded hover:bg-blue-700">Use Admin Credentials</button>
            </div>
            <div>
                <p><strong>Customer Account:</strong></p>
                <p>Email: customer@test.com</p>
                <p>Password: password</p>
                <button type="button" onclick="fillCustomer()" class="mt-1 px-3 py-1 bg-green-600 text-white text-xs rounded hover:bg-green-700">Use Customer Credentials</button>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <script>
        function fillAdmin() {
            document.getElementById('email').value = 'admin@ecommerce.com';
            document.getElementById('password').value = 'password';
        }

        function fillCustomer() {
            document.getElementById('email').value = 'customer@test.com';
            document.getElementById('password').value = 'password';
        }
    </script>
</x-guest-layout>
