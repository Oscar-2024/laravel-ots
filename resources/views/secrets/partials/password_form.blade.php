<form action="{{ route('secrets.decrypt', ['secret' => $secret]) }}" method="POST">
    @csrf

    <div class="mb-4">
        <label class="block text-white text-sm font-bold mb-1" for="password">
            Contraseña
        </label>
        <input
            autofocus
            name="password"
            id="password"
            type="password"
            class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        />
        @error('password')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <button
        type="submit"
        class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
    >
        Descifrar
    </button>
</form>
