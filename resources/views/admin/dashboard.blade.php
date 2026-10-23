@extends('layouts.admin')
@section('title', 'Painel')

@section('content')
<h2 class="mb-4">Painel</h2>
<div class="row g-3">
    @foreach ([
        ['Clientes', $totais['clientes'], 'admin.clientes.index'],
        ['Máquinas', $totais['maquinas'], 'admin.maquinas.index'],
        ['Locações em aberto', $totais['abertas'], 'admin.locacoes.index'],
        ['Máquinas em manutenção', $totais['manutencao'], 'admin.manutencoes.index'],
    ] as [$rotulo, $valor, $rota])
        <div class="col-6 col-lg-3">
            <a href="{{ route($rota) }}" class="text-decoration-none">
                <div class="card shadow-sm h-100 text-center">
                    <div class="card-body">
                        <div class="display-5 fw-bold text-dark">{{ $valor }}</div>
                        <div class="text-muted">{{ $rotulo }}</div>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
</div>
@endsection
