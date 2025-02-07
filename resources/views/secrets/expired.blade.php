@extends($layout)

@section('header')
    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Secreto expirado') }}
    </h1>
@endsection

@section('content')
    <p class="text-white text-lg mb-4">{{ $message }}</p>

    <div class="mb-4">
        <a
            href="{{ route('secrets.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        >
            Crear otro secreto
        </a>
    </div>
@endsection
