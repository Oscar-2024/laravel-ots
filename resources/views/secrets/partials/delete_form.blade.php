<form action="{{ route('secrets.destroy', $secret) }}" method="POST">
    @csrf
    @method('DELETE')

    <div class="p-6 text-gray-900 dark:text-gray-100">
        <div class="flex items center justify-between items-center">
            <div>
                <h3 class="text-lg font-semibold">
                    Expirará en {{ $secret->expires_at->diffForHumans() }}
                </h3>
                <p class="text-sm text-gray-600 dark:text-gray-400">
                    Creado {{ $secret->created_at->diffForHumans() }}
                </p>
            </div>

            <button
                type="submit"
                class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
            >
                Eliminar
            </button>
        </div>
    </div>
</form>
