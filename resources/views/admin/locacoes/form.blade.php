@extends('layouts.admin')
@section('title', $locacao->exists ? 'Editar locação' : 'Nova locação')

@section('content')
<h2 class="mb-3">{{ $locacao->exists ? 'Editar locação' : 'Nova locação' }}</h2>

<form method="POST" class="card card-body shadow-sm"
      action="{{ $locacao->exists ? route('admin.locacoes.update', $locacao) : route('admin.locacoes.store') }}">
    @csrf
    @if ($locacao->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Cliente *</label>
            <select name="id_cliente" class="form-select" required>
                <option value="">Selecione...</option>
                @foreach ($clientes as $c)
                    <option value="{{ $c->id_cliente }}" @selected(old('id_cliente', $locacao->id_cliente) == $c->id_cliente)>{{ $c->nome }}</option>
                @endforeach
            </select>
        </div>

        <div class="col-md-6">
            <label class="form-label">Máquina *</label>
            @if ($locacao->exists)
                <input class="form-control" disabled
                       value="{{ $locacao->maquina->tipo_descricao }} ({{ $locacao->maquina->num_serie }})">
            @else
                <select name="id_maquina" class="form-select" required>
                    <option value="">Selecione (somente disponíveis)...</option>
                    @foreach ($maquinas as $m)
                        <option value="{{ $m->id_maquina }}" @selected(old('id_maquina') == $m->id_maquina)>
                            {{ $m->tipo_descricao }} ({{ $m->num_serie }}) - R$ {{ number_format($m->valor_diaria, 2, ',', '.') }}/dia
                        </option>
                    @endforeach
                </select>
            @endif
        </div>

        <div class="col-md-4">
            <label class="form-label">Data de início *</label>
            <input type="date" name="data_inicio" class="form-control" required
                   value="{{ old('data_inicio', optional($locacao->data_inicio)->format('Y-m-d')) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Devolução prevista *</label>
            <input type="date" name="data_prevista_devolucao" class="form-control" required
                   value="{{ old('data_prevista_devolucao', optional($locacao->data_prevista_devolucao)->format('Y-m-d')) }}">
        </div>
        @if ($locacao->exists)
            <div class="col-md-4">
                <label class="form-label">Data de devolução</label>
                <input type="date" name="data_devolucao" class="form-control"
                       value="{{ old('data_devolucao', optional($locacao->data_devolucao)->format('Y-m-d')) }}">
            </div>
        @endif

        <div class="col-md-4">
            <label class="form-label">Tipo de pagamento *</label>
            <select name="tipo_pagamento" class="form-select" required>
                @foreach (\App\Models\Locacao::TIPOS_PAGAMENTO as $valor => $rotulo)
                    <option value="{{ $valor }}" @selected(old('tipo_pagamento', $locacao->tipo_pagamento) === $valor)>{{ $rotulo }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Forma de pagamento *</label>
            <select name="forma_pagamento" class="form-select" required>
                @foreach (\App\Models\Locacao::FORMAS_PAGAMENTO as $valor => $rotulo)
                    <option value="{{ $valor }}" @selected(old('forma_pagamento', $locacao->forma_pagamento) === $valor)>{{ $rotulo }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <label class="form-label">Valor total (R$)</label>
            <input type="number" step="0.01" min="0" name="valor_total" class="form-control"
                   value="{{ old('valor_total', $locacao->valor_total) }}">
            <div class="form-text">Em branco, calcula dias × diária.</div>
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-warning">Salvar</button>
        <a href="{{ route('admin.locacoes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection
