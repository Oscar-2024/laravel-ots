@extends($layout)

@section('header')
    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Crear nuevo secreto') }}
    </h1>
@endsection

@section('content')
    <p class="text-gray-800 text-lg mb-4">
        Un secreto es un mensaje que se autodestruirá después de ser leído.
        Puedes protegerlo con una contraseña o dejarlo sin protección.
        También puedes establecer una fecha de expiración.
        Si no se lee antes de la fecha de expiración, el secreto se autodestruirá.
    </p>

    @include('secrets.partials.create_form')
@endsection
