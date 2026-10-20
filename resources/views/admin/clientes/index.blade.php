@extends('layouts.admin')
@section('title', 'Clientes')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Clientes</h2>
    <a href="{{ route('admin.clientes.create') }}" class="btn btn-warning">Novo cliente</a>
</div>

<form method="GET" class="mb-3">
    <div class="input-group">
        <input name="q" value="{{ request('q') }}" class="form-control" placeholder="Buscar por nome">
        <button class="btn btn-outline-secondary">Buscar</button>
    </div>
</form>

<div class="table-responsive">
    <table class="table table-striped table-hover border bg-white">
        <thead class="table-dark">
            <tr><th>#</th><th>Nome</th><th>E-mail</th><th>Telefone</th><th>Cidade</th><th></th></tr>
        </thead>
        <tbody>
            @forelse ($clientes as $c)
                <tr>
                    <td>{{ $c->id_cliente }}</td>
                    <td>{{ $c->nome }}</td>
                    <td>{{ $c->email }}</td>
                    <td>{{ $c->telefone }}</td>
                    <td>{{ $c->cidade }}</td>
                    <td>@include('admin._acoes', [
                        'edit'    => route('admin.clientes.edit', $c),
                        'destroy' => route('admin.clientes.destroy', $c),
                    ])</td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center text-muted">Nenhum cliente encontrado.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
{{ $clientes->links('pagination::bootstrap-5') }}
@endsection
