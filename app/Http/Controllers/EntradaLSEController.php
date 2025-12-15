<?php
namespace App\Http\Controllers;

use App\Models\EntradaLSE;

class EntradaLSEController extends Controller
{
    public function index()
    {
        // Trae las entradas ordenadas por fecha_guardado
        $entradas = EntradaLSE::orderBy('fecha_guardado', 'desc')->paginate(10);

        return view('entradas.lse.index', compact('entradas'));
    }
}