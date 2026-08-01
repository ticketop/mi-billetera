<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title>Mi Billetera</title>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="bg-gray-100">

<div class="max-w-6xl mx-auto py-10">

    <h1 class="text-4xl font-bold">
        💰 Mi Billetera
    </h1>

    <p class="text-gray-500 mt-2">
        Finanzas personales
    </p>

    {{-- Saldo disponible --}}

    <div class="bg-white rounded-xl shadow mt-8 p-8">

        <p class="text-gray-500">
            Saldo disponible
        </p>

        <h2 class="text-6xl font-bold mt-3">

            Gs. {{ number_format($saldo,0,',','.') }}

        </h2>

    </div>

    {{-- Cuentas --}}

    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-4 mt-8">

        @foreach(config('cuentas') as $codigo => $nombre)

            <div class="bg-white rounded-xl shadow p-5">

                <div class="text-lg">

                    {{ $nombre }}

                </div>

                <div class="text-2xl font-bold mt-3">

                    Gs. {{ number_format($saldos[$codigo] ?? 0,0,',','.') }}

                </div>

            </div>

        @endforeach

    </div>

    {{-- Botón nuevo movimiento --}}

    <div class="mt-8">

        <a href="/movimientos/nuevo"
           class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl inline-block">

            + Nuevo movimiento

        </a>

    </div>

    {{-- Buscador --}}

    <div class="bg-white rounded-xl shadow mt-8 p-5">

        <form method="GET" action="/">

            <input
                type="text"
                name="buscar"
                value="{{ $buscar }}"
                placeholder="🔍 Buscar por descripción, categoría, cuenta o tipo..."
                class="w-full border rounded-lg p-3">

        </form>

    </div>

    {{-- Resumen --}}

    <div class="bg-white rounded-xl shadow mt-6 p-6">

        <h3 class="text-xl font-bold mb-6">

            @if($buscar)

                Resultados para "{{ $buscar }}"

            @else

                Resumen General

            @endif

        </h3>

        <div class="grid md:grid-cols-4 gap-6">

            <div>

                <div class="text-gray-500 text-sm">

                    Movimientos

                </div>

                <div class="text-3xl font-bold">

                    {{ $cantidadMovimientos }}

                </div>

            </div>

            <div>

                <div class="text-gray-500 text-sm">

                    Ingresos

                </div>

                <div class="text-3xl font-bold text-green-600">

                    Gs. {{ number_format($ingresosBusqueda,0,',','.') }}

                </div>

            </div>

            <div>

                <div class="text-gray-500 text-sm">

                    Gastos

                </div>

                <div class="text-3xl font-bold text-red-600">

                    Gs. {{ number_format($gastosBusqueda,0,',','.') }}

                </div>

            </div>

            <div>

                <div class="text-gray-500 text-sm">

                    Resultado

                </div>

                <div class="text-3xl font-bold
                    @if($resultadoBusqueda >= 0)
                        text-green-600
                    @else
                        text-red-600
                    @endif">

                    Gs. {{ number_format($resultadoBusqueda,0,',','.') }}

                </div>

            </div>

        </div>

    </div>

    {{-- Historial --}}

    <div class="bg-white rounded-xl shadow mt-8 overflow-hidden">

        <div class="p-5 border-b">

            <h3 class="text-xl font-bold">

                Historial de movimientos

            </h3>

        </div>

        <table class="w-full">

            <thead class="bg-gray-100">

                <tr>

                    <th class="text-left p-3">Fecha</th>
                    <th class="text-left p-3">Tipo</th>
                    <th class="text-left p-3">Cuenta</th>
                    <th class="text-left p-3">Categoría</th>
                    <th class="text-left p-3">Descripción</th>
                    <th class="text-right p-3">Importe</th>

                </tr>

            </thead>

            <tbody>

                @forelse($movimientos as $movimiento)

                    <tr class="border-b hover:bg-gray-50">

                        <td class="p-3">

                            {{ \Carbon\Carbon::parse($movimiento->fecha)->format('d/m/Y') }}

                        </td>

                        <td class="p-3">

                            @if($movimiento->tipo == 'ingreso')

                                <span class="text-green-600 font-semibold">

                                    Ingreso

                                </span>

                            @else

                                <span class="text-red-600 font-semibold">

                                    Gasto

                                </span>

                            @endif

                        </td>

                        <td class="p-3">

                            {{ config('cuentas')[$movimiento->cuenta] }}

                        </td>

                        <td class="p-3">

                            {{ $movimiento->categoria }}

                        </td>

                        <td class="p-3">

                            {{ $movimiento->descripcion }}

                        </td>

                        <td class="p-3 text-right font-bold">

                            @if($movimiento->tipo == 'ingreso')

                                <span class="text-green-600">

                                    +Gs. {{ number_format($movimiento->importe,0,',','.') }}

                                </span>

                            @else

                                <span class="text-red-600">

                                    -Gs. {{ number_format($movimiento->importe,0,',','.') }}

                                </span>

                            @endif

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td colspan="6" class="text-center text-gray-500 p-6">

                            No hay movimientos registrados.

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>

</div>

</body>

</html>