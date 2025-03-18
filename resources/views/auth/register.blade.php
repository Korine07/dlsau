<x-guest-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <div class="flex justify-center items-center min-h-screen bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('assets/images/banner1.JPG') }}');"> 
        <!-- Change background.jpg to your actual image file -->

        <div class="w-full max-w-md p-8 bg-white bg-opacity-90 backdrop-blur-lg rounded-lg shadow-lg">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/images/DLSAU.png') }}" class="h-12 w-auto" alt="DLSAU Logo"> 
                <!-- Change to your actual logo -->
            </div>

            <x-validation-errors class="mb-4" />

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-4">
                    <label for="name" class="block text-sm font-semibold text-gray-700">Full Name</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus 
                        autocomplete="name"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email Address</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                        autocomplete="username"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <input id="password" type="password" name="password" required 
                        autocomplete="new-password"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label for="password_confirmation" class="block text-sm font-semibold text-gray-700">Confirm Password</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required 
                        autocomplete="new-password"
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Terms & Privacy Policy -->
                @if (Laravel\Jetstream\Jetstream::hasTermsAndPrivacyPolicyFeature())
                    <div class="mb-4">
                        <label for="terms" class="flex items-center">
                            <input type="checkbox" name="terms" id="terms" required class="rounded text-green-500 focus:ring-green-500">
                            <span class="ml-2 text-sm text-gray-600">
                                I agree to the 
                                <a target="_blank" href="{{ route('terms.show') }}" class="text-green-600 hover:underline">
                                    Terms of Service
                                </a> and 
                                <a target="_blank" href="{{ route('policy.show') }}" class="text-green-600 hover:underline">
                                    Privacy Policy
                                </a>.
                            </span>
                        </label>
                    </div>
                @endif

                <!-- Register Button -->
                <div class="mt-4">
                    <button type="submit" 
                        class="w-full bg-green-500 text-white p-3 rounded-lg hover:bg-green-600 transition duration-300">
                        Register
                    </button>
                </div>

                <!-- Already Registered Link -->
                <p class="text-sm text-center text-gray-600 mt-4">
                    Already have an account? 
                    <a href="{{ route('login') }}" class="text-green-600 font-semibold hover:underline">
                        Log in
                    </a>
                </p>
            </form>
        </div>
    </div>
</x-guest-layout>
