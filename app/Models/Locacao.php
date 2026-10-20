<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Locacao extends Model
{
    protected $table = 'locacao';
    protected $primaryKey = 'id_locacao';
    public $timestamps = false;

    protected $fillable = [
        'id_cliente', 'id_maquina', 'data_inicio', 'data_prevista_devolucao',
        'data_devolucao', 'tipo_pagamento', 'forma_pagamento', 'valor_total',
    ];

    protected $casts = [
        'data_inicio' => 'date',
        'data_prevista_devolucao'=> 'date',
        'data_devolucao' =>'date',
        'valor_total'=> 'decimal:2',
    ];

    public const TIPOS_PAGAMENTO = ['diaria' => 'Diária', 'semanal' => 'Semanal', 'mensal' => 'Mensal'];
    public const FORMAS_PAGAMENTO = ['dinheiro' => 'Dinheiro', 'cartao' => 'Cartão', 'pix' => 'Pix'];

    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'id_cliente');
    }

    public function maquina (): BelongsTo
    {
        return $this->belongsTo(Maquina::class, 'id_maquina', 'id_maquina');
    }
}
