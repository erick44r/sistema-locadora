<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Manutencao extends Model
{
    protected $table = 'manutencao';
    protected $primaryKey = 'id_manutencao';
    public $timestamps = false;

    protected $fillable = ['id_maquina', 'data_inicio', 'data_prevista_fim', 'custo_manutencao', 'descricao'];

    protected $casts = [
        'data_inicio'       => 'date',
        'data_prevista_fim' => 'date',
        'custo_manutencao'  => 'decimal:2',
    ];

    public function maquina(): BelongsTo
    {
        return $this->belongsTo(Maquina::class, 'id_maquina', 'id_maquina');
    }
}