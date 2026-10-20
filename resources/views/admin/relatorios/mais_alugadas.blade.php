@extends('layouts.admin')
@section('title', 'Máquinas Mais Alugadas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Máquinas Mais Alugadas</h2>
    <button onclick="window.print()" class="btn btn-outline-secondary no-print">Imprimir</button>
</div>

<table class="table table-striped border bg-white">
    <thead class="table-dark">
        <tr><th>#</th><th>Máquina</th><th>Nº de série</th><th class="text-end">Locações</th></tr>
    </thead>
    <tbody>
        @forelse ($linhas as $i => $l)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>{{ $l->tipo_descricao }}</td>
                <td>{{ $l->num_serie }}</td>
                <td class="text-end">{{ $l->qtd_locacoes }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted">Nenhuma máquina cadastrada.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
