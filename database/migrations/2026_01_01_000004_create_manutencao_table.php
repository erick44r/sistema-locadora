<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('manutencao', function (Blueprint $table) {
            $table->id('id_manutencao');
            $table->foreignId('id_maquina')->constrained('maquina', 'id_maquina');
            $table->date('data_inicio');
            $table->date('data_prevista_fim')->nullable();
            $table->decimal('custo_manutencao', 10, 2)->nullable();
            $table->string('descricao', 255)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('manutencao');
    }
};
