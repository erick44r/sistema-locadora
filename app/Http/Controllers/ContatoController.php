<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContatoController extends Controller
{
    public function index()
    {
        return view('contato');
    }

    public function enviar(Request $request)
    {
        
        if ($request->filled('site')) {
            return redirect()->route('contato')->with('success', 'Mensagem enviada! Entraremos em contato em breve.');
        }

        $dados = $request->validate([
            'nome'     => 'required|string|max:100',
            'email'    => 'required|email|max:100',
            'telefone' => 'nullable|string|max:20',
            'mensagem' => 'required|string|max:2000',
        ], [
            'nome.required'     => 'Informe seu nome.',
            'email.required'    => 'Informe seu e-mail.',
            'email.email'       => 'Informe um e-mail válido.',
            'mensagem.required' => 'Escreva sua mensagem.',
            'mensagem.max'      => 'A mensagem pode ter no máximo 2000 caracteres.',
        ]);

        $linha = fn ($texto) => trim(preg_replace('/\s+/', ' ', (string) $texto));

        $registro = implode(PHP_EOL, [
            str_repeat('=', 60),
            'Data: ' . now()->format('d/m/Y H:i:s'),
            'Nome: ' . $linha($dados['nome']),
            'E-mail: ' . $linha($dados['email']),
            'Telefone: ' . $linha($dados['telefone'] ?? ''),
            'Mensagem:',
            preg_replace('/^/m', '    ', trim($dados['mensagem'])),   // recua a mensagem
            '',
        ]);

        try {
            Storage::disk('local')->append('contatos.txt', $registro);
        } catch (\Throwable $e) {
            report($e);

            return back()->withInput()->with('error', 'Não foi possível enviar agora. Tente novamente em instantes.');
        }

        return redirect()->route('contato')->with('success', 'Mensagem enviada! Entraremos em contato em breve.');
    }
}