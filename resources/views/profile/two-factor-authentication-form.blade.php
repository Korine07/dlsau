<x-action-section>
    <x-slot name="title">
        {{ __('Two-Factor Authentication') }}
    </x-slot>

    <x-slot name="description">
        {{ __('Add additional security to your account using two-factor authentication.') }}
    </x-slot>

    <x-slot name="content">
        <div class="bg-white shadow-md rounded-lg p-6">
            <h3 class="text-lg font-semibold text-gray-900">
                @if ($this->enabled)
                    @if ($showingConfirmation)
                        {{ __('Finish enabling two-factor authentication.') }}
                    @else
                        {{ __('You have enabled two-factor authentication.') }}
                    @endif
                @else
                    {{ __('You have not enabled two-factor authentication.') }}
                @endif
            </h3>

            <div class="mt-3 max-w-xl text-sm text-gray-600">
                <p>
                    {{ __('When two-factor authentication is enabled, you will be prompted for a secure, random token during authentication. You may retrieve this token from your phone\'s Google Authenticator application.') }}
                </p>
            </div>

            @if ($this->enabled)
                @if ($showingQrCode)
                    <div class="mt-6 max-w-xl">
                        <p class="font-semibold text-gray-800">
                            @if ($showingConfirmation)
                                {{ __('To finish enabling two-factor authentication, scan the QR code below using your phone\'s authenticator application, or enter the setup key and provide the generated OTP code.') }}
                            @else
                                {{ __('Two-factor authentication is now enabled. Scan the QR code below using your phone\'s authenticator application or enter the setup key manually.') }}
                            @endif
                        </p>
                    </div>

                    <div class="mt-4 flex justify-center p-4 border border-gray-300 rounded-lg bg-gray-50">
                        {!! $this->user->twoFactorQrCodeSvg() !!}
                    </div>

                    <div class="mt-4 max-w-xl text-sm text-gray-700 bg-gray-100 p-4 rounded-lg">
                        <p class="font-semibold">
                            {{ __('Setup Key:') }} <span class="text-gray-900">{{ decrypt($this->user->two_factor_secret) }}</span>
                        </p>
                    </div>

                    @if ($showingConfirmation)
                        <div class="mt-4">
                            <x-label for="code" value="{{ __('Enter Code') }}" />
                            <x-input id="code" type="text" class="block mt-1 w-1/2" inputmode="numeric" wire:model="code" wire:keydown.enter="confirmTwoFactorAuthentication" />
                            <x-input-error for="code" class="mt-2" />
                        </div>
                    @endif
                @endif

                @if ($showingRecoveryCodes)
                    <div class="mt-6 max-w-xl">
                        <p class="font-semibold text-gray-800">
                            {{ __('Store these recovery codes securely. They can be used to recover access if you lose your two-factor device.') }}
                        </p>
                    </div>

                    <div class="grid gap-2 max-w-xl mt-4 px-4 py-4 font-mono text-sm bg-gray-100 rounded-lg border border-gray-300">
                        @foreach (json_decode(decrypt($this->user->two_factor_recovery_codes), true) as $code)
                            <div class="p-1 bg-white border border-gray-200 rounded">{{ $code }}</div>
                        @endforeach
                    </div>
                @endif
            @endif

            <div class="mt-5 flex flex-wrap space-x-3">
                @if (! $this->enabled)
                    <x-confirms-password wire:then="enableTwoFactorAuthentication">
                        <x-button type="button" wire:loading.attr="disabled">
                            {{ __('Enable 2FA') }}
                        </x-button>
                    </x-confirms-password>
                @else
                    @if ($showingRecoveryCodes)
                        <x-confirms-password wire:then="regenerateRecoveryCodes">
                            <x-secondary-button>
                                {{ __('Regenerate Recovery Codes') }}
                            </x-secondary-button>
                        </x-confirms-password>
                    @elseif ($showingConfirmation)
                        <x-confirms-password wire:then="confirmTwoFactorAuthentication">
                            <x-button type="button" wire:loading.attr="disabled">
                                {{ __('Confirm & Enable') }}
                            </x-button>
                        </x-confirms-password>
                    @else
                        <x-confirms-password wire:then="showRecoveryCodes">
                            <x-secondary-button>
                                {{ __('View Recovery Codes') }}
                            </x-secondary-button>
                        </x-confirms-password>
                    @endif

                    @if ($showingConfirmation)
                        <x-confirms-password wire:then="disableTwoFactorAuthentication">
                            <x-secondary-button>
                                {{ __('Cancel') }}
                            </x-secondary-button>
                        </x-confirms-password>
                    @else
                        <x-confirms-password wire:then="disableTwoFactorAuthentication">
                            <x-danger-button>
                                {{ __('Disable 2FA') }}
                            </x-danger-button>
                        </x-confirms-password>
                    @endif
                @endif
            </div>
        </div>
    </x-slot>
</x-action-section>
