<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'LSE')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 (si tu template Material ya lo trae, puedes omitir este) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Material Design for Bootstrap (MDB) --}}
    <!--<link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.min.css" rel="stylesheet"/>-->
    {{-- Iconos Material --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet"/>

    <link href="{{ asset('css/index.css') }}" rel="stylesheet"/>

    {{-- Estilos propios ligeros (opcional) --}}
    <style>
        .brand { font-weight: 600; letter-spacing: .5px; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
         <div class="container-fluid">
            {{-- DILSE + botón --}}
            <div class="d-flex align-items-center gap-2">
                <a class="navbar-brand fw-bold mb-0" href="{{ url('/') }}">
                    DILSE
                </a>
            </div>

            <div id="navMain" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    @auth
                       <button
                            class="btn btn-outline-secondary"
                            type="button"
                            data-bs-toggle="collapse"
                            data-bs-target="#sidebarMenu"
                            aria-controls="sidebarMenu"
                            aria-expanded="false"
                        >
                            ☰
                        </button>

                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Ingresar</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registro</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a
                                class="nav-link dropdown-toggle"
                                href="#"
                                id="userMenu"
                                role="button"
                                data-bs-toggle="dropdown"
                                aria-expanded="false"
                            >
                                {{ auth()->user()->name }}
                            </a>

                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/dashboard') }}">
                                        <span class="material-icons" style="font-size:18px;">dashboard</span>
                                        Panel
                                    </a>
                                </li>

                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <span class="material-icons" style="font-size:18px;">logout</span>
                                            Salir
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </li>

                    @endguest
                </ul>
            </div>
        </div>
    </nav>
    {{-- Layout con sidebar + contenido --}}
   <div class="container-fluid">
        <div class="row">
            @auth
            {{-- SIDEBAR --}}
            <nav
                id="sidebarMenu"
                class="col-lg-2 bg-dark text-white collapse vh-100 show"
            >
                <div class="pt-3 px-2">
                    <ul class="nav flex-column">

                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="{{ route('entradas.le') }}">
                                <span class="material-icons me-2">book</span>
                                Entradas LE
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="{{ route('entradas.lse') }}">
                                <span class="material-icons me-2">translate</span>
                                Entradas LSE
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="{{ route('signo.dia') }}">
                                <span class="material-icons me-2">emoji_objects</span>
                                Signo del día
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="{{ route('notificaciones') }}">
                                <span class="material-icons me-2">notifications</span>
                                Notificaciones
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="{{  route('categorias.index')  }}">
                                <span class="material-icons me-2">category</span>
                                Categorías
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="{{ route('informes') }}">
                                <span class="material-icons me-2">assessment</span>
                                Informes
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="{{ route('productos') }}">
                                <span class="material-icons me-2">inventory</span>
                                Productos
                            </a>
                        </li>

                        <li class="nav-item mb-2">
                            <a class="nav-link text-white" href="{{ route('usuarios') }}">
                                <span class="material-icons me-2">group</span>
                                Usuarios
                            </a>
                        </li>

                    </ul>
                </div>
            </nav>
            @endauth

            {{-- MAIN --}}
            @auth
                <main class="col-lg-10 px-4 py-4">
            @else
                <main class="col-lg-12 px-4 py-4">
            @endauth

                @yield('content')
            </main>
        </div>
    </div>

    {{-- JS Bootstrap / MDB --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <link href="{{ asset('css/index.css') }}" rel="stylesheet"/>
    <!--<script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/9.2.0/mdb.umd.min.js"></script>-->
    <script>
    document.addEventListener('DOMContentLoaded', function () {
        document.querySelectorAll('.form-outline').forEach((formOutline) => {
            new mdb.Input(formOutline).init();
        });
    });
    </script>
</body>
</html>