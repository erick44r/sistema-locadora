@extends('layouts.admin')
@section('title', 'Faturamento por Cliente')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Faturamento por Cliente</h2>
    <button onclick="window.print()" class="btn btn-outline-secondary no-print">Imprimir</button>
</div>

<table class="table table-striped border bg-white">
    <thead class="table-dark">
        <tr><th>Cliente</th><th>Cidade</th><th class="text-end">Locações</th><th class="text-end">Faturamento</th></tr>
    </thead>
    <tbody>
        @forelse ($linhas as $l)
            <tr>
                <td>{{ $l->nome }}</td>
                <td>{{ $l->cidade }}</td>
                <td class="text-end">{{ $l->qtd }}</td>
                <td class="text-end">R$ {{ number_format($l->faturamento, 2, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="4" class="text-center text-muted">Nenhum cliente cadastrado.</td></tr>
        @endforelse
    </tbody>
    @if ($linhas->isNotEmpty())
        <tfoot class="table-light fw-bold">
            <tr>
                <td colspan="2">Total</td>
                <td class="text-end">{{ $linhas->sum('qtd') }}</td>
                <td class="text-end">R$ {{ number_format($linhas->sum('faturamento'), 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    @endif
</table>
@endsection
