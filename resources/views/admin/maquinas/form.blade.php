@extends('layouts.admin')
@section('title', $maquina->exists ? 'Editar máquina' : 'Nova máquina')

@section('content')
<h2 class="mb-3">{{ $maquina->exists ? 'Editar máquina' : 'Nova máquina' }}</h2>

<form method="POST" class="card card-body shadow-sm"
      action="{{ $maquina->exists ? route('admin.maquinas.update', $maquina) : route('admin.maquinas.store') }}">
    @csrf
    @if ($maquina->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-4">
            <label class="form-label">Nº de série *</label>
            <input name="num_serie" class="form-control" required maxlength="50" value="{{ old('num_serie', $maquina->num_serie) }}">
        </div>
        <div class="col-md-8">
            <label class="form-label">Descrição *</label>
            <input name="tipo_descricao" class="form-control" required maxlength="100" value="{{ old('tipo_descricao', $maquina->tipo_descricao) }}">
        </div>
        <div class="col-md-6">
            <label class="form-label">Valor da diária (R$) *</label>
            <input type="number" step="0.01" min="0" name="valor_diaria" class="form-control" required
                   value="{{ old('valor_diaria', $maquina->valor_diaria) }}">
        </div>
                <div class="col-md-6">
            <label class="form-label">Status</label>
            @php $atual = old('status', $maquina->status ?: 'disponivel'); @endphp
        
            @if (in_array($atual, ['alugada', 'manutencao']))
                <input class="form-control" disabled value="{{ \App\Models\Maquina::STATUS[$atual] }}">
                <input type="hidden" name="status" value="{{ $atual }}">
                <div class="form-text">Alterado automaticamente pelas locações e manutenções.</div>
            @else
                <select name="status" class="form-select" required>
                    <option value="disponivel" @selected($atual === 'disponivel')>Disponível</option>
                    <option value="indisponivel" @selected($atual === 'indisponivel')>Indisponível</option>
                </select>
            @endif
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-warning">Salvar</button>
        <a href="{{ route('admin.maquinas.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection
