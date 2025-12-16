<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>DILSE - Dashboard</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">

</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        @auth   
            {{-- NAVBAR --}}
            <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                <!-- Left navbar links -->
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" data-widget="pushmenu" href="#" role="button">
                            <i class="fas fa-bars"></i>
                        </a>
                    </li>
                </ul>
                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <!-- Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-user mr-1"></i> Usuario
                        </a>
                        <div class="dropdown-menu dropdown-menu-right">
                            <a href="{{ route('perfil') }}" class="dropdown-item">
                                <i class="fas fa-id-card mr-2"></i> Perfil
                            </a>
                            <a href="{{ route('configuracion') }}" class="dropdown-item">
                                <i class="fas fa-cog mr-2"></i> Configuración
                            </a>
                            <div class="dropdown-divider"></div>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button class="dropdown-item" type="submit">
                                    <i class="fas fa-sign-out-alt mr-2"></i> Salir
                                </button>
                            </form>
                        </div>
                    </li>
                </ul>
            </nav>
            {{-- SIDEBAR --}}
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <a href="{{ url('/') }}" class="brand-link text-left" style="">
                    <span class="brand-text font-weight-light"><i class="nav-icon fas fa-book"></i> DILSE</span>
                </a>
                <div class="sidebar">
                    <nav class="mt-2">
                        <ul class="nav nav-pills nav-sidebar flex-column" role="menu">
                            <li class="nav-item">
                                <a href="{{ route('entradas_le.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-map-marker-alt"></i>
                                    <p>Entradas LE</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('entradas.lse') }}" class="nav-link">
                                    <i class="nav-icon fas fa-hand-point-up"></i>
                                    <p>Entradas LSE</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('signo.dia') }}" class="nav-link">
                                    <i class="nav-icon fas fa-lightbulb"></i>
                                    <p>Signo del día</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('notificaciones') }}" class="nav-link">
                                    <i class="nav-icon fas fa-bell"></i>
                                    <p>Notificaciones</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('categorias.index') }}" class="nav-link">
                                    <i class="nav-icon fas fa-list"></i>
                                    <p>Categorías</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('informes') }}" class="nav-link">
                                    <i class="nav-icon fas fa-chart-bar"></i>
                                    <p>Informes</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('productos') }}" class="nav-link">
                                    <i class="nav-icon fas fa-boxes"></i>
                                    <p>Productos</p>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="{{ route('usuarios') }}" class="nav-link">
                                    <i class="nav-icon fas fa-users"></i>
                                    <p>Usuarios</p>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </aside>
        @else
            <div class="mt-30"></div>    
        @endauth

        {{-- CONTENT --}}
        <div class="content-wrapper 
            @guest 
                ml-0  {{-- elimina el margen que deja el sidebar --}}
            @endguest">
            <section class="content pt-3">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </section>
        </div>
        @auth 
        {{-- FOOTER --}}
        <footer class="main-footer text-center">
            <strong>&copy; {{ date('Y') }} DILSE.</strong> Todos los derechos reservados. Desarrollado por ReÁnima Soluciones
        </footer>
     @endauth
    </div>

    <!-- Scripts (orden correcto) -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap 4 bundle (incluye Popper) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- AdminLTE -->
    <script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
    
    <!-- Sweet Alert -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Refuerzo por si hay conflictos: inicializa dropdowns
        $(function () {
            $('.dropdown-toggle').dropdown();
        });
    </script>
    @stack("scripts")
</body>
</html>