<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>@yield('title', 'LSE')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap 5 (si tu template Material ya lo trae, puedes omitir este) --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    {{-- Material Design for Bootstrap (MDB) --}}
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.css" rel="stylesheet"/>

    {{-- Iconos Material --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    {{-- Estilos propios ligeros (opcional) --}}
    <style>
        .brand { font-weight: 600; letter-spacing: .5px; }
    </style>
</head>
<body class="bg-light">
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom">
        <div class="container">
            <a class="navbar-brand brand" href="{{ url('/') }}">LSE</a>
            <button class="navbar-toggler" type="button" data-mdb-collapse-init data-mdb-target="#navMain">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div id="navMain" class="collapse navbar-collapse">
                <ul class="navbar-nav me-auto">
                    @auth
                        <li class="nav-item">
                            <a class="nav-link" href="{{ url('/dashboard') }}">Dashboard</a>
                        </li>

                        {{-- Enlace solo visible para administradores --}}
                        @if(auth()->user()->is_admin)
                            <li class="nav-item">
                                <a class="nav-link" href="{{ route('admin.users.index') }}">
                                    Administración
                                </a>
                            </li>
                        @endif
                    @endauth
                </ul>
                <ul class="navbar-nav ms-auto">
                    @guest
                        <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Ingresar</a></li>
                        <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registro</a></li>
                    @else
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="userMenu" role="button" data-mdb-dropdown-init>
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userMenu">
                                <li>
                                    <a class="dropdown-item" href="{{ url('/dashboard') }}">
                                        <span class="material-icons" style="font-size:18px;">dashboard</span> Panel
                                    </a>
                                </li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button class="dropdown-item" type="submit">
                                            <span class="material-icons" style="font-size:18px;">logout</span> Salir
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

    <main class="container py-4">
        @yield('content')
    </main>

    {{-- JS Bootstrap / MDB --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.0.0/mdb.min.js"></script>
</body>
</html>