<?php

namespace App\Http\Controllers;

use App\Models\EntradaLE;
use App\Models\Categoria;
use App\Models\Acepciones;
use App\Models\Sublema;
use App\Models\SublemaAcepcion;
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
    /*
    public function storeAcepciones(Request $request)
    {
        // Validar que venga el arreglo
        $request->validate([
            'acepciones' => 'required|array',
            'acepciones.*.id' => 'nullable|integer|exists:lse_acepciones_entradas_lengua_espanola,id',
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
            // Si viene el id, actualizamos esa acepción
            if (!empty($acepcionData['id'])) {
                $acepcion = Acepciones::find($acepcionData['id']);
                if ($acepcion) {
                    $acepcion->update([
                        'acepcion'           => $acepcionData['acepcion'],
                        'ejemplo'            => $acepcionData['ejemplo'] ?? null,
                        'id_categoria'       => $acepcionData['id_categoria'] ?? null,
                        'fecha_modificacion' => $acepcionData['fecha_modificacion'],
                        'definicion_propia'  => $acepcionData['definicion_propia'] ?? 0,
                    ]);
                }
            } else {
                // Si no viene id, creamos una nueva
                $acepcion = Acepciones::create([
                    'id_entrada'         => $acepcionData['id_entrada'],
                    'acepcion'           => $acepcionData['acepcion'],
                    'ejemplo'            => $acepcionData['ejemplo'] ?? null,
                    'id_categoria'       => $acepcionData['id_categoria'] ?? null,
                    'fecha_modificacion' => $acepcionData['fecha_modificacion'],
                    'definicion_propia'  => $acepcionData['definicion_propia'] ?? 0,
                ]);
            }
            // Guardamos el modelo con su id
            $acepcionesGuardadas[] = $acepcion;
        }
        // Contar cuántas acepciones tiene la entrada 
        $idEntrada =  $acepcionData['id_entrada'];
        if ($idEntrada) {
            $numAcepciones = Acepciones::where('id_entrada', $idEntrada)->count();

            //Actualizar el campo num_acepciones en la tabla lse_entradas_lengua_espanola
            EntradaLE::where('id', $idEntrada)->update([
                'num_acepciones' => $numAcepciones
            ]);
        }

        return response()->json([
            'success' => true,
            'acepciones' => $acepcionesGuardadas
        ]);
    }*/
    /**
    *   Guardar Acepción  
    */
    public function storeAcepciones(Request $request)
    {
        // Validar los campos
        $request->validate([
            'id_entrada'        => 'required|integer|exists:lse_entradas_lengua_espanola,id',
            'acepcion'          => 'required|string|max:255',
            'ejemplo'           => 'nullable|string|max:255',
            'id_categoria'      => 'nullable|integer|exists:lse_categorias,id',
            'fecha_modificacion'=> 'required|date',
            'definicion_propia' => 'boolean',
            'id'                => 'nullable|integer|exists:lse_acepciones_entradas_lengua_espanola,id',
            ],
            [
                'id_entrada.required'        => 'La entrada es obligatoria.',
                'id_entrada.integer'         => 'La entrada debe ser un número entero.',
                'id_entrada.exists'          => 'La entrada seleccionada no existe.',

                'acepcion.required'          => 'La acepción es obligatoria.',
                'acepcion.string'            => 'La acepción debe ser texto.',
                'acepcion.max'               => 'La acepción no puede superar los 255 caracteres.',

                'ejemplo.string'             => 'El ejemplo debe ser texto.',
                'ejemplo.max'                => 'El ejemplo no puede superar los 255 caracteres.',

                'id_categoria.integer'       => 'La categoría debe ser un número entero.',
                'id_categoria.exists'        => 'La categoría seleccionada no existe.',

                'fecha_modificacion.required'=> 'La fecha de modificación es obligatoria.',
                'fecha_modificacion.date'    => 'La fecha de modificación debe tener un formato válido.',

                'definicion_propia.boolean'  => 'El campo definición propia debe ser verdadero o falso.',

                'id.integer'                 => 'El identificador debe ser un número entero.',
                'id.exists'                  => 'La acepción seleccionada no existe.',
            ]
        );

        // Si viene el id, actualizamos; si no, creamos
        if ($request->filled('id')) {
            $acepcion = Acepciones::find($request->id);
            if ($acepcion) {
                $acepcion->update([
                    'acepcion'           => $request->acepcion,
                    'ejemplo'            => $request->ejemplo,
                    'id_categoria'       => $request->id_categoria,
                    'fecha_modificacion' => $request->fecha_modificacion,
                    'definicion_propia'  => $request->definicion_propia ?? 0,
                ]);
            }
        } else {
            $acepcion = Acepciones::create([
                'id_entrada'         => $request->id_entrada,
                'acepcion'           => $request->acepcion,
                'ejemplo'            => $request->ejemplo,
                'id_categoria'       => $request->id_categoria,
                'fecha_modificacion' => $request->fecha_modificacion,
                'definicion_propia'  => $request->definicion_propia ?? 0,
            ]);
        }

        // Actualizar contador de acepciones en la entrada
        $numAcepciones = Acepciones::where('id_entrada', $request->id_entrada)->count();
        EntradaLE::where('id', $request->id_entrada)->update([
            'num_acepciones' => $numAcepciones
        ]);

        return response()->json([
            'success'   => true,
            'acepcion'  => [
                'id'                => $acepcion->id,
                'acepcion'          => $acepcion->acepcion,
                'ejemplo'           => $acepcion->ejemplo,
                'id_categoria'      => $acepcion->id_categoria,
                'categoria_descripcion' => $acepcion->categoria->categoria ?? null,
                'fecha_modificacion'=> $acepcion->fecha_modificacion,
                'definicion_propia' => $acepcion->definicion_propia,
            ]

        ]);
    }
    /**
     * Eliminar acepción
     */
    public function destroyAcepcion(Request $request)
    {
        $acepcion = Acepciones::findOrFail($request->id_acepcion);
        $idEntrada = $acepcion->id_entrada;

        $acepcion->delete();

        // Actualizar contador de acepciones en la entrada
        $numAcepciones = Acepciones::where('id_entrada', $idEntrada)->count();
        EntradaLE::where('id', $idEntrada)->update(['num_acepciones' => $numAcepciones]);

        return response()->json([
            'success' => true,
            'message' => 'Acepción eliminada correctamente',
            'id' => $request->id_acepcion
        ]);
    }

    /**
     * GUardar sublmea principal
     */
    public function storeSublemas(Request $request){
        $request->validate([
            'id_entrada' => 'required|integer|exists:lse_entradas_lengua_espanola,id',
            'sublema'    => 'required|string|max:255',
            'id'         => 'nullable|integer|exists:lse_sublemas_entradas,id',
        ], [
            'id_entrada.required' => 'La entrada es obligatoria.',
            'id_entrada.integer'  => 'La entrada debe ser un número entero.',
            'id_entrada.exists'   => 'La entrada seleccionada no existe.',

            'sublema.required'    => 'El sublema es obligatorio.',
            'sublema.string'      => 'El sublema debe ser texto.',
            'sublema.max'         => 'El sublema no puede superar los 255 caracteres.',

            'id.integer'          => 'El identificador debe ser un número entero.',
            'id.exists'           => 'El sublema seleccionado no existe.',
        ]);

        // Si viene el id, actualizamos; si no, creamos
        if ($request->filled('id')) {
            $sublema = Sublema::find($request->id);
            if ($sublema) {
                $sublema->update([
                    'id_entrada' => $request->id_entrada,
                    'sublema'    => $request->sublema,
                ]);
            }
        } else {
            $sublema = Sublema::create([
                'id_entrada' => $request->id_entrada,
                'sublema'    => $request->sublema,
            ]);
        }

        return response()->json([
            'success'  => true,
            'message'  => 'Sublema guardado correctamente',
            'sublema'  => $sublema,
        ]);

    }
    /**
     * 
     */
    public function guardarSublema(Request $request){
        $idEntrada = $request->input('id_entrada');
        $sublemasData = $request->input('sublemas', []); // ahora recibes un array de sublemas

        $sublemasGuardados = [];
        $totalSublemas = 0;
        $totalAcepciones = 0;
        $idsSublemas = [];
        $idsAcepciones = [];


        foreach ($sublemasData as $sublemaData) {
            $sublema = Sublema::firstOrNew(['id' => $sublemaData['id'] ?? null]);
            $sublema->id_entrada = $idEntrada;
            $sublema->sublema    = $sublemaData['sublema'];
            $sublema->save();

            $totalSublemas++;
            $idsSublemas[] = $sublema->id;

            // 2. Recorrer las acepciones y guardarlas
            $acepciones = [];
            if (!empty($sublemaData['acepciones']) && is_array($sublemaData['acepciones'])) {
                foreach ($sublemaData['acepciones'] as $acepcionData) {
                    $acepciones[] = [
                        'acepcion'           => $acepcionData['acepcion'],
                        'ejemplo'            => $acepcionData['ejemplo'],
                        'id_categoria'       => $acepcionData['categoria'],
                        'fecha_modificacion' => $acepcionData['fecha'],
                        'definicion_propia'  => $acepcionData['propia'] ? 1 : 0,
                        'id_entrada'         => $idEntrada,
                        'id_sublema'         => $sublema->id,
                    ];
                }
            }

            if (!empty($acepciones)) {
                foreach ($acepciones as $acepcionData) {
                    $sublema_acepcion = SublemaAcepcion::create($acepcionData);
                    $idsAcepciones[] = $sublema_acepcion->id;
                }
                $totalAcepciones += count($acepciones);

            }
            
            $sublemasGuardados[] = $sublema;
        }

        //  Actualizar la tabla EntradaLE con los contadores
        $entrada = EntradaLE::find($idEntrada);
        if ($entrada) {
            $entrada->num_sublemas = $totalSublemas;
            $entrada->num_acepciones = $totalAcepciones;
            $entrada->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Sublemas y acepciones guardados correctamente',
            'sublemas' => $sublemasGuardados,
            'num_sublemas' => $totalSublemas,
            'num_acepciones' => $totalAcepciones,
            'idsSublemas' => $idsSublemas,
            'idsAcepciones' => $idsAcepciones,
        ]);
    }
     /* $idEntrada = $request->input('id_entrada');
        $sublemasData = $request->input('sublemas', []); // ahora recibes un array de sublemas

        $sublemasGuardados = [];

        foreach ($sublemasData as $sublemaData) {
            // 1. Crear el sublema
            $sublema = Sublema::create([
                'id_entrada' => $idEntrada,
                'sublema'    => $sublemaData['sublema'],
            ]);

            // 2. Recorrer las acepciones y guardarlas
            $acepciones = [];
            foreach ($sublemaData['acepciones'] as $acepcionData) {
                $acepciones[] = [
                    'acepcion'           => $acepcionData['acepcion'],
                    'ejemplo'            => $acepcionData['ejemplo'],
                    'id_categoria'       => $acepcionData['categoria'],
                    'fecha_modificacion' => $acepcionData['fecha'],
                    'definicion_propia'  => $acepcionData['propia'] ? 1 : 0,
                    'id_entrada'         => $idEntrada,
                    'id_sublema'         => $sublema->id,
                ];
            }

            if (!empty($acepciones)) {
                SublemaAcepcion::insert($acepciones);
            }

            $sublemasGuardados[] = $sublema;
        }

        return response()->json([
            'success' => true,
            'message' => 'Sublemas y acepciones guardados correctamente',
            'sublemas' => $sublemasGuardados,
        ]);*/
}
