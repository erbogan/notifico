@extends('layouts.login')

@section('title', __('auth.login_title'))

@section('content')
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <div class="flex justify-center mb-4">
            <i class="ph ph-lock-simple text-blue-600 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">{{ __('auth.login_title') }}</h2>
        <x-validation-errors />
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    {{ __('auth.email') }}
                </label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="ph ph-envelope"></i>
                    </span>
                    <input id="email" name="email" type="email" required autofocus
                           class="pl-10 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    {{ __('auth.password') }}
                </label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="ph ph-key"></i>
                    </span>
                    <input id="password" name="password" type="password" required
                           class="pl-10 pr-10 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
                    <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                        <i id="eyeIcon" class="ph ph-eye"></i>
                    </button>
                </div>
            </div>

            <div class="flex items-center justify-between">
                <label class="flex items-center">
                    <input type="checkbox" name="remember" class="form-checkbox text-blue-600">
                    <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
                </label>

                <a href="{{ route('password.request') }}" class="text-sm text-blue-600 hover:underline flex items-center gap-1">
                    <i class="ph ph-question"></i>
                    {{ __('auth.forgot_password') }}
                </a>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-150 flex items-center justify-center gap-2">
                    <i class="ph ph-sign-in"></i>
                    {{ __('auth.login_button') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('eyeIcon');
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.className = isPassword ? 'ph ph-eye-slash' : 'ph ph-eye';
        }
    </script>
@endpush
