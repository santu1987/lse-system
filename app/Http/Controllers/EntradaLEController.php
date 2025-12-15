<?php

namespace App\Http\Controllers;

use App\Models\EntradaLE;

class EntradaLEController extends Controller
{
    public function index()
    {
        // Trae las entradas ordenadas por fecha de guardado
        $entradas = EntradaLE::orderBy('orden', 'desc')->paginate(10);

        return view('entradas.le.index', compact('entradas'));
    }
}
