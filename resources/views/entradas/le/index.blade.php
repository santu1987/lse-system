@extends('layouts.app')

@section('title', 'Entradas LE')

@section('content')
<div class="container">
    <h1 class="mb-4">Entradas Lengua Española</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Entrada</th>
                <th>Nº Acepciones</th>
                <th>Orden Fecha Guardado</th>
                <th>Nº Sublemas</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->id }}</td>
                    <td>{{ $entrada->date_time }}</td>
                    <td>{{ $entrada->entrada }}</td>
                    <td>{{ $entrada->num_acepciones }}</td>
                    <td>{{ $entrada->orden_fecha_guardado }}</td>
                    <td>{{ $entrada->num_sublemas }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay entradas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $entradas->links() }}
</div>
@endsection