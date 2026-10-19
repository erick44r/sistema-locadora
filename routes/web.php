<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use app\http\controllers\ClienteControlller;
use app\http\controllers\LocacaoController;
use app\http\controllers\ManutencaoController;
use app\http\controllers\MaquinaController;
use app\http\controllers\RelatorioController;
use app\Models\Cliente;
use app\Models\Locacao;
use app\Models\Maquina;

Route::view('/', 'site')->name('home');
Route::view('/contato' , 'contato')->name('contato');

Route::middleware('auth')->group(function(){

Route::get('/dashboard', function () {
    $totais = [
        'cliente' => Cliente::count(),
        'maquinas'=> Maquina::count(),
        'abertas'=> Locacao::whereNull('data_devolucao')->count(),
        'atrasadas'=> Locacao::whereNull('data_devolucao')
                    ->whereDate('data_prevista_devolucao', '<', now()->toDateString())
                    ->count(),

    ];

    return view('admin.dashboard', compact('totais'));
})->name('dashboard');

Route::prefix('admin')->name('admin.')->group(function() {
    Route::resource('clientes', ClienteController::class)->except('show');
    Route::resource('maquinas' , MaquinaController::class)->except('show');
    Route::resource('locacoes', LocacaoController::class)
    ->parameters(['locações' => 'locacao'])
    ->except('show');
Route::patch('locacoes/{locacao}/devolver', [LocacaoController::class, 'devolver'])->name('locacoes.devolver');
Route::resource('manutencoes', ManutencaoController::class)
        ->parameters(['manutencoes'=>'manutencao'])
        ->except('show');

        Route::prefix('relatorios')->name('relatorios')->group(function (){
            Route::get('receita', [RelatorioController::class, 'receita'])->name('receita');
            Route::get('atraso', [RelatorioController::class, 'atraso'])->name('atraso');
            Route::get('mais-alugadas', [RelatorioController::class, 'maisAlugadas'])->name('mais_alugadas');
            Route::get('custo-manutencao', [RelatorioController::class, 'custoManutencao'])->name('custo_manutencap');
            Route::get('faturamento', [RelatorioController::class, 'faturamento'])->name('faturamento');
        });
    });
});



Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
