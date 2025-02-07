<form action="{{ route('secrets.store') }}" method="POST" class="mb-4">
    @csrf

    <div class="mb-4">
        <label class="block text-gray-800 text-sm font-bold" for="content">
            Secreto
        </label>
        <textarea autofocus name="content" id="content" class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" rows="5">{{ old('content') }}</textarea>
        @error('content')
            <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
        @enderror
    </div>

    <!-- fieldset privacity, password and expiration -->
    <div class="mb-2">
        <fieldset>
            <legend class="block text-gray-800 text-sm font-bold mb-1">
                Privacidad (protege tu secreto)
            </legend>

            <!-- password field (optional) -->
            <div class="mb-4">
                <label class="block text-gray-800 text-sm font-bold mb-1" for="password">
                    Contraseña (opcional)
                </label>
                <input
                    name="password"
                    id="password"
                    type="password"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                />
                @error('password')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>

            @auth()
                <!-- recepient email field (optional) -->
                <div class="mb-4">
                    <label class="block text-gray-800 text-sm font-bold mb-1" for="recipient">
                        Email del destinatario (opcional)
                    </label>
                    <input
                        name="recipient"
                        id="recipient"
                        type="email"
                        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                    />
                    @error('recipient')
                        <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                    @enderror
                </div>
            @endauth

            <!-- expiration select field -->
            <div class="mb-4">
                <label class="block text-gray-800 text-sm font-bold mb-1" for="expires_at">
                    Expiración
                </label>
                <select
                    name="expires_at"
                    id="expires_at"
                    class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
                >
                    @foreach(\App\Models\Secret::expirationOptions() as $value => $label)
                        <option value="{{ $value }}">{{ $label }}</option>
                    @endforeach
                </select>
                @error('expires_at')
                    <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
                @enderror
            </div>
        </fieldset>
    </div>

    <!-- share secret button -->
    <button
        type="submit"
        value="share"
        name="secret"
        class="w-full mb-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
    >
        Generar secreto
    </button>

    <!-- random secret button -->
    <button
        type="submit"
        value="random"
        name="secret"
        class="w-full bg-indigo-500 hover:bg-indigo-700 text-gray-800 font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline"
    >
        Generar secreto aleatorio
    </button>
</form>
