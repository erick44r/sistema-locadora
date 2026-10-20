@extends('layouts.admin')
@section('title', 'Receita por Período')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Receita por Período</h2>
    <button onclick="window.print()" class="btn btn-outline-secondary no-print">Imprimir</button>
</div>

<form method="GET" class="row g-2 mb-4 no-print">
    <div class="col-md-4">
        <label class="form-label">De</label>
        <input type="date" name="ini" class="form-control" value="{{ $ini }}">
    </div>
    <div class="col-md-4">
        <label class="form-label">Até</label>
        <input type="date" name="fim" class="form-control" value="{{ $fim }}">
    </div>
    <div class="col-md-4 d-flex align-items-end">
        <button class="btn btn-warning w-100">Gerar</button>
    </div>
</form>

<p class="text-muted">Período: {{ \Carbon\Carbon::parse($ini)->format('d/m/Y') }} a {{ \Carbon\Carbon::parse($fim)->format('d/m/Y') }}</p>

<table class="table table-striped border bg-white">
    <thead class="table-dark">
        <tr><th>Mês</th><th class="text-end">Locações</th><th class="text-end">Receita</th></tr>
    </thead>
    <tbody>
        @forelse ($linhas as $l)
            <tr>
                <td>{{ $l->mes }}</td>
                <td class="text-end">{{ $l->qtd }}</td>
                <td class="text-end">R$ {{ number_format($l->receita, 2, ',', '.') }}</td>
            </tr>
        @empty
            <tr><td colspan="3" class="text-center text-muted">Nenhuma locação no período.</td></tr>
        @endforelse
    </tbody>
    @if ($linhas->isNotEmpty())
        <tfoot class="table-light fw-bold">
            <tr>
                <td>Total</td>
                <td class="text-end">{{ $linhas->sum('qtd') }}</td>
                <td class="text-end">R$ {{ number_format($linhas->sum('receita'), 2, ',', '.') }}</td>
            </tr>
        </tfoot>
    @endif
</table>
@endsection
