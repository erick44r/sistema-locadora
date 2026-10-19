<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Maquina extends Model
{
    protected $table = 'maquina';
    protected $primaryKey = 'id_maquina';
    public $timestamps = false;

    protected $fillable = ['num_serie', 'tipo_descricao', 'valor_diaria', 'status'];
    protected $casts = ['valor_diaria'=> 'decimal:2'];

    public const STATUS = [
        'disponivel' => 'Disponível',
        'alugada' => 'Alugada',
        'manutencao' => 'Em manutenção',
    ];

    public function locacoes(): HasMany
    {
        return $this->hasMany(Locacao::class, 'id_maquina', 'id_maquina');
    }

    public function manutencoes(): HasMany
    {
        return $this->hasMany(Manutencao::class, 'id_maquina', 'id_maquina');
    }
}
