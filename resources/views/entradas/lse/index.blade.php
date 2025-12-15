@extends('layouts.app')

@section('title', 'Entradas LSE')

@section('content')
<div class="container">
    <h1 class="mb-4">Entradas LSE</h1>

    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>ID Entrada LE</th>
                <th>Glosario</th>
                <th>Nombres Propios</th>
                <th>Foto</th>
                <th>Video</th>
                <th>Nº Acepciones</th>
                <th>Orden</th>
                <th>Tiene Foto</th>
                <th>Tiene Video</th>
                <th>Tiene Acepción</th>
                <th>Tiene Ejemplo</th>
                <th>Fecha Guardado</th>
                <th>Oculto en Web</th>
                <th>Medida Imagen</th>
                <th>Entrada Masculino</th>
                <th>Entrada Femenino</th>
            </tr>
        </thead>
        <tbody>
            @forelse($entradas as $entrada)
                <tr>
                    <td>{{ $entrada->id }}</td>
                    <td>{{ $entrada->date_time }}</td>
                    <td>{{ $entrada->id_entrada_le }}</td>
                    <td>{{ $entrada->glosario }}</td>
                    <td>{{ $entrada->nombres_propios }}</td>
                    <td>{{ $entrada->foto }}</td>
                    <td>{{ $entrada->video }}</td>
                    <td>{{ $entrada->num_acepciones }}</td>
                    <td>{{ $entrada->orden }}</td>
                    <td>{{ $entrada->tiene_foto ? 'Sí' : 'No' }}</td>
                    <td>{{ $entrada->tiene_video ? 'Sí' : 'No' }}</td>
                    <td>{{ $entrada->tiene_acepcion ? 'Sí' : 'No' }}</td>
                    <td>{{ $entrada->tiene_ejemplo ? 'Sí' : 'No' }}</td>
                    <td>{{ $entrada->fecha_guardado }}</td>
                    <td>{{ $entrada->oculto_en_web_diccionario_lse ? 'Sí' : 'No' }}</td>
                    <td>{{ $entrada->medida_imagen }}</td>
                    <td>{{ $entrada->entrada_masculino }}</td>
                    <td>{{ $entrada->entrada_femenino }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="18" class="text-center">No hay entradas registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{ $entradas->links() }}
</div>
@endsection