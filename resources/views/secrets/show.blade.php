@extends($layout)

@section('header')
    <h1 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
        {{ __('Mostrando secreto') }}
    </h1>
@endsection

@section('content')
    @if(! $secret->contentIsVisible())
        <p class="text-white text-lg mb-4">Este secreto está protegido por contraseña.</p>
    @endif

    @includeWhen(! $secret->contentIsVisible(), 'secrets.partials.password_form')
    @includeWhen($secret->contentIsVisible(), 'secrets.partials.secret_content')
    @includeWhen(! $secret->contentIsVisible(), 'secrets.partials.delete_form')
@endsection
