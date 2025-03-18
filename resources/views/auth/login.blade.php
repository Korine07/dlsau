<x-guest-layout>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @include('admin.preloader')
    
    <div class="flex justify-center items-center min-h-screen bg-cover bg-center bg-no-repeat" 
         style="background-image: url('{{ asset('assets/images/banner1.JPG') }}');">
        <div class="w-full max-w-md p-8 bg-white bg-opacity-80 backdrop-blur-lg rounded-lg shadow-lg">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('assets/images/DLSAU.png') }}" class="h-12 w-auto" alt="Logo">
            </div>

            <!-- Incorrect Password or Login Errors -->
            @if ($errors->any())
                <div class="mb-4 p-3 text-sm text-red-700 bg-red-100 border border-red-400 rounded-lg">
                    <strong>Warning:</strong> Incorrect email or password. Please try again.
                </div>
            @endif

            @if(session('status'))
                <div class="mb-4 font-medium text-sm text-green-600">
                    {{ session('status') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email -->
                <div class="mb-4">
                    <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required 
                        autofocus autocomplete="username" 
                        class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Password</label>
                    <div class="relative">
                        <input id="password" type="password" name="password" required 
                            autocomplete="current-password"
                            class="w-full p-3 border border-gray-300 rounded-lg focus:ring-green-500 focus:border-green-500" />
                        <!-- Show Password Button -->
                        <button type="button" id="toggle-password" class="absolute top-0 right-3 mt-3 text-gray-600">
                            <i class="fas fa-eye"></i> <!-- Eye icon -->
                        </button>
                    </div>
                </div>

                <!-- Remember Me & Forgot Password -->
                <div class="flex items-center justify-between mb-4">
                    <label for="remember_me" class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="rounded text-green-500 focus:ring-green-500">
                        <span class="ml-2 text-sm text-gray-600">Remember me</span>
                    </label>

                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="text-sm text-green-600 hover:underline">
                            Forgot your password?
                        </a>
                    @endif
                </div>

                <!-- Login Button -->
                <button type="submit" class="w-full bg-gradient-to-r from-green-400 to-green-600 text-white p-3 rounded-lg hover:from-green-500 hover:to-green-700 transition duration-300">
                    Log in
                </button>

                <!-- Register Link -->
                <p class="text-sm text-center text-gray-600 mt-4">
                    Not registered? 
                    <a href="{{ route('register') }}" class="text-green-600 font-semibold hover:underline">
                        Create an account
                    </a>
                </p>
            </form>
        </div>
    </div>

    <!-- Add Font Awesome for the eye icon -->
    <script src="https://kit.fontawesome.com/a076d05399.js"></script>

    <!-- Script for toggling password visibility -->
    <script>
        document.getElementById('toggle-password').addEventListener('click', function() {
            var passwordField = document.getElementById('password');
            var passwordType = passwordField.type === 'password' ? 'text' : 'password';
            passwordField.type = passwordType;
            this.innerHTML = passwordType === 'password' ? '<i class="fas fa-eye"></i>' : '<i class="fas fa-eye-slash"></i>';
        });
    </script>
</x-guest-layout>
