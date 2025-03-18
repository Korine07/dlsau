<x-guest-layout>
    <x-authentication-card>
        <x-slot name="logo">
            <x-authentication-card-logo />
        </x-slot>

        <div class="text-center">
            <h2 class="text-xl font-semibold text-gray-800">{{ __('Verify Your Email Address') }}</h2>
            <p class="mt-2 text-sm text-gray-600">
                {{ __('Before proceeding, please check your email for a verification link. If you did not receive the email, click below to resend.') }}
            </p>
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mt-4 p-3 bg-green-100 border border-green-300 rounded-md text-green-700 text-sm text-center">
                {{ __('A new verification link has been sent to your email address.') }}
            </div>
        @endif

        <div class="mt-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <!-- Resend Verification Button -->
            <form method="POST" action="{{ route('verification.send') }}" class="w-full sm:w-auto">
                @csrf
                <x-button type="submit" class="w-full sm:w-auto">
                    {{ __('Resend Verification Email') }}
                </x-button>
            </form>

            <!-- Profile & Logout Buttons -->
            <div class="text-center sm:text-right">
                <a href="{{ route('profile.show') }}" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                    {{ __('Edit Profile') }}
                </a>

                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="ml-4 text-red-600 hover:text-red-800 text-sm font-medium">
                        {{ __('Log Out') }}
                    </button>
                </form>
            </div>
        </div>
    </x-authentication-card>
</x-guest-layout>
