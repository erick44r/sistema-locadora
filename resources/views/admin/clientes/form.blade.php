@extends('layouts.admin')
@section('title', $cliente->exists ? 'Editar cliente' : 'Novo cliente')

@section('content')
<h2 class="mb-3">{{ $cliente->exists ? 'Editar cliente' : 'Novo cliente' }}</h2>

<form method="POST" class="card card-body shadow-sm"
      action="{{ $cliente->exists ? route('admin.clientes.update', $cliente) : route('admin.clientes.store') }}">
    @csrf
    @if ($cliente->exists) @method('PUT') @endif

    <div class="row g-3">
        <div class="col-md-8">
            <label class="form-label">Nome *</label>
            <input name="nome" class="form-control" required maxlength="100" value="{{ old('nome', $cliente->nome) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Cidade</label>
            <input name="cidade" class="form-control" maxlength="80" value="{{ old('cidade', $cliente->cidade) }}">
        </div>
        <div class="col-md-8">
            <label class="form-label">E-mail</label>
            <input type="email" name="email" class="form-control" maxlength="100" value="{{ old('email', $cliente->email) }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Telefone</label>
            <input name="telefone" class="form-control" maxlength="20" value="{{ old('telefone', $cliente->telefone) }}">
        </div>
    </div>

    <div class="mt-4 d-flex gap-2">
        <button class="btn btn-warning">Salvar</button>
        <a href="{{ route('admin.clientes.index') }}" class="btn btn-outline-secondary">Cancelar</a>
    </div>
</form>
@endsection
