<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Administração') - Locação de Máquinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        @media print {
            nav, .no-print { display: none !important; }
        }
    </style>
</head>
<body class="bg-light">
<nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('dashboard') }}">Administração</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="nav">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Cadastros</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.clientes.index') }}">Clientes</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.maquinas.index') }}">Máquinas</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.locacoes.index') }}">Locações</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.manutencoes.index') }}">Manutenções</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">Relatórios</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="{{ route('admin.relatorios.receita') }}">Receita por Período</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.relatorios.atraso') }}">Locações em Atraso</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.relatorios.mais_alugadas') }}">Máquinas Mais Alugadas</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.relatorios.custo_manutencao') }}">Custo de Manutenção por Máquina</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.relatorios.faturamento') }}">Faturamento por Cliente</a></li>
                    </ul>
                </li>
            </ul>
            <ul class="navbar-nav align-items-lg-center">
                <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Ver site</a></li>
                <li class="nav-item">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="btn btn-sm btn-outline-light ms-lg-2">Sair ({{ auth()->user()->name }})</button>
                    </form>
                </li>
            </ul>
        </div>
    </div>
</nav>

<main class="container py-4">
    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show no-print">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show no-print">
            {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    @endif
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">
                @foreach ($errors->all() as $erro)
                    <li>{{ $erro }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @yield('content')
</main>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
