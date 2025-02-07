<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Tus secretos') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">

                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <div class="mt-4">
                        <a href="{{ route('secrets.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">Crear un secreto</a>
                    </div>
                </div>

                @forelse($secrets as $secret)
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <div class="flex items center justify-between">
                            <div>
                                <h3 class="text-lg font-semibold">
                                    Expirará en {{ $secret->expires_at->diffForHumans() }}
                                </h3>
                                <p class="text-sm text-gray-600 dark:text-gray-400">
                                    Creado {{ $secret->created_at->diffForHumans() }}
                                </p>
                            </div>
                            <div class="flex items-center w-2/4">
                                <input
                                    name="share"
                                    id="share"
                                    class="shadow appearance-none w-full border rounded py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                                    value="{{ $secret->sharedLink() }}"
                                    readonly
                                />
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="p-6 text-gray-900 dark:text-gray-100">
                        <p>No tienes secretos.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
