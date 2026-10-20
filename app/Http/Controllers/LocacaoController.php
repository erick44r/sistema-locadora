<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\Locacao;
use App\Models\Maquina;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class LocacaoController extends Controller
{
    public function index(Request $request)
    {
        $locacoes = Locacao::with(['cliente', 'maquina'])
            ->when($request->situacao === 'abertas', fn ($q) => $q->whereNull('data_devolucao'))
            ->when($request->situacao === 'devolvidas', fn ($q) => $q->whereNotNull('data_devolucao'))
            ->orderByDesc('data_inicio')
            ->paginate(10)
            ->withQueryString();

        return view('admin.locacoes.index', compact('locacoes'));
    }

    public function create()
    {
        return view('admin.locacoes.form', [
            'locacao'  => new Locacao(['data_inicio' => now()->toDateString()]),
            'clientes' => Cliente::orderBy('nome')->get(),
            'maquinas' => Maquina::where('status', 'disponivel')->orderBy('tipo_descricao')->get(),
        ]);
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'id_cliente'              => 'required|exists:cliente,id_cliente',
            'id_maquina'              => 'required|exists:maquina,id_maquina',
            'data_inicio'             => 'required|date',
            'data_prevista_devolucao' => 'required|date|after_or_equal:data_inicio',
            'tipo_pagamento'          => ['required', Rule::in(array_keys(Locacao::TIPOS_PAGAMENTO))],
            'forma_pagamento'         => ['required', Rule::in(array_keys(Locacao::FORMAS_PAGAMENTO))],
            'valor_total'             => 'nullable|numeric|min:0',
        ]);

        $maquina = Maquina::findOrFail($data['id_maquina']);

        if ($maquina->status !== 'disponivel') {
            return back()->withInput()->withErrors(['id_maquina' => 'Esta máquina não está disponível.']);
        }

        // Se o valor não for informado, calcula: dias x valor da diária (mínimo 1 dia)
        if (!isset($data['valor_total']) || $data['valor_total'] === '') {
            $dias = max(1, (int) ceil(abs(
                Carbon::parse($data['data_inicio'])->diffInDays(Carbon::parse($data['data_prevista_devolucao']))
            )));
            $data['valor_total'] = $dias * $maquina->valor_diaria;
        }

        DB::transaction(function () use ($data, $maquina) {
            Locacao::create($data);
            $maquina->update(['status' => 'alugada']);
        });

        return redirect()->route('admin.locacoes.index')->with('success', 'Locação registrada.');
    }

    public function edit(Locacao $locacao)
    {
        return view('admin.locacoes.form', [
            'locacao'  => $locacao->load(['cliente', 'maquina']),
            'clientes' => Cliente::orderBy('nome')->get(),
            'maquinas' => collect(), // a máquina não pode ser trocada na edição
        ]);
    }

    public function update(Request $request, Locacao $locacao)
    {
        $data = $request->validate([
            'id_cliente'              => 'required|exists:cliente,id_cliente',
            'data_inicio'             => 'required|date',
            'data_prevista_devolucao' => 'required|date|after_or_equal:data_inicio',
            'data_devolucao'          => 'nullable|date|after_or_equal:data_inicio',
            'tipo_pagamento'          => ['required', Rule::in(array_keys(Locacao::TIPOS_PAGAMENTO))],
            'forma_pagamento'         => ['required', Rule::in(array_keys(Locacao::FORMAS_PAGAMENTO))],
            'valor_total'             => 'nullable|numeric|min:0',
        ]);

        DB::transaction(function () use ($locacao, $data) {
            $locacao->update($data);

            if (!empty($data['data_devolucao'])) {
                $locacao->maquina()->update(['status' => 'disponivel']);
            }
        });

        return redirect()->route('admin.locacoes.index')->with('success', 'Locação atualizada.');
    }

    /** Registra a devolução hoje e libera a máquina. */
    public function devolver(Locacao $locacao)
    {
        DB::transaction(function () use ($locacao) {
            $locacao->update(['data_devolucao' => now()->toDateString()]);
            $locacao->maquina()->update(['status' => 'disponivel']);
        });

        return back()->with('success', 'Devolução registrada.');
    }

    public function destroy(Locacao $locacao)
    {
        DB::transaction(function () use ($locacao) {
            if (is_null($locacao->data_devolucao)) {
                $locacao->maquina()->update(['status' => 'disponivel']);
            }
            $locacao->delete();
        });

        return redirect()->route('admin.locacoes.index')->with('success', 'Locação excluída.');
    }
}
