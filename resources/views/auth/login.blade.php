<x-guest-layout>

    <div class="flex justify-center items-center min-h-screen bg-gray-100 dark:bg-gray-900">

        <div class="w-full max-w-md bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">

            <!-- Title -->
            <h2 class="text-2xl font-bold mb-6 text-center text-gray-800 dark:text-gray-100">
                Inventory System Login
            </h2>

            <!-- Session Status -->
            <x-auth-session-status class="mb-4" :status="session('status')" />

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input 
                        id="email" 
                        class="block mt-1 w-full" 
                        type="email" 
                        name="email" 
                        :value="old('email')" 
                        required 
                        autofocus 
                        autocomplete="username" 
                    />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />

                    <x-text-input 
                        id="password" 
                        class="block mt-1 w-full"
                        type="password"
                        name="password"
                        required 
                        autocomplete="current-password" 
                    />

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Remember Me -->
                <div class="block mt-4">
                    <label for="remember_me" class="inline-flex items-center">
                        <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500" name="remember">
                        <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                            {{ __('Remember me') }}
                        </span>
                    </label>
                </div>

                <!-- Actions -->
                <div class="flex items-center justify-between mt-6">

                    @if (Route::has('password.request'))
                        <a class="text-sm text-blue-500 hover:underline" href="{{ route('password.request') }}">
                            Forgot password?
                        </a>
                    @endif

                    <x-primary-button>
                        Login
                    </x-primary-button>

                </div>

                <!-- Register Link -->
                <div class="mt-4 text-center text-sm">
                    <span class="text-gray-600 dark:text-gray-400">Don't have an account?</span>
                    <a href="{{ route('register') }}" class="text-blue-500 hover:underline">
                        Register
                    </a>
                </div>

            </form>

        </div>

    </div>

</x-guest-layout>