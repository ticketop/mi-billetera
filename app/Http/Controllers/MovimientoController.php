<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use Illuminate\Http\Request;

class MovimientoController extends Controller
{
    /**
     * Dashboard principal
     */
    public function dashboard(Request $request)
    {
        $buscar = trim($request->input('buscar', ''));

        /*
        |--------------------------------------------------------------------------
        | Saldo total
        |--------------------------------------------------------------------------
        */

        $ingresos = Movimiento::where('tipo', 'ingreso')->sum('importe');
        $gastos = Movimiento::where('tipo', 'gasto')->sum('importe');

        $saldo = $ingresos - $gastos;

        /*
        |--------------------------------------------------------------------------
        | Saldo por cuenta
        |--------------------------------------------------------------------------
        */

        $saldos = [];

        foreach (config('cuentas') as $codigo => $nombre) {

            $ingresosCuenta = Movimiento::where('tipo', 'ingreso')
                ->where('cuenta', $codigo)
                ->sum('importe');

            $gastosCuenta = Movimiento::where('tipo', 'gasto')
                ->where('cuenta', $codigo)
                ->sum('importe');

            $saldos[$codigo] = $ingresosCuenta - $gastosCuenta;
        }

        /*
        |--------------------------------------------------------------------------
        | Consulta del historial
        |--------------------------------------------------------------------------
        */

        $query = Movimiento::query();

        if ($buscar != '') {

            $query->where(function ($q) use ($buscar) {

                $q->where('descripcion', 'ILIKE', "%{$buscar}%")
                  ->orWhere('categoria', 'ILIKE', "%{$buscar}%")
                  ->orWhere('tipo', 'ILIKE', "%{$buscar}%")
                  ->orWhere('cuenta', 'ILIKE', "%{$buscar}%");

            });

        }

        /*
        |--------------------------------------------------------------------------
        | Resumen de la búsqueda
        |--------------------------------------------------------------------------
        */

        $cantidadMovimientos = (clone $query)->count();

        $ingresosBusqueda = (clone $query)
            ->where('tipo', 'ingreso')
            ->sum('importe');

        $gastosBusqueda = (clone $query)
            ->where('tipo', 'gasto')
            ->sum('importe');

        $resultadoBusqueda = $ingresosBusqueda - $gastosBusqueda;

        /*
        |--------------------------------------------------------------------------
        | Movimientos
        |--------------------------------------------------------------------------
        */

        $movimientos = (clone $query)
            ->orderBy('fecha', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        return view('dashboard', [
            'saldo' => $saldo,
            'saldos' => $saldos,
            'movimientos' => $movimientos,
            'buscar' => $buscar,

            'cantidadMovimientos' => $cantidadMovimientos,
            'ingresosBusqueda' => $ingresosBusqueda,
            'gastosBusqueda' => $gastosBusqueda,
            'resultadoBusqueda' => $resultadoBusqueda,
        ]);
    }

    /**
     * Formulario de nuevo movimiento
     */
    public function create()
    {
        return view('movimientos.create');
    }

    /**
     * Guardar movimiento
     */
    public function store(Request $request)
    {
        $request->validate([
            'fecha' => 'required|date',
            'tipo' => 'required|in:ingreso,gasto',
            'cuenta' => 'required',
            'categoria' => 'nullable|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'importe' => 'required|numeric|min:1',
        ]);

        Movimiento::create([
            'fecha' => $request->fecha,
            'tipo' => $request->tipo,
            'cuenta' => $request->cuenta,
            'categoria' => $request->categoria,
            'descripcion' => $request->descripcion,
            'importe' => $request->importe,
        ]);

        return redirect('/')->with('success', 'Movimiento registrado correctamente.');
    }
}