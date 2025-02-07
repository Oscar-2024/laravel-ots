<div class="mb-4">
    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-4" role="alert">
        <p class="font-bold">¡Éxito!</p>
        <p>Aquí tienes tu secreto. Recuerda que solo puedes verlo esta vez.</p>
    </div>

    <label class="block text-white text-sm font-bold mb-1" for="content">
        Secreto
    </label>
    <textarea
        id="content"
        class="shadow appearance-none border rounded w-full py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline"
        rows="5"
        readonly
    >{{ $secret->content }}</textarea>
</div>
