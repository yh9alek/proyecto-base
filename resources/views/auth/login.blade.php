<x-guest-layout>

    <!-- Session Status -->
    <x-app.auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Correo Electrónico -->
        <div>
            <x-input.text label="Email:" id="email" class="mt-1 border border-base-350" type="email"
                name="email" :value="old('email')" autofocus required autocomplete="username" :errors="$errors->get('email')">

                <x-slot:iconLeft>
                    <svg class="h-[1em] opacity-75" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                        </g>
                    </svg>
                </x-slot:iconLeft>

            </x-input.text>
        </div>

        <!-- Password -->
        <div class="mt-2">

            <x-input.text label="Password:" id="password" class="mt-1 border border-base-350"
                type="password" name="password" required autocomplete="current-password" :errors="$errors->get('password')">

                <x-slot:iconLeft>
                    <svg class="h-[1em] opacity-75" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                            stroke="currentColor">
                            <path
                                d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z">
                            </path>
                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                        </g>
                    </svg>
                </x-slot:iconLeft>

            </x-input.text>

        </div>

        <!-- Remember Me -->
        <div class="block mt-6">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded-sm border-gray-300 text-indigo-600 shadow-xs focus:ring-indigo-500" name="remember">
                <span class="ms-2 text-sm">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-neutral block w-full mb-5">{{ __('Log In') }}</button>
            @if ($errors->get('auth'))
                @foreach ($errors->get('auth') as $error)
                    <x-alert type="error" title="{{ $error }}">
                        <x-slot name="icon">
                            <svg viewBox="0 0 20 20" fill="currentColor" data-slot="icon" aria-hidden="true"
                                class="kma kmt">
                                <path
                                    d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM8.28 7.22a.75.75 0 0 0-1.06 1.06L8.94 10l-1.72 1.72a.75.75 0 1 0 1.06 1.06L10 11.06l1.72 1.72a.75.75 0 1 0 1.06-1.06L11.06 10l1.72-1.72a.75.75 0 0 0-1.06-1.06L10 8.94 8.28 7.22Z"
                                    clip-rule="evenodd" fill-rule="evenodd"></path>
                            </svg>
                        </x-slot>
                    </x-alert>
                @endforeach
            @endif
        </div>
    </form>
</x-guest-layout>
