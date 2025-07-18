@extends('layouts.login')

@section('title', __('auth.reset_password'))

@section('content')
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <div class="flex justify-center mb-4">
            <i class="ph ph-lock-key text-blue-600 text-5xl"></i>
        </div>

        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">{{ __('auth.reset_password') }}</h2>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <x-validation-errors />
        <form method="POST" action="{{ route('password.update') }}" class="space-y-6">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ old('email', $email) }}">

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
                    <button type="button" onclick="togglePassword('password', 'eyeIcon1')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                        <i id="eyeIcon1" class="ph ph-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700">
                    {{ __('auth.password_confirm') }}
                </label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="ph ph-key-return"></i>
                    </span>
                    <input id="password_confirmation" name="password_confirmation" type="password" required
                           class="pl-10 pr-10 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
                    <button type="button" onclick="togglePassword('password_confirmation', 'eyeIcon2')"
                            class="absolute inset-y-0 right-0 pr-3 flex items-center text-gray-400">
                        <i id="eyeIcon2" class="ph ph-eye"></i>
                    </button>
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-150 flex items-center justify-center gap-2">
                    <i class="ph ph-lock-key-open"></i>
                    {{ __('auth.reset_password_button') }}
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon = document.getElementById(iconId);
            const isPassword = input.type === 'password';
            input.type = isPassword ? 'text' : 'password';
            icon.className = isPassword ? 'ph ph-eye-slash' : 'ph ph-eye';
        }
    </script>
@endpush
