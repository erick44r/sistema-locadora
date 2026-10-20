<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('maquina', function (Blueprint $table) {
            $table->id('id_maquina');
            $table->string('num_serie', 50)->unique();
            $table->string('tipo_descricao', 100);
            $table->decimal('valor_diaria', 10, 2);
            $table->enum('status', ['disponivel', 'alugada', 'manutencao'])->default('disponivel');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('maquina');
    }
};
