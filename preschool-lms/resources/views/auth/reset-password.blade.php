<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center bg-gradient-to-r from-green-300 to-green-600 p-4">
        <div class="w-full max-w-md bg-white dark:bg-gray-800 rounded-lg shadow-lg p-6">
            
            <!-- Logo or Image -->
            <div class="flex justify-center mb-6">
                <img src="{{ asset('logo.jpeg') }}" alt="logo" class="w-20 h-20 rounded-full">
            </div>

            <!-- Password Reset Form -->
            <form method="POST" action="{{ route('password.store') }}">
                @csrf

                <!-- Password Reset Token -->
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email Address -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div class="mt-4">
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full"
                                  type="password"
                                  name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Submit Button -->
                <div class="flex flex-col items-center gap-4 mt-6">
                    <x-primary-button class="w-full bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-lg shadow-md transition-all duration-300 flex justify-center">
                        {{ __('Reset Password') }}
                    </x-primary-button>

                    <!-- Optional: Back to Login Link -->
                    <a href="{{ route('login') }}"
                       class="underline text-sm text-blue-600 dark:text-gray-400 hover:text-gray-900 dark:hover:text-gray-100 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                        {{ __('Back to Login') }}
                    </a>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
