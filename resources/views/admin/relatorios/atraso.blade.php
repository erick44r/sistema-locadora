@extends('layouts.admin')
@section('title', 'Locações em Atraso')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Locações em Atraso</h2>
    <button onclick="window.print()" class="btn btn-outline-secondary no-print">Imprimir</button>
</div>

<p class="text-muted">Locações sem devolução cuja data prevista já passou (posição em {{ now()->format('d/m/Y') }}).</p>

<table class="table table-striped border bg-white">
    <thead class="table-dark">
        <tr><th>Cliente</th><th>Telefone</th><th>Máquina</th><th>Nº de série</th><th>Prev. devolução</th><th class="text-end">Dias de atraso</th></tr>
    </thead>
    <tbody>
        @forelse ($linhas as $l)
            <tr>
                <td>{{ $l->nome }}</td>
                <td>{{ $l->telefone }}</td>
                <td>{{ $l->tipo_descricao }}</td>
                <td>{{ $l->num_serie }}</td>
                <td>{{ \Carbon\Carbon::parse($l->data_prevista_devolucao)->format('d/m/Y') }}</td>
                <td class="text-end"><span class="badge text-bg-danger">{{ $l->dias_atraso }}</span></td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted">Nenhuma locação em atraso.</td></tr>
        @endforelse
    </tbody>
</table>
@endsection
