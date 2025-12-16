<?php

namespace App\Http\Controllers;

use App\Models\User; // Modelo User
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Mostrar listado de usuarios.
     */
    public function index()
    {
        // Consultar todos los usuarios con paginación
        $users = User::paginate(10);

        // Retornar la vista con los usuarios
        return view('usuarios.index', compact('users'));
    }
}