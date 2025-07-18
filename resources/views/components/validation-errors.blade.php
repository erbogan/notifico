@if ($errors->any())
    <div class="mb-4">
        <div class="text-red-600 font-semibold mb-2">
            {{ __('validation.general_error') }}
        </div>
        <ul class="list-disc list-inside text-sm text-red-500">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
