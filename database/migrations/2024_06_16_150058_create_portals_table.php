<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('portais', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('pago')->nullable();
            $table->boolean('gratuito')->nullable();
            $table->string('nome');
            $table->string('logomarca')->nullable();
            $table->string('link');
            $table->text('notas')->nullable(); 
            $table->string('codigo')->nullable();
            $table->string('servidor_ftp')->nullable();
            $table->string('servidor_user')->nullable();
            $table->string('servidor_pass')->nullable();
            $table->string('plano1_nome')->nullable();
            $table->integer('plano1_qtd')->nullable();
            $table->string('plano2_nome')->nullable();
            $table->integer('plano2_qtd')->nullable();
            $table->string('plano3_nome')->nullable();
            $table->integer('plano3_qtd')->nullable();
            $table->string('plano4_nome')->nullable();
            $table->integer('plano4_qtd')->nullable();
            $table->string('xml_nome')->nullable();

            $table->integer('status')->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('portais');
    }
};
