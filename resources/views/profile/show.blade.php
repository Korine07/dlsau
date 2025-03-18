<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-2xl text-gray-900 leading-tight">
                {{ __('Profile Settings') }}
            </h2>
            <!-- Back Button -->
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-gray-800 text-white text-sm font-semibold rounded-lg shadow-md hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-gray-500">
                ← Back to Dashboard
            </a>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">

            <!-- Update Password -->
            @if (Laravel\Fortify\Features::enabled(Laravel\Fortify\Features::updatePasswords()))
                <div class="bg-white shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Change Password</h3>
                    @livewire('profile.update-password-form')
                </div>
            @endif

            <!-- Logout Other Browser Sessions -->
            <div class="bg-white shadow-lg rounded-lg p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Logout Other Sessions</h3>
                @livewire('profile.logout-other-browser-sessions-form')
            </div>

            <!-- Account Deletion -->
            @if (Laravel\Jetstream\Jetstream::hasAccountDeletionFeatures())
                <div class="bg-red-50 border border-red-200 shadow-lg rounded-lg p-6">
                    <h3 class="text-lg font-semibold text-red-700 mb-4">Delete Account</h3>
                    <p class="text-sm text-gray-600 mb-4">Permanently delete your account and all its data. This action cannot be undone.</p>
                    @livewire('profile.delete-user-form')
                </div>
            @endif
        </div>
    </div>
</x-app-layout>
