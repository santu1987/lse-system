@extends('layouts.app')

@section('title', 'Entradas LE')

@section('content')
<div class="container">
    <h1 class="mb-4">Entradas Lengua Española</h1>
    {{-- Botón para crear nueva entrada --}}
    <a href="{{ route('entradas_le.create') }}" class="btn btn-success mb-3">
        <span class="material-icons align-middle">add</span> Nueva Entrada
    </a>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Entrada</th>
                <th>Orden</th>
                <th>Fecha Guardado</th>
                <th>Acción</th>
            </tr>
        </thead>
        <tbody>
            @foreach($entradas as $entrada)
            <tr id="row-{{ $entrada->id }}">
                <td>{{ $entrada->id }}</td>
                <td>{{ $entrada->entrada }}</td>
                <td>{{ $entrada->orden }}</td>
                <td>{{ $entrada->fecha_guardado }}</td>
                <td>
                    <button class="btn btn-success btn-sm edit-btn" data-id="{{ $entrada->id }}" title="Editar entrada"  onclick="window.location.href='{{ route('entradas_le.edit', $entrada->id) }}'">
                        <span class="material-icons" style="font-size:18px;">edit</span>
                    </button>
                    <button class="btn btn-success btn-sm delete-btn" data-id="{{ $entrada->id }}" title="Eliminar entrada">
                         <span class="material-icons" style="font-size:18px;">delete</span>
                    </button>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

<div id="mensaje"></div>

    {{ $entradas->links() }}
</div>
@endsection
@push('scripts')
    <script src="{{ asset('js/entradas.js') }}"></script>
@endpush
