<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    private function rules(): array
    {
        return [
            'nome'     => 'required|string|max:100',
            'email'    => 'nullable|email|max:100',
            'telefone' => 'nullable|string|max:20',
            'cidade'   => 'nullable|string|max:80',
        ];
    }

    public function index(Request $request)
    {
        $clientes = Cliente::when($request->q, fn ($q, $t) => $q->where('nome', 'like', "%{$t}%"))
            ->orderBy('nome')
            ->paginate(10)
            ->withQueryString();

        return view('admin.clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('admin.clientes.form', ['cliente' => new Cliente()]);
    }

    public function store(Request $request)
    {
        Cliente::create($request->validate($this->rules()));

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente cadastrado.');
    }

    public function edit(Cliente $cliente)
    {
        return view('admin.clientes.form', compact('cliente'));
    }

    public function update(Request $request, Cliente $cliente)
    {
        $cliente->update($request->validate($this->rules()));

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente atualizado.');
    }

    public function destroy(Cliente $cliente)
    {
        try {
            $cliente->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Não é possível excluir: o cliente possui locações vinculadas.');
        }

        return redirect()->route('admin.clientes.index')->with('success', 'Cliente excluído.');
    }
}
