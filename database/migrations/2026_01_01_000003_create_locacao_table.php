<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('locacao', function (Blueprint $table) {
            $table->id('id_locacao');
            $table->foreignId('id_cliente')->constrained('cliente', 'id_cliente');
            $table->foreignId('id_maquina')->constrained('maquina', 'id_maquina');
            $table->date('data_inicio');
            $table->date('data_prevista_devolucao');
            $table->date('data_devolucao')->nullable(); // necessário para o relatório de atrasos
            $table->enum('tipo_pagamento', ['diaria', 'semanal', 'mensal']);
            $table->enum('forma_pagamento', ['dinheiro', 'pix', 'cartao', 'boleto']);
            $table->decimal('valor_total', 10, 2)->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('locacao');
    }
};
