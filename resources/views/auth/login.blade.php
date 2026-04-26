<x-guest-layout>
    <div data-theme="tailwind">
        <!-- Session Status -->
        <x-app.auth-session-status class="mb-4" :status="session('status')" />

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div>
                <x-app.application-logo class="block mx-auto mt-2 mb-5"/>
                <p class="block w-min mx-auto px-3 py-1 mb-3 rounded-xl bg-success text-white font-bold text-[16px]">{{ env('APP_NAME') }}</p>
                <p class="text-center font-semibold text-[#12233D]">{{ env('APP_DESC') }}</p>
            </div>

            <!-- Correo Electrónico -->
            <div>
                <x-input.text label="Email:" id="email" class="mt-1" type="email"
                    name="email" autofocus required autocomplete="username" :errorMessages="$errors->get('email')">

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

                <x-input.text label="Password:" id="password" class="mt-1"
                    type="password" name="password" required autocomplete="current-password" :errorMessages="$errors->get('password')">

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

            <div class="mt-4">
                <button type="submit" class="btn btn-primary block w-full mb-5"><span class="relative -top-2.5 sm:top-0!">{{ __('Log In') }}</span></button>
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
                        <style>
                            .alert-title {
                                color: oklch(44.4% .177 26.899) !important;
                            }
                        </style>
                    @endforeach
                @endif
            </div>
        </form>

        <style>
            .text-error {
                top: 50px;
            }
        </style>
    </div>
</x-guest-layout>
