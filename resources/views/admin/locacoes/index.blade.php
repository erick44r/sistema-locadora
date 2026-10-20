@extends('layouts.admin')
@section('title', 'Locações')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Locações</h2>
    <a href="{{ route('admin.locacoes.create') }}" class="btn btn-warning">Nova locação</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <select name="situacao" class="form-select">
            <option value="">Todas</option>
            <option value="abertas" @selected(request('situacao') === 'abertas')>Em aberto</option>
            <option value="devolvidas" @selected(request('situacao') === 'devolvidas')>Devolvidas</option>
        </select>
        <button class="btn btn-outline-secondary">Filtrar</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-hover border bg-white align-middle">
        <thead class="table-dark">
            <tr>
                <th>#</th><th>Cliente</th><th>Máquina</th><th>Início</th>
                <th>Prev. devolução</th><th>Devolução</th><th>Pagamento</th><th>Total</th><th></th>
            </tr>
        </thead>
        <tbody>
            @forelse ($locacoes as $l)
                <tr>
                    <td>{{ $l->id_locacao }}</td>
                    <td>{{ $l->cliente->nome }}</td>
                    <td>{{ $l->maquina->tipo_descricao }} <small class="text-muted">({{ $l->maquina->num_serie }})</small></td>
                    <td>{{ $l->data_inicio->format('d/m/Y') }}</td>
                    <td>{{ $l->data_prevista_devolucao->format('d/m/Y') }}</td>
                    <td>
                        @if ($l->data_devolucao)
                            {{ $l->data_devolucao->format('d/m/Y') }}
                        @elseif ($l->data_prevista_devolucao->isPast() && !$l->data_prevista_devolucao->isToday())
                            <span class="badge text-bg-danger">Em atraso</span>
                        @else
                            <span class="badge text-bg-primary">Em aberto</span>
                        @endif
                    </td>
                    <td>{{ \App\Models\Locacao::TIPOS_PAGAMENTO[$l->tipo_pagamento] ?? $l->tipo_pagamento }}
                        / {{ \App\Models\Locacao::FORMAS_PAGAMENTO[$l->forma_pagamento] ?? $l->forma_pagamento }}</td>
                    <td>R$ {{ number_format($l->valor_total ?? 0, 2, ',', '.') }}</td>
                    <td>
                        <div class="d-flex gap-1 justify-content-end">
                            @unless ($l->data_devolucao)
                                <form method="POST" action="{{ route('admin.locacoes.devolver', $l) }}"
                                      onsubmit="return confirm('Registrar devolução hoje?')">
                                    @csrf
                                    @method('PATCH')
                                    <button class="btn btn-sm btn-outline-success">Devolver</button>
                                </form>
                            @endunless
                            <a href="{{ route('admin.locacoes.edit', $l) }}" class="btn btn-sm btn-outline-primary">Editar</a>
                            <form method="POST" action="{{ route('admin.locacoes.destroy', $l) }}"
                                  onsubmit="return confirm('Excluir esta locação?')">
                                @csrf
                                @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger">Excluir</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr><td colspan="9" class="text-center text-muted">Nenhuma locação encontrada.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $locacoes->links('pagination::bootstrap-5') }}
@endsection
