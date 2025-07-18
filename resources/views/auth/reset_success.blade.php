@extends('layouts.login')

@section('title', __('auth.reset_success_title'))

@section('content')
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 text-center">
        <div class="flex justify-center mb-4">
            <i class="ph ph-check-circle text-green-600 text-5xl"></i>
        </div>

        <h2 class="text-2xl font-bold text-gray-800 mb-4">
            {{ __('auth.reset_success_title') }}
        </h2>

        <p class="text-gray-600 mb-6">
            {{ __('auth.reset_success_message') }}
        </p>

        <a href="{{ route('home') }}" class="inline-block px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
            {{ __('auth.back_to_home') }}
        </a>
    </div>
@endsection
