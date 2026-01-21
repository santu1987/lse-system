<?php

namespace App\Http\Controllers;

use App\Models\EntradaLE;
use App\Models\Categoria;
use App\Models\Acepciones;
use App\Models\Sublema;
use App\Models\SublemaAcepcion;
use Illuminate\Http\Request; 
use Illuminate\Support\Facades\Validator;
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
     * Store de entradas
     */
    public function store(Request $request)
    {
         $request->validate([
            'entrada' => 'required|string|max:255',
            'orden' => 'nullable|integer|min:1',
            'fecha_modificacion' => 'required|date',
        ], [
            'entrada.required' => 'El campo entrada es obligatorio.',
            'entrada.string' => 'El campo entrada debe ser texto.',
            'entrada.max' => 'El campo entrada no puede tener más de :max caracteres.',

            'orden.integer' => 'El campo orden debe ser un número entero.',
            'orden.min' => 'El campo orden debe ser como mínimo :min.',

            'fecha_modificacion.required' => 'La fecha de modificación es obligatoria.',
            'fecha_modificacion.date' => 'La fecha de modificación debe tener un formato de fecha válido.',
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
     * Edit de entradas
     */
    public function edit($id)
    {
        $entrada = EntradaLE::findOrFail($id);
        // Reutilizamos la vista create, pero le pasamos la entrada
        return view('entradas.le.edit', compact('entrada'));
    }

    /**
     * Update de entradas
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
     * Destroy de entradas
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
            'acepciones.*.id' => 'nullable|integer|exists:lse_acepciones_entradas_lengua_espanola,id',
            'acepciones.*.id_entrada' => 'required|integer|exists:lse_entradas_lengua_espanola,id',
            'acepciones.*.orden' => 'nullable|integer|min:1',
            'acepciones.*.acepcion' => 'required|string|max:255',
            'acepciones.*.ejemplo' => 'required|string',
            'acepciones.*.id_categoria' => 'required|integer|exists:lse_categorias,id',
            'acepciones.*.fecha_modificacion' => 'required|date',
            'acepciones.*.definicion_propia' => 'boolean',
        ],
        [ 
            'acepciones.required' => 'Debe enviar al menos una acepción.',
            'acepciones.array' => 'El campo de acepciones debe ser un arreglo.',

            'acepciones.*.id.integer' => 'El identificador de la acepción debe ser un número entero.',
            'acepciones.*.id.exists' => 'La acepción indicada no existe en la base de datos.',

            'acepciones.*.id_entrada.required' => 'El campo id_entrada es obligatorio para cada acepción.',
            'acepciones.*.id_entrada.integer' => 'El id_entrada debe ser un número entero.',
            'acepciones.*.id_entrada.exists' => 'La entrada asociada no existe.',

            'acepciones.*.orden.integer' => 'El orden debe ser un número entero.',
            'acepciones.*.orden.min' => 'El orden debe ser como mínimo :min.',

            'acepciones.*.acepcion.required' => 'La acepción es obligatoria.',
            'acepciones.*.acepcion.string' => 'La acepción debe ser texto.',
            'acepciones.*.acepcion.max' => 'La acepción no puede tener más de :max caracteres.',

            'acepciones.*.ejemplo.required' => 'El ejemplo es obligatorio.',
            'acepciones.*.ejemplo.string' => 'El ejemplo debe ser texto.',

            'acepciones.*.id_categoria.required' => 'La categoría es obligatoria.',
            'acepciones.*.id_categoria.integer' => 'La categoría debe ser un número entero.',
            'acepciones.*.id_categoria.exists' => 'La categoría seleccionada no existe.',

            'acepciones.*.fecha_modificacion.required' => 'La fecha de modificación es obligatoria.',
            'acepciones.*.fecha_modificacion.date' => 'La fecha de modificación debe tener un formato de fecha válido.',

            'acepciones.*.definicion_propia.boolean' => 'El valor de definición propia debe ser verdadero o falso.',
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
           /*
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

            $acepcionesGuardadas[] = $acepcion;*/
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
    }
    /**
     * GUardar sublmea principal
     */
    public function guardarSublema(Request $request){
        $rules = [
            'id_entrada' => 'required|integer|exists:lse_entradas_lengua_espanola,id',
            'sublemas' => 'required|array',
            'sublemas.*.sublema' => 'required|string|max:255',
            'sublemas.*.acepciones' => 'required|array|min:1',

            'sublemas.*.acepciones.*.acepcion' => 'required|string|max:255',
            'sublemas.*.acepciones.*.ejemplo' => 'required|string',
            'sublemas.*.acepciones.*.categoria' => 'required|integer|exists:lse_categorias,id',
            'sublemas.*.acepciones.*.fecha' => 'required|date',
        ];

        $messages = [
            'id_entrada.required' => 'El campo id_entrada es obligatorio.',
            'id_entrada.integer' => 'El id_entrada debe ser un número entero.',
            'id_entrada.exists' => 'La entrada indicada no existe.',

            'sublemas.required' => 'Debe enviar al menos un sublema.',
            'sublemas.array' => 'El campo sublemas debe ser un arreglo.',

            'sublemas.*.sublema.required' => 'El nombre del sublema es obligatorio.',
            'sublemas.*.sublema.string' => 'El sublema debe ser texto.',
            'sublemas.*.sublema.max' => 'El sublema no puede tener más de :max caracteres.',

            'sublemas.*.acepciones.required' => 'Cada sublema debe contener al menos una acepción.',
            'sublemas.*.acepciones.array' => 'El campo acepciones debe ser un arreglo.',
            'sublemas.*.acepciones.min' => 'Cada sublema debe tener al menos :min acepción.',

            'sublemas.*.acepciones.*.acepcion.required' => 'La acepción es obligatoria.',
            'sublemas.*.acepciones.*.acepcion.string' => 'La acepción debe ser texto.',
            'sublemas.*.acepciones.*.acepcion.max' => 'La acepción no puede tener más de :max caracteres.',

            'sublemas.*.acepciones.*.ejemplo.required' => 'El ejemplo es obligatorio.',
            'sublemas.*.acepciones.*.ejemplo.string' => 'El ejemplo debe ser texto.',

            'sublemas.*.acepciones.*.categoria.required' => 'La categoría es obligatoria.',
            'sublemas.*.acepciones.*.categoria.integer' => 'La categoría debe ser un número entero.',
            'sublemas.*.acepciones.*.categoria.exists' => 'La categoría seleccionada no existe.',

            'sublemas.*.acepciones.*.fecha.required' => 'La fecha de modificación es obligatoria.',
            'sublemas.*.acepciones.*.fecha.date' => 'La fecha debe tener un formato de fecha válido (YYYY-MM-DD).',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }


        $idEntrada = $request->input('id_entrada');
        $sublemasData = $request->input('sublemas', []); // ahora recibes un array de sublemas

        $sublemasGuardados = [];
        $totalSublemas = 0;
        $totalAcepciones = 0;
        $idsSublemas = [];
        $idsAcepciones = [];


        foreach ($sublemasData as $sublemaData) {
            // 1. Crear el sublema
            $sublema = Sublema::create([
                'id_entrada' => $idEntrada,
                'sublema'    => $sublemaData['sublema'],
            ]);
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
