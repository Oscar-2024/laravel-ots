@extends($layout)

@section('header')
    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Mostrando secreto') }}
    </h1>
@endsection

@section('content')
    <!-- enlace para compartir -->
    <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-1" for="share">
            Compartir
        </label>
        <input
            name="share"
            id="share"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
            value="{{ $secret->sharedLink() }}"
            readonly
        />
    </div>

    @if ($secret->recipient)
        <div class="mb-4">
            <label class="block text-white text-sm font-bold mb-1" for="recipient">
                Se ha compartido con
            </label>
            <input
                name="recipient"
                id="recipient"
                class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                value="{{ $secret->maskedRecipient() }}"
                readonly
            />
        </div>
    @endif

    @include('secrets.partials.delete_form')

    <!-- add another secret -->
    <div class="mb-4">
        <a
            href="{{ route('secrets.create') }}"
            class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
        >
            Crear otro secreto
        </a>
    </div>
@endsection
