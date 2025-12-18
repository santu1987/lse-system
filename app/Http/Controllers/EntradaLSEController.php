<?php
namespace App\Http\Controllers;

use App\Models\EntradaLSE;
use App\Models\EntradaLE;

class EntradaLSEController extends Controller
{
    /**
     * Index
     */
    public function index()
    {
            // Trae las entradas ordenadas por fecha_guardado
            $entradas = EntradaLSE::orderBy('fecha_guardado', 'desc')->paginate(10);

        return view('entradas.lse.index', compact('entradas'));
    }
    /**
     * Create
     */
    public function create()
    {
        // Traer las 10 primeras entradas LE
        $entradas = EntradaLE::orderBy('id', 'asc')
            ->take(10)
            ->get();
        // Pasar los datos a la vista
        return view('entradas.lse.create', compact('entradas'));
    }
}