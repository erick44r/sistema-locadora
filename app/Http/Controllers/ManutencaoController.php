<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Manutencao;
use Illuminate\Http\Request;

class ManutencaoController extends Controller
{
    private function rules(): array
    {
        return [
            'id_maquina'        => 'required|exists:maquina,id_maquina',
            'data_inicio'       => 'required|date',
            'data_prevista_fim' => 'nullable|date|after_or_equal:data_inicio',
            'custo_manutencao'  => 'nullable|numeric|min:0',
            'descricao'         => 'nullable|string|max:255',
        ];
    }

    public function index()
    {
        $manutencoes = Manutencao::with('maquina')->orderByDesc('data_inicio')->paginate(10);

        return view('admin.manutencoes.index', compact('manutencoes'));
    }

    public function create()
    {
        return view('admin.manutencoes.form', [
            'manutencao' => new Manutencao(['data_inicio' => now()->toDateString()]),
            'maquinas'   => Maquina::orderBy('tipo_descricao')->get(),
        ]);
    }

    public function store(Request $request)
    {
        Manutencao::create($request->validate($this->rules()));

        return redirect()->route('admin.manutencoes.index')->with('success', 'Manutenção registrada.');
    }

    public function edit(Manutencao $manutencao)
    {
        return view('admin.manutencoes.form', [
            'manutencao' => $manutencao,
            'maquinas'   => Maquina::orderBy('tipo_descricao')->get(),
        ]);
    }

    public function update(Request $request, Manutencao $manutencao)
    {
        $manutencao->update($request->validate($this->rules()));

        return redirect()->route('admin.manutencoes.index')->with('success', 'Manutenção atualizada.');
    }

    public function destroy(Manutencao $manutencao)
    {
        $manutencao->delete();

        return redirect()->route('admin.manutencoes.index')->with('success', 'Manutenção excluída.');
    }
}
