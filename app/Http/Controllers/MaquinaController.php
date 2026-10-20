<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MaquinaController extends Controller
{
    private function rules(?Maquina $maquina = null): array
    {
        return [
            'num_serie'      => ['required', 'string', 'max:50',
                                 Rule::unique('maquina', 'num_serie')->ignore($maquina?->id_maquina, 'id_maquina')],
            'tipo_descricao' => 'required|string|max:100',
            'valor_diaria'   => 'required|numeric|min:0',
            'status'         => ['required', Rule::in(array_keys(Maquina::STATUS))],
        ];
    }

    public function index(Request $request)
    {
        $maquinas = Maquina::when($request->q, function ($q, $t) {
                $q->where('tipo_descricao', 'like', "%{$t}%")->orWhere('num_serie', 'like', "%{$t}%");
            })
            ->orderBy('tipo_descricao')
            ->paginate(10)
            ->withQueryString();

        return view('admin.maquinas.index', compact('maquinas'));
    }

    public function create()
    {
        return view('admin.maquinas.form', ['maquina' => new Maquina(['status' => 'disponivel'])]);
    }

    public function store(Request $request)
    {
        Maquina::create($request->validate($this->rules()));

        return redirect()->route('admin.maquinas.index')->with('success', 'Máquina cadastrada.');
    }

    public function edit(Maquina $maquina)
    {
        return view('admin.maquinas.form', compact('maquina'));
    }

    public function update(Request $request, Maquina $maquina)
    {
        $maquina->update($request->validate($this->rules($maquina)));

        return redirect()->route('admin.maquinas.index')->with('success', 'Máquina atualizada.');
    }

    public function destroy(Maquina $maquina)
    {
        try {
            $maquina->delete();
        } catch (QueryException $e) {
            return back()->with('error', 'Não é possível excluir: a máquina possui locações ou manutenções vinculadas.');
        }

        return redirect()->route('admin.maquinas.index')->with('success', 'Máquina excluída.');
    }
}
