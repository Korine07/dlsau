<x-guest-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="flex justify-center items-center min-h-screen bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('assets/images/banner1.JPG') }}');"> 
        <!-- Change background.jpg to your actual image file -->

        <div class="w-full max-w-md p-8 bg-white bg-opacity-80 backdrop-blur-lg rounded-lg shadow-lg">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/images/DLSAU.png') }}" class="h-12 w-auto" alt="DLSAU Logo"> 
                <!-- Change to your actual logo -->
            </div>

            <div class="mb-4 text-sm text-gray-700 text-center">
                <strong>Forgot your password?</strong> No problem. Enter your email address, and we'll send you a reset link to create a new password.
            </div>

            @if (session('status'))
                <div class="mb-4 font-medium text-sm text-green-600 text-center">
                    {{ session('status') }}
                </div>
            @endif

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('password.email') }}">
                @csrf

                <!-- Email Input -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                        autofocus autocomplete="username" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Submit Button -->
                <div class="mt-4">
                    <button type="submit" 
                        class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition duration-300">
                        Send Password Reset Link
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
