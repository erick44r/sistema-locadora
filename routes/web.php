<?php

use App\Http\Controllers\ClienteController;
use App\Http\Controllers\LocacaoController;
use App\Http\Controllers\MaquinaController;
use App\Http\Controllers\ManutencaoController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RelatorioController;
use App\Models\Cliente;
use App\Models\Locacao;
use App\Models\Maquina;
use Illuminate\Support\Facades\Route;


Route::view('/', 'site')->name('home');
Route::view('/contato', 'contato')->name('contato');


Route::middleware('auth')->group(function () {

    Route::get('/dashboard', function () {
        $totais = [
            'clientes'  => Cliente::count(),
            'maquinas'  => Maquina::count(),
            'abertas'   => Locacao::whereNull('data_devolucao')->count(),
            'manutencao' => Maquina::where('status', 'manutencao')->count(),
        ];

        return view('admin.dashboard', compact('totais'));
    })->name('dashboard');

    Route::prefix('admin')->name('admin.')->group(function () {
        Route::resource('clientes', ClienteController::class)->except('show');
        Route::resource('maquinas', MaquinaController::class)->except('show');
        Route::resource('locacoes', LocacaoController::class)
            ->parameters(['locacoes' => 'locacao'])
            ->except('show');
        Route::patch('locacoes/{locacao}/devolver', [LocacaoController::class, 'devolver'])->name('locacoes.devolver');
        Route::patch('manutencoes/{manutencao}/concluir', [ManutencaoController::class, 'concluir'])->name('manutencoes.concluir');       
        Route::resource('manutencoes', ManutencaoController::class)
            ->parameters(['manutencoes' => 'manutencao'])
            ->except('show');

        Route::prefix('relatorios')->name('relatorios.')->group(function () {
            Route::get('receita', [RelatorioController::class, 'receita'])->name('receita');
            Route::get('atraso', [RelatorioController::class, 'atraso'])->name('atraso');
            Route::get('mais-alugadas', [RelatorioController::class, 'maisAlugadas'])->name('mais_alugadas');
            Route::get('custo-manutencao', [RelatorioController::class, 'custoManutencao'])->name('custo_manutencao');
            Route::get('faturamento', [RelatorioController::class, 'faturamento'])->name('faturamento');
        });
    });

   
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';