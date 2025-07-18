@extends('layouts.login')

@section('title', __('auth.forgot_password'))

@section('content')
    <div class="w-full max-w-md bg-white rounded-2xl shadow-2xl p-8 text-center">
        <div class="flex justify-center mb-4">
            <i class="ph ph-check-circle text-green-500 text-5xl"></i>
        </div>
        <h2 class="text-xl font-semibold text-gray-800 mb-4">
            {{ __('auth.check_email_title') }}
        </h2>
        <p class="text-gray-600 mb-6">
            {{ __('auth.check_email_description') }}
        </p>
        <a href="{{ route('home') }}" class="text-blue-600 hover:underline text-sm flex items-center justify-center gap-1">
            <i class="ph ph-arrow-left"></i>
            {{ __('default.back') }}
        </a>
    </div>
@endsection
