<x-guest-layout>
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- CAPTCHA -->
        <div class="mt-4">
            <x-input-label for="captcha" :value="__('Captcha')" />
            <div class="mt-2 flex items-center">
                <img src="{{ captcha_src() }}" id="captcha-img" class="rounded-lg border" alt="captcha">
                <button type="button" id="refresh-captcha" class="ml-2 text-sm text-indigo-600">⟳ Refresh</button>
            </div>
            <x-text-input id="captcha" class="block mt-1 w-full" type="text" name="captcha" required />
            <x-input-error :messages="$errors->get('captcha')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <!-- Tombol Login -->
        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        document.getElementById("refresh-captcha").addEventListener("click", function (event) {
            event.preventDefault(); // Mencegah reload halaman

            fetch('/captcha/reload')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('captcha-img').src = data.captcha + '?' + new Date().getTime();
                })
                .catch(error => console.error('Error:', error));
        });
    });
</script>
