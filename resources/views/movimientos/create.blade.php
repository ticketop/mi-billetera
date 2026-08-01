<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">
    <title>Nuevo movimiento</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="max-w-xl mx-auto mt-10 bg-white rounded-xl shadow p-8">

    <h1 class="text-3xl font-bold mb-6">
        Nuevo movimiento
    </h1>

    <form action="/movimientos" method="POST">

        @csrf

        <div class="mb-4">

            <label class="block mb-2">Fecha</label>

            <input
                type="date"
                name="fecha"
                value="{{ date('Y-m-d') }}"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-4">

            <label class="block mb-2">Tipo</label>

            <select
                name="tipo"
                class="w-full border rounded p-2">

                <option value="ingreso">Ingreso</option>
                <option value="gasto">Gasto</option>

            </select>

        </div>

        <div class="mb-4">

            <label class="block mb-2">Cuenta</label>

            <select
                name="cuenta"
                class="w-full border rounded p-2">

                @foreach(config('cuentas') as $codigo => $nombre)

                    <option value="{{ $codigo }}">
                        {{ $nombre }}
                    </option>

                @endforeach

            </select>

        </div>

        <div class="mb-4">

            <label class="block mb-2">Categoría</label>

            <input
                type="text"
                name="categoria"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-4">

            <label class="block mb-2">Descripción</label>

            <input
                type="text"
                name="descripcion"
                class="w-full border rounded p-2">

        </div>

        <div class="mb-6">

            <label class="block mb-2">Importe</label>

            <input
                type="number"
                name="importe"
                step="0.01"
                min="1"
                class="w-full border rounded p-2">

        </div>

        <button
            type="submit"
            class="w-full bg-blue-600 text-white py-3 rounded-xl hover:bg-blue-700">

            Guardar movimiento

        </button>

    </form>

    <a
        href="/"
        class="block text-center mt-6 text-gray-500">

        ← Volver

    </a>

</div>

</body>

</html>