@extends('layouts.admin')
@section('title', 'Máquinas')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Máquinas</h2>
    <a href="{{ route('admin.maquinas.create') }}" class="btn btn-warning">Nova máquina</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por descrição ou nº de série">
        <button class="btn btn-outline-secondary">Buscar</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-hover border bg-white">
        <thead class="table-dark">
            <tr><th>#</th><th>Nº de série</th><th>Descrição</th><th>Diária</th><th>Status</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($maquinas as $m)
                <tr>
                    <td>{{ $m->id_maquina }}</td>
                    <td>{{ $m->num_serie }}</td>
                    <td>{{ $m->tipo_descricao }}</td>
                    <td>R$ {{ number_format($m->valor_diaria, 2, ',', '.') }}</td>
                    <td>
                        <span class="badge text-bg-{{ ['disponivel' => 'success', 'alugada' => 'primary', 'manutencao' => 'warning'][$m->status] ?? 'secondary' }}">
                            {{ \App\Models\Maquina::STATUS[$m->status] ?? $m->status }}
                        </span>
                    </td>
                    <td>@include('admin._acoes', [
                        'edit'    => route('admin.maquinas.edit', $m),
                        'destroy' => route('admin.maquinas.destroy', $m),
                    ])</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Nenhuma máquina encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $maquinas->links('pagination::bootstrap-5') }}
@endsection
