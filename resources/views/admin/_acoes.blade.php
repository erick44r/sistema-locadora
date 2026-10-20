{{-- Botões Editar / Excluir. Uso: @include('admin._acoes', ['edit' => route(...), 'destroy' => route(...)]) --}}
<div class="d-flex gap-1 justify-content-end">
    {{ $extra ?? '' }}
    <a href="{{ $edit }}" class="btn btn-sm btn-outline-primary">Editar</a>
    <form method="POST" action="{{ $destroy }}" onsubmit="return confirm('Excluir este registro?')">
        @csrf
        @method('DELETE')
        <button class="btn btn-sm btn-outline-danger">Excluir</button>
    </form>
</div>
