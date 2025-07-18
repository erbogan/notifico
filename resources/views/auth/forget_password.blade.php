@extends('layouts.login')

@section('title', __('auth.forgot_password'))

@section('content')
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8">
        <div class="flex justify-center mb-4">
            <i class="ph ph-envelope-simple text-blue-600 text-5xl"></i>
        </div>
        <h2 class="text-2xl font-bold text-center text-gray-800 mb-6">{{ __('auth.forgot_password') }}</h2>

        @if (session('status'))
            <div class="mb-4 text-sm text-green-600">
                {{ session('status') }}
            </div>
        @endif
        <form method="POST" action="{{ route('password.email') }}" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    {{ __('auth.email') }}
                </label>
                <div class="mt-1 relative">
                    <span class="absolute inset-y-0 left-0 pl-3 flex items-center text-gray-400">
                        <i class="ph ph-envelope"></i>
                    </span>
                    <input id="email" name="email" type="email" required
                           class="pl-10 block w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-blue-200 focus:outline-none">
                </div>
            </div>

            <div>
                <button type="submit"
                        class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 transition duration-150 flex items-center justify-center gap-2">
                    <i class="ph ph-paper-plane-right"></i>
                    {{ __('auth.send_reset_link') }}
                </button>
            </div>

            <div class="text-center mt-6">
                <a href="{{ route('home') }}" class="text-sm text-gray-600 hover:text-blue-600 flex items-center justify-center gap-1">
                    <i class="ph ph-arrow-left"></i>
                    {{ __('default.back') }}
                </a>
            </div>
        </form>
    </div>
@endsection
