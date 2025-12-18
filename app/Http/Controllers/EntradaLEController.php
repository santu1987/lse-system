<?php

namespace App\Http\Controllers;

use App\Models\EntradaLE;
use App\Models\Categoria;
use App\Models\Acepciones;
use Illuminate\Http\Request; 
use Carbon\Carbon; 

class EntradaLEController extends Controller
{
    public function index()
    {
        // Trae las entradas ordenadas por fecha de guardado
        $entradas = EntradaLE::orderBy('entrada', 'asc')->paginate(10);

        return view('entradas.le.index', compact('entradas'));
    }

    public function create()
    {
        $acepciones =[];
        // Consultar todas las categorías
        $categorias = Categoria::orderBy('categoria', 'asc')->get();
        // Enviar ambas variables a la vista
        return view('entradas.le.create', compact('acepciones', 'categorias'));
    }    
    /**
     * Store
     */
    public function store(Request $request)
    {
         $request->validate([
            'entrada' => 'required|string|max:255',
            'orden' => 'nullable|integer|min:1',
            'fecha_modificacion' => 'required|date',
        ]);

        $data = $request->all();
        $data['fecha_guardado'] = Carbon::now();
        $data['date_time'] = $request->fecha_modificacion;

        // Si viene idEntrada, actualiza; si no, inserta
        if (!empty($request->idEntrada)) {
            $entrada = EntradaLE::find($request->idEntrada);

            if ($entrada) {
                $entrada->update($data);
            } else {
                // Si no existe el id, crea nuevo
                $entrada = EntradaLE::create($data);
            }
        } else {
            $entrada = EntradaLE::create($data);
        }

        return response()->json([
            'success' => true,
            'entrada' => $entrada
        ]);


    }
    /**
     * Edit
     */
    public function edit($id)
    {
        $entrada = EntradaLE::findOrFail($id);
        // Reutilizamos la vista create, pero le pasamos la entrada
        return view('entradas.le.edit', compact('entrada'));
    }

    /**
     * Update
     * 
     */
    public function update(Request $request, $id)
    {
        $entrada = EntradaLE::findOrFail($id);

        $request->validate([
            'entrada' => 'required|string|max:255',
            'orden' => 'required|integer|min:1',
            'fecha_modificacion' => 'required|date',
        ]);
                
        $entrada->update([
            'entrada' => $request->entrada,
            'orden' => $request->orden,
            'fecha_modificacion' => $request->fecha_modificacion,
        ]);

        return response()->json(['success' => true, 'entrada' => $entrada]);
    }
    /**
     * Destroy
     */
    public function destroy($id)
    {
        $entrada = EntradaLE::findOrFail($id);
        $entrada->delete(); // 👈 marca deleted_at
        return response()->json(['success' => true]);
    }
    /**
     * Retsore
     */
    public function restore($id)
    {
        $entrada = EntradaLE::withTrashed()->findOrFail($id);
        $entrada->restore(); // 👈 quita deleted_at
        return response()->json(['success' => true, 'entrada' => $entrada]);
    }
    /**
     * Store acepciones
     */
    public function storeAcepciones(Request $request)
    {
        // Validar que venga el arreglo
        $request->validate([
            'acepciones' => 'required|array',
            'acepciones.*.id_entrada' => 'required|integer|exists:lse_entradas_lengua_espanola,id',
            'acepciones.*.orden' => 'nullable|integer|min:1',
            'acepciones.*.acepcion' => 'required|string|max:255',
            'acepciones.*.ejemplo' => 'nullable|string',
            'acepciones.*.id_categoria' => 'nullable|integer|exists:lse_categorias,id',
            'acepciones.*.fecha_modificacion' => 'required|date',
            'acepciones.*.definicion_propia' => 'boolean',
        ]);

        $acepcionesGuardadas = [];

        foreach ($request->acepciones as $acepcionData) {
            // Si quieres actualizar si ya existe (por ejemplo por orden + entrada)
            $acepcion = Acepciones::updateOrCreate(
                [
                    'id_entrada' => $acepcionData['id_entrada'],
                ],
                [
                    'acepcion' => $acepcionData['acepcion'],
                    'ejemplo' => $acepcionData['ejemplo'] ?? null,
                    'id_categoria' => $acepcionData['id_categoria'] ?? null,
                    'fecha_modificacion' => $acepcionData['fecha_modificacion'],
                    'definicion_propia' => $acepcionData['definicion_propia'] ?? 0,
                ]
            );

            $acepcionesGuardadas[] = $acepcion;
        }

        return response()->json([
            'success' => true,
            'acepciones' => $acepcionesGuardadas
        ]);
    }


}
