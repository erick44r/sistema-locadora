@extends('layouts.admin')
@section('title', 'Manutenções')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Manutenções</h2>
    <a href="{{ route('admin.manutencoes.create') }}" class="btn btn-warning">Nova manutenção</a>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover border bg-white">
        <thead class="table-dark">
            <tr><th>#</th><th>Máquina</th><th>Início</th><th>Prev. fim</th><th>Custo</th><th>Descrição</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($manutencoes as $mt)
                <tr>
                    <td>{{ $mt->id_manutencao }}</td>
                    <td>{{ $mt->maquina->tipo_descricao }} <small class="text-muted">({{ $mt->maquina->num_serie }})</small></td>
                    <td>{{ $mt->data_inicio->format('d/m/Y') }}</td>
                    <td>{{ optional($mt->data_prevista_fim)->format('d/m/Y') }}</td>
                    <td>R$ {{ number_format($mt->custo_manutencao ?? 0, 2, ',', '.') }}</td>
                    <td>{{ $mt->descricao }}</td>
                    <td>@include('admin._acoes', [
                        'edit'    => route('admin.manutencoes.edit', $mt),
                        'destroy' => route('admin.manutencoes.destroy', $mt),
                    ])</td>
                </tr>
            @empty
                <tr><td colspan="7" class="text-center text-muted">Nenhuma manutenção registrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $manutencoes->links('pagination::bootstrap-5') }}
@endsection
