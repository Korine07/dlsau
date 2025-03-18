<x-guest-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="flex justify-center items-center min-h-screen bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('assets/images/banner1.JPG') }}');"> 
        <!-- Change to your actual background image -->

        <div class="w-full max-w-md p-8 bg-white bg-opacity-80 backdrop-blur-lg rounded-lg shadow-lg">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/images/DLSAU.png') }}" class="h-12 w-auto" alt="DLSAU Logo"> 
                <!-- Change to your actual logo -->
            </div>

            <div class="mb-4 text-sm text-gray-700 text-center">
                <strong>Reset Your Password</strong> <br>
                Please enter your new password below.
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.update') }}">
                @csrf

                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input id="email" type="email" name="email" 
                           value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- New Password Input -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700">New Password</label>
                    <input id="password" type="password" name="password" required autocomplete="new-password"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Confirm Password Input -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm New Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                           class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" 
                        class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition duration-300">
                        Reset Password
                    </button>
                </div>

                <!-- Back to Login Link -->
                <p class="text-sm text-center text-gray-600 mt-4">
                    <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">
                        Back to Login
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
