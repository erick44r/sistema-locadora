<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contato - Locação de Máquinas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">LOGO</a>
        <a class="btn btn-outline-light btn-sm" href="{{ route('home') }}">Voltar ao site</a>
    </div>
</nav>

<main class="container py-5">
    <h1 class="mb-4">Contato</h1>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="row g-4">
        {{-- Dados da empresa --}}
        <div class="col-lg-5">
            <p class="lead">Fale com a nossa equipe para pedir um orçamento de locação.</p>
            <ul class="list-group">
                <li class="list-group-item"><strong>Telefone:</strong> (00) 0000-0000</li>
                <li class="list-group-item"><strong>WhatsApp:</strong> (00) 90000-0000</li>
                <li class="list-group-item"><strong>E-mail:</strong> contato@locadora.com</li>
                <li class="list-group-item"><strong>Endereço:</strong> Rua Exemplo, 123 - Centro</li>
            </ul>
        </div>

        {{-- Formulário --}}
        <div class="col-lg-7">
            <form method="POST" action="{{ route('contato.enviar') }}" class="card card-body shadow-sm" novalidate>
                @csrf

                {{-- Armadilha para robôs: fica fora da tela e não deve ser preenchida --}}
                <div style="position:absolute; left:-9999px" aria-hidden="true">
                    <label>Não preencha este campo
                        <input type="text" name="site" tabindex="-1" autocomplete="off">
                    </label>
                </div>

                <div class="row g-3">
                    <div class="col-md-6">
                        <label class="form-label">Nome *</label>
                        <input name="nome" maxlength="100" value="{{ old('nome') }}"
                               class="form-control @error('nome') is-invalid @enderror">
                        @error('nome') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Telefone</label>
                        <input name="telefone" maxlength="20" value="{{ old('telefone') }}"
                               class="form-control @error('telefone') is-invalid @enderror">
                        @error('telefone') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">E-mail *</label>
                        <input type="email" name="email" maxlength="100" value="{{ old('email') }}"
                               class="form-control @error('email') is-invalid @enderror">
                        @error('email') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                    <div class="col-12">
                        <label class="form-label">Mensagem *</label>
                        <textarea name="mensagem" rows="5" maxlength="2000"
                                  class="form-control @error('mensagem') is-invalid @enderror">{{ old('mensagem') }}</textarea>
                        @error('mensagem') <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>
                </div>

                <div class="mt-4">
                    <button class="btn btn-warning">Enviar mensagem</button>
                </div>
            </form>
        </div>
    </div>
</main>
</body>
</html>