@extends('layouts.app')

@section('title', 'Categorías')

@section('content')
<div class="container">
    <h1 class="mb-4">Categorías</h1>

    <a href="{{ route('categorias.create') }}" class="btn btn-primary mb-3">Nueva Categoría</a>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>Fecha</th>
                <th>Categoría</th>
                <th>Entrada</th>
            </tr>
        </thead>
        <tbody>
            @forelse($categorias as $categoria)
                <tr>
                    <td>{{ $categoria->date_time }}</td>
                    <td>{{ $categoria->categoria }}</td>
                    <td>{{ $categoria->entrada }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="3" class="text-center">No hay categorías registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $categorias->links() }}
</div>
@endsection