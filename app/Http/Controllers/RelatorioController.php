<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

/**
 * Relatórios em SQL puro (Query Builder). As funções DATE_FORMAT, DATEDIFF e CURDATE
 * são do MySQL/MariaDB, então o projeto deve usar MySQL.
 */
class RelatorioController extends Controller
{
    public function receita(Request $request)
    {
        $ini = $request->input('ini', now()->startOfYear()->toDateString());
        $fim = $request->input('fim', now()->toDateString());

        $linhas = DB::table('locacao')
            ->selectRaw("DATE_FORMAT(data_inicio, '%m/%Y') as mes,
                         COUNT(*) as qtd,
                         COALESCE(SUM(valor_total), 0) as receita")
            ->whereBetween('data_inicio', [$ini, $fim])
            ->groupByRaw("DATE_FORMAT(data_inicio, '%m/%Y'), YEAR(data_inicio), MONTH(data_inicio)")
            ->orderByRaw('YEAR(data_inicio), MONTH(data_inicio)')
            ->get();

        return view('admin.relatorios.receita', compact('linhas', 'ini', 'fim'));
    }

    public function atraso()
    {
        $linhas = DB::table('locacao as l')
            ->join('cliente as c', 'c.id_cliente', '=', 'l.id_cliente')
            ->join('maquina as m', 'm.id_maquina', '=', 'l.id_maquina')
            ->whereNull('l.data_devolucao')
            ->whereDate('l.data_prevista_devolucao', '<', now()->toDateString())
            ->selectRaw('c.nome, c.telefone, m.tipo_descricao, m.num_serie,
                         l.data_prevista_devolucao,
                         DATEDIFF(CURDATE(), l.data_prevista_devolucao) as dias_atraso')
            ->orderByDesc('dias_atraso')
            ->get();

        return view('admin.relatorios.atraso', compact('linhas'));
    }

    public function maisAlugadas()
    {
        $linhas = DB::table('maquina as m')
            ->leftJoin('locacao as l', 'l.id_maquina', '=', 'm.id_maquina')
            ->selectRaw('m.tipo_descricao, m.num_serie, COUNT(l.id_locacao) as qtd_locacoes')
            ->groupBy('m.id_maquina', 'm.tipo_descricao', 'm.num_serie')
            ->orderByDesc('qtd_locacoes')
            ->get();

        return view('admin.relatorios.mais_alugadas', compact('linhas'));
    }

    public function custoManutencao()
    {
        $linhas = DB::table('maquina as m')
            ->leftJoin('manutencao as mt', 'mt.id_maquina', '=', 'm.id_maquina')
            ->selectRaw('m.tipo_descricao, m.num_serie,
                         COUNT(mt.id_manutencao) as qtd,
                         COALESCE(SUM(mt.custo_manutencao), 0) as custo_total')
            ->groupBy('m.id_maquina', 'm.tipo_descricao', 'm.num_serie')
            ->orderByDesc('custo_total')
            ->get();

        return view('admin.relatorios.custo_manutencao', compact('linhas'));
    }

    public function faturamento()
    {
        $linhas = DB::table('cliente as c')
            ->leftJoin('locacao as l', 'l.id_cliente', '=', 'c.id_cliente')
            ->selectRaw('c.nome, c.cidade,
                         COUNT(l.id_locacao) as qtd,
                         COALESCE(SUM(l.valor_total), 0) as faturamento')
            ->groupBy('c.id_cliente', 'c.nome', 'c.cidade')
            ->orderByDesc('faturamento')
            ->get();

        return view('admin.relatorios.faturamento', compact('linhas'));
    }
}
