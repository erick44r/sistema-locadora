<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
        protected $table ='cliente';
        protected $primaryKey = 'id_cliente';
        public $timestamps = false;


    protected $fillable = [
        'nome',
        'email',
        'telefone',
        'cidade',
    ];

    public function locacoes():HasMany 
    {
        return $this->hasMany(Locacao::class, 'id_cliente', 'id_cliente');
    }
}
