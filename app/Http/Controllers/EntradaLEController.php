<?php

namespace App\Http\Controllers;

use App\Models\EntradaLE;
use Illuminate\Http\Request; 
use Carbon\Carbon; 

class EntradaLEController extends Controller
{
    public function index()
    {
        // Trae las entradas ordenadas por fecha de guardado
        $entradas = EntradaLE::orderBy('orden', 'desc')->paginate(10);

        return view('entradas.le.index', compact('entradas'));
    }

    public function create()
    {
        return view('entradas.le.create');
    }
    /**
     * Store
     */
    public function store(Request $request)
    {
        $request->validate([
            'entrada' => 'required|string|max:255',
            'orden' => 'required|integer|min:1',
            'fecha_modificacion' => 'required|date',
        ]);
        
        $data = $request->all();
        $data['fecha_guardado'] = Carbon::now();
        $data['date_time'] = $request->fecha_modificacion;
        $entrada = EntradaLE::create($data);

        return response()->json(['success' => true, 'entrada' => $entrada]);
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

}
