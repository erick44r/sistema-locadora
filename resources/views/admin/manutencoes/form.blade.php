@extends('layouts.admin')
@section('title', $manutencao->exists ? 'Editar manutenção' : 'Nova manutenção')

@section('content')
<h2 class="mb-3">{{ $manutencao->exists ? 'Editar manutenção' : 'Nova manutenção' }}</h2>

<form method="POST" class="card card-body shadow-sm"
      action="{{ $manutencao->exists ? route('admin.manutencoes.update', $manutencao) : route('admin.manutencoes.store') }}">
    @csrf
    @if ($manutencao->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-12">
            <label class="form-label">Máquina *</label>
            <select name="id_maquina" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach ($maquinas as $m)
                    <option value="{{ $m->id_maquina }}" @selected(old('id_maquina', $manutencao->id_maquina) == $m->id_maquina)>
                        {{ $m->tipo_descricao }} ({{ $m->num_serie }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Data de início *</label>
            <input type="date" name="data_inicio" class="form-control" required
                   value="{{ old('data_inicio', optional($manutencao->data_inicio)->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Previsão de término</label>
            <input type="date" name="data_prevista_fim" class="form-control"
                   value="{{ old('data_prevista_fim', optional($manutencao->data_prevista_fim)->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Custo (R$)</label>
            <input type="number" step="0.01" min="0" name="custo_manutencao" class="form-control"
                   value="{{ old('custo_manutencao', $manutencao->custo_manutencao) }}">
        </div>
        <div class="col-md-12">
            <label class="form-label">Descrição</label>
            <input name="descricao" class="form-control" maxlength="255" value="{{ old('descricao', $manutencao->descricao) }}">
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-warning">Salvar</button>
        <a href="{{ route('admin.manutencoes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection
