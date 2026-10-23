<?php

namespace App\Http\Controllers;

use App\Models\Maquina;
use App\Models\Manutencao;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
    $data = $request->validate($this->rules());
    $maquina = Maquina::findOrFail($data['id_maquina']);

    if ($maquina->status === 'alugada') {
        return back()->withInput()->withErrors([
            'id_maquina' => 'Esta máquina está alugada. Registre a devolução antes de enviá-la para manutenção.',
        ]);
    }

    // Só muda o status se a manutenção já começou e ainda não terminou
    $hoje = now()->toDateString();
    $emAndamento = $data['data_inicio'] <= $hoje
        && (empty($data['data_prevista_fim']) || $data['data_prevista_fim'] >= $hoje);

    DB::transaction(function () use ($data, $maquina, $emAndamento) {
        Manutencao::create($data);

        if ($emAndamento) {
            $maquina->update(['status' => 'manutencao']);
        }
    });

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


    public function concluir(Manutencao $manutencao)
    {
        DB::transaction(function () use ($manutencao) {
            if (is_null($manutencao->data_prevista_fim) || $manutencao->data_prevista_fim->isFuture()) {
                $manutencao->update(['data_prevista_fim' => now()->toDateString()]);
            }

            $manutencao->maquina()->where('status', 'manutencao')->update(['status' => 'disponivel']);
        });

        return back()->with('success', 'Manutenção concluída. A máquina está disponível.');
    }


    public function destroy(Manutencao $manutencao)
{
    DB::transaction(function () use ($manutencao) {
        $idMaquina = $manutencao->id_maquina;
        $manutencao->delete();

        // Se não sobrou outra manutenção em andamento, libera a máquina
        $outraEmAndamento = Manutencao::where('id_maquina', $idMaquina)
            ->where(function ($q) {
                $q->whereNull('data_prevista_fim')
                  ->orWhereDate('data_prevista_fim', '>=', now()->toDateString());
            })->exists();

        if (!$outraEmAndamento) {
            Maquina::where('id_maquina', $idMaquina)
                ->where('status', 'manutencao')
                ->update(['status' => 'disponivel']);
        }
    });

    return redirect()->route('admin.manutencoes.index')->with('success', 'Manutenção excluída.');
}
}
